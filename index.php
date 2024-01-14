<?php
include "config.php";
include "header.php";
require_once "db.php";

$getFanFavouritesQuery = "SELECT * FROM series ORDER BY rating DESC LIMIT 7";
$fanFavourites = $conn->query($getFanFavouritesQuery);

$getGenresQuery = "SELECT * FROM genres";
$genres = $conn->query($getGenresQuery);
echo "<h2>Fan Favourites:</h2><br>";
while ($fanFavourite = $fanFavourites->fetch_assoc()) {
    ?>
    <a href="series_details.php?series_id=<?php echo $fanFavourite['series_id']; ?>">
        <div><?php echo $fanFavourite['series_name']; ?></div>
        <div><?php echo $fanFavourite['rating']; ?></div>
        <div><?php echo $fanFavourite['start_year']; ?></div>
    </a>
    <?php
}

while ($genre = $genres->fetch_assoc()) {
    $getTopSeriesByGenreQuery = "SELECT * FROM series s JOIN series_genres sg ON s.series_id = sg.series_id
                            JOIN genres g ON sg.genre_id = g.genre_id WHERE g.genre_id = " . intval($genre['genre_id']) .
        " ORDER BY s.rating DESC LIMIT 7";
    echo "<h2>Top " . $genre['genre_name'];
    $topSeriesByGenre = $conn->query($getTopSeriesByGenreQuery);
    while ($series = $topSeriesByGenre->fetch_assoc()) {
        ?>
        <a href="series_details.php?series_id=<?php echo $series['series_id']; ?>&src=index.php">
            <div><?php echo $series['series_name']; ?></div>
            <div><?php echo $series['rating']; ?></div>
            <div><?php echo $series['start_year']; ?></div>
        </a>
        <?php
    }
}
?>

