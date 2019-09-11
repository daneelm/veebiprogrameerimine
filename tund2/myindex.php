<?php
    $userName = "Daniel Eelmaa";
    $fullTImeNow = date("d.m.Y H:i:s");
    $hourNow = date("H");
    $partOfDay = "hägune aeg";

    if($hourNow < 8){
        $partOfDay = "hommik";
    }
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title><?php
    echo $userName;
    ?>
     programmerib veebi</title>   
</head>
<body>
    <?php
    echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
    ?>
    <p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
<?php
    echo "<p>See on minu esimene PHP!</p>";
    echo "<p>Lehe avamise hetkel oli " .$fullTImeNow .", " .$partOfDay .".</p>";
?>




</body>
</html>