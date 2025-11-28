<?php
session_start();
include("config/config_db.php");

// Fetch government jobs (both central and state) from the database
$query = "SELECT * FROM records WHERE type IN ('Central Govt Jobs', 'State Govt Jobs')";
$result = $conn->query($query);

// Fetch total vacancies for Central Govt Jobs
$centralVacanciesQuery = "SELECT SUM(vacancies) AS total_central_vacancies FROM records WHERE type = 'Central Govt Jobs'";
$centralVacanciesResult = $conn->query($centralVacanciesQuery);
$centralVacanciesRow = $centralVacanciesResult->fetch_assoc();
$totalCentralVacancies = $centralVacanciesRow['total_central_vacancies'] ?? 0;

// Fetch total vacancies for State Govt Jobs
$stateVacanciesQuery = "SELECT SUM(vacancies) AS total_state_vacancies FROM records WHERE type = 'State Govt Jobs'";
$stateVacanciesResult = $conn->query($stateVacanciesQuery);
$stateVacanciesRow = $stateVacanciesResult->fetch_assoc();
$totalStateVacancies = $stateVacanciesRow['total_state_vacancies'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Government Jobs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .btn-red {
            background-color: red;
            border-color: red;
            color: white;
        }
        .btn-red:hover {
            background-color: gold;
            border-color: red;
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
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 40px;
            font-family: monospace;
            color: azure;
        }
        .nav-item {
            font-weight: bold;
        }
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }
        .btn-light-gray {
            background-color: lightgray;
            border-color: gray;
            color: black;
        }
        .btn-light-gray:hover {
            background-color: darkgray;
            border-color: darkgray;
        }
        .join-us-box i {
            margin-left: 5px;
            font-size: 40px;
            font-weight: bolder;
            color: #25D366;
        }
        .join-us-box i:hover {
            color: white;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function() {
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="https://obcrights.org/">
            <img src="obclogo.jpg" width="80" height="50" class="d-inline-block align-top" alt="" loading="lazy">
        </a>
        <h3 class="navbar-center font-weight-bold">Government Jobs</h3>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="about" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="https://obcrights.org/about-sfrbc/">Story</a>
                        <a class="dropdown-item" href="https://obcrights.org/vision/">Vision</a>
                        <a class="dropdown-item" href="https://obcrights.org/our-team/">Team</a>
                        <a class="dropdown-item" href="https://obcrights.org/what-we-do/">What We Do</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="blogs.php">Blogs</a></li>
                <li class="nav-item"><a class="nav-link" href="privatejobportal.php">Private Job Portals</a></li>
                <li class="nav-item"><a class="nav-link" href="save_contact.php">Contact</a></li>
                <li class="nav-item">
                    <a class="nav-link join-us-box" href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Display Total Vacancies -->
    <div class="container">
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 text-center">
                <a href="central_gov_jobs.php" class="btn btn-light-gray btn-block">
                    <b>Total Central Govt Vacancies: <span><?php echo htmlspecialchars($totalCentralVacancies); ?></span></b>
                </a>
            </div>
            <div class="col-md-4 text-center">
                <a href="state_jobs.php" class="btn btn-light-gray btn-block">
                    <b>Total State Govt Vacancies: <span><?php echo htmlspecialchars($totalStateVacancies); ?></span></b>
                </a>
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
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['vacancies']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['place_of_posting']) ?></td>
                            <td><?= htmlspecialchars($row['type']) ?></td>
                            <td><?= htmlspecialchars($row['age_limits']) ?></td>
                            <td><?= htmlspecialchars($row['to_date']) ?></td>
                            <td><a href="job_details.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-red btn-sm">View</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
