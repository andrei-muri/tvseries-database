<?php
include "header.php";
require_once 'db.php';

// Get the series ID from the URL
$seriesId = isset($_GET['series_id']) ? $_GET['series_id'] : null;
$src = isset($_GET['src']) ? $_GET['src'] : "index.php";

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
} else {
    $user_id = null;
    $username = null;
}


if ($seriesId) {
// Fetch the series details from the database
    $query = "SELECT * FROM series WHERE series_id = $seriesId"; // Adjust the query according to your database structure
    $result = $conn->query($query);

    if ($row = $result->fetch_assoc()) {
        $series_name = $row['series_name'];
// Display the series details
        echo "<h2>" . $row['series_name'] . "</h2>";
        echo "<h2>" . $row['start_year'] . "</h2>";
        echo "<h2>" . $row['end_year'] . "</h2>";
        echo "<h2>" . $row['rating'] . "</h2>";
        if ($row['img']) {
            echo "<div><img src='uploads/" . $row['img'] . "'></div>";
        }

        echo "<p>" . $row['details'] . "</p>";

        $director_id = $row['director_id'];
        $query = "SELECT director_name FROM directors WHERE director_id = $director_id";
        $directorResult = $conn->query($query);
        if ($directorRow = $directorResult->fetch_assoc()) {
            echo "<h2>" . $directorRow['director_name'] . "</h2>";
        }

        //display characters played by actor
        $selectCharactersQuery = "SELECT * FROM actors a RIGHT JOIN characters c ON a.actor_id = c.actor_id
                                LEFT JOIN roles r ON c.role_id = r.role_id WHERE c.series_id = $seriesId";
        $characters = $conn->query($selectCharactersQuery);
        while ($character = $characters->fetch_assoc()) {
            echo "<h6>" . $character['character_name'] . " role: " . $character['role_name'] . ". Played by: " .$character['actor_name'] . "</h6>";
        }


        echo "<div style='color : gray'>" . "Reviewed by: " . $row['nb_reviews'] ."</div>";
        //check if series is already a favourite
        if ($user_id != null) {
            $isFav = false;
            $check = "SELECT * FROM favourite_series WHERE user_id = $user_id AND series_id = $seriesId";
            $result = $conn->query($check);
            if ($result->num_rows > 0) {
                $isFav = true;
            }
        }

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
        <?php if ($user_id && $isFav): ?>
            <a href="add_delete_favourites.php?series_id=<?php echo $seriesId; ?>&action=delete&series_src=<?php echo $src; ?>&src=series_details.php">Remove from
                favourites</a>
        <?php elseif ($user_id): ?>
            <a href="add_delete_favourites.php?series_id=<?php echo $seriesId; ?>&action=add&series_src=<?php echo $src; ?>&src=series_details.php">Add to
                favourites</a>
        <?php endif; ?>
        <?php
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
        } else {
            $user_id = null;
            $username = null;
        }
        $result2 = null;
        if ($user_id) {
            $checkIfRatingExistsQuery = "SELECT * FROM reviews WHERE user_id = $user_id AND series_id = $seriesId";
            $result2 = $conn->query($checkIfRatingExistsQuery);
            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                echo "<div'>";
                echo "<div>" . $username . "</div><br>";
                echo "<div>" . $row['rating'] . "</div><br>";
                echo "<div>" . $row['text'] . "</div><br>";
                echo "</div>";
            }
        }

        if ($user_id) {
            $reviewGetQuery = "SELECT * FROM reviews WHERE series_id = $seriesId AND user_id <> $user_id";
        } else {
            $reviewGetQuery = "SELECT * FROM reviews WHERE series_id = $seriesId";
        }
        $reviews = $conn->query($reviewGetQuery);
        $i = 0;
        while ($review = $reviews->fetch_assoc()) {
            if ($i < 3) {
                $getUsernameQuery = "SELECT username FROM users WHERE user_id = {$review['user_id']}";
                $username = $conn->query($getUsernameQuery)->fetch_assoc();
                echo "<div>";
                echo "<div>" . $username['username'] . "</div><br>";
                echo "<div>" . $review['rating'] . "</div><br>";
                echo "<div>" . $review['text'] . "</div><br>";
                echo "</div>";
                $i++;
            } else {
                break;
            }
        }


    } else {
        echo "Series not found.";
    }
} else {
    echo "No series selected.";
}


$reviewExists = false;
if ($result2 && $result2->num_rows > 0) {
    $reviewExists = true;
}

$conn->close();
?>
<?php if ($reviewExists && $user_id): ?>
    <a href="edit_review.php?series_id=<?php echo $seriesId; ?>&src=series_details.php">Edit review</a>
<?php elseif ($user_id): ?>
    <a href="review.php?series_id=<?php echo $seriesId; ?>">Give rating!</a>
<?php endif; ?>
<a href="all_series_reviews.php?series_id=<?php echo $seriesId; ?>&series_name=<?php echo $series_name; ?>">View all
    reviews</a>
<a href="<?php echo $src; ?>">Go back</a>