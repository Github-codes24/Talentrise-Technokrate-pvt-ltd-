<?php
@session_start();
require_once ('../../config/connection.inc.php');
header('Content-type: application/json');

$username = escapeString($_POST['username']);
$password = escapeString($_POST['password']);
$response = [];

$query = executeQuery("SELECT * FROM admin WHERE username = '$username'");

if (numRows($query) > 0) {
    $row = fetchObject($query);
    $ExistingPassword = $row->password;

    if ($password === $ExistingPassword) {
        if ($row->status == 1) {
            if ($row->is_deleted == 1) {
                $response["status"] = "error";
                $response["message"] = "This account has been deactivated. Please contact the system administrator for assistance.";
            } else {
                $_SESSION['username'] = $row->username;
                $_SESSION['admin_id'] = $row->admin_id;
                $_SESSION['email'] = $row->email;
                $_SESSION['role_id'] = $row->role_id;

                // Set cookies for 7 days
                $cookie_time = time() + (7 * 24 * 60 * 60); // 7 days from now
                setcookie('username', $row->username, $cookie_time, "/");
                setcookie('admin_id', $row->admin_id, $cookie_time, "/");
                setcookie('email', $row->email, $cookie_time, "/");
                setcookie('role_id', $row->role_id, $cookie_time, "/");

                $response["status"] = "success";
                $response["message"] = "Login successful. Welcome back!";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Your account is currently inactive. Please contact the system administrator for assistance.";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "The password you entered is incorrect. Please try again.";
    }
} else {
    $response["status"] = "error";
    $response["message"] = "No account found with the provided username.";
}

echo json_encode($response);
closeDB();
?>