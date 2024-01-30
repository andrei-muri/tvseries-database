<?php
include "config.php";
include "header.php";
?>

<div class="form-container" style="max-width: 500px">
    <h1 class="form-title">Add Actor</h1>
    <form class="form-design" action="add_actor.php" method="POST">
        <label for="actor_name">Actor name:</label>
        <input type="text" id="actor_name" name="actor_name" required>
        <br><br>
        <button type="submit">Add Actor</button>
    </form>
</div>
