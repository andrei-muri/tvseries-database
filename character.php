<?php
include "header.php";
include "config.php";

$seriesId = (isset($_GET['series_id'])) ? $_GET['series_id'] : null;

if ($seriesId) {
    ?>
    <form action="add_character.php" method="post">

    </form>
    <?php
}

?>
