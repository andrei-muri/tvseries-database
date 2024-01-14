<?php
//session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db.php';
    include 'header.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve user information from the database
    $sql = "SELECT user_id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row["password"])) {
            // Password is correct, set session variables
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];

            // Redirect to a welcome page or any other desired location
            header("Location: index.php");
            exit();
        } else {
            $loginError = "Invalid username or password.";
            $_SESSION["loginError"] = $loginError;
            header("Location: login.php");
        }
    } else {
        $loginError = "Invalid username or password.";
        $_SESSION["loginError"] = $loginError;
        header("Location: login.php");
    }

    $conn->close();
}
?>
