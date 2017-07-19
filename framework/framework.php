<?php
require 'vendor/autoload.php';
include_once('includes/database.php');
include('includes/functions.php');

if (!isset($_SESSION)) {
    session_start();
    $_SESSION['taal'] = "nederlands";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['taal'])) {
        $_SESSION['taal'] = $_POST['taal'];
    }
}
switch ($_SESSION['taal']) {
    case "nederlands":
        include("taal/nederlands.php");
        break;
    case "engels":
        include("taal/engels.php");
        break;
    case "duits":
        include("taal/duits.php");
        break;
}

global $taal;
?>

<html>
<head>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">

    <title>
        B&B Landgoed Schoolland
    </title>

</head>
<body style="background-color: white;font-family: 'Roboto Slab'">
<div class="container" style="background-color: white">


    <?php
    include('header.php')
    ?>
    <script src="jquery/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <!--  Callender from yui  -->
    <script src="http://yui.yahooapis.com/3.18.1/build/yui/yui-min.js"></script>

