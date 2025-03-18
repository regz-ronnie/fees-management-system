<?php
// Include the database connection file
include 'php/dbconnect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $studentName = $_POST['student-name'];
    $studentId = $_POST['student-id'];
    $problemDescription = $_POST['problem-description'];

    // Check if any of the fields are empty
    if (empty($studentName) || empty($studentId) || empty($problemDescription)) {
        echo "All fields are required.";
    } else {
        // Prepare the SQL query with placeholders for binding
        $sql = "INSERT INTO problem_reports (student_name, student_id, problem_description)
                VALUES (?, ?, ?)";
        
        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sss", $studentName, $studentId, $problemDescription);
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "Problem report submitted successfully.";
            } else {
                echo "Error executing the query: " . $stmt->error;
            }
            
            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the query: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
}
?>
