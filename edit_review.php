<?php
include "header.php";
include "config.php";
require_once 'db.php';

if (isset($_GET['series_id'])) {
    $src = (isset($_GET['src'])) ? $_GET['src'] : "index.php";
    $seriesId = $_GET['series_id'];
    $userId = $_SESSION['user_id']; // Assuming user is logged in and you have their ID in session

    // Fetch the user's review
    $query = "SELECT * FROM reviews WHERE series_id = $seriesId AND user_id = $userId";
    $result = $conn->query($query);

    if ($row = $result->fetch_assoc()) {
        // Display the form with existing review data
        ?>
            <link rel="stylesheet" href="review.css">
        <form action="edit_review.php" method="post" class="form-review">
            <input type="hidden" name="src" value="<?php echo htmlspecialchars($src); ?>">
            <input type="hidden" name="review_id" value="<?php echo $row['review_id']; ?>">
            <input type="hidden" name="series_id" value="<?php echo $seriesId; ?>">
            <input type="hidden" id="rating" name="rating" value="<?php echo $row['rating']; ?>">

            <div class="star-rating">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <span class="star" data-value="<?php echo $i; ?>">&#9733;</span>
                <?php endfor; ?>
            </div>

            <label for="text">Review:</label>
            <textarea id="text" name="text"><?php echo htmlspecialchars($row['text']); ?></textarea>
            <br>

            <?php if (isset($_SESSION["ratingError"])): ?>
                <div class="message-box">
                    <p><?php echo $_SESSION["ratingError"]; ?></p>
                </div>
                <?php unset($_SESSION["ratingError"]); ?>
            <?php endif; ?>

            <div class="action-buttons-container">
                <button type="submit" name="action" value="update">Update Review</button>
                <button type="submit" name="action" value="delete">Delete Review</button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                const stars = document.querySelectorAll('.star-rating .star');
                const ratingInput = document.getElementById('rating');

                stars.forEach((star, index) => {
                    star.addEventListener('click', () => {
                        ratingInput.value = index + 1; // Update the hidden input value
                        highlightStars(index);
                    });
                });

                function highlightStars(index) {
                    stars.forEach((star, idx) => {
                        star.style.color = idx <= index ? 'gold' : 'white'; // Fill or empty the stars
                    });
                }
            });

        </script>
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
    if ($row = $result->fetch_assoc()) {
        $newNbRatings = $row['nb_reviews'];
    }

    if ($rating > 10 || $rating < 1) {
        $_SESSION['ratingError'] = "Give a rating between 1 and 10";
        header("Location: edit_review.php?series_id=$seriesId");
        exit();
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

    switch ($_POST['src']) {
        case'series_details.php':
            header("Location: series_details.php?series_id=" . intval($seriesId));
            exit();
        case 'your_reviews.php':
            header("Location: your_reviews.php");
            exit();
        case 'all_series_review.php':
            header("Location: all_series_reviews.php?series_id=". $seriesId);
            exit();
    }


}

$conn->close();

?>
