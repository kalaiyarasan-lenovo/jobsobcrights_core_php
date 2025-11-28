<?php
include("config/config_db.php");

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Basic email validation
    if (empty($email)) {
        $error_message = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } elseif (strlen($email) > 100) {
        $error_message = "Email must be 100 characters or less.";
    } elseif (!preg_match('/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/', $email)) {
        // extra regex check (optional, little stricter than FILTER_VALIDATE_EMAIL)
        $error_message = "Please enter a properly formatted email address.";
    } else {
        // Check if email already exists
        $check_query = "SELECT id FROM subscribers_table WHERE email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "This email is already subscribed.";
        } else {
            // Insert new subscriber
            $insert_query = "INSERT INTO subscribers_table (email) VALUES (?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $success_message = "Thank you for subscribing! You will receive job updates.";
            } else {
                $error_message = "Error subscribing. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscribe - Job Updates</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .subscribe-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .subscribe-btn {
            background-color: #dc3545;
            border-color: #dc3545;
            font-weight: bold;
        }

        .subscribe-btn:hover {
            background-color: #ffd700;
            border-color: #dc3545;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="subscribe-container">
            <h2 class="text-center mb-4">Subscribe for Job Updates</h2>
            <p class="text-center text-muted mb-4">Get latest job notifications directly in your inbox!</p>

            <!-- Success Message -->
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                    <?php echo $success_message; ?>
                    <a href="home.php" class="btn btn-primary mt-3">Back to Home</a>
                </div>
            <?php else: ?>
                <!-- Error Message -->
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Subscription Form -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email"><strong>Your Email Address</strong></label>
                        <input type="email" class="form-control form-control-lg" name="email" id="email"
                            placeholder="example@email.com"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        <small class="form-text text-muted">We will send you job updates only. No spam!</small>
                    </div>
                    <button type="submit" class="btn btn-red subscribe-btn btn-block btn-lg">
                        <i class="fas fa-bell mr-2"></i>Subscribe Now
                    </button>
                </form>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="home.php" class="btn btn-outline-secondary">← Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>

</html>