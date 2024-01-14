<?php
session_start();
include 'config.php';
// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    $username = $_SESSION["username"];
} else {
    $username = null;
}
?>


<div style="background-color: black">
    <div class="container d-flex justify-content-end text-white " style="gap: 50px">
        <?php if ($username !== null): ?>
        <div style="color: red"><?php echo $username ?></div>
            <a href="index.php">Home</a>
            <form action="logout.php" method="post">
                <button type="submit">Logout</button>
                <a href="director.php">Add Director</a>
                <a href="actor.php">Add Actor</a>
                <a href="series.php">Add Series</a>
                <a href="display_series.php">View Series</a>
                <a href="favourites.php">View Favourites</a>
            </form>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="sign_up.php">Sign Up</a>
        <?php endif; ?>

    </div>
</div>
