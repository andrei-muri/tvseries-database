<?php
include "config.php";
include "header.php";
?>

<link rel="stylesheet" href="director.css">

<form class="form-add-director" action="add_director.php" method="POST">
    <label for="director_name">Director name:</label>
    <input type="text" id="director_name" name="director_name" required>
    <br><br>
    <button type="submit">Add Director</button>
</form>
