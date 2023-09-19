<?php
    $title = "Admin panel";
    session_start();
    include("header.php");

    global $db_conn;
    global $mysqli;

    if (!isset($_SESSION['user_id'])) {
        include("error_require_login.php");
        include("footer.php");
        exit();
    }
    if (!$_SESSION['admin']) {
        include("error_require_admin.php");
        include("footer.php");
        exit();
    }
?>

<link rel="stylesheet" type="text/css" href="/public/styles/admin.css">

<h1 class="sectionTitle">
    <?php echo $title?>
    <button class="btn" type="button" data-toggle="modal" data-target="#adminHelp">
        <i class="bi bi-question-circle-fill"></i>
    </button>
</h1>

<div class="modal fade" id="adminHelp" tabindex="-1" role="dialog" aria-labelledby="adminHelpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="adminHelpLabel">Help</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                        <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-dark">
                    <p class="text-dark">On this panel you can see the user reports about pages and categories.</p>
                    <p class="text-dark">When you make a report effective, the corresponding page/category will be erased.</p>
                    <p class="text-dark">You can also discard a report.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletePage" tabindex="-1" role="dialog" aria-labelledby="deletePageLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="deletePageLabel">Delete page</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                    <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body text-dark">
                Are you sure you want to delete page <a id="pageToBeDeleted" target="_blank"></a>?
            </div>
            <div class="modal-footer">
                <button type="button" id="deletePageBtn" class="btn btn-danger">Delete page</button>
                <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="deleteCategoryLabel">Delete category</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                        <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body text-dark">
                Are you sure you want to delete category <b class="text-dark" id="categoryToBeDeleted"></b>?
            </div>
            <div class="modal-footer">
                <button type="button" id="deleteCategoryBtn" class="btn btn-danger">Delete category</button>
                <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="box">
        <h3>Page reports</h3>
        <hr>
        <div id="page-reports-empty">
            There are no page reports at the moment
        </div>
        <div id="page-reports-cont" class="report-table-wrapper" onchange="updateTablesVisualization()">
            <table class="table table-striped report-table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Page</th>
                    <th scope="col">Description</th>
                    <th scope="col">Reported by</th>
                    <th scope="col">Reported at</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="page-report-table"></tbody>
            </table>
        </div>
    </div>
    <div class="box">
        <h3>Category reports</h3>
        <hr>
        <div id="category-reports-empty">
            There are no category reports at the moment
        </div>
        <div id="category-reports-cont" class="report-table-wrapper onchange="updateTablesVisualization()">
            <table class="table table-striped report-table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                    <th scope="col">Reported by</th>
                    <th scope="col">Reported at</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="category-report-table"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="/public/scripts/admin.js"></script>

<?php include("footer.php") ?>

