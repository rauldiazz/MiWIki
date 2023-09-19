<?php
    $title = "Log in";
    session_start();
    include("header.php");
?>

    <br>

    <div class="container login-box w-md-50">
        <div class="box text-center">
            <h2>Log in</h2>
            <br>
            <form class="text-left" id="login-form" onsubmit="login(event, redirect)">
                <div class="form-group">
                    <label for="usernameInp">Username</label>
                    <input type="text" class="form-control dark-input" id="usernameInp" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="passwordInp">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control dark-input" id="passwordInp" placeholder="Password" required>
                        <button class="btn btn-outline-secondary password-eye" type="button" id="passwordInpToggleBtn" onclick="togglePasswordVisibility('passwordInp')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <br>
                <div class="form-inline">
                    <button type="submit" class="btn btn-success my-auto">Log in</button>
                    <div class="auth-loading spinner-border ml-2" role="status" style="display: none">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="alert alert-danger ml-auto my-auto" role="alert" id="login-error" style="display:none"></div>
                </div>
            </form>
        </div>
    </div>

    <script src="/public/scripts/passwordVisibility.js"></script>

    <script>
        function redirect() {
            url = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : '/' ?>';
            location.href = url;
        }
    </script>

<?php include("footer.php") ?>
