<?php
$gebruikerCheckEmail="";
if(!empty($_SESSION['gebruiker'])){
    $gebruikerCheckEmail = $_SESSION['gebruiker'];
}else{
    $_SESSION['gebruiker'] = "";
}
// vraagt informatie op over de gebruiker.
$ses_sql = mysqli_query($db,"select email from ls_admin_gebruiker where email = '$gebruikerCheckEmail'");

$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

$login_id = $row['id'];
$login_session = $row['email'];             // bevat de email die gevraagd wordt van de database.

