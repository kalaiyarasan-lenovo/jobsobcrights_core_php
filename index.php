<?php
session_start();
include("config/config_db.php");


// Check if user is admin
$logged_in_as_admin = isset($_SESSION['login_user']) && $_SESSION['login_user'] == 'admin';


// Fetch total number of vacancies
$totalVacanciesQuery = "SELECT SUM(vacancies) AS total_vacancies FROM records";
$totalVacanciesResult = $conn->query($totalVacanciesQuery);
$totalVacanciesRow = $totalVacanciesResult->fetch_assoc();
$totalVacancies = $totalVacanciesRow['total_vacancies'];


// Handle filtering
$query = "SELECT * FROM records";
$conditions = array();


if (isset($_POST['submit'])) {
    if (!empty($_POST['type'])) {
        $type = $conn->real_escape_string($_POST['type']);
        $conditions[] = "type = '$type'";
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

        .highlight {
            background-color: yellow;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .blink {
            animation: blink 1s infinite;
        }

        .btn-yellow {
            background-color: lightgray;
            border-color: black;
            color: black;
            font-weight: bold;
        }

        .btn-yellow:hover {
            background-color: darkgray;
            border-color: darkorange;
        }

        .btn-total-vacancies {
            background-color: white;
            color: red;
        }

        .btn-total-vacancies:hover {
            background-color: white;
            color: black;
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
            white-space: nowrap;
        }

        @media (max-width: 991px) {
            .navbar-center {
                position: static;
                transform: none;
                left: auto;
                font-size: 24px;
                flex-grow: 1;
                text-align: center;
                margin: 0;
            }
        }

        .mobile-subscribe-container {
            display: none;
        }

        @media (max-width: 991px) {
            .mobile-subscribe-container {
                display: block;
                margin-top: 15px;
                text-align: center;
            }
        }

        .navbar-nav {
            margin-left: auto;
        }

        .nav-item {
            font-weight: bold;
        }

        .join-us-box i {
            margin-left: 5px;
            font-size: 40px;
            font-weight: bolder;
            color: #25D366;
            /* WhatsApp green color */
        }

        .join-us-box i:hover {
            margin-left: 5px;
            font-size: 40px;
            font-weight: bolder;
            color: white;
            /* WhatsApp green color */
        }

        .nav-item.dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            list-style: none;
            padding: 0;
            margin: 0;
            min-width: 200px;
            z-index: 1000;
        }

        .dropdown-item {
            padding: 10px 20px;
            text-decoration: none;
            color: #000;
            display: block;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        /* --- SIDE POPUP STYLES --- */
        .side-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 320px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 2000; /* High z-index to stay on top */
            display: none;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.1);
            transition: all 0.4s ease;
        }

        .side-popup-header {
            background-color: red;
            color: white;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .side-popup-header h5 {
            font-size: 14px;
            margin: 0;
            font-weight: 600;
        }

        .side-popup-header .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            line-height: 1;
            padding: 0;
        }

        .side-popup-body {
            padding: 15px;
            font-size: 13px;
            color: #333;
            text-align: left;
        }

        .side-popup-body p {
            margin-bottom: 8px;
        }

        .side-popup-footer {
            padding: 0 15px 15px;
        }

        .side-popup .btn-red {
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            padding: 8px;
        }

        @media (max-width: 576px) {
            .side-popup {
                width: 260px; /* Smaller width for mobile */
                top: 15px;
                right: 15px;
                border-radius: 10px;
            }
            .side-popup-header h5 {
                font-size: 13px;
            }
            .side-popup-body {
                font-size: 12px;
                padding: 12px;
            }
            .side-popup-footer {
                padding: 0 12px 12px;
            }
        }
        /* -------------------------- */

    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function () {
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="https://obcrights.org/">
            <img src="obclogo.jpg" width="80" height="50" class="d-inline-block align-top" alt="" loading="lazy">
        </a>

        <!-- Blinking Subscribe button (Desktop only) -->
        <a href="subscribe.php" class="btn btn-danger blink ml-2 d-none d-lg-inline-block" style="font-weight:bold;">
            Subscribe
        </a>

        <h3 class="navbar-center font-weight-bold">Jobs</h3>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="about" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
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
                    <a class="nav-link" href="https://jobs.obcrights.org/Blogs/">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="privatejobportal.php">Private Job Portals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="save_contact.php">Contact <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link join-us-box" href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi"
                        target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </li>

            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Mobile Subscribe Button -->
        <div class="mobile-subscribe-container">
            <a href="subscribe.php" class="btn btn-danger blink" style="font-weight:bold; padding: 10px 30px; border-radius: 8px;">
                 Subscribe
            </a>
        </div>
        <!-- Display Total Vacancies -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 text-center">
                <h5 class="btn btn-total-vacancies btn-block"><b>Total Vacancies:
                        <span><?php echo htmlspecialchars($totalVacancies); ?></span></b></h5>
            </div>
        </div>
        <div class="row mt-4">
            <form class="form-horizontal w-100" action="jobs.php" method="POST">
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

        <!-- Job Category Buttons -->
        <div class="row mt-3">
            <div class="col-md-4 text-center">
                <a href="government_jobs.php" class="btn btn-yellow btn-block">Government Jobs</a>
            </div>
            <div class="col-md-4 text-center">
                <a href="bank_jobs.php" class="btn btn-yellow btn-block">Bank Jobs</a>
            </div>
            <div class="col-md-4 text-center">
                <a href="private_jobs.php" class="btn btn-yellow btn-block">Private Jobs</a>
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
                        <th>To</th>
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
                        echo "<tr><td colspan='9' class='text-center'>No jobs found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">Copyright © 2026 [obcrights]</span><br>
            <span class="text-muted">Powered by jobs.obcrights</span>
        </div>
    </footer>

    <!-- Welcome Side Popup -->
    <div id="sidePopup" class="side-popup">
        <div class="side-popup-header">
            <h5><i class="fas fa-handshake"></i> Welcome to OBC Rights!</h5>
            <button type="button" class="close-btn" onclick="closeSidePopup()">&times;</button>
        </div>
        <div class="side-popup-body">
            <p>Empowering OBC youth to achieve their constitutional rights in <strong>Education, Scholarships, Entrance Exams, and Jobs</strong>.</p>
            <p>Join our mission: <br>
               <a href="https://obcrights.org/about-sfrbc/" target="_blank" style="color: red;">Learn More</a> | 
               <a href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi" target="_blank"><i class="fab fa-whatsapp text-success"></i> WhatsApp</a></p>
        </div>
        <div class="side-popup-footer">
            <a href="https://obcrights.org/" class="btn btn-red btn-block">
                <i class="fas fa-external-link-alt"></i> Visit Website
            </a>
        </div>
    </div>

    <!-- Auto-show side popup script with 5-second delay -->
    <script>
    $(document).ready(function() {
        if (!sessionStorage.getItem('sidePopupShown')) {
            // Delay 5000ms (5 seconds) before showing
            setTimeout(function() {
                $('#sidePopup').fadeIn();
                sessionStorage.setItem('sidePopupShown', 'true');
            }, 5000);
        }
        $('#jobsTable').DataTable();
    });

    function closeSidePopup() {
        $('#sidePopup').fadeOut();
    }
    </script>

</body>

</html>
