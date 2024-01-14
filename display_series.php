<?php
include "header.php";
require_once 'db.php';

//// Fetch all series from the database
//$query = "SELECT * FROM series"; // Adjust the query according to your database structure
//$result = $conn->query($query);

$genresQuery = "SELECT * FROM genres"; // Adjust this query to match your genres table structure
$genresResult = $conn->query($genresQuery);
?>

    <form action="display_series.php" method="get">

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
            <option value="alphabetical">Alphabetically</option>
            <!-- Additional sorting options can be added here -->
        </select>

        <button type="submit">Apply Filters</button>
    </form>

<?php

$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'rating';

$query = "SELECT series.*, AVG(reviews.rating) AS average_rating FROM series LEFT JOIN reviews ON series.series_id = reviews.series_id";

// Apply genre filter
if (!empty($genre)) {
    $query .= " JOIN series_genres ON series.series_id = series_genres.series_id WHERE series_genres.genre_id = " . intval($genre);
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        $query .= " AND series.series_name LIKE '%$name%'";
    }
} else if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $query .= " WHERE series.series_name LIKE '%$name%'";
}

$query .= " GROUP BY series.series_id";

// Apply sorting
switch ($sort) {
    case 'rating':
        $query .= " ORDER BY average_rating DESC";
        break;
    case 'alphabetical':
        $query .= " ORDER BY series.series_name ASC";
        break;
}

$result = $conn->query($query);
?>

<?php if ($result->num_rows < 1) : ?>
    <h3>No series found!</h3>
<?php endif; ?>

    <div class="series-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="series-item">
                <!-- Link to the series details page with the series ID -->
                <a href="series_details.php?series_id=<?php echo $row['series_id']; ?>&src=display_series.php">
                    <?php echo $row['series_name'] ?>
                    <?php echo $row['start_year'] ?>
                    <?php echo $row['end_year'] ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

<?php
$conn->close();
?>