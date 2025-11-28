<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filter";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $number = $conn->real_escape_string($_POST['number']);

    $sql = "INSERT INTO contacts (name, email, number) VALUES ('$name', '$email', '$number')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .image-container {
            position: relative;
            text-align: center;
            color: white;
        }

        .image-container img {
            width: 100%;
            height: 85vh;
        }

        .centered-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
            font-weight: normal;
            font-family: 'Times New Roman', Times, serif;
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

        .nav-item {
            font-weight: bold;
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

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-img-center {
            justify-content: center;
            width: 300px;
            height: 230px;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card-img-center {
            background: none;
            border: none;
        }

        .image-item h6 {
            color: black;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<!-- Navbar with Logo -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="https://obcrights.org/">
        <img src="obclogo.jpg" width="80" height="50" class="d-inline-block align-top" alt="" loading="lazy">
    </a>
    <h3 class="navbar-center font-weight-bold">Job Portal</h3>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://obcrights.org/">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blogs.php">Blogs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="privatejobs.php">Private Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="save_contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link join-us-box" href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="image-container">
    <img src="images/Jobs.png" alt="Bank">
</div>

<div class="container px-4">
    <div class="row gx-5">
        <!-- First Row: Naukri and LinkedIn -->
        <div class="col">
            <div class="p-3 border bg-light">
                <img class="card-img-center" src="images/Naukri.png" alt="Naukri.com">
                <div class="card-body">
                    <h5 class="card-title">Naukri.com</h5>
                    <p class="card-text">Naukri is an India-based job portal used by both freshers and experienced candidates for applying to jobs.</p>
                    <ul>
                        <li>Naukri is available for candidates in web and mobile application form.</li>
                        <li>It's a free application.</li>
                    </ul>
                    <!-- <h5 class="card-title">How to utilize Naukri!!!</h5>
                    <ul>
                        <li>Make sure your profile is 100% complete and has a HIGH performance score before applying for jobs.</li>
                        <li>Add key skills as per industry requirements.</li>
                        <li>Weekly profile updates are recommended.</li>
                    </ul> -->
                    <div class="button-container">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 border bg-light">
                <img class="card-img-center" src="images/linkedin.jpeg" alt="LinkedIn">
                <div class="card-body">
                    <h5 class="card-title">LinkedIn</h5>
                    <p class="card-text">LinkedIn is a professional networking platform that also offers job listings. It allows you to create a professional profile and connect with recruiters and professionals in your field.</p>
                    <ul>
                        <li>Used by Entrepreneurs, Job seekers, Influencers, Companies, Freelancers, etc.</li>
                    </ul>
                    <!-- <div class="image-container text-center">
                        <div class="image-item">
                            <img class="card-img-center" src="images/connections.png" alt="Connections" style="width: 150px; height: auto; margin: 10px;">
                            <h6>Connections</h6>
                        </div>
                        <div class="image-item">
                            <img class="card-img-center" src="images/employments.png" alt="Employment" style="width: 150px; height: auto; margin: 10px;">
                            <h6>Employment</h6>
                        </div>
                        <div class="image-item">
                            <img class="card-img-center" src="images/skill developments.png" alt="Skill Development" style="width: 150px; height: auto; margin: 10px;">
                            <h6>Skill Development</h6>
                        </div>
                        <div class="image-item">
                            <img class="card-img-center" src="images/insight.png" alt="Insights" style="width: 150px; height: auto; margin: 10px;">
                            <h6>Insights</h6>
                        </div>
                    </div> -->
                    <div class="button-container text-center mt-3">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row gx-5">
        <!-- Second Row: Indeed, Glassdoor, and Monster -->
        <div class="col">
            <div class="p-3 border bg-light">
                <img class="card-img-center" src="images/indeed.png" alt="Indeed">
                <div class="card-body">
                    <h5 class="card-title">Indeed</h5>
                    <p class="card-text">Indeed is a global job search platform that allows job seekers to search for jobs, post resumes, and research companies.</p>
                    <div class="button-container">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 border bg-light">
                <img class="card-img-center" src="images/glassdoor.png" alt="Glassdoor">
                <div class="card-body">
                    <h5 class="card-title">Glassdoor</h5>
                    <p class="card-text">Glassdoor is a job search and review site that also provides company reviews, CEO approval ratings, salary reports, interview reviews, and more.</p>
                    <div class="button-container">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3 border bg-light">
                <img class="card-img-center" src="images/monster.png" alt="Monster">
                <div class="card-body">
                    <h5 class="card-title">Monster</h5>
                    <p class="card-text">Monster is a global online employment solution for people seeking jobs and the employers who need great people.</p>
                    <div class="button-container">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted">Copyright © 2024 [obcrights]</span><br>
        <span class="text-muted">Powered by jobs.obcrights</span>
    </div>
</footer>
</body>
</html>
