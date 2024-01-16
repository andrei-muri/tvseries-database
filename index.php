<?php
include "config.php";
include "header.php";
require_once "db.php";

$getFanFavouritesQuery = "SELECT * FROM series ORDER BY rating DESC LIMIT 6";
$fanFavourites = $conn->query($getFanFavouritesQuery);

$getGenresQuery = "SELECT * FROM genres";
$genres = $conn->query($getGenresQuery);
echo "<h2 class='categories-title'>Fan Favourites</h2><br>";
?>
<div class="series-list">
    <?php
    while ($fanFavourite = $fanFavourites->fetch_assoc()) {
        ?>
        <div class="series-item">
            <img src="uploads/<?php echo $fanFavourite['img']; ?>" alt="Series Image">
            <div class="series-info">
                <div class="series-name"><?php echo htmlspecialchars($fanFavourite['series_name']); ?></div>
                <div class="series-rating">Rating: <?php echo htmlspecialchars($fanFavourite['rating']); ?> ★</div>
                <div class="series-year"><?php echo htmlspecialchars($fanFavourite['start_year']); ?>
                    - <?php echo htmlspecialchars($fanFavourite['end_year']); ?></div>
            </div>
            <a href="series_details.php?series_id=<?php echo $fanFavourite['series_id']; ?>&src=display_series.php"
               class="series-buttons">View Details</a>
        </div>
        <?php
    }
    ?>
</div>

<?php

while ($genre = $genres->fetch_assoc()) {
    $getTopSeriesByGenreQuery = "SELECT * FROM series s JOIN series_genres sg ON s.series_id = sg.series_id
                            JOIN genres g ON sg.genre_id = g.genre_id WHERE g.genre_id = " . intval($genre['genre_id']) .
        " ORDER BY s.rating DESC LIMIT 6";
    echo "<h2 class='categories-title'>Top " . $genre['genre_name'] . "</h2>";
    $topSeriesByGenre = $conn->query($getTopSeriesByGenreQuery);
    ?>
    <div class="series-list">
        <?php while ($series = $topSeriesByGenre->fetch_assoc()): ?>
            <div class="series-item">
                <img src="uploads/<?php echo $series['img']; ?>" alt="Series Image">
                <div class="series-info">
                    <div class="series-name"><?php echo htmlspecialchars($series['series_name']); ?></div>
                    <div class="series-rating">Rating: <?php echo htmlspecialchars($series['rating']); ?> ★</div>
                    <div class="series-year"><?php echo htmlspecialchars($series['start_year']); ?> - <?php echo htmlspecialchars($series['end_year']); ?></div>
                </div>
                <a href="series_details.php?series_id=<?php echo $series['series_id']; ?>&src=index.php" class="series-buttons">View Details</a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
}
?>


