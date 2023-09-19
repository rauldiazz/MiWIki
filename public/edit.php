
<?php
    if (!isset($_GET['page_id'])) {
        include("error404.php");
        exit();
    }
    $page_id = $_GET['page_id'];
    $page_data = getPageData($page_id);
    $page_content = getPageContent($page_id);

    if (!$page_data or !$page_content) {
        include("error404.php");
        exit();
    }

    session_start();

    if (!isset($_SESSION['user_id'])) {
        $title = "Login required";
        include("header.php");
        include("error_require_login.php");
        include("footer.php");
        exit();
    }

    $title = "Edit page";
    include("header.php");
    include("editor.php");

?>

    <script>
        var page_id = <?php echo $page_id?>;
        var page_title = <?php echo json_encode($page_data['title'])?>;
        var page_category = <?php echo json_encode($page_data['category'])?>;
        var page_content = <?php echo json_encode($page_content)?>;
    </script>

    <script src='/public/scripts/edit.js'></script>

<?php
    include("footer.php");
?>