<?php
include('framework/framework.php');
global $taal;
?>

<div class="row">
    <div class="col-md-4">
        <h3><?php echo $taal['prijzen-titel']; ?></h3>
        <?php echo $taal['prijzen-text']; ?>
        </div>
    <div class="col-md-8">
        <img src="img/images/Foto%204.JPG" width="600px" height="350px" style="float: right">
    </div>
        <br>
    <div class="col-md-4">

        <h3><?php echo $taal['prijzen-ontbijtbox-titel']; ?></h3>
        <?php echo $taal['prijzen-ontbijtbox-text']; ?>
        <div class="col-md-12">
            <?php echo $taal['prijzen-ontbijtbox-1p']; ?>
        </div>
        <div class="col-md-12">
            <?php echo $taal['prijzen-ontbijtbox-2p']; ?>
        </div>
    </div>
    <div class="col-md-8">
        <br><br><br>
        <img src="img/images/gezond-ontbijt.jpg" width="600px" height="350px" style="float: right">
    </div>
</div>
<br><br><br>

<?php
include('framework/footer.php');
?>
