<?php



function createCategory(){

    global $db_conn;
    global $mysqli;

    if(!isset($_POST['name'])){
        return "error";
    }

    $name = mysqli_real_escape_string($db_conn, stripslashes($_POST['name']));

    $query = "INSERT INTO categories (name) VALUES ('$name')";
    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $id = mysqli_insert_id($db_conn);
    $new_category = array('id' => $id, 'name' => $name);
    
    return json_encode($new_category);    
}

function deleteCategory()
{

    global $db_conn;
    global $mysqli;

    $category_id = $_GET['id'];

    session_start();

    if (!isset($_SESSION['user_id']) or !$_SESSION['admin'] or !isset($category_id) or $category_id == 1) {
        return "error";
    }

    $query = "DELETE FROM category_reports WHERE category_reports.category_id=$category_id";
    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $query = "UPDATE pages SET pages.category=1 WHERE pages.category=$category_id";
    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $query = "DELETE FROM categories WHERE categories.id=$category_id";
    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    return "success";
}


function obtainCategories()  
{
    global $db_conn;
    global $mysqli;

    $query = "SELECT id, name FROM categories";
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
    $categories = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    return $categories;
}

function obtainCategoryById($category_id)
{
    global $db_conn;
    global $mysqli;

    $query = "SELECT name FROM categories WHERE id=$category_id";
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($result) == 0)
        return false;

    return mysqli_fetch_assoc($result)['name'];
}


?>