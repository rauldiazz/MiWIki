<?php
    require_once("config.php");

    $db_conn = mysqli_connect(
        DB_URL,
        DB_username,
        DB_password,
        'MiWiki'
    ) or die(mysqli_error($mysqli));

    mysqli_query($db_conn, "SET NAMES 'utf8'");

?>