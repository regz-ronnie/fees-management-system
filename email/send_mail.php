<?php
// Collecting the POST data
$email = $_POST['email'];    // This can be used as the sender's email if needed
$message = $_POST['message'];  // The message you want to send

// Include the necessary PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer classes
require 'includes/PHPMailer.php';
require 'includes/Exception.php';
require 'includes/SMTP.php';

$mail = new PHPMailer(true);

// Check if both fields are not empty
if (!empty($message)) {
    try {
        // Set up the SMTP server
        $mail->isSMTP();                                             // Use SMTP
        $mail->Host       = 'smtp.gmail.com';                         // Gmail SMTP server
        $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
        $mail->Username   = 'sheilahvisela@gmail.com';                // Your Gmail username
        $mail->Password   = 'pddc lthb hyxw zwmc';                    // Your Gmail password (ensure it's correct)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;              // Use SMTP over SSL/TLS
        $mail->Port       = 465;                                      // Use port 465 for SSL

        // Recipients - fetch all users from the database and send the email to each
        $mail->setFrom('sheilahvisela@gmail.com', 'Secure Streets');  // Set the 'from' address
        $mail->Subject = 'Message from Secure Streets';               // Subject of the email
        $mail->Body    = nl2br(htmlspecialchars($message));           // Sanitize message to avoid XSS
        $mail->AltBody = strip_tags($message);                        // Plain text for non-HTML clients

        // Database connection
        $servername = "localhost";  // Your database server
        $username = "root";         // Your database username
        $password = "";             // Your database password
        $dbname = "paysystem";  // Your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get all user emails from the database
        $sql = "SELECT email FROM userss";  // Assuming there's a 'users' table with an 'email' column
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            // Loop through each user and send the email
            while ($row = $result->fetch_assoc()) {
                $mail->addAddress($row['email']);  // Add user email to the recipient list
            }

            // Send the email to all users
            $mail->send();
            echo 'Message has been sent to all users.';
        } else {
            echo 'No users found in the system.';
        }

        // Close the connection
        $conn->close();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Please fill in the message field.";
}
?>
