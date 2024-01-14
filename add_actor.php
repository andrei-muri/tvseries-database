<?php
require_once 'db.php';
include 'header.php';
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actor_name = $_POST["actor_name"];

    $sql = "INSERT INTO actors (actor_name) VALUES ('$actor_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Actor added successfully!";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<?php
$conn->close();
?>
