<?php
include "header.php";
include "db.php";
// Fetch directors and genres
$directorsQuery = "SELECT director_id, director_name FROM directors";
$directorsResult = $conn->query($directorsQuery);
$genresQuery = "SELECT genre_id, genre_name FROM genres";
$genresResult = $conn->query($genresQuery);
$conn->close();
?>

<link rel="stylesheet" href="series.css">

<form class="form-series" action="add_series.php" method="POST" enctype="multipart/form-data">
    <!-- Series Name -->
    <label for="series_name">Series name:</label>
    <input type="text" id="series_name" name="series_name" required>
    <!-- Start Year -->
    <label for="start_year">Start year:</label>
    <input type="number" id="start_year" name="start_year" required>
    <!-- Is Running -->
    <label for="isRunning">Is the series running?</label>
    <select id="isRunning" name="isRunning" required onchange="toggleEndYearVisibility()">
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
    <!-- End Year -->
    <div id="endYearContainer" class="end-year-container">
        <label for="end_year">End year:</label>
        <input type="number" id="end_year" name="end_year">
    </div>
    <!-- Description -->
    <label for
           ="details">Description:</label>
    <textarea id="details" name="details" placeholder="Write description"></textarea>
    <!-- Director -->
    <label for="director_id">Director:</label>
    <select id="director_id" name="director_id" required>
        <option value="">Select a director</option>
        <?php while ($director = $directorsResult->fetch_assoc()): ?>
            <option value="<?php echo htmlspecialchars($director['director_id']); ?>"><?php echo htmlspecialchars($director['director_name']); ?></option>
        <?php endwhile; ?>
    </select>
    <!-- Genres -->
    <div class="genres-container-add">
        <div>Genres:</div>
        <?php while ($genre = $genresResult->fetch_assoc()): ?>
            <div class="genre-checkbox">
                <label for="genre<?php echo $genre['genre_id']; ?>"><?php echo htmlspecialchars($genre['genre_name']); ?></label>
                <input type="checkbox" id="genre<?php echo $genre['genre_id']; ?>" name="genre<?php echo $genre['genre_id']; ?>" value="<?php echo $genre['genre_id']; ?>">
            </div>
        <?php endwhile; ?>
    </div>
    <!-- Image Upload -->
    <label for="my_image">Upload image</label>
    <input type="file" id="my_image" name="my_image">
    <!-- Error Messages -->
    <?php if (isset($_SESSION["yearError"])): ?>
        <div class="message-box"><?php echo $_SESSION["yearError"]; ?></div>
        <?php unset($_SESSION["yearError"]); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION["nameError"])): ?>
        <div class="message-box"><?php echo $_SESSION["nameError"]; ?></div>
        <?php unset($_SESSION["nameError"]); ?>
    <?php endif; ?>
    <?php if (isset($_GET["error"])): ?>
        <div class="message-box"><?php echo $_GET["error"]; ?></div>
        <?php unset($_GET["error"]); ?>
    <?php endif; ?>
    <!-- Submit Button -->
    <button type="submit">Add Series</button>

</form>
<script>
    function toggleEndYearVisibility() {
        var isRunning = document.getElementById('isRunning').value;
        var endYearContainer = document.getElementById('endYearContainer');
        if (isRunning == "0") { // "No" is selected
            endYearContainer.style.display = 'block';
        } else {
            endYearContainer.style.display = 'none';
        }
    }

    // Call the function on page load to set the initial state
    window.onload = toggleEndYearVisibility;
</script>