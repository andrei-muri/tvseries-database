<?php
session_start();
require_once "db.php";

$userId = $_SESSION['user_id'];

$deleteFavsQuery = "DELETE FROM favourite_series WHERE user_id = ?";
$stmt = $conn->prepare($deleteFavsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();

$selectReviewsQuery = "SELECT * FROM reviews WHERE user_id = ?";
$stmt = $conn->prepare($selectReviewsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while($review = $result->fetch_assoc()) {
    $seriesId = $review['series_id'];

    $deleteReviewQuery = "DELETE FROM reviews WHERE review_id = ?";
    $stmt = $conn->prepare($deleteReviewQuery);
    $stmt->bind_param("i", $review['review_id']);
    $stmt->execute();

    $newAvg = 1000;
    $getAvgQuery = "SELECT AVG(rating) as avgRating FROM reviews WHERE series_id = ?";
    $stmt = $conn->prepare($getAvgQuery);
    $stmt->bind_param("i", $seriesId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($avg = $result->fetch_assoc()) {
        $newAvg = $avg['avgRating'];
        if(!$newAvg) {
            $newAvg = 0;
        }
    }

    $updateSeries = "UPDATE series SET nb_reviews = nb_reviews - 1, rating = ? WHERE series_id = ?";
    $stmt = $conn->prepare($updateSeries);
    $intval = intval($seriesId);
    $stmt->bind_param("di", $newAvg, $intval);
    $stmt->execute();

}

$deleteAccountQuery = "DELETE FROM users WHERE user_id = ?";
$stmt = $conn->prepare($deleteAccountQuery);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

header("Location: logout.php");
exit();
?>
