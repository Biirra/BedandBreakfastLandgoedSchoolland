<?php

//------------------------------------------------------------
//  Gastenboek
//------------------------------------------------------------
// creeer een nieuw gastboek bericht
function createGastboekBericht($db, $naam, $date ,$bericht )
{
    $sql = "INSERT INTO ls_gastboek (naam, datum, bericht) VALUES ('$naam', '$date', '$bericht')";
    mysqli_query($db, $sql);
}
// haal alle bestaande berichten op van de database
function getGastboekMessage($db)
{
    $output = '';
    $sql = 'SELECT id, naam, bericht, datum FROM ls_gastboek ORDER BY id DESC ';
    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $output .= getMessageOutput($row);   // stuur de opgehaalde evenementen naar een functie die de output handeld
    }
    return $output;
}

// genereerd php code voor de gastboekberichten. deze output is voor bezoekers van de website
function getMessageOutput($row)
{
    return '
        <tr>
        <td>
        <div class="gastboek-parent">
        <table>
        <tr>
        <td>
        <h4 style="color: crimson;">' . ucfirst($row['naam']) . '</h4>
        </td>
        <td>
        <h4 class="gastenboek-datum">' . reverseDate($row['datum']) . '</h4>
        </td>
        </tr>
        <tr>
        <td> "' . $row['bericht'] . '"</td>
        </tr>
        </table>
        <hr>
        </div>
        </td>
        </tr>
       ';
}
//------------------------------------------------------------
// Reservering
//------------------------------------------------------------

// check of de aanvangsdatum op een datum valt dat al bezet is.
function checkVrijeDatumAanvang($db, $datum){
    $sql = "SELECT vertrek FROM ls_reservering WHERE vertrek = '$datum'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row == null) {
        return true;
    }else{
        return false;
    }
}
function checkVrijeDatumVertrek($db, $datum){
    $sql = "SELECT aanvang FROM ls_reservering WHERE aanvang = '$datum'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row == null) {
        return true;
    }else{
        return false;
    }
}

function sendReserveringMail($zender, $ontvanger, $inhoud)
{
    $from = new SendGrid\Email("Example User", $zender);
    $subject = "Reservering";
    $to = new SendGrid\Email("Example User", $ontvanger);

    $content = new SendGrid\Content("text/plain", $inhoud);
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $apiKey = "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";

    $sg = new \SendGrid($apiKey);
    $response = $sg->client->mail()->send()->post($mail);

    return $response->statusCode();
}

function createKlant($db, $aanhef, $naam, $achternaam, $adres, $postcode, $plaats, $land, $areaCode, $telefoonnummer, $email)
{
    $sql = "SELECT id FROM ls_klant WHERE email = '$email'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row == null) {
        $sql = "INSERT INTO ls_klant (aanhef, naam, achternaam, adres, postcode, plaats, land, area_code, telefoonnummer, email)
        VALUES ('$aanhef','$naam','$achternaam','$adres','$postcode','$plaats','$land','$areaCode','$telefoonnummer','$email')";
        mysqli_query($db, $sql);
    }
}

function createResevering($db, $email, $aanvang, $vertrek, $aantalPersonen, $aantalKinderen, $vragenOpmerking)
{
    $sql = "SELECT id FROM ls_reservering 
            WHERE aanvang BETWEEN '$aanvang' AND '$vertrek'
            AND  vertrek BETWEEN '$aanvang' AND '$vertrek'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row == null) {
        //    haal klantId op.
        $sql = "SELECT id FROM ls_klant WHERE email = '$email'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $klantId = $row['id'];

        $sql = "INSERT INTO ls_reservering (klant_id, aanvang, vertrek, aantal_personen, aantal_kinderen, vragen_opmerkingen)
        VALUES ('$klantId', '$aanvang', '$vertrek', '$aantalPersonen', '$aantalKinderen', '$vragenOpmerking')";
        mysqli_query($db, $sql);
    }

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

?>