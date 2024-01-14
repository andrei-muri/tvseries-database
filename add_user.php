<?php

// Include the database connection file
require_once 'db.php';
include 'header.php';
include 'config.php';

// Initialize the registration error variable
$registrationError = "";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if the username is unique
    $checkUsernameQuery = "SELECT user_id FROM users WHERE username = '$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    if ($checkUsernameResult->num_rows > 0) {
        $registrationError = "Username is already taken. Please choose another one.";
        $_SESSION["registrationError"] = $registrationError;
        header("Location: sign_up.php");
    } elseif ($password !== $confirmPassword) {
        $registrationError = "Password and Confirm Password do not match.";
        $_SESSION["registrationError"] = $registrationError;
        header("Location: sign_up.php");
    } else {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $insertUserQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        if ($conn->query($insertUserQuery) === TRUE) {
            // Set success message and redirect to login page
            $_SESSION["registrationSuccess"] = "Account created successfully. You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $registrationError = "Error during registration: " . $conn->error;
            $_SESSION["registrationError"] = $registrationError;
            header("Location: sign_up.php");
        }
    }
}

// Close the database connection
$conn->close();
?>
