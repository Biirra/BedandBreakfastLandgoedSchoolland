<?php
include ('../includes/database.php');

$error = "";
function sentEmailNieuwsbrief($db, $email){
    $sql = "INSERT INTO ls_nieuws_brief (email) VALUES ('$email')";
    mysqli_query($db, $sql);
}
function deleteEmailNieuwsbrief($db, $email){
    $sql = "DELETE FROM ls_nieuws_brief WHERE email = '$email'";
    mysqli_query($db, $sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['nb_email'])){
        $email = $_POST['nb_email'];
        $sql = "SELECT email FROM ls_nieuws_brief WHERE email = '$email'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if(count($row) == 0){
            sentEmailNieuwsbrief($db, $email);
        }else{
            $error = "Deze email is al geabonneerd";
        }
    }else{
        $error = "Het email veld is leeg";
    }
}

?>
<div class="row" align="center">
    <div class="col-md-12">
        <div class="nb-outer-div">
            <div class="nb-inner-div">
                <form method="post" name="form_nieuwsbrief_email">
                    <label>Email: </label>
                    <input type="email" name="nb_email" placeholder="voorbeeld@voorbeeld.com">
                    <input type="submit" value="submit">
                    <button>anuleren</button>
                </form>

                <p class="error"><?php echo $error; ?></p>
            </div>
        </div>
    </div>
</div>
<script rel="javascript" src="js/javascript.js">