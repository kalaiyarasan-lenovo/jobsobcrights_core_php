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
    <style>
        .btn-red {
            background-color: red;
            border-color: red;
            color: white;
        }
        .btn-red:hover {
            background-color: darkred;
            border-color: darkred;
        }
        .vacancies-box {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            border-radius: 0.25rem;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .vacancies-container {
            text-align: center;
            margin-top: 20px;
        }
        .banner {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .intro-content {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .highlight {
            background-color: yellow;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }
        .blink {
            animation: blink 1s infinite;
        }
        .btn-yellow {
            background-color: orange;
            border-color: goldenrod;
            color: black;
        }
        .btn-yellow:hover {
            background-color: darkorange;
            border-color: darkorange;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            margin-right: 10px;
        }
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 40px;
            font-family: monospace;
            color: azure;
            font-style: normal;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .nav-item{
            font-weight: bold;
        }
        .join-us-box {
            display: flex;
            align-items: center;
            border: 2px yellow;
            padding: 5px 10px;
            border-radius: 5px;
            background-color:red;
            color: red;
        }
        .join-us-box:hover {
            background-color:gold;
        }
        .join-us-box i {
            margin-left: 5px;
            color: #25D366; /* WhatsApp green color */
        }
    </style>
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
    <!-- Header with Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="obclogo.jpg" width="100" height="70" class="d-inline-block align-top" alt="" loading="lazy">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="search_jobs.php">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3 class="text-center font-weight-bold my-4">Search Jobs</h3>
        <div class="row mt-4">
            <form class="form-horizontal w-100" action="search_jobs.php" method="POST">
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
                        <button type="submit" name="submit" class="btn btn-red btn-block">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <?php
        $query = "SELECT * FROM records";
        $conditions = array();

        if (isset($_POST['submit'])) {
            if (!empty($_POST['type'])) {
                $conditions[] = "type='" . $conn->real_escape_string($_POST['type']) . "'";
            }
            if (!empty($_POST['age'])) {
                $age = intval($_POST['age']);
                $conditions[] = "$age BETWEEN start_age AND end_age";
            }
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $result = $conn->query($query);
        $total_vacancies = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total_vacancies += intval($row['vacancies']);
            }
        }
        ?>

        <div class="vacancies-container">
            <div class="vacancies-box">
                Total Vacancies: <?php echo $total_vacancies; ?>
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
                        <th>Job Type</th>
                        <th>Age Limits</th>
                        <th>To</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Re-execute the query to fetch the records for display
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['vacancies']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age_limits']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['to_date']) . "</td>";
                        echo "<td>";
                        echo "<a href='job_details.php?id=" . htmlspecialchars($row['id']) . "&org=" . htmlspecialchars($row['name']) . "' class='btn btn-red btn-sm'>View</a>";
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

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">© 2024 Jobs Portal. All rights reserved.</span>
        </div>
    </footer>
</body>
</html>
