<?php
//------------------------------------------------------------
// Reservering
//------------------------------------------------------------

// delete bestaande reservering
function deleteResevering($db, $reserveringId)
{
    $sql = "DELETE FROM ls_reservering WHERE id = '$reserveringId'";
    mysqli_query($db, $sql);
}

// accepteer een bestaande reservering.
function accepteerReservering($db, $reserveringId)
{
    $sql = "UPDATE ls_reservering SET geaccepteerd = 1 WHERE id = '$reserveringId'";
    mysqli_query($db, $sql);
}

// weiger een bestaande reservering. een geaccepteerde reservering alsnog weigeren.
function weigerReservering($db, $reserveringId)
{
    $sql = "UPDATE ls_reservering SET geaccepteerd = 0 WHERE id = '$reserveringId'";
    mysqli_query($db, $sql);
}

function getResevering($db)
{
    $output = '';

    $sql = "SELECT ls_reservering.id, aanvang, vertrek, aantal_personen, aantal_kinderen, vragen_opmerkingen, geaccepteerd, naam, achternaam, area_code, telefoonnummer, email
            FROM ls_reservering, ls_klant WHERE ls_reservering.klant_id = ls_klant.id";
    $result = mysqli_query($db, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $reservering = $row['id'];
        $aanvang = $row['aanvang'];
        $vertrek = $row['vertrek'];
        $aantalPersonen = $row['aantal_personen'];
        $aantalKinderen = $row['aantal_kinderen'];
        $opmerkingen = $row['vragen_opmerkingen'];

        $naam = $row['naam'];
        $achternaam = $row['achternaam'];
        $telefoonnummer = $row['area_code'] . "-" . $row['telefoonnummer'];
        $email = $row['email'];
        if ($row['id'] != null) {
            $output .= "<tr>
                        <td>
                            $naam
                        </td>
                        <td>
                            $achternaam
                        </td>
                        <td>
                            $telefoonnummer
                        </td>
                        <td>
                            $email
                        </td>
                        <td>
                            " . reverseDate($aanvang) . "
                        </td>
                        <td>
                            " . reverseDate($vertrek) . "
                        </td>
                        <td>
                            $aantalPersonen
                        </td>
                        <td>
                            $aantalKinderen
                        </td>
                        <td>
                            $opmerkingen
                        </td>";

            if ($row['geaccepteerd'] == 1) {
                $output .= "<td>
                        <form method='post'>
                            <input name='reservering-id' type='hidden' value='$reservering'>
                            <input name='weiger-reservering' type='hidden' value='weiger-reservering'>
                            <button type='submit' class='btn btn-primary'><i class='fa fa-times-circle-o' aria-hidden='true'></i></button>
                        </form>
                        </td>
                        ";
            }
            if ($row['geaccepteerd'] == 0) {
                $output .= "<td>
                        <form method='post'>
                            <input name='reservering-id' type='hidden' value='$reservering'>
                            <input name='accepteer-reservering' type='hidden' value='accepteer-reservering'>
                            <button type='submit' class='btn btn-primary'><i class='fa fa-check-circle-o' aria-hidden='true'></i></button>
                        </form>
                        </td>";
            }

            $output .= "<td>
                        <form method='post'>
                            <input name='reservering-id' type='hidden' value='$reservering'>
                            <input name='delete-reservering' type='hidden' value='delete-reservering'>
                            <button type='submit' class='btn btn-primary'><i class='fa fa-trash-o' aria-hidden='true'></i></button>
                        </form>
                        </td>
                        </tr>";
        }
    }


    return $output;
}


//--------------------------------------------------------
// Misc
//--------------------------------------------------------

// verander de datum vanuit de database zodat hij niet achterstevoren wordt weergeven.
function reverseDate($date)
{
    $originalDate = strtotime($date);
    return date("d-m-Y", $originalDate);
}

function getAantalNachten($startDatum, $eindDatum)
{
    $now = $startDatum;
    $your_date = strtotime($eindDatum);
    $datediff = $now - $your_date;

    return floor($datediff / (60 * 60 * 24));
}


