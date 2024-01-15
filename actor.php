<?php
include "config.php";
include "header.php";
?>

<link rel="stylesheet" href="actor.css">

<form class="form-add-actor" action="add_actor.php" method="POST">
    <label for="actor_name">Actor name:</label>
    <input type="text" id="actor_name" name="actor_name" required>
    <br><br>
    <button type="submit">Add Actor</button>
</form>
