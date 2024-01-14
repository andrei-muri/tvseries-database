<?php
include "config.php";
require_once "db.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $character_name = $conn->real_escape_string($_POST["character_name"]);
    $actor_id = intval($_POST["actor_id"]); // Assuming actor_id is an integer
    $role_id = intval($_POST["role_id"]); // Assuming role_id is an integer
    $series_id = intval($_POST["series_id"]); // Get series_id from the form

    // Insert the character into the characters table (replace with your actual table name)
    $insertQuery = "INSERT INTO characters (character_name, actor_id, role_id, series_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("siii", $character_name, $actor_id, $role_id, $series_id);

    if ($stmt->execute()) {
        echo "Character added successfully!";
    } else {
        echo "Error adding character: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Check which button was clicked
    if (isset($_POST["add_another"])) {
        // Redirect back to the form to add another character
        header("Location: character.php?series_id=" . $series_id); // Include series_id in the URL
        exit();
    } else {
        // Redirect to the home page
        header("Location: index.php");
        exit();
    }
}

//// Check if series_id is passed in the URL
//if (isset($_GET["series_id"])) {
//    $series_id = intval($_GET["series_id"]);
//} else {
//    echo "Series ID not provided.";
//    exit();
//}
?>