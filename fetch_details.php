<?php
include("config/config_db.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM records WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "<p><strong>Job Title:</strong> " . $row['name'] . "</p>";
        echo "<p><strong>Vacancies:</strong> " . $row['vacancies'] . "</p>";
        echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
        echo "<p><strong>Place of Posting:</strong> " . $row['place_of_posting'] . "</p>";
        echo "<p><strong>Education Qualification:</strong> " . $row['education_qualification'] . "</p>";
        echo "<p><strong>Selection Process:</strong> " . $row['selection_process'] . "</p>";
        echo "<p><strong>Application Fee:</strong> " . $row['app_fee'] . "</p>";
        echo "<p><strong>Type:</strong> " . $row['type'] . "</p>";
        echo "<p><strong>Age Limits</strong> " . $row['age_limits'] . "</p>";
        echo "<p><strong>Start Age</strong> " . $row['start_age'] . "</p>";
        echo "<p><strong>End Age</strong> " . $row['end_age'] . "</p>";
        echo "<p><strong>From Date:</strong> " . $row['from_date'] . "</p>";
        echo "<p><strong>To Date:</strong> " . $row['to_date'] . "</p>";
        echo "<p><strong>Official Website:</strong> " . $row['official_website'] . "</p>";
        echo "<p><strong>How to Apply:</strong> " . $row['how_to_apply'] . "</p>";
    } else {
        echo "Error fetching details.";
    }
} else {
    echo "Invalid request.";
}
?>
