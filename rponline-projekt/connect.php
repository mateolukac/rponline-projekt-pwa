<?php
    header('Content-Type: text/html; charset=utf-8');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $basename = "rponline";
    $dbc = mysqli_connect($servername, $username, $password, $basename)
        or die('Error connecting to MySQL server.'.mysqli_error());
    mysqli_set_charset($dbc, "utf8");
    $stmt=mysqli_stmt_init($dbc);
?>