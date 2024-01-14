<?php
include "header.php";
include "config.php";
require_once 'db.php';

if (isset($_GET['series_id'])) {
    $seriesId = $_GET['series_id'];
    $userId = $_SESSION['user_id']; // Assuming user is logged in and you have their ID in session

    // Fetch the user's review
    $query = "SELECT * FROM reviews WHERE series_id = $seriesId AND user_id = $userId";
    $result = $conn->query($query);

    if ($row = $result->fetch_assoc()) {
        // Display the form with existing review data
        ?>
        <form action="edit_review.php" method="post">
            <input type="hidden" name="review_id" value="<?php echo $row['review_id']; ?>">
            <input type="hidden" name="series_id" value="<?php echo $seriesId; ?>">
            <label for="rating">Rating:</label>
            <input type="number" name="rating" value="<?php echo $row['rating']; ?>">
            <br>
            <label for="text">Review:</label>
            <textarea name="text"><?php echo $row['text']; ?></textarea>
            <br>
            <button type="submit" name="action" value="update">Update Review</button>
            <button type="submit" name="action" value="delete">Delete Review</button>
        </form>
        <?php
    } else {
        echo "Review not found.";
    }
} else {
    echo "Series ID not provided.";
}


?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seriesId = $_POST['series_id'];
    $reviewId = $_POST['review_id'];
    $action = $_POST['action'];
    $rating = $_POST['rating'];
    $text = $_POST['text'];
    $newNbRatings = 0;
    $getNbRatings = "SELECT nb_reviews FROM series WHERE series_id = " . intval($seriesId);
    $result = $conn->query($getNbRatings);
    if($row = $result->fetch_assoc()) {
        $newNbRatings = $row['nb_reviews'];
    }

    if ($action == 'update') {
        // Update review
        $updateQuery = "UPDATE reviews SET rating = ?, text = ? WHERE review_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("isi", $rating, $text, $reviewId);
        $stmt->execute();
    } elseif ($action == 'delete') {
        // Delete review
        $deleteQuery = "DELETE FROM reviews WHERE review_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $reviewId);
        $stmt->execute();
        $newNbRatings--;
    }

    // Recalculate the average rating
    $avgQuery = "SELECT AVG(rating) as avgRating FROM reviews WHERE series_id = ?";
    $stmtAvg = $conn->prepare($avgQuery);
    $stmtAvg->bind_param("i", $seriesId);
    $stmtAvg->execute();
    $resultAvg = $stmtAvg->get_result();
    $rowAvg = $resultAvg->fetch_assoc();

    $newAvgRating = $rowAvg['avgRating'];

// Update the average rating in the series table
    $updateSeriesQuery = "UPDATE series SET rating = ?, nb_reviews = ? WHERE series_id = ?";
    $stmtSeries = $conn->prepare($updateSeriesQuery);
    if ($newNbRatings == 0) {
        $newAvgRating = 0;
    }
    $stmtSeries->bind_param("dii", $newAvgRating, $newNbRatings, $seriesId);
    $stmtSeries->execute();

//    echo "Redirecting to series ID: $seriesId";
//    exit();
// Redirect back to series details or show a success message
    header("Location: series_details.php?series_id=" . intval($seriesId));
    exit();
}

$conn->close();

?>
