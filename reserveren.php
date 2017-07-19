<?php
global $taal;
include('framework/framework.php');
?>

<?php
$error = "";
$aanhef = "";
$naam = "";
$achternaam = "";
$adres = "";
$postcode = "";
$plaats = "";
$land = "";
$areaCode = "";
$telefoonnummer = "";
$email = "";
$vragenOpmerking = "";

$aanvang = "";
$vertrek = "";
$aantalPersonen = "";
$aantalKinderen = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //---------------------
    //    klantformulier
    //---------------------
    if (!empty($_POST['klant-aanhef'])) {
        $aanhef = mysqli_real_escape_string($db, $_POST['klant-aanhef']);
    } else {
        $error .= "<li style='color: red'>Selecteer een aanhef</li>";
    }
    if (!empty($_POST['klant-naam'])) {
        $naam = mysqli_real_escape_string($db, $_POST['klant-naam']);
    } else {
        $error .= "<li style='color: red'>vul u naam in</li>";
    }
    if (!empty($_POST['klant-achternaam'])) {
        $achternaam = mysqli_real_escape_string($db, $_POST['klant-achternaam']);
    } else {
        $error .= "<li style='color: red'>vul u achternaam in</li>";
    }
    if (!empty($_POST['klant-adres'])) {
        $adres = mysqli_real_escape_string($db, $_POST['klant-adres']);
    } else {
        $error .= "<li style='color: red'>vul uw adres in</li>";
    }
    if (!empty($_POST['klant-postcode'])) {
        $postcode = mysqli_real_escape_string($db, $_POST['klant-postcode']);
    } else {
        $error .= "<li style='color: red'>vul uw postcode in</li>";
    }
    if (!empty($_POST['klant-plaats'])) {
        $plaats = mysqli_real_escape_string($db, $_POST['klant-plaats']);
    } else {
        $error .= "<li style='color: red'>vul uw woonplaats in</li>";
    }
    if (!empty($_POST['klant-land'])) {
        $land = mysqli_real_escape_string($db, $_POST['klant-land']);
    } else {
        $error .= "<li style='color: red'>selecteer uw land</li>";
    }
    if (!empty($_POST['klant-areacode'])) {
        $areaCode = mysqli_real_escape_string($db, $_POST['klant-areacode']);
    } else {
        $error .= "<li style='color: red'>vul uw area-code in</li>";
    }
    if (!empty($_POST['klant-telefoon'])) {
        $telefoonnummer = mysqli_real_escape_string($db, $_POST['klant-telefoon']);
    } else {
        $error .= "<li style='color: red'>vul een telefoon nummer in</li>";
    }
    if (!empty($_POST['klant-email'])) {
        $email = mysqli_real_escape_string($db, $_POST['klant-email']);
    } else {
        $error .= "<li style='color: red'>vul een email in</li>";
    }

//---------------------------
//    reservering formulier
//---------------------------
    if (!empty($_POST['aanvang-datum'])) {
        if (checkVrijeDatumAanvang($db, $_POST['aanvang-datum'])) {
            $aanvang = mysqli_real_escape_string($db, $_POST['aanvang-datum']);
        } else {
            $error .= "<li style='color: red'>De aanvang datum die u gekozen hebt is al bezet</li>";
        }
    } else {
        $error .= "<li style='color: red'>Selecteer een begin datum</li>";
    }
    if (!empty($_POST['vertrek-datum'])) {
        if (checkVrijeDatumVertrek($db, $_POST['vertrek-datum'])) {
            $vertrek = mysqli_real_escape_string($db, $_POST['vertrek-datum']);
        } else {
            $error .= "<li style='color: red'>De vertrek datum die u gekozen hebt is al bezet</li>";
        }
    } else {
        $error .= "<li style='color: red'>Selecteer een eind datum</li>";
    }
    if (!empty($_POST['aantal-personen'])) {
        $aantalPersonen = mysqli_real_escape_string($db, $_POST['aantal-personen']);
    } else {
        $error .= "<li style='color: red'>Selecteer met hoeveel personen u bent</li>";
    }
    if (!empty($_POST['aantal-kinderen']) && $_POST['aantal-kinderen'] >= 0) {
        $aantalKinderen = mysqli_real_escape_string($db, $_POST['aantal-kinderen']);
    } else {
        $error .= "<li style='color: red'>Selecteer hoeveel kinderen u meeneemt</li>";
    }
    if (!empty($_POST['klant-vragen-opmerking'])) {
        $vragenOpmerking = mysqli_real_escape_string($db, $_POST['klant-vragen-opmerking']);
    }
