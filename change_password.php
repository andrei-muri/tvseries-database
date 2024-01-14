<?php
session_start();
require_once "db.php"; // Your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$changePasswordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = sanitize_input($_POST['current_password']);
    $new_password = sanitize_input($_POST['new_password']);
    $confirm_new_password = sanitize_input($_POST['confirm_password']);

    // Prepare the statement to fetch the existing password
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $changePasswordError = "User not found!";
    } else {
        $user = $result->fetch_assoc();

        // Check current password
        if (password_verify($current_password, $user['password'])) {
            if ($current_password === $new_password || $current_password === $confirm_new_password) {
                $_SESSION['changePasswordError'] = "Error: New password is the same as the old one!";
                header("Location: change_password_form.php");
                exit();
            }
            if ($new_password != $confirm_new_password) {
                $_SESSION['changePasswordError'] = "Error: New password and confirm new password do not match!";
                header("Location: change_password_form.php");
                exit();
            } else {
                // Update the password
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $update_stmt->bind_param("si", $new_password_hash, $_SESSION['user_id']);
                $update_stmt->execute();
                header("Location: index.php"); // Redirect on success
                exit();
            }
        } else {
            $_SESSION['changePasswordError'] = "Error: Wrong current password!";
            header("Location: change_password_form.php");
            exit();
        }
    }
}
?>
