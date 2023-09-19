<?php
$title = "Sign up";
session_start();
include("header.php");
?>


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


<br>


<div class="container login-box">
    <div class="box text-center">
        <h2>Sign up</h2>
        <br>
        <div id="signup-success" class="container text-center" style="display:none">
            <div id="succes-msg" class="alert alert-success" role="alert"></div>
            <a class="btn btn-success" href="/login">Log in</a>
        </div>
        <form class="text-left" id="signup-form" onsubmit="signup(event)">
            <div class="form-group">
                <label for="usernameInp">Username</label>
                <input type="text" class="form-control dark-input" id="usernameInp" placeholder="Username"
                    oninput="updateSuccessMsg(this.value)" required>
            </div>
            <div class="form-group">
                <label for="nameInp">Full name</label>
                <input type="text" class="form-control dark-input" id="nameInp" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <label for="emailInp">Email</label>
                <input type="email" class="form-control dark-input" id="emailInp" placeholder="Email" required>
            </div>

            <div class="form-group">
                <label for="passwordInp">Password</label>
                <button class="btn infobutton" type="button" data-toggle="modal" data-target="#passwordInfo"
                style="padding: .375rem .4rem !important; vertical-align: baseline !important;">
                    <i class="bi bi-info-circle-fill"></i>
                </button>
                <div class="input-group">
                    <input type="password" class="form-control dark-input" id="passwordInp" placeholder="Password"
                        oninput="validatePassword()" required>
                    <button class="btn btn-outline-secondary password-eye" type="button" id="passwordInpToggleBtn"
                        onclick="togglePasswordVisibility('passwordInp')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="repeatPasswordInp">Repeat password</label>
                <div class="input-group">
                    <input type="password" class="form-control dark-input" id="repeatPasswordInp"
                        placeholder="Repeat password" oninput="checkPasswords()" required>
                    <button class="btn btn-outline-secondary password-eye" type="button" id="repeatPasswordInpToggleBtn"
                        onclick="togglePasswordVisibility('repeatPasswordInp')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>


            <br>
            <div class="form-inline">
                <button type="submit" class="btn btn-info">Sign up</button>
                <div class="auth-loading spinner-border ml-2" role="status" style="display: none">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="alert alert-danger ml-auto my-auto" role="alert" id="signup-error" style="display:none">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateSuccessMsg(value) {
        var successMsg = document.getElementById("succes-msg");
        successMsg.innerText = value + " was successfully signed up!";
    }
</script>
<script src="/public/scripts/passwordVisibility.js"></script>

<?php include("footer.php") ?>