<?php
    require("../../../config_19.php");
    //echo $serverHost;
    $userName = "Daniel Eelmaa";
    $database = "if19_daniel_ee_1"; 
    
    require("functions_film.php");

    $titleEmpty = "";
    $yearValue = "2019";
    $durationValue = "80";
    $genreValue = "";
    $studioValue = "";
    $directorValue = "";


    //var_dump($_POST);
    if(isset($_POST["submitFilm"])){
        //echo "keegi submittis";
        // !empty - not empty
        if(!empty($_POST["filmTitle"])){
            storeFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmStudio"], $_POST["filmDirector"]);
            $titleEmpty = "";
            $yearValue = "2019";
            $durationValue = "80";
            $genreValue = "";
            $studioValue = "";
            $directorValue = "";
        }
        else{
            $titleEmpty = "<h3>" ."pealkiri ei saa tühjaks jääda" ."</h3>";
            $yearValue = $_POST["filmYear"];
            $durationValue = $_POST["filmDuration"];
            $genreValue = $_POST["filmGenre"];
            $studioValue = $_POST["filmStudio"];
            $directorValue = $_POST["filmDirector"];
        }
    }
   

    require("header.php");

    echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
?>
    <p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
    
<hr>
<h2>Eesti filmi info lisamine</h2>
<p>Meie andmebaasis uue filmi lisamine </p>
<hr>
<form method="POST">
<label> filmi pealkiri </label>
<input type="text" name="filmTitle" >
<br>
<label> filmi tootmisaasta </label>
<input type="number" min="1912" max="2019" value="<?php echo $yearValue; ?>" name="filmYear">
<br>
<label> filmi kestus </label>
<input type="number" min="1" max="300" value="<?php echo $durationValue; ?>" name="filmDuration">
<br>
<label> filmi žanr </label>
<input type="text" value="<?php echo $genreValue; ?>" name="filmGenre" >
<br>
<label> filmi tootja </label>
<input type="text" value="<?php echo $studioValue; ?>" name="filmStudio" >
<br>
<label> filmi lavastaja </label>
<input type="text" value="<?php echo $directorValue; ?>" name="filmDirector" >
<br>
<input type="submit" value="Talleta filmi info" name="submitFilm">

</form>
<?php
echo $titleEmpty;
?>

</body>
</html>

