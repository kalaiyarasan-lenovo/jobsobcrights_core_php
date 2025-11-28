<?php
include("config/config_db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  // Ensure the ID is an integer to prevent SQL injection

    // Retrieve the job record from the `records` table before deleting
    $query = "SELECT * FROM records WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the record data
        $job = $result->fetch_assoc();

        // Insert the job into `archived_records` before deletion
        $archive_query = "INSERT INTO archived_records (name, vacancies, description, place_of_posting, type, age_limits, from_date, to_date, deleted_at) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $archive_stmt = $conn->prepare($archive_query);
        $archive_stmt->bind_param("sisssiss", 
            $job['name'], 
            $job['vacancies'], 
            $job['description'], 
            $job['place_of_posting'], 
            $job['type'], 
            $job['age_limits'], 
            $job['from_date'], 
            $job['to_date']
        );
        
        // Execute the insert into archive table
        if ($archive_stmt->execute()) {
            // If successfully archived, proceed to delete from the `records` table
            $delete_query = "DELETE FROM records WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                // Redirect back to the main page after successful deletion
                header("Location: demo1.php");
                exit();
            } else {
                echo "Error deleting record: " . $conn->error;
            }

            $delete_stmt->close();
        } else {
            echo "Error archiving record: " . $conn->error;
        }

        $archive_stmt->close();
    } else {
        echo "Record not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid ID.";
}
?>
