

<link rel="stylesheet" type="text/css" href="/public/styles/editor.css">

<h1 class="sectionTitle">
    <?php echo $title?>
    <button class="btn" type="button" data-toggle="modal" data-target="#editorHelp">
        <i class="bi bi-question-circle-fill"></i>
    </button>
</h1>

<div class="modal fade" id="editorHelp" tabindex="-1" role="dialog" aria-labelledby="editorHelpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="editorHelpLabel">Help</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                    <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-dark">In this section you can create a new page for MiWiki.</p>
                <p class="text-dark">
                    First, choose a title for the page. Then, to load the content you have 2 possibilities:
                    <br>
                    <span class="indented text-dark">[1] Upload an already typed file</span>
                    <br>
                    <span class="indented text-dark">[2] Manually type the article on this page</span>
                    <br>
                </p>
                <p class="text-dark">
                    On the side, a real-time preview will be shown.
                    <br>
                    Finally, click on the green button to publish the article.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">

        <div class="col-md w-50">
            <div class="box">
                <h3>Input</h3>
                <hr>
                <form id="editor">

                    <div class="modal fade" id="resetConfirm" tabindex="-1" role="dialog" aria-labelledby="resetConfirmLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-dark" id="resetConfirmLabel">Reset fields</h5>
                                    <button type="button" class="btn ml-auto" data-dismiss="modal">
                                            <i class="bi bi-x-circle-fill text-dark"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-dark">
                                        Are you sure you want to reset all the fields?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="reset-fields" type="button" class="btn btn-danger" data-dismiss="modal">Reset</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>                       

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input required type="text" id="title" name="title" class="form-control dark-input">
                    </div>
                    <div class="form-group">
                        <label for="categories">Category:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button id="toggleNewCategory" type="button" class="btn dark-input" onclick="toggleNewCategoryField()">+</button>
                            </div>
                            <select id="categories" name="categories" class="form-control dark-input" required>
                                <?php
                                    $categories = obtainCategories();
                                    foreach ($categories as $cat) {
                                        echo '<option value='.$cat['id'].'>'.$cat['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="input-group" id="newCategoryField" style="display: none;">
                            <div class="input-group-prepend">
                                <button id="create-category" type="button" class="btn dark-input" onclick="createCategory()">🗸</button>
                            </div>
                            <input id="newCategoryInput" name="newCategoryInput" class="form-control dark-input"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><i>(Optional)</i> File:</label>
                        <input style="display:none;" type="file" accept=".md,.txt" id="fileInp" name="fileInp" onchange="loadFile()">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" id="fileIcon" class="form-control btn dark-input" onclick="$('#fileInp').click()"><i class="bi bi-file-earmark-text-fill"></i></button>
                            </div>
                            <input type="text" id="fileName" class="form-control dark-input" placeholder="No file chosen" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Edit content:</label>
                        <textarea class="form-control dark-input" id="content" name="content"></textarea>
                    </div>
                    <div class="form-group form-inline">
                        <button type="submit" class="btn btn-success">Publish</button>
                        <button type="button" data-toggle="modal" data-target="#resetConfirm" class="btn btn-danger ml-auto">Clear fields</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md w-50">
            <div class="box">
                <h3>Preview</h3>
                <hr>
                <div id="preview">
                    <p>A preview of the article will be displayed in this section.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="/public/scripts/editor.js"></script>

