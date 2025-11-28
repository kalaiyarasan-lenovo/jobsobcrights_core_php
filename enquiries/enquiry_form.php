<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "daily_enquiries";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use isset() to handle undefined index issues and sanitize inputs
    $location = isset($_POST['location']) ? htmlspecialchars($_POST['location'], ENT_QUOTES) : '';
    $request_id = isset($_POST['request_id']) ? htmlspecialchars($_POST['request_id'], ENT_QUOTES) : '';
    $date = isset($_POST['request_date']) ? htmlspecialchars($_POST['request_date'], ENT_QUOTES) : '';
    $time = isset($_POST['request_time']) ? htmlspecialchars($_POST['request_time'], ENT_QUOTES) : '';
    $beneficiary_name = isset($_POST['beneficiary_name']) ? htmlspecialchars($_POST['beneficiary_name'], ENT_QUOTES) : '';
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address'], ENT_QUOTES) : '';
    $phone_no = isset($_POST['phone_no']) ? htmlspecialchars($_POST['phone_no'], ENT_QUOTES) : '';
    $department = isset($_POST['department']) ? htmlspecialchars($_POST['department'], ENT_QUOTES) : '';
    $issue_description = isset($_POST['issue_description']) ? htmlspecialchars($_POST['issue_description'], ENT_QUOTES) : '';
    $assisted_by = isset($_POST['assisted_by']) ? htmlspecialchars($_POST['assisted_by'], ENT_QUOTES) : '';
    $start_time = isset($_POST['start_time']) ? htmlspecialchars($_POST['start_time'], ENT_QUOTES) : '';
    $end_time = isset($_POST['end_time']) ? htmlspecialchars($_POST['end_time'], ENT_QUOTES) : '';
    $status = isset($_POST['status']) ? htmlspecialchars($_POST['status'], ENT_QUOTES) : '';
    $external_help_details = isset($_POST['external_help_details']) ? htmlspecialchars($_POST['external_help_details'], ENT_QUOTES) : '';
    $disposal_details = isset($_POST['disposal_details']) ? htmlspecialchars($_POST['disposal_details'], ENT_QUOTES) : '';
    $feedback = isset($_POST['feedback']) ? htmlspecialchars($_POST['feedback'], ENT_QUOTES) : '';

    // Insert data into the database
    $sql = "INSERT INTO for_ppl_centre
            (location, request_id, date, time, beneficiary_name, address, phone_no, department, issue_description, 
             assisted_by, start_time, end_time, status, external_help_details, disposal_details, feedback) 
            VALUES 
            ('$location', '$request_id', '$date', '$time', '$beneficiary_name', '$address', '$phone_no', '$department', 
             '$issue_description', '$assisted_by', '$start_time', '$end_time', '$status', '$external_help_details', 
             '$disposal_details', '$feedback')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='feedback'>Record submitted successfully!</div>";
    } else {
        echo "<div class='feedback'>Error: " . $conn->error . "</div>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary Assistance Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], 
        input[type="date"], 
        input[type="time"], 
        textarea, 
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .feedback {
            text-align: center;
            color: green;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Create Daily Enquiries</h1>
        <form method="POST" action="">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="request_id">Request ID:</label>
            <input type="text" id="request_id" name="request_id" required>

            <label for="request_date">Date:</label>
            <input type="date" id="request_date" name="request_date" required>

            <label for="request_time">Time:</label>
            <input type="time" id="request_time" name="request_time" required>

            <label for="beneficiary_name">Beneficiary Name:</label>
            <input type="text" id="beneficiary_name" name="beneficiary_name" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="phone_no">Phone Number:</label>
            <input type="text" id="phone_no" name="phone_no">

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <label for="issue_description">Issue Description:</label>
            <textarea id="issue_description" name="issue_description" required></textarea>

            <label for="assisted_by">Assisted By:</label>
            <input type="text" id="assisted_by" name="assisted_by">

            <label for="start_time">Start Time:</label>
            <input type="time" id="start_time" name="start_time">

            <label for="end_time">End Time:</label>
            <input type="time" id="end_time" name="end_time">

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="In Progress">In Progress</option>
            </select>

            <label for="external_help_details">External Help Details:</label>
            <textarea id="external_help_details" name="external_help_details"></textarea>

            <label for="disposal_details">Disposal Details:</label>
            <textarea id="disposal_details" name="disposal_details"></textarea>

            <label for="feedback">Feedback:</label>
            <textarea id="feedback" name="feedback"></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
