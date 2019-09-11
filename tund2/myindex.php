<?php
    $userName = "Daniel Eelmaa";
    $fullTImeNow = date("d.m.Y H:i:s");
    $hourNow = date("H");
    $partOfDay = "hägune aeg";

    if($hourNow < 8 AND $hourNow > 4){
        $partOfDay = "hommik";
    }
    elseif($hourNow > 8 AND $hourNow < 16){
        $partOfDay = "kooliaeg";
    }
    elseif($hourNow > 16 AND $hourNow < 19){
        $partOfDay = "õhtu";
    }
    else{
        $partOfDay = "öö";
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