<?php
include "header.php";
include "config.php";
require_once "db.php";

$series_id = isset($_GET['series_id']) ? $_GET['series_id'] : 0;
$series_name = isset($_GET['series_name']) ? $_GET['series_name'] : '';
?>

<form class="form-filters" action="all_series_reviews.php" method="get">
    <input type="hidden" name="series_id" value="<?php echo htmlspecialchars($series_id); ?>">
    <input type="hidden" name="series_name" value="<?php echo htmlspecialchars($series_name); ?>">

    <label for="sort">Sort:</label>
    <select id="sort" name="sort">
        <option value="chronologically">Chronologically</option>
        <option value="rating">By rating</option>
    </select>
    <button type="submit">Sort</button>
</form>

<link rel="stylesheet" href="your_reviews.css">
<h3 style="text-align: center"><?php echo htmlspecialchars($series_name); ?></h3>
<div class="review-list">

    <?php
    $sortMethod = isset($_GET['sort']) ? $_GET['sort'] : '';
    $reviewGetQuery = "SELECT * FROM reviews WHERE series_id = " . intval($series_id);

    if ($sortMethod === 'rating') {
        $reviewGetQuery .= " ORDER BY rating DESC";
    }

    $reviews = $conn->query($reviewGetQuery);
    if ($reviews->num_rows > 0):
        while ($review = $reviews->fetch_assoc()):
            $getUsernameQuery = "SELECT username FROM users WHERE user_id = " . intval($review['user_id']);
            $usernameResult = $conn->query($getUsernameQuery);
            $username = $usernameResult->fetch_assoc();
            ?>
            <div class="review-item">
                <div style="color: #0056b3"><?php echo htmlspecialchars($username['username']); ?></div>
                <div class="star-rating">
                    <div class="star-rating">
                        <?php echo str_repeat('★', intval($review['rating'])); ?>
                        <?php echo str_repeat('☆', 10 - intval($review['rating'])); ?>
                        <span style="color: #666666"><?php echo intval($review['rating']) ?></span>
                    </div>
                </div>
                <div class="review-text"><?php echo htmlspecialchars($review['text']); ?></div>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
                    <a href="edit_review.php?series_id=<?php echo $series_id; ?>&src=all_series_reviews.php">Edit</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <h4>No reviews</h4>
    <?php endif; ?>
</div>

<!--<a class="go" href="series_details.php?series_id=--><?php //echo $series_id; ?><!--">Go back</a>-->
