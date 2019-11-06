<?php
    require("../../../config_19.php");
    require("functions_main.php");
    require("functions_user.php");
    $database = "if19_daniel_ee_1";
    $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
    require("functions_film.php");







    require("header.php");
    echo "<h1>" .$userName .", veebiprogrameerimine 2019</h1>";
?>


<p>See veebileht on valminud oppetoo kaigus ning ei sisalda mingisugust tosiseltvoetavat sisu!</p>
</body>
</html>