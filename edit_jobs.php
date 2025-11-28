<?php
session_start();
include("config/config_db.php");

if (!isset($_SESSION['login_user']) || $_SESSION['login_user'] != 'admin') {
    header("Location: index.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = $conn->prepare("SELECT * FROM records WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($row = $result->fetch_assoc()) {
    // Job details fetched successfully
} else {
    echo "Job not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $vacancies = $conn->real_escape_string($_POST['vacancies']);
    $description = $conn->real_escape_string($_POST['description']);
    $place_of_posting = $conn->real_escape_string($_POST['place_of_posting']);
    $education_qualification = $conn->real_escape_string($_POST['education_qualification']);
    $selection_process = $conn->real_escape_string($_POST['selection_process']);
    $app_fee = $conn->real_escape_string($_POST['app_fee']);
    $type = $conn->real_escape_string($_POST['type']);
    $age_limits = $conn->real_escape_string($_POST['age_limits']);
    $start_age = $conn->real_escape_string($_POST['start_age']);
    $end_age = $conn->real_escape_string($_POST['end_age']);
    $from_date = $conn->real_escape_string($_POST['from_date']);
    $to_date = $conn->real_escape_string($_POST['to_date']);
    $official_website = $conn->real_escape_string($_POST['official_website']);
    $how_to_apply = $conn->real_escape_string($_POST['how_to_apply']);

    $updateQuery = $conn->prepare("UPDATE records SET name=?, vacancies=?, description=?, place_of_posting=?, education_qualification=?, selection_process=?, app_fee=?, type=?, age_limits=?, start_age=?, end_age=?, from_date=?, to_date=?, official_website=?, how_to_apply=? WHERE id=?");
    $updateQuery->bind_param("sisssssssssssssi", $name, $vacancies, $description, $place_of_posting, $education_qualification, $selection_process, $app_fee, $type, $age_limits, $start_age, $end_age, $from_date, $to_date, $official_website, $how_to_apply, $id);

    if ($updateQuery->execute()) {
        header("Location: demo1.php");
        exit();
    } else {
        echo "Error: " . $updateQuery->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Job</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h3 class="text-center font-weight-bold my-4">Edit Job</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="edit_jobs.php?id=<?php echo $id; ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Organization Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vacancies">Vacancies</label>
                        <input type="number" name="vacancies" id="vacancies" class="form-control" value="<?php echo htmlspecialchars($row['vacancies']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Job Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="place_of_posting">Place of Posting</label>
                        <textarea name="place_of_posting" id="place_of_posting" class="form-control" rows="5" required><?php echo htmlspecialchars($row['place_of_posting']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="education_qualification">Educational Qualification</label>
                        <textarea name="education_qualification" id="education_qualification" class="form-control" rows="5" required><?php echo htmlspecialchars($row['education_qualification']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="selection_process">Selection Process</label>
                        <textarea name="selection_process" id="selection_process" class="form-control" rows="6" required><?php echo htmlspecialchars($row['selection_process']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="app_fee">Application Fee</label>
                        <textarea name="app_fee" id="app_fee" class="form-control" rows="7" required><?php echo htmlspecialchars($row['app_fee']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="type">Job Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="Central Govt Jobs" <?php if ($row['type'] == 'Central Govt Jobs') echo 'selected'; ?>>Central Govt Jobs</option>
                            <option value="State Govt Jobs" <?php if ($row['type'] == 'State Govt Jobs') echo 'selected'; ?>>State Govt Jobs</option>
                            <option value="Bank Jobs" <?php if ($row['type'] == 'Bank Jobs') echo 'selected'; ?>>Bank Jobs</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="age_limits">Age Limits</label>
                        <input type="text" name="age_limits" id="age_limits" class="form-control" value="<?php echo htmlspecialchars($row['age_limits']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="start_age">Start Age</label>
                        <input type="number" name="start_age" id="start_age" class="form-control" value="<?php echo htmlspecialchars($row['start_age']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_age">End Age</label>
                        <input type="number" name="end_age" id="end_age" class="form-control" value="<?php echo htmlspecialchars($row['end_age']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="from_date">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo htmlspecialchars($row['from_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="to_date">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo htmlspecialchars($row['to_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="official_website">Official Website</label>
                        <input type="url" name="official_website" id="official_website" class="form-control" value="<?php echo htmlspecialchars($row['official_website']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="how_to_apply">How to Apply</label>
                        <textarea name="how_to_apply" id="how_to_apply" class="form-control" rows="5" required><?php echo htmlspecialchars($row['how_to_apply']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update Job</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
