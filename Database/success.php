<?php
    session_start();
    if(!isset($_SESSION["username"]) || (empty($_SESSION["username"]))){
        header("Location: loginform.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang=en>
<head>
<title>Success</title>
</head>
<body>

    <?php
        echo "Login id is ". $_SESSION["login_id"];
        echo "<br/>";
        echo "Welcome, " . $_SESSION["username"];
    ?>

    <a href="logout.php">Logout</a>
</body>
</html>
