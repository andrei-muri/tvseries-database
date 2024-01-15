<?php
session_start();
require_once "db.php";

$seriesId = (isset($_GET['series_id'])) ? $_GET['series_id'] : null;
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$series_src = (isset($_GET['series_src'])) ? $_GET['series_src'] : "index.php";
$src = (isset($_GET['src'])) ? $_GET['src'] : "favourites.php";

if($seriesId && $action) {
    $userId = $_SESSION['user_id'];
    switch ($action) {
        case 'add':
            $insertQuery = "INSERT INTO favourite_series (user_id, series_id) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ii", $userId, $seriesId);
            $stmt->execute();
            $_SESSION['addedFav'] = "Series added successfully!";
            break;
        case 'delete':
            $deleteQuery = "DELETE FROM favourite_series WHERE user_id = $userId AND series_id = $seriesId";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->execute();
            if ($src != "favourites.php") {
                $_SESSION['deletedFav'] = "Series deleted successfully!";
            }
            break;
    }

    switch($src) {
        case 'series_details.php':
            header("Location: series_details.php?series_id=" . $seriesId . "&src=" . $series_src);
            exit();
        case 'favourites.php':
            header("Location:favourites.php");
            exit();
    }

} else {
    echo "Series not found";
}
?>
