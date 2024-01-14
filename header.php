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
<head>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="display_series.css">
    <link rel="stylesheet" href="display_series.css">
    <link rel="stylesheet" href="filters.css">
</head>

<div class="header">
    <div class="container1">
        <?php if ($username !== null): ?>

            <div><a href="account.php"><?php echo $username ?></a>
                <a href="index.php">Home</a></div>

            <form action="display_series.php" method="get">
                <input type="text" id="name" name="name" placeholder="Search series">
                <button type="submit">Search!</button>
            </form>

            <div><a href="director.php">Add Director</a>
                <a href="actor.php">Add Actor</a>
                <a href="series.php">Add Series</a>
                <a href="display_series.php">Series</a>
                <a href="favourites.php">Favourites</a>
                <a href="your_reviews.php">Your Reviews</a></div>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="sign_up.php">Sign Up</a>
        <?php endif; ?>

    </div>
</div>
