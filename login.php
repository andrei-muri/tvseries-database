<?php
include "config.php";
include "header.php";
?>

<form class="mt-25" action="check_user.php" method="POST">
    <label for="username">User Name:</label>
    <input type="text" id="username" name="username" required>
    <br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br><br>
    <?php if (isset($_SESSION["loginError"])): ?>
        <div class="col-6">
            <p style="color: red;"><?php echo $_SESSION["loginError"]; ?></p>
            <?php unset($_SESSION["loginError"]); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION["registrationSuccess"])): ?>
        <div class="col-6">
            <p style="color: green;"><?php echo $_SESSION["registrationSuccess"]; ?></p>
            <?php unset($_SESSION["registrationSuccess"]); ?>
        </div>
    <?php endif; ?>
    <button type="submit">Login</button>
</form>
