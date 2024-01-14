<?php
include "header.php";
?>

<form class="mt-25" action="add_user.php" method="post">
    <label for="username">User Name:</label>
    <input type="text" id="username" name="username" required>
    <br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br><br>
    <label for="confirm_password">Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <br><br>
    <?php if (isset($_SESSION["registrationError"])): ?>
        <div class="col-6">
            <p style="color: red;"><?php echo $_SESSION["registrationError"]; ?></p>
            <?php unset($_SESSION["registrationError"]); ?>
        </div>
    <?php endif; ?>
    <button type="submit">Add User</button>

</form>