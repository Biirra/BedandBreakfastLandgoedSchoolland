<?php
if (!isset($_SESSION)) {
    session_start();
}
include ("includes/config.php");
global $adminPanel;

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $myemail = "";
    $mypassword = "";
    if (!empty($_POST['email']))
        $myemail = mysqli_real_escape_string($db, $_POST['email']);
    if (!empty($_POST['wachtwoord']))
        $mypassword = mysqli_real_escape_string($db, $_POST['wachtwoord']);


    $sql = "SELECT wachtwoord, geactiveerd FROM ls_admin_gebruiker WHERE email = '$myemail' LIMIT 1";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if($row['wachtwoord'] > 0){
        if ($row['wachtwoord'] == $mypassword) {
            $_SESSION['gebruiker'] = $myemail;
            header('location: '. $adminPanel["url"]);
            exit;
        } else {
            $error = "Uw email of wachtwoord is incorrect.";
        }
    }else{
        $error = "Dit account bestaat niet";
    }
}
?>


<div align="center">
    <div class="form-container-outer">
        <div class="form-container-title" align="left"><b>Login</b></div>

        <div class="form-container-inner">

            <form action="" method="post">

                <table class="formtable">
                    <tr>
                        <td>
                            <label>Email :</label>
                        </td>
                        <td>
                            <input type="email" name="email" class="box"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password :</label>
                        </td>
                        <td>
                            <input type="password" name="wachtwoord" class="box"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value=" Login! "/><br/>
                        </td>
                        <td>
                            <!--                            <a href="-->
                            <?php //echo $config['homeURL']; ?><!--?state=wwvergeten">Wachtwoord vergeten?</a>-->
                        </td>
                    </tr>
                </table>

            </form>

            <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>

        </div>

    </div>

</div>
