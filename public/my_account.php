<?php

$title = "My account";
session_start();
include("header.php");
if (!isset($_SESSION['user_id'])) {
    include("error_require_login.php");
    include("footer.php");
    exit();
}

?>

<link rel="stylesheet" type="text/css" href="/public/styles/my_account.css">

<div class="modal fade" id="myAccountHelp" tabindex="-1" role="dialog" aria-labelledby="myAccountHelpLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="myAccountHelpLabel">Help</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                    <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-dark">
                    <p class="text-dark">In this section, you can view information related to your user acccount.</p>
                    <p class="text-dark">
                        You can also see a list of all your pages in MiWiki.
                        <br>
                        By default, you see the list of the pages ordered by date of creation.
                        <br>
                        If you want, you can choose other criteria to order the pages, or apply some filter to only show
                        some of them.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passwordInfo" tabindex="-1" role="dialog" aria-labelledby="passwordRequisitesInfo"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="passwordRequisitesInfo">Password info</h5>
                <button type="button" class="btn ml-auto" data-dismiss="modal">
                    <i class="bi bi-x-circle-fill text-dark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-dark">
                    <p class="text-dark">In order for a password to be accepted it must meet these 4 requirements:</p>
                    <ul>
                        <li class="text-dark">Must be at least 8 characters long</li>
                        <li class="text-dark">Must contain one lowercase letter</li>
                        <li class="text-dark">Must contain one uppercase letter</li>
                        <li class="text-dark">Must contain one number</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<h1 class="sectionTitle">
    <?php echo $title ?>
    <button class="btn" type="button" data-toggle="modal" data-target="#myAccountHelp">
        <i class="bi bi-question-circle-fill"></i>
    </button>
</h1>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="row-12">
                <div class="box">
                    <h3><i class="bi bi-info-square"></i> User account details</h3>
                    <hr class="my-2">
                    <?php
                    echo '  <h7><b>Username:</b> ' . $_SESSION['username'] . '</h7><br>';
                    echo '  <h7><b>Full name:</b> ' . $_SESSION['fullname'] . '</h7><br>';
                    echo '  <h7><b>E-mail:</b> ' . $_SESSION['email'] . '</h7><br>';
                    echo '  <h7><b>Number of created pages:</b> ' . numberOfPagesByUser($_SESSION['user_id']) . '</b></h7><br><br>';
                    echo '  <h7><b>Admin:</b> ' . ($_SESSION['admin'] ? 'Yes' : 'No') . '</h7>';
                    ?>
                </div>
            </div>
            <div class="row-12">
                <div class="box">
                    <h3><i class="bi bi-pass"></i> Listing of my created pages</h3>
                    <hr>
                    <div class="flex-wrap flex-md-nowrap px-3 justify-content-between">
                        <input class="form-control dark-input mt-2 order-md-2" id="termFilter" type="text"
                            placeholder="Search..." onkeyup="filterByTerm()">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="mb-2 mt-2">
                                <div class="input-group flex-shrink-0" id="categoriesWrapper">
                                    <div class="input-group-prepend">
                                        <label id="categoryLabel"
                                            class="input-group-text text-light border-0">Category:</label>
                                    </div>
                                    <select class="custom-select bg-secondary border-0 text-light" id="categories"
                                        name="categories" onchange="updateCategory()">
                                        <option value="0">*</option>
                                        <?php
                                        $categories = obtainCategories();
                                        foreach ($categories as $cat) {
                                            echo '<option value=' . $cat['id'] . '>' . $cat['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2 mt-2">
                                <div class="dropdown ml-md-2" id="dropdownWrapper">
                                    <div class="btn-group dropdown" role="group" aria-label="Ordering">
                                        <button type="button" class="btn btn-secondary" data-toggle="dropdown">
                                            Order criterion
                                            <i class="bi bi-caret-down-fill"></i>
                                        </button>
                                        <div id="orderCriterions" class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton">
                                            <button class="dropdown-item"
                                                onclick="updateCriterion('creation_time')">Creation time
                                            </button>
                                            <button class="dropdown-item"
                                                onclick="updateCriterion('modification_time')">Modification
                                                time</button>
                                            <button class="dropdown-item"
                                                onclick="updateCriterion('alphabetical')">Alphabetical
                                                order</button>
                                        </div>
                                        <button type="button" class="btn btn-secondary" id="invertButton"
                                            onclick="invertListOrder()">
                                            <i class="bi bi-sort-up"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row px-3 mt-2" id="listOfPagesWrapper"></div>
                </div>

            </div>
        </div>

        <div class="col-lg-6">
            <div class="box">
                <h3><i class="bi bi-key"></i> Change password</h3>
                <hr class="my-2">
                <div class="form-group">
                    <form id="changePassword" class="my-0">
                        <label for="current-password">Current password</label>
                        <div class="input-group margin-bottom">
                            <input type="password" class="form-control dark-input" id="current-password"
                                placeholder="Enter your current password" required>
                            <button class="btn btn-outline-secondary password-eye" type="button"
                                id="current-passwordToggleBtn" onclick="togglePasswordVisibility('current-password')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <label for="new-password">New password</label>
                        <button class="btn infobutton" type="button" data-toggle="modal" data-target="#passwordInfo">
                            <i class="bi bi-info-circle-fill"></i>
                        </button>
                        <div id="new-password-cont" class="input-group margin-bottom">
                            <input type="password" class="form-control dark-input" id="new-password"
                                placeholder="Enter new password" onkeyup="checkPasswordRequisites()" required>
                            <button class="btn btn-outline-secondary password-eye" type="button"
                                id="new-passwordToggleBtn" onclick="togglePasswordVisibility('new-password')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <label for="confirm-password">Confirm new password</label>
                        <div class="input-group margin-bottom">
                            <input type="password" class="form-control dark-input" id="confirm-password"
                                placeholder="Confirm new password" required>
                            <button class="btn btn-outline-secondary password-eye" type="button"
                                id="confirm-passwordToggleBtn" onclick="togglePasswordVisibility('confirm-password')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-success">Update password</button>
                        <br>
                        <br>
                        <div class="alert alert-danger ml-auto my-auto" role="alert" id="password-error"
                            style="display:none"></div>
                        <div class="alert alert-success ml-auto my-auto" role="alert" id="password-success"
                            style="display:none">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        function checkPasswordRequisites() {
            var password = $('#new-password').val();

            // Check for minimum length of 8 characters
            if (password.length < 8) {
                $('#password-error').html("New password is too short");
                $('#password-error').show();
                return;
            }

            // Check if there is at least one uppercase letter, one lowercase letter, and one number
            var hasUppercase = false;
            var hasLowercase = false;
            var hasNumber = false;

            for (var i = 0; i < password.length; i++) {
                var character = password[i];

                if (/[A-Z]/.test(character)) {
                    hasUppercase = true;
                } else if (/[a-z]/.test(character)) {
                    hasLowercase = true;
                } else if (/[0-9]/.test(character)) {
                    hasNumber = true;
                }

                if (!hasUppercase || !hasLowercase || !hasNumber) {
                    $('#password-error').html("New password does not meet requisites");
                    $('#password-error').show();
                } else {
                    $('#password-error').hide();
                    $('#password-error').html("");
                }
            }
        }


    </script>
    <script src='/public/scripts/passwordVisibility.js'></script>
    <script src='/public/scripts/my_account.js'></script>


    <?php include("footer.php") ?>