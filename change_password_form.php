<?php
include "header.php";
include "config.php";
?>

<form action="change_password.php" method="POST">
    <label for="current_password">Current password: </label>
    <input type="password" id="current_password" name="current_password" required>
    <br><br>

    <label for="new_password">New password: </label>
    <input type="password" id="new_password" name="new_password" required>
    <br><br>


    <label for="confirm_password">Confirm new password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <br><br>

    <?php if (isset($_SESSION["changePasswordError"])): ?>
        <div class="col-6">
            <p style="color: red;"><?php echo $_SESSION["changePasswordError"]; ?></p>
            <?php unset($_SESSION["changePasswordError"]); ?>
        </div>
    <?php endif; ?>

    <button type="submit" value="Change password">Change password</button>
</form>
