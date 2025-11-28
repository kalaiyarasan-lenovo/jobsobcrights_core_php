<?php
session_start();
include("config/config_db.php");

$logged_in_as_admin = isset($_SESSION['login_user']) && $_SESSION['login_user'] == 'admin';

// Fetch total number of vacancies
$totalVacanciesQuery = "SELECT SUM(vacancies) AS total_vacancies FROM records";
$totalVacanciesResult = $conn->query($totalVacanciesQuery);
$totalVacanciesRow = $totalVacanciesResult->fetch_assoc();
$totalVacancies = $totalVacanciesRow['total_vacancies'];
?>
<div class="row mt-4 justify-content-center">
    <div class="col-md-4 text-center">
        <h5 class="btn btn-red btn-block"><b>Total Vacancies: <span class="blink"><?php echo htmlspecialchars($totalVacancies); ?></span></b></h5>
    </div>
</div>