
<?php
    $title = "New page";
    session_start();
    include("header.php");

    global $db_conn;
    global $mysqli;

    if (isset($_SESSION['user_id'])) {
        include("editor.php");
        echo "<script src='/public/scripts/create.js'></script>";
    }
    else {
        include("error_require_login.php");
    }
?>

<?php include("footer.php") ?>

