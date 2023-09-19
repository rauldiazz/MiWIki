<?php
if (!isset($page_data) or !isset($page_content)) {
    include("public/error404.php");
    exit();
}
$title = $page_data['title'];
session_start();
include("header.php");
?>

<link rel="stylesheet" type="text/css" href="/public/styles/page_template.css">

<!-- Modal for reporting the page -->
<div class="modal fade" id="newPageReport" tabindex="-1" role="dialog" aria-labelledby="newPageReportLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="newPageReportLabel">Report this page</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                    <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="pageReportSuccess" class="container text-center" style="display:none">
                    <i class="bi bi-check-circle text-success"></i>
                    <span class="text-success">Report has been sent successfuly!</span>
                </div>
                <div id="pageReportError" class="container text-center" style="display:none">
                    <i class="bi bi-exclamation-circle text-danger"></i>
                    <span class="text-danger">An error occured while sending report</span>
                </div>
                <form id="pageReport">
                    <div class="form-group">
                        <label for="description" class="text-dark">Insert a description for the report:</label>
                        <textarea class="form-control text-dark" id="description" name="description"></textarea>
                    </div>
                    <input type="text" name="page" id="page" style="display: none"
                        value="<?php echo $page_data['id']; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="sendPageReport" class="btn btn-danger">Send report</button>
                <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for reporting the category -->
<div class="modal fade" id="newCategoryReport" tabindex="-1" role="dialog" aria-labelledby="newCategoryReportLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="newCategoryReportLabel">Report this category</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                    <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="categoryReportSuccess" class="container text-center" style="display:none">
                    <i class="bi bi-check-circle text-success"></i>
                    <span class="text-success">Report has been sent successfuly!</span>
                </div>
                <div id="categoryReportError" class="container text-center" style="display:none">
                    <i class="bi bi-exclamation-circle text-danger"></i>
                    <span class="text-danger">An error occured while sending report</span>
                </div>
                <form id="categoryReport">
                    <div class="form-group">
                        <label for="description" class="text-dark">Insert a description for the report:</label>
                        <textarea class="form-control text-dark" id="description" name="description"></textarea>
                    </div>
                    <input type="text" name="category" id="category" style="display: none"
                        value="<?php echo $page_data['category']; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="sendCategoryReport" class="btn btn-danger">Send report</button>
                <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="page-header">
    <div class="row">
        <div class="col-sm-8">
            <h1 class="page-title">
                <?php echo $page_data['title']; ?>
            </h1>
            <hr class="page-header-sep d-none d-md-block">
            <div class="d-none d-md-block">
                <?php
                echo 'Category: <b>' . obtainCategoryById($page_data['category']) . '</b>';
                $creation_time = strtotime($page_data['created_at']);
                $modification_time = strtotime($page_data['updated_at']);
                echo '<br>Created by <b>' . $page_data['created_by'] . '</b> on ' . date("m/d/y", $creation_time);
                if ($modification_time > $creation_time) {
                    echo '<br>Updated by <b>' . $page_data['updated_by'] . '</b> on ' . date("m/d/y", $modification_time);
                }
                ?>
            </div>
        </div>
        <div class="col-sm-4 d-none d-md-flex">
            <div class="container my-auto d-flex flex-column">
                <a href="/edit?page_id=<?php echo $page_data['id'] ?>" class="btn btn-danger ml-auto show-if-logged"
                    style="display:none">
                    <i class="bi bi-pencil-square"></i>
                    Edit page
                </a>
                <button class="btn btn-secondary mt-2 ml-auto show-if-logged" data-toggle="modal"
                    data-target="#newPageReport" style="display:none">
                    <i class="bi bi-flag-fill"></i>
                    Report page
                </button>
                <button class="btn btn-secondary mt-2 ml-auto show-if-logged" data-toggle="modal"
                    data-target="#newCategoryReport" style="display:none">
                    <i class="bi bi-flag-fill"></i>
                    Report category
                </button>
                <a class="btn btn-primary mt-2 ml-auto show-if-logged" id="downloadButton" style="display:none"
                    href="/download_page/<?php echo $page_data['id'] ?>">
                    <i class="bi bi-cloud-download"></i>
                    Download page
                </a>
            </div>
        </div>
    </div>
    <div class="row d-md-none">
        <a class="mx-auto metadataToggle" data-toggle="collapse" href="#metadataCollapse" role="button"
            aria-expanded="false" aria-controls="metadataCollapse">
            <i class="text-center bi bi-caret-down-fill"></i>
        </a>
    </div>
    <div class="row d-md-none px-4">
        <div class="collapse" id="metadataCollapse">
            <?php
            echo 'Category: <b>' . obtainCategoryById($page_data['category']) . '</b>';
            $creation_time = strtotime($page_data['created_at']);
            $modification_time = strtotime($page_data['updated_at']);
            echo '<br>Created by <b>' . $page_data['created_by'] . '</b> on ' . date("m/d/y", $creation_time);
            if ($modification_time > $creation_time) {
                echo '<br>Updated by <b>' . $page_data['updated_by'] . '</b> on ' . date("m/d/y", $modification_time);
            }
            ?>
            <br>
            <a href="/edit?page_id=<?php echo $page_data['id'] ?>"
                class="mt-2 btn btn-sm btn-danger align-self-center ml-auto show-if-logged" style="display:none">
                <i class="bi bi-pencil-square"></i>
                Edit page
            </a>
            <br>
            <button class="mt-2 btn btn-sm btn-secondary show-if-logged" data-toggle="modal"
                data-target="#newPageReport" style="display:none">
                <i class="bi bi-flag-fill"></i>
                Report page
            </button>
            <br>
            <button class="mt-2 btn btn-sm btn-secondary show-if-logged" data-toggle="modal"
                data-target="#newCategoryReport" style="display:none">
                <i class="bi bi-flag-fill"></i>
                Report category
            </button>
            <br>
            <a class="btn btn-sm btn-primary mt-2 ml-auto show-if-logged" id="downloadButton" style="display:none"
                href="/download_page/<?php echo $page_data['id'] ?>">
                <i class="bi bi-cloud-download"></i>
                Download file
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="box" id="pageBody"></div>
</div>

<script>
    const converter = new showdown.Converter();
    let plainText = <?php echo json_encode($page_content); ?>;
    let htmlText = converter.makeHtml(plainText);
    $('#pageBody').html(htmlText);
</script>

<script src="/public/scripts/page.js"></script>

<?php include("footer.php") ?>