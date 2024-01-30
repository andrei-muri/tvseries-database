<?php
include "header.php";
?>

<head>
    <link rel="stylesheet" href="sign_up.css">
</head>

<div class="form-container">
    <h1 class="form-title">Sign Up</h1>
    <form class="form-design" action="add_user.php" method="post">
        <label for="username">User Name:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br><br>
        <?php if (isset($_SESSION["registrationError"])): ?>
            <div class="message-box error">
                <p><?php echo $_SESSION["registrationError"]; ?></p>
            </div>
            <?php unset($_SESSION["registrationError"]); ?>
        <?php endif; ?>
        <button type="submit">Add User</button>
    </form>
</div>
