<?php
require_once 'db.php';
include 'header.php';
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $director_name = $_POST["director_name"];

    $sql = "INSERT INTO directors (director_name) VALUES ('$director_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Director added successfully!";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<?php
$conn->close();
?>
