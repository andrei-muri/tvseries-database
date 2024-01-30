<?php
global $conn;
include "header.php";
include "config.php";
require_once "db.php";

$series_id = $_GET['series_id'];
?>

<head>
    <link rel="stylesheet" href="character.css">
</head>

<form class="add-character-form" method="post" action="add_character.php">
    <div class="form-group">
        <label for="character_name">Character Name:</label>
        <input type="text" id="character_name" name="character_name" required>
    </div>

    <div class="form-group">
        <label for="actor_id">Played by:</label>
        <select id="actor_id" name="actor_id">
            <?php
            $actorQuery = "SELECT actor_id, actor_name FROM actors";
            $actorResult = $conn->query($actorQuery);
            while ($actorRow = $actorResult->fetch_assoc()) {
                echo "<option value='{$actorRow["actor_id"]}'>{$actorRow["actor_name"]}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="role_id">Role:</label>
        <select id="role_id" name="role_id">
            <?php
            $roleQuery = "SELECT role_id, role_name FROM roles";
            $roleResult = $conn->query($roleQuery);
            while ($roleRow = $roleResult->fetch_assoc()) {
                echo "<option value='{$roleRow["role_id"]}'>{$roleRow["role_name"]}</option>";
            }
            ?>
        </select>
    </div>

    <input type="hidden" name="series_id" value="<?php echo $series_id; ?>">

    <div class="form-buttons">
        <input type="submit" name="add_another" value="Add Character & Add Another">
        <input type="submit" name="add_and_redirect" value="Add Character & Go Home">
    </div>
</form>
