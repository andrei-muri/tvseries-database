<?php
include "header.php";
include "config.php";

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['series_id'])) {
    $series_id = $_GET['series_id'];
    ?>
    <form action="add_review.php?series_id=<?php echo $series_id; ?>" method="POST">
        <label for="rating">Rating: </label>
        <input type="number" id="rating" name="rating">
        <br><br>
        <input type="text" id="text" name="text" maxlength="155" size="155">
        <br><br>
        <?php if (isset($_SESSION["ratingError"])): ?>
            <div class="col-6">
                <p style="color: red;"><?php echo $_SESSION["ratingError"]; ?></p>
                <?php unset($_SESSION["ratingError"]); ?>
            </div>
        <?php endif; ?>
        <button type="submit">Submit</button>
    </form>
    <?php
}
?>
