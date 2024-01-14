<?php
require_once "db.php";
include "header.php";
include "config.php";


$userId = $_SESSION['user_id'];

$getFavsQuery = "SELECT * FROM favourite_series fs JOIN series s ON fs.series_id = s.series_id 
         WHERE fs.user_id = $userId";
$results = $conn->query($getFavsQuery);
?>
<?php if (isset($_SESSION["addedFav"])): ?>
            <div class="col-6">
                <p style="color: green;"><?php echo $_SESSION["addedFav"]; ?></p>
                <?php unset($_SESSION["addedFav"]); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION["deletedFav"])): ?>
            <div class="col-6">
                <p style="color: red;"><?php echo $_SESSION["deletedFav"]; ?></p>
                <?php unset($_SESSION["deletedFav"]); ?>
            </div>
        <?php endif; ?>
<?php
while ($fav = $results->fetch_assoc()) {
    echo "<a href='series_details.php?series_id=" . $fav['series_id'] . "&src=favourites.php'>" . $fav['series_name'] . "</a>";
    echo "<a href='add_delete_favourites.php?series_id=" . $fav['series_id'] . "&action=delete&src=favourites.php'>" . " Delete" . "</a>";
}

if($results->num_rows == 0) {
    echo "<h2>" . "No favourite series" . "</h2>";
    echo "<a href='index.php'>" . "Go home" . "</a>";
}

?>
