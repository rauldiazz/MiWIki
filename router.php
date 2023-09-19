<?php
include("database.php");
include("api/auth.php");
include("api/categories.php");
include("api/pages.php");
include("api/reports.php");


function loadURL($url)
{
    $url_parts = parse_url($url);
    $path = explode('/', $url_parts['path']);

    if (count($path) <= 2) {
        switch ($url_parts['path']) {
            case "/":
            case "/home":
                include("public/home.php");
                break;

            case "/new":
                include("public/new.php");
                break;

            case "/search":
                if (isset($_POST['prompt'])) {
                    echo json_encode(searchPages());
                } else {
                    include("public/search.php");
                }
                break;

            case "/random":
                $random = getRandomPageId();
                loadPage($random);
                break;

            case "/login":
                include("public/login.php");
                break;

            case "/signup":
                include("public/signup.php");
                break;
            
            case "/edit";
                include("public/edit.php");
                break;
            
            case "/admin":
                include("public/admin.php");
                break;

            // GET /my_account
            case "/my_account":
                include("public/my_account.php");
                break;

     
            // POST /auth/login
            case "/auth_login":
                echo login();
                break;

            // GET/POST /auth/logout
            case "/auth_logout":
                logout();
                break;

            // POST /auth/signup
            case "/auth_signup":
                echo signup();
                break;

            // POST /pages
            case "/create_page":
                echo createPage();
                break;

            // PUT /pages/[id]
            case "/edit_page":
                echo editPage();
                break;

            // GET /categories
            case "/obtain_categories":
                echo json_encode(obtainCategories());
                break;

            // PUT /categories
            case "/create_category":
                echo createCategory();
                break;

            // POST /page_reports
            case "/send_page_report";
                echo sendPageReport();
                break;

            // POST /page_reports
            case "/send_category_report";
                echo sendCategoryReport();
                break;

            // GET /my_account/pages/
            case "/get_my_pages":
                echo getListOfPages();
                break;

            // POST /auth/update_password
            case "/update_password":
                echo updatePasword();
                break;

            default:
                include("public/error404.php");
                break;
        }
    } else {
        switch ($path[1]) {
            case "pages":
                loadPage($path[2]);
                break;

            case "download_page":
                downloadPage($path[2]);
                break;

            case "admin":
                switch ($path[2]) {

                    case "":
                        include("public/admin.php");
                        break;

                    // GET /page_reports
                    case "get_page_reports":
                        echo getPageReports();
                        break;

                    // GET /category_reports
                    case "get_category_reports":
                        echo getCategoryReports();
                        break;
                    
                    // DELETE /page_reports/[id]
                    case "discard_page_report":
                        echo discardPageReport();
                        break;
                    
                    // DELETE /category_reports/[id]
                    case "discard_category_report":
                        echo discardCategoryReport();
                        break;
                    
                    // DELETE /pages/[id]
                    case "delete_page":
                        echo deletePage();
                        break;

                    // DELETE /categories/[id]
                    case "delete_category":
                        echo deleteCategory();
                        break;

                    default:
                        include("public/error404.php");
                        break;
                }
                break;


            default:
                include("public/error404.php");
                break;
        }
    }
}

?>