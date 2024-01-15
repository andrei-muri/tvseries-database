<?php
include "header.php";
include "config.php";
?>

<link rel="stylesheet" href="account.css">

<div class="form-wrapper">
    <form action="change_password_form.php" method="post">
        <button type="submit" value="Change Password">Change Password</button>
    </form>

    <form action="delete_account.php" method="post">
        <button type="submit" value="Delete">Delete account</button>
    </form>

    <form action="logout.php" method="post">
        <button type="submit" value="logout">Logout</button>
    </form>
</div>