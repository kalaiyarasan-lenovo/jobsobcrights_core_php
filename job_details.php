<?php
include("config/config_db.php");

$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM records WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($row = $result->fetch_assoc()) {
    // Fetch job details
} else {
    echo "Job not found.";
    exit();
}

function formatText($text) {
    return nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Your CSS styles here */
        .btn-red {
            background-color:red;
            border-color:red;
            color: white;
        }
        .btn-red:hover {
            background-color:gold;
            border-color:red;
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

    </style>
</head>
<body>
<!-- Navbar with Logo -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="https://obcrights.org/">
            <img src="obclogo.jpg" width="80" height="50" class="d-inline-block align-top" alt="" loading="lazy">
        </a>
        
        <h3 class="navbar-center font-weight-bold">Jobs</h3>
        
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
    <h3 class="text-center font-weight-bold my-4">Job Details</h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th>Organization Name</th>
                    <td><?php echo formatText($row['name']); ?></td>
                </tr>
                <tr>
                    <th>Vacancies</th>
                    <td><?php echo formatText($row['vacancies']); ?></td>
                </tr>
                <tr>
                    <th>Job Description</th>
                    <td><?php echo formatText($row['description']); ?></td>
                </tr>
                <tr>
                    <th>Place of Posting</th>
                    <td><?php echo formatText($row['place_of_posting']); ?></td>
                </tr>
                <tr>
                    <th>Educational Qualification</th>
                    <td>
                        <ul>
                            <?php 
                            $qualifications = formatText($row['education_qualification']);
                            $qualificationsArray = preg_split('/\d+\.\s+/', $qualifications, -1, PREG_SPLIT_NO_EMPTY);
                            foreach ($qualificationsArray as $key => $qualification) {
                                echo '<li>' . formatText(($key + 1) . '. ' . $qualification) . '</li>';
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Selection Process</th>
                    <td>
                        <ul>
                            <?php 
                            $processes = formatText($row['selection_process']);
                            $processesArray = preg_split('/\d+\.\s+/', $processes, -1, PREG_SPLIT_NO_EMPTY);
                            foreach ($processesArray as $key => $process) {
                                echo '<li>' . formatText(($key + 1) . '. ' . $process) . '</li>';
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Application Fee</th>
                    <td>
                        <ul>
                            <?php 
                            $apps = formatText($row['app_fee']);
                            $appArray = preg_split('/\d+\.\s+/', $apps, -1, PREG_SPLIT_NO_EMPTY);
                            foreach ($appArray as $key => $app) {
                                echo '<li>' . formatText(($key + 1) . '. ' . $app) . '</li>';
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Job Type</th>
                    <td><?php echo formatText($row['type']); ?></td>
                </tr>
                <tr>
                    <th>Age Limits</th>
                    <td><?php echo formatText($row['age_limits']); ?></td>
                </tr>
                <tr>
                    <th>From Date</th>
                    <td><?php echo formatText($row['from_date']); ?></td>
                </tr>
                <tr>
                    <th>To Date</th>
                    <td><?php echo formatText($row['to_date']); ?></td>
                </tr>
                <tr>
                    <th>Official Website</th>
                    <td><a href="<?php echo formatText($row['official_website']); ?>" target="_blank"><?php echo formatText($row['official_website']); ?></a></td>
                </tr>
                <tr>
                    <th>How to Apply</th>
                    <td>
                        <ul>
                            <?php 
                            $applys = formatText($row['how_to_apply']);
                            $applyArray = preg_split('/\d+\.\s+/', $applys, -1, PREG_SPLIT_NO_EMPTY);
                            foreach ($applyArray as $key => $apply) {
                                echo '<li>' . formatText(($key + 1) . '. ' . $apply) . '</li>';
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
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
