<?php
include "header.php";
require_once 'db.php';

//// Fetch all series from the database
//$query = "SELECT * FROM series"; // Adjust the query according to your database structure
//$result = $conn->query($query);

$genresQuery = "SELECT * FROM genres";
$genresResult = $conn->query($genresQuery);
?>

    <form class="form-filters" action="your_reviews.php" method="get">

        <!-- Genre Filter -->
        <label for="genre">Genre:</label>
        <select id="genre" name="genre">
            <option value="">All Genres</option>
            <?php while ($genre = $genresResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($genre['genre_id']); ?>">
                    <?php echo htmlspecialchars($genre['genre_name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="sort">Sort by:</label>
        <select id="sort" name="sort">
            <option value="rating">Rating</option>
            <option value="chronologically">Chronologically</option>
        </select>

        <button type="submit">Apply Filters</button>
    </form>

<?php

$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'rating';

$query = "SELECT series.*, reviews.rating AS review_rating, reviews.text AS review_text, reviews.user_id AS id FROM series JOIN reviews ON series.series_id = reviews.series_id";

// Apply genre filter
if (!empty($genre)) {
    $query .= " JOIN series_genres ON series.series_id = series_genres.series_id WHERE series_genres.genre_id = " . intval($genre);
    $query .= " AND reviews.user_id = " . $_SESSION['user_id'];
} else {
    $query .= " WHERE reviews.user_id = " . $_SESSION['user_id'];
}

//$query .= " GROUP BY series.series_id";

// Apply sorting
switch ($sort) {
    case 'rating':
        $query .= " ORDER BY reviews.rating DESC";
        break;
    case 'chronologically':
        $query .= " ORDER BY review_id DESC";
        break;
}



$result = $conn->query($query);
?>

    <link rel="stylesheet" href="your_reviews.css">
    <div class="review-list">
        <?php if ($result->num_rows < 1): ?>
        <h3>No reviews</h3>
        <?php endif; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review-item">
                <h3><?php echo htmlspecialchars($row['series_name']); ?></h3>
                <div class="star-rating">
                    <?php echo str_repeat('★', intval($row['review_rating'])); ?>
                    <?php echo str_repeat('☆', 10 - intval($row['review_rating'])); ?>
                    <span style="color: #666666"><?php echo intval($row['review_rating']) ?></span>
                </div>
                <div class="review-text"><?php echo htmlspecialchars($row['review_text']); ?></div>
                <a href="edit_review.php?series_id=<?php echo htmlspecialchars($row['series_id']); ?>&src=your_reviews.php">Edit</a>
            </div>
        <?php endwhile; ?>
    </div>

<?php
$conn->close();
?>