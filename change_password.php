<?php
session_start();
require_once "db.php";
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    exit('User not logged in');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Fetch the existing password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (password_verify($current_password, $user['password'])) {
        if ($new_password == $confirm_new_password) {
            // Update the password
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->execute([$new_password_hash, $_SESSION['user_id']]);
            echo "Password updated successfully.";
        } else {
            echo "New passwords do not match.";
        }
    } else {
        echo "Current password is incorrect.";
    }
}
?>