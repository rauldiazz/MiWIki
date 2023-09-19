<?php

function sendPageReport()
{

    session_start();

    global $db_conn;
    global $mysqli;

    $page_id = $_POST['page'];
    $user_id = $_SESSION['user_id'];
    $description = $_POST['description'];

    if (isset($page_id) and isset($description) and isset($user_id)) {
        $query = "INSERT INTO page_reports (page_id,user_id,description) VALUES ('$page_id','$user_id','$description')";
        mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
        return "success";
    }

    return "error";
}

function sendCategoryReport()
{

    session_start();

    global $db_conn;
    global $mysqli;

    $category_id = $_POST['category'];
    $user_id = $_SESSION['user_id'];
    $description = $_POST['description'];

    if (isset($category_id) and isset($description) and isset($user_id)) {
        $query = "INSERT INTO category_reports (category_id,user_id,description) VALUES ('$category_id','$user_id','$description')";
        mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
        return "success";
    }

    return "error";
}

function discardPageReport()
{

    global $db_conn;
    global $mysqli;

    $reportId = $_GET['report_id'];

    session_start();

    if (!isset($_SESSION['user_id']) or !$_SESSION['admin'] or !isset($reportId)) {
        return "error";
    }

    $query = 'DELETE FROM page_reports WHERE page_reports.id=' . $reportId;

    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    return "success";
}

function discardCategoryReport()
{

    global $db_conn;
    global $mysqli;

    $reportId = $_GET['report_id'];

    session_start();

    if (!isset($_SESSION['user_id']) or !$_SESSION['admin'] or !isset($reportId)) {
        return "error";
    }

    $query = 'DELETE FROM category_reports WHERE category_reports.id=' . $reportId;

    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    return "success";
}

function getPageReports()
{

    global $db_conn;
    global $mysqli;

    session_start();

    if (!isset($_SESSION['user_id']) or !$_SESSION['admin']) {
        return "error";
    }

    $query = "SELECT page_reports.id, pages.id AS page_id, pages.title, users.username, page_reports.description, page_reports.created_at FROM page_reports INNER JOIN pages ON page_reports.page_id=pages.id INNER JOIN users ON page_reports.user_id=users.id ORDER BY page_reports.created_at";

    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
    $pageReports = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $pageReports[] = array(
            'id' => $row['id'],
            'page_id' => $row['page_id'],
            'page_title' => $row['title'],
            'user' => $row['username'],
            'description' => $row['description'],
            'created_at' => date("m/d/y H:i:s", strtotime($row['created_at']))
        );
    }

    return json_encode($pageReports);
}

function getCategoryReports()
{

    global $db_conn;
    global $mysqli;

    session_start();

    if (!isset($_SESSION['user_id']) or !$_SESSION['admin']) {
        return "error";
    }

    $query = "SELECT category_reports.id, categories.id as category_id, categories.name, users.username, category_reports.description, category_reports.created_at FROM category_reports INNER JOIN categories on category_reports.category_id=categories.id INNER JOIN users on category_reports.user_id=users.id ORDER BY category_reports.created_at";

    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
    $categoryReports = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $categoryReports[] = array(
            'id' => $row['id'],
            'category_id' => $row['category_id'],
            'category_name' => $row['name'],
            'user' => $row['username'],
            'description' => $row['description'],
            'created_at' => date("m/d/y H:i:s", strtotime($row['created_at']))
        );
    }
    return json_encode($categoryReports);

}

?>