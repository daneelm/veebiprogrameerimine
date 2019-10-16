<?php
    $userName = "Daniel Eelmaa";
    $photoDir = "../photos/";
    $photoTypesAllowed = ["image/jpeg", "image/png"];
    $fullTimeNow = date("d.m.Y H:i:s");
    $hourNow = date("H");
    $partOfDay = "hägune aeg";
    $weekDay = date("N");
    $weekDaysET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
    $monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
    $month = date("n"); 
    $email = null;
    $emailError = null;
    $passwordError = null;
    $notice = null;
    require("../../../config_19.php");
    require("functions_main.php");
    require("functions_user.php");
    $database = "if19_daniel_ee_1";
    $userName = "Sisselogimata kasutaja";
    

    if(isset($_POST["login"])){
		if (isset($_POST["email"]) and !empty($_POST["email"])){
		  $email = test_input($_POST["email"]);
        }
        else {
		  $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
		}
	  
		if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
		  $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
		}
	  
		if(empty($emailError) and empty($passwordError)){
		   $notice = signIn($email, $_POST["password"]);
        }
        else {
			$notice = "Ei saa sisse logida!";
		}
	}

    if($hourNow <= 8 AND $hourNow >= 4){
        $partOfDay = "hommik";
    }
    elseif($hourNow > 8 AND $hourNow < 16){
        $partOfDay = "kooliaeg";
    }
    elseif($hourNow >= 16 AND $hourNow <= 19){
        $partOfDay = "õhtu";
    }
    else{
        $partOfDay = "öö";
    }


    //info semestri kulgemise kohta
    $semesterStart = new DateTime("2019-9-2");
    $semesterEnd = new DateTime("2019-12-13");
    $semesterDuration = $semesterStart -> diff($semesterEnd);
    //echo $semesterStart; //objekti nii näidata ei saa!
    //var_dump($semesterStart);
    //echo $semesterStart -> timezone;
    $today = new DateTime("now");
    $fromSemesterStart = $semesterStart -> diff($today);
    //var_dump($fromSemesterStart);
    //echo $fromSemesterStart -> days;
    //echo "Päevi: " .$fromSemesterStart -> format("%r%a");
    //<p>Semester on täies hoos: <meter min="0" max="110" value="15">17%</meter></p>
    //$semesterInfoHTML = "<p>Info semestri kohta pole kättesaadav.</p>";
    if ($fromSemesterStart -> format("%r%a") > 0 and $fromSemesterStart -> format("%r%a") <= $semesterDuration -> format("%r%a")){
        $semesterInfoHTML = "<p>Semester on täies hoos: ";
        $semesterInfoHTML .= '<meter min="0" ';
        $semesterInfoHTML .= 'max="' .$semesterDuration -> format("%r%a") . '" ';
        $semesterInfoHTML .= 'value="' .$fromSemesterStart -> format("%r%a") . '">';
        $semesterInfoHTML .= round($fromSemesterStart -> format("%r%a") / $semesterDuration -> format("%r%a") * 100, 1) ."%";
        $semesterInfoHTML .= "</meter></p>";
    }
    elseif ($fromSemesterStart -> format("%r%a") < 0){
    $semesterInfoHTML = "<p>Semester on pole veel alanud!";
    }
    elseif ($fromSemesterStart -> format("%r%a") > 0){
    $semesterInfoHTML = "<p>Semester on lõppenud!";
    }
    //juhusliku foto kasutamine
    $photoList = [];//["tlu_terra_600x400_1.jpg", "tlu_terra_600x400_2.jpg", "tlu_terra_600x400_3.jpg"];//array ehk massiiv

    $allFiles = array_slice(scandir($photoDir), 2);
    //var_dump($allFiles);
    //kontrollin kas on pildid
    foreach ($allFiles as $file){
        $fileInfo = getimagesize($photoDir .$file);
        //var_dump($fileInfo);
        if (in_array($fileInfo["mime"], $photoTypesAllowed) == true){
            array_push($photoList, $file);
        }
    }

    //var_dump($photoList);
    //echo $photoList[2];
    $photoCount = count($photoList);
    $randomImgHTML = "";
    if ($photoCount > 0){
        
        $photoNum = mt_rand(0, $photoCount - 1);
        //echo $photoNum;
        //img src="../photos/tlu_terra_600x400_1.jpg" alt="Juhuslik foto">
        $randomImgHTML = '<img src="' .$photoDir .$photoList[$photoNum] .'" alt="Juhuslik foto">';
    }
    else{
        $randomImgHTML = "<p>Kahjuks pilte ei ole !?!?!?!?</p>";
    }

    echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
?>
    <p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
    
<?php
    echo $semesterInfoHTML;
    echo "<p>See on minu esimene PHP!</p>";
    echo "<p>Lehe avamise hetkel oli " .$weekDaysET[$weekDay-1] .", " .$monthsET[$month-1] .", " .$fullTimeNow .", " .$partOfDay .".</p>";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Sisselogimis leht</title>
  </head>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>E-mail (kasutajatunnus):</label><br>
	<input type="email" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span><br>
    <label>Salasõna:</label><br>
    <input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
    <input name="login" type="submit" value="Logi sisse"><span><?php echo $notice; ?></span>
    </form>
    <br>
	<p>Kui pole kasutajakontot</p>
	<p>Loo <a href="newuser.php">kasutajakonto</a>!</p>
</html>
<hr>
<?php
echo $randomImgHTML;
?>