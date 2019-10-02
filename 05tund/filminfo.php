<?php
    require("../../../config_19.php");
    //echo $serverHost;
    $userName = "Daniel Eelmaa";
    $database = "if19_daniel_ee_1"; 
    
    require("functions_film.php");

    $filmInfoHTML = readAllFilms();
    $filmAge = 50;
    $oldFilmInfoHTML = readOldFilms($filmAge);

    require("header.php");
   // echo (intdiv(7, 5));
    echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
?>
    <p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
    
<hr>
<h2>Eesti filmid</h2>
<p>Meie andmebaasis leidvad järgmised filmid </p>
<hr>
<?php
echo $filmInfoHTML;
echo "<hr>";
echo "<h2>Filmid, mis on vanemad, kui " .$filmAge ." aastat.</h2>";
echo $oldFilmInfoHTML;
//echo $randomImgHTML;
?>