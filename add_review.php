<?php
session_start();
require_once 'db.php';

$series_id = $_GET['series_id'];
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $rating = $_POST['rating'];
    $text = $_POST['text'];
    $user_id = $_SESSION['user_id'];

    $error = false;
    if($rating < 1 || $rating > 10) {
        $_SESSION["ratingError"] = "Please give a rating between 1 and 10";
        $error = true;

    }

    if($error) {
        header("Location: review.php?series_id=" . $series_id);
        exit();
    }

    $query = "INSERT INTO reviews (text, series_id, user_id, rating) VALUES ('$text', '$series_id', '$user_id', '$rating');";
    $conn->query($query);

    $getRatingAndReviews = "SELECT nb_reviews, rating FROM series WHERE series_id = $series_id";
    $result = $conn->query($getRatingAndReviews);
    if($row = $result->fetch_assoc()) {
        $nb_reviews = $row['nb_reviews'];
        $currRating = $row['rating'];
        if ($currRating) {
            $currRating = ($currRating + $rating) / 2;
        } else {
            $currRating = $rating;
        }
        $nb_reviews++;
        $updateQuery = "UPDATE series SET nb_reviews = $nb_reviews, rating = $currRating WHERE series_id = $series_id";
        $conn->query($updateQuery);
    }
    header("Location: series_details.php?series_id=" . $series_id);
}
?>
