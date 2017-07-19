<?php
include_once("database.php");
include('functions.php');
//---------------------------------
//    Ajax voor de kalender
//---------------------------------
$datumsBezet = "";
if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        switch ($action) { //Switch case for value of action
            case "getDatumsBezet":
                getDatumsBezet($db);
                break;
        }
    }
}
//Function to check if the request is an AJAX request
function is_ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function getjaar($date){
    $originalDate = explode("-", $date);
    return $originalDate[0];
}
function getmaand($date){
    $originalDate = explode("-", $date);
    return $originalDate[1]-1;
}
function getdag($date){
    $originalDate = explode("-", $date);
    return $originalDate[2];
}


function getDatumsBezet($db)
{
    $return = "";
    $sql = "SELECT aanvang, vertrek FROM ls_reservering WHERE geaccepteerd = 1;";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $return[getjaar($row['aanvang'])."-".getjaar($row['vertrek'])][getmaand($row['aanvang'])."-".getmaand($row['vertrek'])][getdag($row['aanvang'])."-".getdag($row['vertrek'])] = "iets";
    }
    $return["json"] = json_encode($return);
    echo json_encode($return);
}

?>