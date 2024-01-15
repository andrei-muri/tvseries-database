<?php
include "config.php";
include "header.php";
?>

<div class="login-container">
    <h1 class="login-title">Login</h1>
    <form class="login-form" action="check_user.php" method="POST">
        <label for="username">User Name:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <?php if (isset($_SESSION["loginError"])): ?>
            <div class="message-box error">
                <p><?php echo $_SESSION["loginError"]; ?></p>
            </div>
            <?php unset($_SESSION["loginError"]); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION["registrationSuccess"])): ?>
            <div class="message-box success">
                <p><?php echo $_SESSION["registrationSuccess"]; ?></p>
            </div>
            <?php unset($_SESSION["registrationSuccess"]); ?>
        <?php endif; ?>
        <button type="submit">Login</button>
    </form>
</div>
