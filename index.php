<?php 
    require_once("config.php");
    require_once("database.php");
    require_once("router.php");

    // Load route URL
    $routeURL = $_SERVER['REQUEST_URI'];
    loadURL($routeURL);

?>