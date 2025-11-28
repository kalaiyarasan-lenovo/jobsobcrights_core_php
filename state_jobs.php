<?php
session_start();
include("config/config_db.php");

// Fetch central government jobs from the database
$query = "SELECT * FROM records WHERE type = 'State Govt Jobs'";
$result = $conn->query($query);

// Calculate total vacancies for Central Govt Jobs
$totalVacanciesQuery = "SELECT SUM(vacancies) AS total_vacancies FROM records WHERE type = 'State Govt Jobs'";
$totalVacanciesResult = $conn->query($totalVacanciesQuery);
$totalVacanciesRow = $totalVacanciesResult->fetch_assoc();
$totalVacancies = $totalVacanciesRow['total_vacancies'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>State Government Jobs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .btn-red {
            background-color:red;
            border-color:red;
            color: white;
        }
        .btn-red:hover {
            background-color:gold;
            border-color:red;
        }
        .btn-light-gray {
            background-color: lightgray;
            color: black;
            font-weight: bold;
        }
        .btn-light-gray:hover {
            background-color: gray;
            color: white;
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
        .nav-item {
            font-weight: bold;
        }
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }
        .join-us-box i {
            margin-left: 5px;
            font-size: 40px;
            font-weight:bolder;
            color: #25D366; /* WhatsApp green color */
        }
        .join-us-box i:hover {
            margin-left: 5px;
            font-size: 40px;
            font-weight:bolder;
            color: white; /* WhatsApp green color */
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
        
        <h3 class="navbar-center font-weight-bold">State Jobs</h3>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="about" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        About
                    </a>
                    <div class="dropdown-menu" aria-labelledby="about">
                        <a class="dropdown-item" href="https://obcrights.org/about-sfrbc/">Story</a>
                        <a class="dropdown-item" href="https://obcrights.org/vision/">Vision</a>
                        <a class="dropdown-item" href="https://obcrights.org/our-team/">Team</a>
                        <a class="dropdown-item" href="https://obcrights.org/what-we-do/">What We Do</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="blogs.php">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="privatejobportal.php">Private Job Portals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="save_contact.php">Contact <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link join-us-box" href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </li>

            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Display Total Vacancies -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 text-center">
                <h5 class="btn btn-light-gray btn-block"><b>Total Vacancies: <?php echo htmlspecialchars($totalVacancies); ?></b></h5>
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
                        echo "<a href='job_details.php?id=" . htmlspecialchars($row['id']) . "&org=" . htmlspecialchars($row['name']) . "' class='btn btn-red btn-sm'>View</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No state government jobs found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">Copyright © 2024 [obcrights]</span><br>
            <span class="text-muted">Powered by jobs.obcrights</span>
        </div>
    </footer>
</body>
</html>
