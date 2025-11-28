<?php
session_start();
include("config/config_db.php");

// Check if the user is logged in as admin
if (!isset($_SESSION['login_user']) || $_SESSION['login_user'] != 'admin') {
    header("location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $vacancies = $_POST['vacancies'];
    $description = $_POST['description'];
    $place_of_posting = $_POST['place_of_posting'];
    $education_qualification = nl2br($_POST['education_qualification']);
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
        header("Location: demo1.php");
    } else {
        echo "Error: " . $query . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Job</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script>
    $(function() {
        $("#from_date").datepicker();
        $("#to_date").datepicker();
    });
    </script>
</head>
<body>
    <div class="container">
        <h3 class="text-center font-weight-bold my-4">Add New Job</h3>
        <form class="form-horizontal w-100" action="add_jobs.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Organization Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="vacancies">Vacancies</label>
                    <input type="number" name="vacancies" id="vacancies" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="description">Job Description</label>
                    <textarea name="description" id="description" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="place_of_posting">Place of Posting</label>
                    <textarea name="place_of_posting" id="place_of_posting" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="education_qualification">Educational Qualification</label>
                    <textarea name="education_qualification" id="education_qualification" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="selection_process">Selection Process</label>
                    <textarea name="selection_process" id="selection_process" class="form-control" required></textarea>
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="app_fee">Application Fee</label>
                    <textarea name="app_fee" id="app_fee" class="form-control" required></textarea>
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="type">Job Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="">Select</option>
                        <option value="Central Govt Jobs">Central Govt Jobs</option>
                        <option value="State Govt Jobs">State Govt Jobs</option>
                        <option value="Bank Jobs">Bank Jobs</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="age_limits">Age Limits</label>
                    <input type="text" name="age_limits" id="age_limits" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="start_age">Start Age</label>
                    <input type="number" name="start_age" id="start_age" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="end_age">End Age</label>
                    <input type="number" name="end_age" id="end_age" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="from_date">From Date</label>
                    <input type="text" name="from_date" id="from_date" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="to_date">To Date</label>
                    <input type="text" name="to_date" id="to_date" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="official_website">Official Website</label>
                    <input type="url" name="official_website" id="official_website" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="how_to_apply">How to Apply</label>
                    <textarea name="how_to_apply" id="how_to_apply" class="form-control" required></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3 offset-md-9">
                    <button type="submit" name="insert" class="btn btn-primary btn-block">Add Job</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
