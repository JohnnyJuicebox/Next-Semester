<?php
    session_start();
    if(isset($_SESSION["username"]) && !(empty($_SESSION["username"]))){
        header("Location: success.php");
        exit;
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Login Form</title>
</head>
<body>
    <form id="login" method="POST" action="login.php">
        Username: <input type="text" name="username" /> <br/>
        Password: <input type="password" name="password" /> <br/>
        <input type="submit" name="subm" value="Submit" />
    </form>
</body>
</html>
