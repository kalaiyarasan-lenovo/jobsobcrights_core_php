<?php
session_start();
include("config/config_db.php");

// Fetch total number of vacancies
$totalVacanciesQuery = "SELECT SUM(vacancies) AS total_vacancies FROM records";
$totalVacanciesResult = $conn->query($totalVacanciesQuery);
$totalVacanciesRow = $totalVacanciesResult->fetch_assoc();
$totalVacancies = $totalVacanciesRow['total_vacancies'];

// Return the total vacancies as JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");
echo json_encode(array('total_vacancies' => $totalVacancies));
?>
