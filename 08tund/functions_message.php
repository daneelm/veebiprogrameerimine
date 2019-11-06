<?php
    function storeMessage($message){
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $notice = null;
    $stmt = $conn -> prepare("INSERT INTO vpmsg (userid, message) VALUES(?,?)"); //sql keeles võtab tabeli nime ja lahtrid
    echo $conn -> error; //sql error
    $stmt -> bind_param("is", $_SESSION["userId"], $message); //seob küsimärgid väärtustega
    if($stmt -> execute()){ //paneb tööle käsu
        $notice = "Sõnum salvestati!";
    }
    else{
        $notice = "Sõnumi salvestamisel tekkis tehniline tõrge: " .$stmt -> error; 
    }
    $stmt->close();
    $conn->close();
    return $notice;
}

function readAllMessages(){
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $notice = null;
    $stmt = $conn -> prepare("SELECT message, created FROM vpmsg WHERE deleted IS NULL ORDER BY created DESC"); //kuupäeva järgi DESC - descending
    echo $conn -> error;
    $stmt -> bind_result($messageFromDb, $createdFromDb);
    $stmt -> execute();
    while($stmt -> fetch()){
        $notice .= "<li>" .$messageFromDb ." (Lisatud: " .$createdFromDb .")</li> \n";
    }
    if(!empty($notice)){
        $notice = "<ul> \n" .$notice ."</ul> \n";
    }
    else{
        $notice = "<p>Kahjuks sõnumeid ei ole.</p> \n";
    }

    $stmt->close();
    $conn->close();
    return $notice;
}

function readMyMessages(){
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $notice = null;
    $stmt = $conn -> prepare("SELECT message, created FROM vpmsg WHERE userid = ? AND deleted IS NULL ORDER BY created DESC"); //kuupäeva järgi DESC - descending  deleted IS NULL
    echo $conn -> error;
    $stmt -> bind_param("i", $_SESSION["userId"]);
    $stmt -> bind_result($messageFromDb, $createdFromDb);
    $stmt -> execute();
    while($stmt -> fetch()){
        $notice .= "<li>" .$messageFromDb ." (Lisatud: " .$createdFromDb .")</li> \n";
    }
    if(!empty($notice)){
        $notice = "<ul> \n" .$notice ."</ul> \n";
    }
    else{
        $notice = "<p>Kahjuks sõnumeid ei ole.</p> \n";
    }

    $stmt->close();
    $conn->close();
    return $notice;
}