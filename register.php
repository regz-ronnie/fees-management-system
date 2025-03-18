<?php
// session_start(); // Start the session to manage user authentication
ob_start(); // Start output buffering

include("php/dbconnect.php"); // Include the database connection

$error_message = ''; // Variable to hold error messages

// Process the login request when the form is submitted
if (isset($_POST['login'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']); // Get the student ID and sanitize input
    $password = $_POST['password']; // Password entered by the user

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM student WHERE studentId = ? LIMIT 1");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the student exists in the database
    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);

        // Verify the password entered by the user
        if (password_verify($password, $student['password'])) {
            // Store session variables for the logged-in user
            $_SESSION['student_id'] = $student['studentId'];
            $_SESSION['student_name'] = $student['sname'];
            $_SESSION['student_branch'] = $student['branch'];
            $_SESSION['student_email'] = $student['emailid'];

            // Redirect to the student dashboard or parent portal
            header("Location: student.php");
            exit(); // Stop further script execution after the redirection
        } else {
            // Invalid password
            $error_message = "Invalid password. Please try again.";
        }
    } else {
        // Student ID not found
        $error_message = "Student ID not found. Please try again.";
    }
}

ob_end_flush(); // Flush the output buffer and send output to the browser
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidii Secondary School - Student Login</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        label {
            font-size: 14px;
            color: #2c3e50;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Bidii Secondary School</h2>
        <form action="" method="post">
            <label for="student_id">Student ID</label>
            <input type="text" id="student_id" name="student_id" required placeholder="Enter your Student ID">
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your Password">
            
            <input type="submit" name="login" value="Login">
            
            <!-- Display error message if any -->
            <?php if ($error_message != ''): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
