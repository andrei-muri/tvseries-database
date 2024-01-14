<?php
include "header.php";
include "config.php";
require_once "db.php";

$series_id = isset($_GET['series_id']) ? $_GET['series_id'] : 0;
$series_name = isset($_GET['series_name']) ? $_GET['series_name'] : '';
?>

<form action="all_series_reviews.php" method="get">
    <!-- Include series_id and series_name as hidden fields -->
    <input type="hidden" name="series_id" value="<?php echo htmlspecialchars($series_id); ?>">
    <input type="hidden" name="series_name" value="<?php echo htmlspecialchars($series_name); ?>">

    <label for="sort">Sort:</label>
    <select id="sort" name="sort">
        <option value="chronologically">Chronologically</option>
        <option value="rating">By rating</option>
    </select>
    <button type="submit">Sort</button>
</form>

<?php
$sortMethod = isset($_GET['sort']) ? $_GET['sort'] : '';

if ($series_id && $series_name) {
    echo "<h2>" . htmlspecialchars($series_name) . "</h2>";
    $reviewGetQuery = "SELECT * FROM reviews WHERE series_id = " . intval($series_id);

    if ($sortMethod) {
        switch ($sortMethod) {
            case 'chronologically':
                break;
            case 'rating':
                $reviewGetQuery .= " ORDER BY rating DESC";
                break;
        }
    }
    $reviews = $conn->query($reviewGetQuery);
    while ($review = $reviews->fetch_assoc()) {
        $getUsernameQuery = "SELECT username FROM users WHERE user_id = " . intval($review['user_id']);
        $usernameResult = $conn->query($getUsernameQuery);
        if ($username = $usernameResult->fetch_assoc()) {
            echo "<div>";
            echo "<div>" . htmlspecialchars($username['username']) . "</div><br>";
            echo "<div>" . htmlspecialchars($review['rating']) . "</div><br>";
            echo "<div>" . htmlspecialchars($review['text']) . "</div><br>";
            echo "</div>";
        }
    }
}
?>

<a href="series_details.php?series_id=<?php echo $series_id; ?>">Go back</a>

