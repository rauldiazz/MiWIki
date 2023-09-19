
<?php
    $title = "Error 404";
    session_start();
    include("header.php");
?>

<br>

<div class="container text-center">

    <h1> <?php echo $title ?> </h1>
    <i class="bi bi-exclamation-circle-fill"></i>
    The requested page couldn't be found.

</div>

<?php include("footer.php") ?>