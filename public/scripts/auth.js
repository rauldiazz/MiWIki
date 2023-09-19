var requireRefreshOnLogout;

function loadSessionDetails(sessionInfo) {

    sessionInfo = JSON.parse(sessionInfo);

    $('.session-userid').html(sessionInfo['userid']);
    $('.session-username').html(sessionInfo['username']);
    $('.session-fullname').html(sessionInfo['fullname']);
    $('.session-email').html(sessionInfo['email']);

    $('.show-if-logged').show();
    $('.show-if-not-logged').hide();

    if (sessionInfo['admin']) {
        $('.show-if-admin').show();
    }
}

function login(event, callback) {

    $('.auth-loading').show();

    event.preventDefault();
    
    let usernameInp = $("#usernameInp").val();
    let passwordInp = $("#passwordInp").val();

    $.ajax({
        url: '/auth_login',
        type: 'POST',
        data: {
            username: usernameInp,
            password: passwordInp
        },
        success: function(response) {
            if (response == "error") {
                $('#login-error').html("Incorrect username/password");
                $('#login-error').show();
            }
            else {
                callback(response);
            }
            $('.auth-loading').hide();
        },
        error: function() {
            $('.auth-loading').hide();
            $('#login-error').html("Error on the AJAX request");
            $('#login-error').show();
        }
    });

    $("#usernameInp").val('');
    $("#passwordInp").val('');

}

function logout(event) {

    event.preventDefault();

    $.ajax({
        url: '/auth_logout',
    }).done(function () {

        if (typeof requireRefreshOnLogout == 'undefined' || !requireRefreshOnLogout) {
            $('.session-userid').html('');
            $('.session-username').html('');
            $('.session-fullname').html('');
            $('.session-email').html('');

            $('.show-if-logged').hide();
            $('.show-if-not-logged').show();

            $('.show-if-admin').hide();
        }
        else {
            location.reload();
        }
    });
}

function checkPasswords() {
    let passwordInp = $("#passwordInp").val();
    let repeatPasswordInp = $("#repeatPasswordInp").val();

    if (passwordInp != repeatPasswordInp) {
        $('#signup-error').html("Passwords do not match");
        $('#signup-error').show();
    }
    else {
        $('#signup-error').hide();
        $('#signup-error').html("");
    }
}


function validatePassword() {
    var password = $('#passwordInp').val();

    // Check for minimum length of 8 characters
    if (password.length < 8) {
        $('#signup-error').html("Password is too short");
        $('#signup-error').show();
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
            $('#signup-error').html("Password does not meet requisites");
            $('#signup-error').show();
        }
        else {
            $('#signup-error').hide();
            $('#signup-error').html("");
        }
    }

}




function signup(event) {

    $('.auth-loading').show();

    event.preventDefault();

    let usernameInp = $("#usernameInp").val();
    let nameInp = $("#nameInp").val();
    let emailInp = $("#emailInp").val();
    let passwordInp = $("#passwordInp").val();
    let repeatPasswordInp = $("#repeatPasswordInp").val();

    if (passwordInp != repeatPasswordInp) {
        $('.auth-loading').hide();
        $('#signup-error').html("Passwords do not match");
        $('#signup-error').show();
        return;
    }

    $.ajax({
        url: '/auth_signup',
        type: 'POST',
        data: {
            username: usernameInp,
            password: passwordInp,
            email: emailInp,
            fullname: nameInp
        },
        success: function(response) {
            if (response == "error"){
                $('#signup-error').html("Username/email already in use");
                $('#signup-error').show();

            }
            else {
                $('#signup-form').hide();
                $('#signup-success').show();
            }
            $('.auth-loading').hide();
        },
        error: function() {
            $('.auth-loading').hide();
            $('#signup-error').html("Error on the AJAX request");
            $('#signup-error').show();
        }
    });

    $("#usernameInp").val('');
    $("#nameInp").val('');
    $("#emailInp").val('');
    $("#passwordInp").val('');
    $("#repeatPasswordInp").val('');

}