//---------------------------
//    Verzending Reservering
//---------------------------
    if ($error == "") {
        createKlant($db, $aanhef, $naam, $achternaam, $adres, $postcode, $plaats, $land, $areaCode, $telefoonnummer, $email);
        createResevering($db, $email, $aanvang, $vertrek, $aantalPersonen, $aantalKinderen, $vragenOpmerking);
        $createEmailContent = "De volgende klant wil een reservering maken: 
                                Naam: $naam 
                                Achternaam: $achternaam
                                Adres: $adres
                                Postcode: $postcode plaats: $plaats
                                Land: $land
                                Telefoonnummer: $areaCode - $telefoonnummer
                                Email: $email
                                
                                van: " . reverseDate($aanvang) . " tot: " . reverseDate($vertrek) . "
                                Volwassenen: $aantalPersonen Kinderen: $aantalKinderen
                                Vragen/Opmerkingen: $vragenOpmerking";

        $emailStatusCode = sendReserveringMail($email, "jw.huising@gmail.com", $createEmailContent);
        if ($emailStatusCode == 200 ||
            $emailStatusCode == 202
        ) {
            echo "Uw reservering is verzonden";
        } elseif ($emailStatusCode == 400 ||
            $emailStatusCode == 401 ||
            $emailStatusCode == 403 ||
            $emailStatusCode == 404 ||
            $emailStatusCode == 405 ||
            $emailStatusCode == 413 ||
            $emailStatusCode == 415 ||
            $emailStatusCode == 429
        ) {
            echo "Er is iets mis gegaan met het verzenden van de reservering.";
        } elseif ($emailStatusCode == 500 ||
            $emailStatusCode == 503
        ) {
            echo "De mail service is tijdelijk buiten gebruik. Probeer het later opnieuw.";
        }
    }
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <h3>Reserveren</h3>
        </div>
    </div>
    <div class="row">
        <form method="post">
            <div class="col-md-6" style="float: right">
                <h3><?php echo $taal['prijzen-titel']; ?></h3>
                <?php echo $taal['prijzen-text']; ?>

                <br><br><br>
                <img src="img/images/gezond-ontbijt.jpg" width="600px" height="350px">
            </div>
                <div class="col-md-5">
                <table class="table table-bordered" >
                    <tr>
                        <td>
                            <span><?php echo $taal['aanhef']; ?>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="klant-aanhef">
                                <option selected disabled>
                                    <?php echo $taal['aanhef']; ?>
                                </option>
                                <option value="man">
                                    <?php echo $taal['man']; ?>
                                </option>
                                <option value="vrouw">
                                    <?php echo $taal['vrouw']; ?>
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['klant-naam']; ?>* </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="klant-naam" value="<?php echo $naam; ?>"
                                   placeholder="<?php echo $taal['klant-naam']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['klant-achternaam']; ?>* </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="klant-achternaam" value="<?php echo $achternaam; ?>"
                                   placeholder="<?php echo $taal['klant-achternaam']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['klant-adres'] ?>* </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="klant-adres" value="<?php echo $adres; ?>"
                                   placeholder="<?php echo $taal['klant-adres'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['klant-postcode'] ?>* </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="klant-postcode" maxlength="6" value="<?php echo $postcode; ?>"
                                   placeholder="<?php echo $taal['klant-postcode'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['klant-plaats']; ?>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="klant-plaats" value="<?php echo $plaats; ?>"
                                   placeholder="<?php echo $taal['klant-plaats']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['land']; ?>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="klant-land">
                                <option selected disabled><?php echo $taal['land']; ?></option>
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Åland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia, Plurinational State of</option>
                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="BN">Brunei Darussalam</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CD">Congo, the Democratic Republic of the</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Côte d'Ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CW">Curaçao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands (Malvinas)</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard Island and McDonald Islands</option>
                                <option value="VA">Holy See (Vatican City State)</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran, Islamic Republic of</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KP">Korea, Democratic People's Republic of</option>
                                <option value="KR">Korea, Republic of</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Lao People's Democratic Republic</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao</option>
                                <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia, Federated States of</option>
                                <option value="MD">Moldova, Republic of</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PS">Palestinian Territory, Occupied</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Réunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="BL">Saint Barthélemy</option>
                                <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LC">Saint Lucia</option>
                                <option value="MF">Saint Martin (French part)</option>
                                <option value="PM">Saint Pierre and Miquelon</option>
                                <option value="VC">Saint Vincent and the Grenadines</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SX">Sint Maarten (Dutch part)</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                <option value="SS">South Sudan</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania, United Republic of</option>
                                <option value="TH">Thailand</option>
                                <option value="TL">Timor-Leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VE">Venezuela, Bolivarian Republic of</option>
                                <option value="VN">Viet Nam</option>
                                <option value="VG">Virgin Islands, British</option>
                                <option value="VI">Virgin Islands, U.S.</option>
                                <option value="WF">Wallis and Futuna</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Area-code + <?php echo $taal['klant-telefoonnummer']; ?>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="klant-areacode" value="<?php echo $areaCode; ?>"
                                   style="width: 35px" placeholder="<?php echo $taal['klant-area-code']; ?>">
                            <input type="text" name="klant-telefoon" value="<?php echo $telefoonnummer; ?>"
                                   placeholder="<?php echo $taal['klant-telefoonnummer']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php echo $taal['klant-email']; ?>*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="email" name="klant-email" value="<?php echo $email; ?>"
                                   placeholder="<?php echo $taal['klant-email']; ?>">
                        </td>
                    </tr>
                </table>


            </div>
    </div>
    <div class="row">
    <div class="col-md-5">
        <table class="table table-bordered">
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
                    <span><?php echo $taal['aantal-personen']; ?>*</span>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="aantal-personen">
                        <option><?php echo $taal['aantal-personen']; ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span><?php echo $taal['aantal-kinderen']; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="aantal-kinderen">
                        <option><?php echo $taal['aantal-kinderen']; ?></option>

                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span><?php echo $taal['klant-vraag-opmerking']; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="klant-vragen-opmerking" value="<?php echo $vragenOpmerking; ?>"
                           placeholder="<?php echo $taal['klant-vraag-opmerking']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <input type="submit">
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                    <span>*<?php echo $taal['verplichte-onderdelen']; ?></span>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-4" style=";">
        <table class="table">
            <br>
            <br>
            <!-- start kallender -->
            <div id="" class="yui3-skin-sam yui3-g"> <!-- You need this skin class -->
                <div id="leftcolumn" class="yui3-u">
                    <!-- Container for the calendar -->
                    <div id="mycalendar"></div>
                </div>
            </div>
            <!-- eind kallender -->
        </table>
    </div>
    </form>
</div>
<div>
    <ul>
        <?php echo $error; ?>
    </ul>
</div>
</div>
<script src="js/reserveren.js"></script>
<script src="calendar/calendar.js"></script>
<?php include("framework/footer.php"); ?>

