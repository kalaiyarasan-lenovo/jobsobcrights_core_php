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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .carousel-caption {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }
        h5 {
            font-size: 50px;
            font-family: 'Times New Roman', Times, serif;
        }
        /* Custom button styles */
        .btn-register {
            background-color: #A10606; /* Change to your desired color */
            border-color: #ff6600;     /* Change to your desired color */
        }
        .btn-joinus {
            background-color: #B5B0B0; /* Change to your desired color */
            border-color: #A10606;     /* Change to your desired color */
            border-radius: 20px;
        }
        .btn-register:hover {
            background-color: #cc5200; /* Change to your desired hover color */
            border-color: #cc5200;     /* Change to your desired hover color */
        }
        .btn-joinus:hover {
            background-color: #E69009; /* Change to your desired hover color */
            border-color: #0056b3;     /* Change to your desired hover color */
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
        
        <h3 class="navbar-center font-weight-bold">Job Portal</h3>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="blogs.php">Blogs</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="privateJobsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Jobs
                    </a>
                    <div class="dropdown-menu" aria-labelledby="privateJobsDropdown">
                        <a class="dropdown-item" href="#">Government Jobs</a>
                        <a class="dropdown-item" href="#">Bank Jobs</a>
                        <a class="dropdown-item" href="privatejob.php">Private Job</a>
                    </div>
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

<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/Job.jpg" class="d-block w-100" alt="Jobs">
    </div>
    <div class="carousel-item">
      <img src="images/Central.png" class="d-block w-100" alt="Jobs">
      <div class="carousel-caption d-none d-md-block">
        <h5>Government Jobs</h5>
        <p>"The future depends on what you do today."</p>
        <a href="https://obcrights.org/category/blog/jobs/government-jobs/" class="btn btn-primary btn-register"><b>READ MORE</b></a> <!-- Added custom class -->
        <a href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi" class="btn btn-primary btn-joinus"><b>JOIN US</b></a> <!-- Added custom class -->
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/Private.png" class="d-block w-100" alt="Central">
      <div class="carousel-caption d-none d-md-block">
        <h5>Bank Jobs</h5>
        <p>"The only way to do great work is to love what you do"</p>
        <a href="https://obcrights.org/category/blog/jobs/government-jobs/central/exams/banking/" class="btn btn-primary btn-register"><b>READ MORE</b></a> <!-- Added custom class -->
        <a href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi" class="btn btn-primary btn-joinus"><b>JOIN US</b></a> <!-- Added custom class -->
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/Bank.png" class="d-block w-100" alt="Bank">
      <div class="carousel-caption d-none d-md-block">
        <h5>Private Jobs</h5>
        <p>"Success is not in what you have, but who you are"</p>
        <a href="https://obcrights.org/job-portal/" class="btn btn-primary btn-register"><b>READ MORE</b></a> <!-- Added custom class -->
        <a href="https://chat.whatsapp.com/Dj6ZIz2VicOHKHaDyvbSxi" class="btn btn-primary btn-joinus"><b>JOIN US</b></a> <!-- Added custom class -->
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </button>
</div>

<section class="my-4">
    <div class="py-4">
        <div class="text-center">Contact Us</div>
    </div>
    <div class="w-50 m-auto">
        <form action="index.php" method="post">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Number:</label>
                <input type="text" name="number" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</section>
<section class="my-4">
    <div class="py-4">
        <div class="text-center">Contact Us</div>
    </div>
    <div class="container-fluid">
      <h3 class="text-center">obcrights presents</h3><br>
      <p class="text-center">Empowering Youth to Achieve their Constitutional Rights in Education, Scholarships, Entrance Exams, and Jobs</p>
    </div>
</section>
<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted">Copyright © 2024 [obcrights]</span><br>
        <span class="text-muted">Powered by jobs.obcrights</span>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
