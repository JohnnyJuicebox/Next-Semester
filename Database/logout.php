<?php

    require_once('mysqlConn.php');
    session_start();

    $logoutdate = date('Y-m-d');
    $logoutTime = date('h:i:s');

    $logoutdateTime = $logoutdate . " " . $logoutTime;

    if(isset($_SESSION["login_id"])){
        $loginId = $_SESSION["login_id"];
        $sql = "UPDATE LOGIN_INFO SET LOGOUT_TIME = '$logoutdateTime' WHERE LOGIN_ID = $loginId";
        $result = mysql_query($sql);
    }

    if(isset($_SESSION["login_id"]))
        unset($_SESSION["login_id"]);

    if(isset($_SESSION["user_id"]))
        unset($_SESSION["user_id"]);

    if(isset($_SESSION["username"]))
        unset($_SESSION["username"]);

    mysql_close($link);
    session_destroy();

    header('Location: loginform.php');
?>
