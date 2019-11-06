<?php
    require("../../../config_19.php");
    require("functions_main.php");
    require("functions_user.php");
    require("functions_message.php");
    $database = "if19_daniel_ee_1";
    $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
    $notice="";
        if(!isset($_SESSION["userId"])){
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
        if(isset($_POST["submitMessage"])){
            if(!empty(test_input($_POST["message"]))){
              $notice = storeMessage(test_input($_POST["message"]));
            }
            else{
              $notice = "Tühja sõnumit ei salvestata";
            }
        }

        //$messageHTML = readAllMessages();
        $messageHTML = readMyMessages();

        require("header.php");
        echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";  
?>
<p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
        <hr>
        <p>Olete sisseloginud! Logi <a href="?logout=1">välja</a></p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Minu sõnum</label><br>
            <textarea rows="5" cols="51" name="message" placeholder="Sisesta siia oma sõnum."></textarea>
            <br>
            <input name="submitMessage" type="submit" value="Salvesta sõnum"><span><?php echo $notice; ?></span>
</form>
<hr>
<h2>Senised sõnumid</h2>
<?php
echo $messageHTML;
?>
       
</body>
</html>
