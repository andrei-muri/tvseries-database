<?php
include "header.php";
include "db.php";
// Fetch directors for the dropdown
$directorsQuery = "SELECT director_id, director_name FROM directors";
$directorsResult = $conn->query($directorsQuery);

$genresQuery = "SELECT genre_id, genre_name FROM genres";
$genresResult = $conn->query($genresQuery);
$conn->close();
?>

<form class="mt-25" action="add_series.php" method="POST" enctype="multipart/form-data">
    <label for="series_name">Series name:</label>
    <input type="text" id="series_name" name="series_name" required>
    <br><br>
    <label for="start_year">Start year:</label>
    <input type="number" id="start_year" name="start_year" required>
    <br><br>
    <label for="isRunning">Is the series running?</label>
    <select id="isRunning" name="isRunning" required onchange="toggleEndYearVisibility()">
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
    <br><br>

    <div id="endYearContainer" style="display: none;">
        <label for="end_year">End year:</label>
        <input type="number" id="end_year" name="end_year">
        <br><br>
    </div>
    <label for="director_id">Director:</label>
    <select id="director_id" name="director_id" required>
        <option value="">Select a director</option>
        <?php
        // Display existing directors in the dropdown
        while ($director = $directorsResult->fetch_assoc()) {
            echo "<option value='{$director['director_id']}'>{$director['director_name']}</option>";
        }
        ?>
    </select>
    <br><br>
    <div>Genres:</div>
    <?php while ($genre = $genresResult->fetch_assoc()): ?>
        <label for="genre<?php echo $genre['genre_id']; ?>"><?php echo $genre['genre_name']; ?></label>
        <input type="checkbox" id="genre<?php echo $genre['genre_id']; ?>" name="genre<?php echo $genre['genre_id']; ?>" value="<?php echo $genre['genre_id']; ?>">
        <br>
    <?php endwhile; ?>
    <br><br>

    <label for="my_image">Upload image</label>
    <input type="file" id ="my_image" name="my_image">
    <br><br>

    <?php if (isset($_SESSION["yearError"])): ?>
        <div class="col-6">
            <p style="color: red;"><?php echo $_SESSION["yearError"]; ?></p>
            <?php unset($_SESSION["yearError"]); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION["nameError"])): ?>
        <div class="col-6">
            <p style="color: red;"><?php echo $_SESSION["nameError"]; ?></p>
            <?php unset($_SESSION["nameError"]); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET["error"])): ?>
        <div class="col-6">
            <p style="color: red;"><?php echo $_GET["error"]; ?></p>
            <?php unset($_GET["error"]); ?>
        </div>
    <?php endif; ?>
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
