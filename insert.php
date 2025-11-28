<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("config/config_db.php");

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $vacancies = $_POST['vacancies'];
    $description = $_POST['description'];
    $place_of_posting = $_POST['place_of_posting'];
    $education_qualification = $_POST['education_qualification'];
    $selection_process = $_POST['selection_process'];
    $app_fee = $_POST['app_fee'];
    $type = $_POST['type'];
    $age_limits = $_POST['age_limits'];
    $start_age = $_POST['start_age'];
    $end_age = $_POST['end_age'];
    $from_date = date("Y-m-d", strtotime($_POST['from_date']));
    $to_date = date("Y-m-d", strtotime($_POST['to_date']));
    $official_website = $_POST['official_website'];
    $how_to_apply = $_POST['how_to_apply'];

    $query = "INSERT INTO records (name, vacancies, description, place_of_posting, education_qualification, selection_process, app_fee, type, age_limits, start_age, end_age, from_date, to_date, official_website, how_to_apply)
              VALUES ('$name', '$vacancies', '$description', '$place_of_posting', '$education_qualification', '$selection_process', '$app_fee', '$type', '$age_limits', '$start_age', '$end_age', '$from_date', '$to_date', '$official_website', '$how_to_apply')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
