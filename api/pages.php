<?php


function downloadPage($page_id) {
    
    $file = "uploads/" . $page_id . ".md";

    // Check if the file exists
    if (file_exists($file)) {
        // Get the page data
        $page_data = getPageData($page_id);
        if ($page_data) {
            // Set the headers to indicate it's a downloadable file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $page_data['title'] . '.md"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
        readfile($file);
        } else {
            include("public/error404.php");
        }
    } else {
        include("public/error404.php");
    }
    return;
}

function deletePage()
{

    global $db_conn;
    global $mysqli;

    $page_id = $_GET['id'];

    session_start();

    if (!isset($_SESSION['user_id']) or !$_SESSION['admin'] or !isset($page_id)) {
        return "error";
    }

    $query = "DELETE FROM page_reports WHERE page_reports.page_id=$page_id";
    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $query = "DELETE FROM pages WHERE pages.id=$page_id";
    mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    unlink('uploads/' . $page_id . '.md');

    return "success";
}


function numberOfPages()
{

    global $db_conn;
    global $mysqli;

    $query = "SELECT COUNT(*) as total FROM pages;";
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $data = mysqli_fetch_array($result);
    return $data["total"];
}


function numberOfPagesByuser($user_id)
{

    global $db_conn;
    global $mysqli;

    $query = "SELECT COUNT(*) as total FROM pages WHERE created_by = $user_id;";
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $data = mysqli_fetch_array($result);
    return $data["total"];
}


function getRandomPageId()
{

    global $db_conn;
    global $mysqli;

    $query = "SELECT id FROM pages ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $data = mysqli_fetch_array($result);
    return $data["id"];
}

function getListOfPages()
{

    global $db_conn;
    global $mysqli;

    if (isset($_GET['criterion'])) {
        $criterion = $_GET['criterion'];
    }
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
    }

    session_start();
    if (!isset($_SESSION['user_id'])) {
        return "error";
    }

    $query = "SELECT id, title FROM pages WHERE created_by = " . $_SESSION['user_id'];

    if (isset($category)) {
        $query .= " AND category = " . $category;
    }
    if (isset($criterion)) {
        $query .= " ORDER BY " . $criterion . " ASC";
    }

    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

    $pages = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $pages[] = $row;
    }

    return json_encode($pages);
}


function getPageData($page_id)
{

    global $db_conn;
    global $mysqli;

    $query = "SELECT * FROM pages WHERE id=$page_id";
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($result) == 0)
        return false;
    $page_data = mysqli_fetch_assoc($result);

    $query = 'SELECT username FROM users WHERE id=' . $page_data['created_by'];
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($result) == 0)
        return false;
    $page_data['created_by'] = mysqli_fetch_assoc($result)['username'];

    $query = 'SELECT username FROM users WHERE id=' . $page_data['updated_by'];
    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($result) == 0)
        return false;
    $page_data['updated_by'] = mysqli_fetch_assoc($result)['username'];

    return $page_data;
}

function getPageContent($page_id)
{

    $page_path = 'uploads/' . $page_id . '.md';
    if (!file_exists($page_path))
        return false;
    return file_get_contents($page_path);
}

function createPage()
{
    session_start();

    global $db_conn;
    global $mysqli;

    if (
        isset($_POST['title']) and
        isset($_POST['categories']) and
        isset($_POST['content'])
    ) {
        $titleInput = mysqli_real_escape_string($db_conn, stripslashes($_POST['title']));
        $categoryInput = mysqli_real_escape_string($db_conn, stripslashes($_POST['categories']));
        $textInput = stripcslashes($_POST['content']);
        $userId = $_SESSION['user_id'];

        $query = "INSERT INTO pages (title,category,created_by,updated_by) VALUES ('$titleInput', $categoryInput, '$userId', '$userId')";

        $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
        if ($result) {
            $note_id = mysqli_insert_id($db_conn);
            $route_to_file = "uploads/" . $note_id . '.md';
            file_put_contents($route_to_file, $textInput);

            return $note_id;
        }
    }
    return "error";
}

function editPage()
{
    session_start();

    global $db_conn;
    global $mysqli;

    if (
        isset($_POST['page_id']) and
        isset($_POST['title']) and
        isset($_POST['categories']) and
        isset($_POST['content'])
    ) {
        $pageId = mysqli_real_escape_string($db_conn, stripslashes($_POST['page_id']));
        $titleInput = mysqli_real_escape_string($db_conn, stripslashes($_POST['title']));
        $categoryInput = mysqli_real_escape_string($db_conn, stripslashes($_POST['categories']));
        $textInput = stripcslashes($_POST['content']);
        $userId = $_SESSION['user_id'];

        $query = "UPDATE pages SET title='$titleInput', category=$categoryInput, updated_by=$userId WHERE id=$pageId";

        $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
        if ($result) {
            $route_to_file = "uploads/" . $pageId . '.md';
            file_put_contents($route_to_file, $textInput);

            return $pageId;
        }
    }
    return "error";
}


function loadPage($page_id)
{

    $page_data = getPageData($page_id);
    $page_content = getPageContent($page_id);

    if (!$page_data or !$page_content) {
        include("public/error404.php");
    } else {
        include("public/page_template.php");
    }
}


function findFirstImageURL($page_id)
{
    $file_contents = getPageContent($page_id);

    $imgFound = strpos($file_contents, '![');
    if ($imgFound == false) {
        return '';
    }
    $startChar = strpos($file_contents, '(', $imgFound);
    $endChar = strpos($file_contents, ')', $startChar);

    if ($startChar == false or $endChar == false) {
        return '';
    }

    return substr($file_contents, $startChar + 1, $endChar - $startChar - 1);
}

function searchPages()
{
    global $db_conn;
    global $mysqli;

    $response = array();

    $promptInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['prompt']));
    $query = "SELECT pages.id, pages.title, categories.id AS c_id, categories.name AS c_name, pages.updated_at, users.username FROM pages INNER JOIN users ON pages.updated_by=users.id INNER JOIN categories ON pages.category=categories.id WHERE pages.title LIKE '%$promptInp%'";

    if (isset($_POST['category'])) {
        $category = mysqli_real_escape_string($db_conn, stripslashes($_POST['category']));
        $query .= " AND pages.category = " . $category;
    }
    if (isset($_POST['criterion'])) {
        $criterion = mysqli_real_escape_string($db_conn, stripslashes($_POST['criterion']));
        $query .= " ORDER BY pages." . $criterion . " ASC";
    }

    $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
    while ($row = mysqli_fetch_array($result)) {
        $page_id = $row['id'];
        $img = findFirstImageURL($page_id);

        $response[] = array(
            'id' => $page_id,
            'img' => $img,
            'title' => $row['title'],
            'category_id' => $row['c_id'],
            'category_name' => $row['c_name'],
            'updatedAt' => date("m/d/y", strtotime($row['updated_at'])),
            'updatedBy' => $row['username']
        );
    }
    

    return $response;
}

?>