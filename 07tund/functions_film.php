<?php
    function readAllFilms(){
        //var_dump($GLOBALS);
        //loome andmebaasi ühenduse
        //$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        //valmistame ette sql päringu, nt muutuja nimega $query v ..
        $stmt = $conn->prepare("SELECT * FROM film");
        echo $conn->error;
        //seome saadava tulemuse muutujaga
        $stmt->bind_result($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector);
        //täidame käsu ehk sooritame päringu
        $stmt->execute();
        echo $stmt->error;
        $filmInfoHTML = null;
        //võtan tulemuse (pinu ehk stack)
        while($stmt->fetch()){
            //echo $filmTitle;
            $filmInfoHTML .= "<h3>" .$filmTitle ."</h3>";
            //$filmInfoHTML .= "<p>" .$filmYear ."</p>";
            $filmHours = round($filmDuration / 60, 0);
            $filmMinutes = $filmDuration%60;
            $filmDurationDesc = "";
            if ($filmHours > 0){
                if($filmHours == 1){
                    $filmDurationDesc .= $filmHours ." tund ja ";
                } else {
                    $filmDurationDesc .= $filmHours ." tundi ja ";
                }
                if($filmMinutes == 1){
                    $filmDurationDesc .= $filmMinutes ." minut";
                } else {
                    $filmDurationDesc .= $filmMinutes ." minutit";
                }

            }   
            $filmInfoHTML .= "<p>" ." žanr: " .$filmGenre ."," ." lavastaja: " .$filmDirector ."," ." kestus: " .$filmDurationDesc ."," ." tootnud: " .$filmStudio .","  ." aastal: " .$filmYear ."." ."</p>";
        }
        //sulgeme ühenduses
        $stmt->close();
        $conn->close();
        //echo $filmInfoHTML;
        return $filmInfoHTML;
    }

    function storeFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector){
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
        echo $conn->error;
        //seaon saadetava info muutujatega
        //andmetüübid: s - string, i -integer, d - decimal
        $stmt->bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector);
        $stmt->execute();


        $stmt->close();
        $conn->close();
    }
    function readOldFilms($filmAge){
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $maxYear = date("Y") - $filmAge;
        $stmt = $conn->prepare("SELECT pealkiri, aasta FROM film WHERE aasta < ?");
        $stmt->bind_param("i", $maxYear);
        $stmt->bind_result($filmTitle, $filmYear);
        $stmt->execute();
        $filmInfoHTML = "";
        while($stmt->fetch()){
          $filmInfoHTML .= "<h3>" .$filmTitle ."</h3>";
          $filmInfoHTML .= "<p>Tootmisaasta: " .$filmYear .".</p>";
        }
        
        $stmt->close();
        $conn->close();
        return $filmInfoHTML;
    }