//--------------------------------------------------------------
// Evenementen
//--------------------------------------------------------------

// creeer een nieuw evenement
function createEvent($db, $titel, $info, $date)
{
    $sql = "INSERT INTO ls_evenement (titel, info, datum) VALUES ('$titel', '$info', '$date')";
    mysqli_query($db, $sql);
}

// verwijder een bestaand evenement
function deleteEvent($db, $titel, $date, $info)
{
    $sql = "DELETE FROM ls_evenement WHERE titel = '$titel' AND datum = '$date' AND info = '$info'";
    mysqli_query($db, $sql);
}

// haal alle bestaande evenementen op van de database
function getEvent($db)
{
    $output = '';
    $sql = 'SELECT titel, info, datum FROM ls_evenement';
    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $output .= getEventOutputAdmin($row);   // stuur de opgehaalde evenementen naar een functie die de output handeld
    }
    return $output;
}

// genereerd php code voor de evenementen. deze output is voor bezoekers van de website
function getEventOutput($row)
{
    return '<table>
        <tr>
        <td>
        <table>
        <tr>
        <td>
        <h3>' . $row['titel'] . '</h3>
        </td>
        <td>
        <h4>' . reverseDate($row['datum']) . '</h4>
        </td>
        </tr>
        <tr><td> ' . $row['info'] . '</td></tr>
        </table>
        </td>
        </tr>
        </table>
';
}

// genereerd output voor de opgehaalde evenementen. deze output is bedoeld voor admin.
// deze output bevat een trashcan icoon per evenement.
function getEventOutputAdmin($row)
{
    return '<table>
        <tr>
        <td>
        <div class="event-parent">
        <form method="post" name="event-verwijderen">
        <table>
        <tr>
        <td>
        <h3>' . $row['titel'] . '</h3>
        <input type="hidden" name="titel" value="' . $row['titel'] . '">
        </td>
        <td>
        <h4 class="event-datum">' . reverseDate($row['datum']) . '</h4>
        <input type="hidden" name="datum" value="' . $row['datum'] . '">
        </td>
        <td><button type="submit" class="btn btn-primary trashcan-event"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
        </tr>
        <tr>
        <td> 
        ' . $row['info'] . '
        <input type="hidden" name="event-info" value="' . $row['info'] . '">
        </td>
        </tr>
        </table>
        </form>
        </div>
        </td>
        </tr>
        </table>
';
}
//----------------------------------------------------
//  Gastenboek
//----------------------------------------------------

// verwijder een bestaand evenement
function deleteGastboekBericht($db, $naam, $date, $id)
{
    $sql = "DELETE FROM ls_gastboek WHERE naam = '$naam' AND datum = '$date' AND id = '$id'";
    mysqli_query($db, $sql);
}

// haal alle bestaande berichten op van de database, Admin use
function getGastboekMessage($db)
{
    $output = '';
    $sql = 'SELECT id, naam, bericht, datum FROM ls_gastboek';
    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $output .= getGastboekOutputAdmin($row);   // stuur de opgehaalde berichten naar een functie die de output handeld
    }
    return $output;
}

// genereerd output voor de opgehaalde gastboek berichten. deze output is bedoeld voor admin.
// deze output bevat een trashcan icoon per bericht.
function getGastboekOutputAdmin($row)
{
    return '<table>
        <tr>
        <td>
        <div class="event-parent">
        <form method="post" name="event-verwijderen">
        <table>
        <tr>
        <td>
        <h3>' . $row['naam'] . '</h3>
        <input type="hidden" name="naam" value="' . $row['naam'] . '">
        </td>
        <td>
        <h4 class="event-datum">' . reverseDate($row['datum']) . '</h4>
        <input type="hidden" name="datum" value="' . $row['datum'] . '">
        </td>
        <td><button type="submit" class="btn btn-primary trashcan-event"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
        </tr>
        <tr>
        <td> 
        ' . $row['bericht'] . '
        <input type="hidden" name="id" value="'.$row['id'].'">
        </td>
        </tr>
        </table>
        </form>
        </div>
        </td>
        </tr>
        </table>
';
}



