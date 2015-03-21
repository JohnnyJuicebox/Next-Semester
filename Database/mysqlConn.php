<?php

    define('HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'NextSemester');

    $link = mysql_connect(HOST, DB_USER, DB_PASS) or die('Not connected');
    mysql_select_db(DB_NAME, $link) or die('Not selected');

    date_default_timezone_set("America/New_York");
?>
