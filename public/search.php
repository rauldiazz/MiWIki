
<?php

    if (isset($_GET['q'])) {
        $prompt_get = $_GET['q'];
    }
    else {
        $prompt_get = '';
    }
    $title = "Search";
    session_start();
    include("header.php");
?>

<link rel="stylesheet" type="text/css" href="/public/styles/search.css">

<br>

<div class="container">

      <div class="d-flex flex-column justify-content-center search-box mx-auto">
            
            <h2 class="text-center">Search</h2>   

            <div class="input-group mt-2">
                <input id="search-prompt" type="text" class="form-control" placeholder="Search for a page title" aria-label="" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-light" id="reset-prompt" type="button" onclick="updateResetPromptButton()" disabled="true">
                        <i class="bi bi-x-circle-fill text-dark"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between filters">
                <div class="input-group flex-shrink-0 mt-2" id="categoriesWrapper">
                    <div class="input-group-prepend">
                        <label id="categoryLabel" class="input-group-text text-light border-0">Category: </label>
                    </div>
                    <select class="custom-select bg-secondary border-0 text-light" id="categories" name="categories" onchange="updateCategory()">
                        <option value="0">*</option>
                        <?php
                            $categories = obtainCategories();
                            foreach ($categories as $cat) {
                                echo '<option value='.$cat['id'].'>'.$cat['name'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="dropdown mt-2" id="dropdownWrapper">
                    <div class="btn-group dropdown" role="group" aria-label="Ordering">
                        <button type="button" class="btn btn-secondary" data-toggle="dropdown">
                            Order criterion
                            <i class="bi bi-caret-down-fill"></i>
                        </button>
                        <div id="orderCriterions" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" onclick="updateCriterion('creation_time')">Creation
                                time</button>
                            <button class="dropdown-item" onclick="updateCriterion('modification_time')">Modification
                                time</button>
                            <button class="dropdown-item" onclick="updateCriterion('alphabetical')">Alphabetical
                                order</button>
                        </div>
                        <button type="button" class="btn btn-secondary" id="invertButton" onclick="invertListOrder()">
                            <i class="bi bi-sort-up"></i>
                        </button>
                    </div>
                </div>
            </div>
      </div>

</div>

<div class="row align-items-center justify-content-center" id="search-results-container">
    <div class="col box ml-0">
        <ul id="search-loading">
            <li class="entry-container-shimmer">
                <div class="row">
                    <div class="shimmer-bg entry-img-shimmer ml-4 mr-1 my-auto"></div>
                    <div class="col">
                        <div class="shimmer-bg entry-title-shimmer"></div>
                        <div class="shimmer-bg entry-text-shimmer"></div>
                        <div class="shimmer-bg entry-text-shimmer"></div>
                    </div>
                </div>
            </li>
            <hr class="entrySep">
            <li class="entry-container-shimmer">
                <div class="row">
                    <div class="shimmer-bg entry-img-shimmer ml-4 mr-1 my-auto"></div>
                    <div class="col">
                        <div class="shimmer-bg entry-title-shimmer"></div>
                        <div class="shimmer-bg entry-text-shimmer"></div>
                        <div class="shimmer-bg entry-text-shimmer"></div>
                    </div>
                </div>
            </li>
            <hr class="entrySep">
            <li class="entry-container-shimmer">
                <div class="row">
                    <div class="shimmer-bg entry-img-shimmer ml-4 mr-1 my-auto"></div>
                    <div class="col">
                        <div class="shimmer-bg entry-title-shimmer"></div>
                        <div class="shimmer-bg entry-text-shimmer"></div>
                        <div class="shimmer-bg entry-text-shimmer"></div>
                    </div>
                </div>
            </li>
        </ul>
        <ul id="search-results"></ul>
    </div>
</div>

<script src="/public/scripts/search.js"></script>

<script>
    prompt = '<?php echo $prompt_get ?>';
    $('#search-prompt').val(prompt);
    if (prompt.length > 0) {
        $('#reset-prompt').prop("disabled", false);
    }
    querySearch(prompt);
</script>

<?php include("footer.php") ?>