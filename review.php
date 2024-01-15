<?php
include "header.php";
include "config.php";

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['series_id'])) {
    $series_id = $_GET['series_id'];
    ?>

    <link rel="stylesheet" href="review.css">
    <form action="add_review.php?series_id=<?php echo $series_id; ?>" method="POST" class="form-review">
        <h2>Rate!</h2>
        <div class="star-rating">
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <span class="star" data-value="<?php echo $i; ?>">&#9733;</span>
            <?php endfor; ?>
            <input type="hidden" id="rating" name="rating" value="0">
        </div>
        <br><br>
        <textarea id="text" name="text" maxlength="155"></textarea>
        <br><br>
        <?php if (isset($_SESSION["ratingError"])): ?>
            <div class="message-box">
                <p><?php echo $_SESSION["ratingError"]; ?></p>
            </div>
            <?php unset($_SESSION["ratingError"]); ?>
        <?php endif; ?>
        <button type="submit">Submit</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const stars = document.querySelectorAll('.star-rating .star');
            const ratingInput = document.getElementById('rating');

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    ratingInput.value = index + 1; // Update the hidden input value
                    highlightStars(index);
                });
            });

            function highlightStars(index) {
                stars.forEach((star, idx) => {
                    star.style.color = idx <= index ? 'gold' : 'white'; // Fill or empty the stars
                });
            }
        });
    </script>
    <?php
}
?>
