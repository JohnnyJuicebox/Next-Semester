<?php

    require_once('mysqlConn.php');
    session_start();

    CRYPT_BLOWFISH;

    if((!isset($_POST["username"])) || (!isset($_POST["password"])))
        exit;

    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);

    $Blowfish_Pre = '$2a$05$';
    $Blowfish_End = '$';

    $sql = "SELECT user_id, salt, password FROM Users WHERE username = '$username'";

    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_assoc($result);

    $bcrypt_salt = $Blowfish_Pre . $row['salt'] . $Blowfish_End;

    $hashed_password = crypt($password, $bcrypt_salt);

    $logindate = date('Y-m-d');
    $loginTime = date('h:i:s');
    $logindateTime = $logindate . " " . $loginTime;

    $userid = $row['user_id'];

    if($hashed_password == $row['password']){

        $loginSQL = "INSERT INTO Login_Info(USER_ID, LOGIN_TIME) " .
                    "VALUES($userid, '$logindateTime')";

        mysql_query($loginSQL) or die(mysql_error());

        $_SESSION["login_id"] = mysql_insert_id();
        $_SESSION["username"] = $username;
        $_SESSION["user_id"] = $userid;

        mysql_close($link);

        header('Location: success.php');
    } else {
        mysql_close($link);
        echo "Invalid username\n";
    }

?>
