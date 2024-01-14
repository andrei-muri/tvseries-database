<?php
include "header.php";
include "config.php";
require_once "db.php";

$series_id = $_GET['series_id'];
?>

<form method="post" action="add_character.php">
    <!-- Your character input fields here -->
    <label for="character_name">Character Name:</label>
    <input type="text" id="character_name" name="character_name" required>
    <br><br>

    <!-- Select actor from the list of actors -->
    <label for="actor_id">Played by:</label>
    <select id="actor_id" name="actor_id">
        <?php
        // Fetch actors from the actors table (replace with your actual table name)
        $actorQuery = "SELECT actor_id, actor_name FROM actors";
        $actorResult = $conn->query($actorQuery);

        // Display actors in the dropdown
        while ($actorRow = $actorResult->fetch_assoc()) {
            echo "<option value='{$actorRow["actor_id"]}'>{$actorRow["actor_name"]}</option>";
        }
        ?>
    </select>
    <br><br>

    <!-- Select role from the list of roles -->
    <label for="role_id">Role:</label>
    <select id="role_id" name="role_id">
        <?php
        // Fetch roles from the roles table (replace with your actual table name)
        $roleQuery = "SELECT role_id, role_name FROM roles";
        $roleResult = $conn->query($roleQuery);

        // Display roles in the dropdown
        while ($roleRow = $roleResult->fetch_assoc()) {
            echo "<option value='{$roleRow["role_id"]}'>{$roleRow["role_name"]}</option>";
        }
        ?>
    </select>
    <br><br>

    <!-- Hidden input field to store series_id -->
    <input type="hidden" name="series_id" value="<?php echo $series_id; ?>">

    <!-- Two submit buttons -->
    <input type="submit" name="add_another" value="Add Character & Add Another">
    <input type="submit" name="add_and_redirect" value="Add Character & Go Home">
</form>