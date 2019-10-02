<?php
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