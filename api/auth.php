<?php

    function login()
    {

        global $db_conn;
        global $mysqli;

        if (isset($_POST['username']) and isset($_POST['password'])) {
            $usernameInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['username']));
            $passwordInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['password']));
            $query = "SELECT * FROM users WHERE username='$usernameInp'";
            $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
            if (mysqli_num_rows($result) == 0) {
                return "error";
            }
            $row = mysqli_fetch_assoc($result);
            if (!password_verify($passwordInp, $row['password'])) {
                return "error";
            }
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['admin'] = $row['admin'] > 0 ? true : false;
            $response = array();
            $response['user_id'] = $_SESSION['user_id'];
            $response['username'] = $_SESSION['username'];
            $response['fullname'] = $_SESSION['fullname'];
            $response['email'] = $_SESSION['email'];
            $response['admin'] = $_SESSION['admin'];
            return json_encode($response);
        }
        return "error";
    }

    function logout()
    {
        session_start();

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    function signup()
    {

        global $db_conn;
        global $mysqli;

        if (
            isset($_POST['username']) and
            isset($_POST['password']) and
            isset($_POST['fullname']) and
            isset($_POST['email'])
        ) {

            $usernameInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['username']));
            $passwordInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['password']));
            $fullnameInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['fullname']));
            $emailInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['email']));

            $hashed_password = password_hash($passwordInp, PASSWORD_DEFAULT);

            $query = "SELECT * FROM users WHERE username='$usernameInp' OR email='$emailInp'";
            $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
            if (mysqli_num_rows($result) > 0) {
                return "error";
            }

            $query = "INSERT INTO users (username, email, fullname, password) VALUES ('$usernameInp', '$emailInp', '$fullnameInp', '$hashed_password')";
            $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));
            if ($result) {
                return "success";
            }
        }

        return "error";
    }


    function updatePasword()
    {
        session_start();

        global $db_conn;
        global $mysqli;

        if (
            isset($_POST['currentPassword']) and isset($_POST['newPassword']) and isset($_POST['confirmNewPassword']) and isset($_SESSION['user_id'])
        ) {
            $currentPasswordInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['currentPassword']));
            $passwordInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['newPassword']));
            $confirmPasswordInp = mysqli_real_escape_string($db_conn, stripslashes($_POST['confirmNewPassword']));

            $userId = $_SESSION['user_id'];
            $query = "SELECT * FROM users WHERE id = '$userId'";
            $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if (!password_verify($currentPasswordInp, $row['password'])) {
                    return "errorCurrentPassword";
                }
            }

            if ($passwordInp != $confirmPasswordInp) {
                return "errorMatch";
            }


            $hashed_password = password_hash($passwordInp, PASSWORD_DEFAULT);
            $userId = $_SESSION['user_id'];

            $query = "UPDATE users SET password = '$hashed_password' WHERE id = '$userId'";
            $result = mysqli_query($db_conn, $query) or die(mysqli_error($mysqli));

            if ($result) {

                return "success";
            }
        }
        return "error";

    }


?>