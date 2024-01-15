<?php
session_start();
require_once 'db.php';

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $series_name = $_POST["series_name"];
    $start_year = $_POST["start_year"];
    $isRunning = $_POST["isRunning"];
    $new_img_name = 0;
    $end_year = $_POST["end_year"];
    $director_id = $_POST["director_id"];
    $details = $_POST['details'];

    $error = false;

    if ($start_year < 1950 || $start_year > 2024) {
        $_SESSION["yearError"] = "Invalid start year!";
        $error = true;
    }
    if (!$isRunning && (($end_year < 1950 || $end_year > 2024) || $end_year < $start_year)) {
        $_SESSION["yearError"] = "Invalid end year!";
        $error = true;
    }

    $checkDuplicateSeriesQuery = "SELECT series_id FROM series WHERE series_name = '$series_name'";
    $checkDuplicateSeriesResult = $conn->query($checkDuplicateSeriesQuery);
    if ($checkDuplicateSeriesResult->num_rows > 0) {
        $_SESSION["nameError"] = "Series already exists!";
        $error = true;
    }

    if ($error) {
        header("Location: series.php");
        exit();
    }

    if (isset($_FILES['my_image'])) {
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        if ($error === 0) {
            if ($img_size > 12500000) {
                $em = "Sorry, your file is too large.";
                header("Location: series.php?error=$em");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = 'uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                } else {
                    $em = "You can't upload files of this type";
                    header("Location: series.php?error=$em");
                }
            }
        } else {
            $em = "unknown error occurred!";
            header("Location: series.php?error=$em");
        }

    }

    $insertQuery = "INSERT INTO series (series_name, start_year, end_year, isRunning, director_id, img, nb_reviews, rating, details) VALUES ('$series_name', '$start_year', '$end_year', '$isRunning', '$director_id', '$new_img_name', 0, 0, '$details');";

    if ($conn->query($insertQuery) === TRUE) {
        $seriesId = $conn->insert_id; // Get the last inserted series ID

        // Get all genres
        $getGenresQuery = "SELECT genre_id FROM genres";
        $genres = $conn->query($getGenresQuery);

        while ($genre = $genres->fetch_assoc()) {
            $genreKey = "genre" . $genre["genre_id"];
            if (isset($_POST[$genreKey])) {
                $insertSeriesGenreQuery = "INSERT INTO series_genres (series_id, genre_id) VALUES ('$seriesId', '{$genre["genre_id"]}')";
                $conn->query($insertSeriesGenreQuery);
            }
        }

        header("Location: character.php?series_id=" . $seriesId);
        echo "<div class='d-flex justify-content-center' style='background-color: green; color:white; padding:10px;'>Series added successfully!</div>";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
