<?php
require_once "db.php";
include "header.php";
include "config.php";


$userId = $_SESSION['user_id'];

$getFavsQuery = "SELECT * FROM favourite_series fs JOIN series s ON fs.series_id = s.series_id 
         WHERE fs.user_id = $userId";
$results = $conn->query($getFavsQuery);
?>

<h2 class="categories-title">Favourites</h2>
<div class="series-list" style="margin-top: 10px">
        <?php while ($row = $results->fetch_assoc()): ?>
            <div class="series-item">
                <img src="uploads/<?php echo $row['img']; ?>" alt="Series Image">
                <div class="series-info">
                    <div class="series-name"><?php echo htmlspecialchars($row['series_name']); ?></div>
                    <div class="series-rating">Rating: <?php echo htmlspecialchars($row['rating']); ?> ★</div>
                    <div class="series-year"><?php echo htmlspecialchars($row['start_year']); ?> - <?php echo htmlspecialchars($row['end_year']); ?></div>
                    <a href='add_delete_favourites.php?series_id=<?php echo $row['series_id']; ?>&action=delete&src=favourites.php'>Remove from favs</a>
                </div>
                <a href="series_details.php?series_id=<?php echo $row['series_id']; ?>&src=favourites.php" class="series-buttons">View Details</a>
            </div>
        <?php endwhile; ?>
    </div>

<?php
if($results->num_rows == 0) {
    echo "<h2>" . "No favourite series" . "</h2>";
    echo "<a href='index.php'>" . "Go home" . "</a>";
}

?>
