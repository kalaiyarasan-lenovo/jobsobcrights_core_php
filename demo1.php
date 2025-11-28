<?php
session_start();
include("config/config_db.php");

$logged_in_as_admin = isset($_SESSION['login_user']) && $_SESSION['login_user'] == 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jobs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(function() {
        $("#from_date").datepicker();
        $("#to_date").datepicker();
        $('#jobsTable').DataTable();
    });

    function deleteRecord(id) {
        if (confirm('Are you sure you want to delete this record?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
    </script>
</head>
<body>
    <!-- Navbar with Logo -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="obclogo.jpg" width="100" height="70" class="d-inline-block align-top" alt="" loading="lazy">
        </a>
    </nav>

    <div class="container">
        <h3 class="text-center font-weight-bold my-4">Search Jobs</h3>
        <div class="row mt-4">
            <form class="form-horizontal w-100" action="demo1.php" method="POST">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4">
                        <label for="type">Job Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Select</option>
                            <option value="Central Govt Jobs">Central Govt Jobs</option>
                            <option value="State Govt Jobs">State Govt Jobs</option>
                            <option value="Bank Jobs">Bank Jobs</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Job Button (Admin Only) -->
        <div class="row mt-4">
            <div class="col-md-12">
                <?php if ($logged_in_as_admin) { ?>
                    <a href="add_jobs.php" class="btn btn-success btn-block">Add Job</a>
                <?php } else { ?>
                    <button class="btn btn-success btn-block" disabled>Add Job</button>
                <?php } ?>
            </div>
        </div>

        <div class="row mt-4">
            <table id="jobsTable" class="table table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Organization</th>
                        <th>Vacancies</th>
                        <th>Job Description</th>
                        <th>Location</th>
                        <th>Job Type</th>
                        <th>Age Limits</th>
                        <th>Last Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM records";
                $conditions = array();

                if (isset($_POST['submit'])) {
                    if (!empty($_POST['type'])) {
                        $conditions[] = "type='" . $conn->real_escape_string($_POST['type']) . "'";
                    }
                    if (!empty($_POST['age'])) {
                        $conditions[] = "age_limits='" . $conn->real_escape_string($_POST['age']) . "'";
                    }
                }

                if (count($conditions) > 0) {
                    $query .= " WHERE " . implode(' AND ', $conditions);
                }

                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['vacancies']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['place_of_posting']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age_limits']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['to_date']) . "</td>";
                        echo "<td>";
                        echo "<a href='job_details.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm'>View</a> ";
                        if ($logged_in_as_admin) {
                            echo "<a href='edit_jobs.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Edit</a> ";
                            echo "<button onclick='deleteRecord(" . htmlspecialchars($row['id']) . ")' class='btn btn-danger btn-sm'>Delete</button>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No jobs found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
