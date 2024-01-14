<?php
include "header.php";
require_once 'db.php';

//// Fetch all series from the database
//$query = "SELECT * FROM series"; // Adjust the query according to your database structure
//$result = $conn->query($query);

$genresQuery = "SELECT * FROM genres"; // Adjust this query to match your genres table structure
$genresResult = $conn->query($genresQuery);
?>

    <form action="your_reviews.php" method="get">

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

        <!-- Sorting Options -->
        <label for="sort">Sort by:</label>
        <select id="sort" name="sort">
            <option value="rating">Rating</option>
            <option value="chronologically">Chronologically</option>
            <!-- Additional sorting options can be added here -->
        </select>

        <button type="submit">Apply Filters</button>
    </form>

<?php

$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'rating';

$query = "SELECT series.*, reviews.rating AS review_rating, reviews.text AS review_text FROM series JOIN reviews ON series.series_id = reviews.series_id";

// Apply genre filter
if (!empty($genre)) {
    $query .= " JOIN series_genres ON series.series_id = series_genres.series_id WHERE series_genres.genre_id = " . intval($genre);
}

//$query .= " GROUP BY series.series_id";

// Apply sorting
switch ($sort) {
    case 'rating':
        $query .= " ORDER BY reviews.rating DESC";
        break;
    case 'chronologically':
        break;
}

$result = $conn->query($query);
?>

    <div class="review-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review-item">
                <h3><?php echo $row['series_name'] ?></h3>
                <?php echo $row['review_rating'] ?>
                <?php echo $row['review_text'] ?>
                <a href="edit_review.php?series_id=<?php echo $row['series_id']; ?>&src=your_reviews.php">Edit</a>
            </div>
        <?php endwhile; ?>
    </div>

<?php
$conn->close();
?>