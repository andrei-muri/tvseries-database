<?php
include "header.php";
require_once 'db.php';

// Get the series ID from the URL
$seriesId = isset($_GET['series_id']) ? $_GET['series_id'] : null;
$src = isset($_GET['src']) ? $_GET['src'] : "index.php";

if (isset($_SESSION['user_id'])) {
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

        //get the genres
        $getGenresQuery = "SELECT genre_name FROM series s JOIN series_genres sg ON sg.series_id = s.series_id
                        JOIN genres g ON sg.genre_id = g.genre_id WHERE sg.series_id = $seriesId";
        $genres = $conn->query($getGenresQuery);
        ?>

        <div class="series-details-container">
            <?php
            if ($user_id != null) {
                $isFav = false;
                $check = "SELECT * FROM favourite_series WHERE user_id = $user_id AND series_id = $seriesId";
                $result = $conn->query($check);
                if ($result->num_rows > 0) {
                    $isFav = true;
                }
            }

            ?>
            <div class="favourite-container">
                <?php if ($user_id && $isFav): ?>
                    <a class="add-fav remove-fav"
                       href="add_delete_favourites.php?series_id=<?php echo $seriesId; ?>&action=delete&series_src=<?php echo $src; ?>&src=series_details.php">-</a> <!-- Filled heart -->
                <?php elseif ($user_id): ?>
                    <a class="add-fav add-to-fav"
                       href="add_delete_favourites.php?series_id=<?php echo $seriesId; ?>&action=add&series_src=<?php echo $src; ?>&src=series_details.php">+</a> <!-- Outlined heart -->
                <?php endif; ?>
            </div>
            <div class="series-image">
                <?php if ($row['img']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($row['img']); ?>" alt="Series Image">
                <?php endif; ?>
            </div>


            <div class="series-info-wrapper">
                <h2 class="series-title"><?php echo htmlspecialchars($row['series_name']); ?></h2>
                <div class="genres-container">
                    <?php while ($genre = $genres->fetch_assoc()): ?>
                        <div class="genres-item"><?php echo htmlspecialchars($genre['genre_name']); ?></div>
                    <?php endwhile; ?>
                </div>
                <div class="series-meta">
                    <span class="series-year"><?php echo htmlspecialchars($row['start_year']); ?></span> -
                    <span class="series-year"><?php echo htmlspecialchars($row['end_year']); ?></span>
                    <span class="series-rating">Rating: <?php echo htmlspecialchars($row['rating']); ?> ★</span>
                </div>
                <p class="series-details"><?php echo htmlspecialchars($row['details']); ?></p>

                <?php
                $director_id = $row['director_id'];
                $query = "SELECT director_name FROM directors WHERE director_id = $director_id";
                $directorResult = $conn->query($query);
                if ($directorRow = $directorResult->fetch_assoc()):
                    ?>
                    <h3 class="director-name">Directed
                        by: <?php echo htmlspecialchars($directorRow['director_name']); ?></h3>
                <?php endif; ?>

                <div class="character-list">
                    <h3>Cast & Characters:</h3>
                    <?php
                    $selectCharactersQuery = "SELECT * FROM actors a RIGHT JOIN characters c ON a.actor_id = c.actor_id
                                      LEFT JOIN roles r ON c.role_id = r.role_id WHERE c.series_id = $seriesId";
                    $characters = $conn->query($selectCharactersQuery);
                    while ($character = $characters->fetch_assoc()):
                        ?>
                        <div class="character-item">
                            <span class="character-name"><?php echo htmlspecialchars($character['character_name']); ?></span>
                            <span class="role-name">as <?php echo htmlspecialchars($character['role_name']); ?></span>
                            <span class="actor-name">by <?php echo htmlspecialchars($character['actor_name']); ?></span>
                        </div>
                    <?php endwhile; ?>
                </div>

                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
                      rel="stylesheet"/>


            </div>
        </div>

        <link rel="stylesheet" href="your_reviews.css">
        <div class="review-list">
            <?php
            echo "<div style='color : gray'>" . "Reviewed by: " . $row['nb_reviews'] . "</div>";
            //check if series is already a favourite
            if (isset($_SESSION['user_id'])) {
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
                    ?>
                    <div class="review-item">
                        <div style="color: #0056b3"><?php echo htmlspecialchars($username); ?></div>
                        <div class="star-rating">
                            <div class="star-rating">
                                <?php echo str_repeat('★', intval($row['rating'])); ?>
                                <?php echo str_repeat('☆', 10 - intval($row['rating'])); ?>
                                <span style="color: #666666"><?php echo intval($row['rating']) ?></span>
                            </div>
                        </div>
                        <div class="review-text"><?php echo htmlspecialchars($row['text']); ?></div>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id): ?>
                            <a href="edit_review.php?series_id=<?php echo $seriesId; ?>&src=series_details.php">Edit</a>
                        <?php endif; ?>
                    </div>

                    <?php
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
//                echo "<div>";
//                echo "<div>" . $username['username'] . "</div><br>";
//                echo "<div>" . $review['rating'] . "</div><br>";
//                echo "<div>" . $review['text'] . "</div><br>";
//                echo "</div>";
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
                    </div>
                    <?php
                    $i++;
                } else {
                    break;
                }
            }

            ?>
        </div>
        <?php
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
<div class="d-flex justify-content-center" style="gap: 10px">
    <?php if ($reviewExists && $user_id): ?>
        <!--    <a  href="edit_review.php?series_id=--><?php //echo $seriesId; ?><!--&src=series_details.php">Edit review</a>-->
    <?php elseif ($user_id): ?>
        <a class="series-buttons-actions" href="review.php?series_id=<?php echo $seriesId; ?>">Give rating!</a>
    <?php endif; ?>
    <a class="series-buttons-actions"
       href="all_series_reviews.php?series_id=<?php echo $seriesId; ?>&series_name=<?php echo $series_name; ?>">View all
        reviews</a>
    <a class="series-buttons-actions" href="<?php echo $src; ?>">Go back</a>
</div>
