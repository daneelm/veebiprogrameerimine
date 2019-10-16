<?php
//sessiooni kasutamise algatamine
session_start();
//var_dump($_SESSION);

function signUP($name, $surname, $email, $gender, $birthDate, $password){
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $notice = null;
    $stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
    echo $conn->error;

    //tekitame parooli räsi (hash) ehk krüpteerime 
    $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
    $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
    
    $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);

    if($stmt->execute()){
        $notice="kasutaja salvestamine õnnestus";
    }
    else{
        $notice="tehniline tõrge: " .$stmt->error;
    }

    $stmt->close();
    $conn->close();
    return $notice;
}


function signIn($email, $password){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT password FROM vpusers WHERE email=?");
	echo $conn->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($passwordFromDb);
	if($stmt->execute()){
		//kui päring õnnestus
	  if($stmt->fetch()){
		//kasutaja on olemas
		if(password_verify($password, $passwordFromDb)){

		  //kui salasõna klapib
		  $stmt->close();
		  $stmt = $conn->prepare("SELECT id, firstname, lastname FROM vpusers WHERE email=?");
		  echo $conn->error;
		  $stmt->bind_param("s", $email);
		  $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
		  $stmt->execute();
		  $stmt->fetch();
		  $notice = "Sisse logis " .$firstnameFromDb ." " .$lastnameFromDb ."!";	
		  
		  //salvestame kasutaja kohta loetud info sessiooni muutujatesse
		  $_SESSION["userId"] = $idFromDb;
		  $_SESSION["userFirstname"] = $firstnameFromDb;
		  $_SESSION["userLastname"] = $lastnameFromDb;


		  //loeme kasutajaprofiili
		  $stmt->close();
		  $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userId=?");
		  echo $conn->error;
		  $stmt->bind_param("i", $_SESSION["userId"]);
		  $stmt->bind_result($bgColorFromDb, $txtColorFromDb);
		  $stmt->execute();
		  if($stmt->fetch()){
			$_SESSION["bgColor"] = $bgColorFromDb;
	        $_SESSION["txtColor"] = $txtColorFromDb;
		  } else {
		    $_SESSION["bgColor"] = "#FFFFFF";
	        $_SESSION["txtColor"] = "#000000";
		  }



		  //enne sisselogitutele mõeldud lehtedele jõudmist sulgeme andmebaasi ühendused
		  $stmt->close();
		  $conn->close();
		  //liigume soovitud lehele
		  header("location: home.php");
		  //et siin rohkem midagi ei tehtaks
		  exit();
		}
		else {
		  $notice = "Vale salasõna!";
		}
	  }
	  else {
		$notice = "Sellist kasutajat (" .$email .") ei leitud!";  
	  }
	}
	else {
	  $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}//sisselogimine lõppeb



function storeUserProfile($description, $bgColor, $txtColor){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT id FROM vpuserprofiles WHERE userId=?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($idFromDb);
	$stmt->execute();
	if($stmt->fetch()){
		//profiil juba olemas, uuendame
		$notice = "Profiil olemas, ei salvestanud midagi!";
	} else {
		//profiili pole, salvestame
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO vpuserprofiles (userId, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("isss", $_SESSION["userId"], $description, $bgColor, $txtColor);
		if($stmt->execute()){
			$notice = "Profiil edukalt salvestatud!";
		} else {
			$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

function showMyDesc(){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userId=?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($descriptionFromDb);
	$stmt->execute();
    if($stmt->fetch()){
	  $notice = $descriptionFromDb;
	}
	$stmt->close();
	$conn->close();
	return $notice;
}