<?php
include_once('../includes/database.php');
include('includes/functions.php');
include('login/session.php');
include('../taal/nederlands.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new-event']) && !empty(['new-event-titel'])) {
        createEvent($db, $_POST['new-event-titel'], $_POST['new-event'], date("Y-m-d"));
    }
    if (!empty($_POST['naam']) && !empty($_POST['datum'])) {
        deleteGastboekBericht($db, $_POST['naam'], $_POST['datum'], $_POST['id']);
    }
    if (!empty($_POST['delete-reservering'])) {
        deleteResevering($db, $_POST['reservering-id']);
    }
    if (!empty($_POST['accepteer-reservering'])) {
        accepteerReservering($db, $_POST['reservering-id']);
    }
    if (!empty($_POST['weiger-reservering'])) {
        weigerReservering($db, $_POST['reservering-id']);
    }
}
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/admin-paneel.css">

<!--    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>-->
<!--    <script>tinymce.init({selector: 'textarea'});</script>-->
</head>
<body>
<div class="container">
    <div class="row">
        <h3> Gastenboek </h3>
        <div class="col-md-6">
            <div class="gastenboek-paneel">
                <!--                gedeelte waar alle evenementen zichtbaar zijn       -->
                <table>
                    <?php
                    echo getGastboekMessage($db);
                    ?>
                </table>
                <!--                einde gedeelte waar alle evenementen zichtbaar zijn     -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-container-outer filterable">
                <div class="panel-title form-container-title" align="left"><b>Lijst Reserveringen </b></div>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span
                                class="glyphicon glyphicon-filter"></span>
                        Filter
                    </button>
                </div>
                <div class="form-container-inner">
                    <table class="full-list-opdrachten tablebody">
                        <thead>
                        <tr class="filters">
                            <th class="table-header"><input type="text" class="form-control" placeholder="Naam:"
                                                            disabled></th>
                            <th class="table-header"><input type="text" class="form-control"
                                                            placeholder="Achternaam:" disabled></th>
                            <th class="table-header"><input type="text" class="form-control"
                                                            placeholder="Telefoonnummer:" disabled></th>
                            <th class="table-header"><input type="text" class="form-control" placeholder="Email:"
                                                            disabled></th>
                            <th class="table-header"><input type="text" class="form-control" placeholder="Aanvang:"
                                                            disabled></th>
                            <th class="table-header"><input type="text" class="form-control" placeholder="Vertrek:"
                                                            disabled></th>
                            <th class="table-header"><input type="text" class="form-control"
                                                            placeholder="Aantal personen:" disabled></th>
                            <th class="table-header"><input type="text" class="form-control"
                                                            placeholder="Aantal Kinderen:" disabled></th>
                            <th class="table-header"><input type="text" class="form-control"
                                                            placeholder="opmerkingen:" disabled></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo getResevering($db); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="../jquery/jquery-3.2.1.min.js"></script>
<script src="js/filterable.js"></script>
</body>
</html>
