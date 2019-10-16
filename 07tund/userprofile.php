<?php
    require("../../../config_19.php");
    require("functions_main.php");
    require("functions_user.php");
    $database = "if19_daniel_ee_1";
    $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
    $mydescription="";
    $mybgcolor="";
    $mytxtcolor="";
    $notice="";

    //$_SESSION["bgColor"] ja $_SESSION["txtColor"];
        //kontrollime kas on sisse loginud
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
        } if(isset($_POST["submitProfile"])){
            $notice = storeUserProfile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
            if(!empty($_POST["description"])){
                $myDescription = $_POST["description"];
              }
              $_SESSION["bgColor"] = $_POST["bgcolor"];
              $_SESSION["txtColor"] = $_POST["txtcolor"];
            } else {
              $myProfileDesc = showMyDesc();
              if($myProfileDesc != ""){
                $myDescription = $myProfileDesc;
              }
            }
            //$_SESSION["bgColor"] = $mybgcolor;
            //$_SESSION["txtColor"]) = $mytxtcolor;
        

        require("header.php");
        echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
       
        
?>




<p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
        <hr>
        <p>Olete sisseloginud! Logi <a href="?logout=1">välja</a></p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Minu kirjeldus</label><br>
            <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
            <br>
            <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
            <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
            <input name="submitProfile" type="submit" value="Salvesta profiil"><span><?php echo $notice; ?></span>
</form>
       
</body>
</html>
