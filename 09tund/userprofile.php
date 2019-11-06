<?php
    require("../../../config_19.php");
    require("functions_main.php");
    require("functions_user.php");
    $database = "if19_daniel_ee_1";
    $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
    $mydescription="";
    #$mybgcolor="";
    #$mytxtcolor="";
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
            $notice = storeUserProfile(test_input($_POST["description"]), $_POST["bgcolor"], $_POST["txtcolor"]);
            if(!empty($_POST["description"])){
                $myDescription = test_input($_POST["description"]);
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



            $oldpassword = "";
            $newpasswor = "";
            $repeatnewpassword = "";
            $passwordfromdb = "";
            $oldpwError = "";
            $newpwError = "";
            $confirmnewpwError = "";

            if(isset($_POST['changepw'])){
              if(!isset($_POST["oldpassword"]) or strlen($_POST["oldpassword"]) < 8 or empty($_POST["oldpassword"])){
                $oldpwError = "Ei sobi";
              }
              if(!isset($_POST["newpassword"]) or strlen($_POST["newpassword"]) < 8 or empty($_POST["newpassword"])){
                $newpwError = "Ei sobi";
              }
              if (!isset($_POST["confirmnewpassword"]) or empty($_POST["confirmnewpassword"]) or $_POST["confirmnewpassword"] != $_POST["newpassword"]){
                $confirmnewpwError = "Ei sobi";  
              }
              if(empty($oldpwError) and empty($newpwError) and empty($confirmnewpwError)){
                $notice = changePw($_POST["oldpassword"], $_POST["newpassword"]);
                 }
              else{
                $notice = "viga";
              }
            }





        require("header.php");
        echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
       
        
?>




<p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
        <hr>
        <p>Olete sisseloginud! Logi <a href="?logout=1">välja</a></p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Minu kirjeldus</label><br>
            <textarea rows="10" cols="80" name="description" placeholder="Sisesta siia oma tutvustus."><?php echo $mydescription; ?></textarea>
            <br>
            <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
            <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
            <input name="submitProfile" type="submit" value="Salvesta profiil"><span><?php echo $notice; ?></span>
            </form>


          <br><br><br>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <label>Vana salasõna:</label><br>
          <input name="oldpassword" type="password"><?php echo $oldpwError; ?><br><br>
          <label>Uus salasõna</label><br>
          <input type='password' name='newpassword'><?php echo $newpwError; ?><br><br>
          <label>Korrake uut salasõna</label><br>
          <input type='password' name='confirmnewpassword'><?php echo $confirmnewpwError; ?><br><br>
          <input type='submit' name='changepw' value='Muuda parool'><span><?php echo $notice; ?>
          </form>
       
</body>
</html>
