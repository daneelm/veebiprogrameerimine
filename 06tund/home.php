<?php
    require("../../../config_19.php");
    require("functions_main.php");
    require("functions_user.php");
    $database = "if19_daniel_ee_1";
    $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];

    //kontrollime kas on sisse loginud
    if(!isset($_SESSION["userid"])){
        header("location: myindex.php");
        exit();
    }

    //väljalogimine
    if(isset($_GET["logout"])){
        //sessioon kinni
        session_unset();
        session_destroy();
        header("location: myindex.php");
        exit();
    }

    require("header.php");

    echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
?>
    <p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
    <hr>
    <p>Olete sisseloginud! Logi <a href="?logout=1">välja</a></p>

<html>
<head>
<style>
	body{background-color: #FFFFFF; 
	color: #000000} 
</style>
</head>
</html>
