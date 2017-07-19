<?php
include('framework/framework.php');
?>
<div class="row">
    <p class="fancy-titel">Landgoed-Schoolland</p>
    <div class="col-md-3" style="font-family: 'Roboto Slab';">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Kamer Reserveren</h3>
            </div>
            <form action="reserveren.php" method="post">
                <table class="table" style="font-size: 12px;">
                    <tr>
                        <td>
                            <span><?php echo $taal['aanvang']; ?>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="aanvang-datum" type="date" value="<?php echo $aanvang; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['vertrek']; ?>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="vertrek-datum" type="date" value="<?php echo $vertrek; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Reserveren">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="col-md-9">
        <br>
        <div id="myCarousel" class="carousel slide" data-ride="carousel" style="height: 70%;width: 100%;float: right">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
                <li data-target="#myCarousel" data-slide-to="5"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

                <div class="item active">
                    <img src="img/images/Banner%2002.JPG" alt="Tuin" class="foto-slide">
                    <div class="carousel-caption">
                        <h3>Tuin</h3>
                        <p>Lekker in de tuin met een wijntje</p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/images/Banner%2003.JPG" alt="Hal" class="foto-slide">
                    <div class="carousel-caption">
                        <h3>Hal</h3>
                        <p>De mooie hal gelegen in het huis</p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/images/Banner%2004.JPG" alt="Masterkamer" class="foto-slide">
                    <div class="carousel-caption">
                        <h3>Masterkamer</h3>
                        <p>De masterkamer voor de ouders of als stelletje</p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/images/Banner%2005.JPG" alt="Woonkamer" class="foto-slide">
                    <div class="carousel-caption">
                        <h3>Woonkamer</h3>
                        <p>De altijd gezellige open woonkamer</p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/images/Banner%2006.JPG" alt="Badkamer" class="foto-slide">
                    <div class="carousel-caption">
                        <h3>Badkamer</h3>
                        <p>De mooi ingerichte badkamer die voldoet aan alle hygiënische wensen</p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/images/Banner%2001.png" alt="School" class="foto-slide">
                    <div class="carousel-caption">
                        <h3>School</h3>
                        <p>Oude Locatie</p>
                    </div>
                </div>

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>


</div>
<div class="row">
    <div class="col-md-12">
        <h3 align="center">
            <?php echo $taal['home-titel1-h3']; ?>
        </h3>

        <span>
            <?php echo $taal['home-p']; ?>
        </span>
    </div>

</div>

<br><br>
<?php include('framework/footer.php'); ?>
