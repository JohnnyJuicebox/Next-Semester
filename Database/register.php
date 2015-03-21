<?php
    require_once('mysqlConn.php');

    CRYPT_BLOWFISH;

    if((!isset($_POST["username"])) || (!isset($_POST["password"])) || (!isset($_POST["email"])))
        exit;

    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $email = mysql_real_escape_string($_POST['email']);

    $Blowfish_Pre = '$2a$05$';
    $Blowfish_End = '$';

    $Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';

    $Chars_Len = 63;
    $Salt_Length = 21;

    $mysql_date = date('Y-m-d');
    $salt = "";

    for($index=0; $index < $Salt_Length; $index++){
        $salt .= $Allowed_Chars[mt_rand(0, $Chars_Len)];
    }

    $bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
    $hashed_password = crypt($password, $bcrypt_salt);

    $sql = "INSERT INTO Users(USERNAME, PASSWORD, SALT, EMAIL) " .
           "VALUES('$username', '$hashed_password', '$salt', '$email')";

    mysql_query($sql) or die( mysql_error());
    mysql_close($link);

?>
