<?php
include('framework/framework.php');

global $taal;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new-gastboek-naam']) && !empty(['new-gastboek-message'])) {
        $gastboekNaam = mysqli_escape_string($db, $_POST['new-gastboek-naam']);
        $gastboekBericht = mysqli_escape_string($db, $_POST['new-gastboek-message']);
        createGastboekBericht($db, $gastboekNaam, date("Y-m-d"), $gastboekBericht);
    }
}

?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({selector: 'textarea'});</script>
</head>
<h3 class="fancy-titel"> Gastenboek </h3>
    <div class="row" id="gastenboek-foto">

        <br>
        <div class="col-md-6">
            <div class="gastenboek-paneel">
                <!--                gedeelte waar alle evenementen zichtbaar zijn       -->
                <table>
                    <?php
                    echo    getGastboekMessage($db);
                    ?>
                </table>
                <!--                einde gedeelte waar alle evenementen zichtbaar zijn     -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="gastenboek-form" style="padding-left: 27px; padding-top: 15px;">
                <form method="post" name="new-event-form">
                    <table>
                        <tr>
                            <td>
                                <p align="center">Naam: <input type="text" name="new-gastboek-naam"></p>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td><br></td>
                        </tr>
                        <tr>
                            <td>
                                <p align="right"><textarea name="new-gastboek-message" style="width:95%"></textarea></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" value="Plaats bericht" style="float: right;border-radius: 5px;">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        </div>
    <br><br><br>

<?php
include('framework/footer.php');
?>
