<div id="navbar-main">
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" style="background-color: white;">
        <p style="float: left; font-family: 'Kunstler Script'; font-size: 75; margin-left: 25px;">LS</p>
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span
                        class="icon icon-heart" style="font-size:30px; color:#3498db;"></span></button>
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav" style="margin-left: 120px;margin-top: 35px;">
                    <li><a href="index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true"
                           aria-expanded="false"><?php echo $taal['prijzen']; ?><span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="prijzen.php"><?php echo $taal['bed-en-breakfast']; ?></a>
                            </li>
                            <li>
                                <a href="faciliteiten.php"><?php echo $taal['faciliteiten']; ?></a>
                            </li>
                            <li><a href="pizza-workshop.php"><?php echo $taal['pizza-workshop']; ?></a></li>
                            <!--<li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>-->
                        </ul>
                    </li>
                    <li><a href="fotos.php"><?php echo $taal['fotos']; ?></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true"
                           aria-expanded="false"><?php echo $taal['omgeving-garrelsweer'] ?> <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a href="#"><?php echo $taal['steden']; ?></a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1"
                                           href="omgeving-garrelsweer-appingedam.php"><?php echo $taal['appingedam']; ?></a>
                                    </li>
                                    <li>
                                        <a href="omgeving-garrelsweer-groningenstad.php"><?php echo $taal['groningen-stad']; ?></a>
                                    </li>
                                    <li>
                                        <a href="omgeving-garrelsweer-delfzijl.php"><?php echo $taal['delfzijl']; ?></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#"><?php echo $taal['eilanden']; ?></a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1"
                                           href="eilanden-borkum.php"><?php echo $taal['borkum']; ?></a></li>
                                    <li>
                                        <a href="eilanden-schiermonnikoog.php"><?php echo $taal['schiermonnikoog']; ?></a>
                                    </li>
                                    <li><a href="eilanden-ameland.php"><?php echo $taal['ameland']; ?></a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#"><?php echo $taal['lunch-dinner-ontspanning']; ?></a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1"
                                           href="lunch-diner-ontspanning-landgoed-ekenstein.php"><?php echo $taal['landgoed-ekenstijn']; ?></a>
                                    </li>
                                    <li>
                                        <a href="lunch-diner-ontspanning-restaurant-'t-regthuys-wirdum-groningen.php"><?php echo $taal['reghuys-wirdum']; ?> </a>
                                    </li>
                                    <li>
                                        <a href="lunch-diner-ontspanning-grandcafe-restaurant-bij-de-molen.php"><?php echo $taal['bij-de-molen']; ?></a>
                                    </li>
                                    <li>
                                        <a href="lunch-diner-ontspanning-spa-loppersum.php"><?php echo $taal['spa-loppersum']; ?></a>
                                    </li>
                                    </li>
                                </ul>
                            </li>
                            <!--
                            <li><a href="#">One more separated link</a></li>-->
                        </ul>
                    </li>
                    <li><a href="gastenboek.php"><?php echo $taal['gastenboek']; ?></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true"
                           aria-expanded="false"><?php echo $taal['reserveren-contact']; ?><span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="reserveren.php"><?php echo $taal['reserveren']; ?></a>
                            </li>
                            <li>
                                <a href="contact.php"><?php echo $taal['contact']; ?></a>
                            </li>
                            <!--<li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>-->
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right" style="margin-top: 5px; margin-right: -90px;">
                    <li>
                        <form method="post">
                            <input name="taal" type="hidden" value="nederlands">
                            <input type="image" id="saveform" src="img/netherlands_32.png " alt="Submit Form"/>
                        </form>
                    </li>
                    <li>
                        <form method="post">
                            <input name="taal" type="hidden" value="duits">
                            <input type="image" id="saveform" src="img/germany_32.png " alt="Submit Form"/>
                        </form>
                    </li>
                    <li>
                        <form method="post">
                            <input name="taal" type="hidden" value="engels">
                            <input type="image" id="saveform" src="img/united_kingdom_32.png " alt="Submit Form"/>
                        </form>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <br><br><br><br><br><br><br>