<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "paysystem";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    if (empty($message)) {
        echo "Message cannot be empty.";
        exit;
    }

    // Insert the email log with status "Pending"
    $stmt = $conn->prepare("INSERT INTO email_logs (recipient_email, message, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param("ss", $email, $message);

    if ($stmt->execute()) {
        // Simulate sending email (replace with actual mail function in production)
        $mail_status = mail($email, "Notification", $message) ? 'Sent' : 'Failed';

        // Update the status in the database
        $update_stmt = $conn->prepare("UPDATE email_logs SET status = ? WHERE id = ?");
        $update_stmt->bind_param("si", $mail_status, $stmt->insert_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo $mail_status === 'Sent' ? "Email sent successfully." : "Failed to send email.";
    } else {
        echo "Failed to log the email.";
    }

    $stmt->close();
}

$conn->close();
?>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sending Email</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <div class="icon-container">
            <i class="fas fa-envelope"></i>
        </div>
        <h2>Send Email</h2>
        <form action="send_mail.php" method="POST">
            <div class="form-group mb-2">
                <input type="email" name="email" id="" class="form-control" placeholder="input email here">
            </div>
            <div class="form-group mb-2">
                <textarea name="message" id="" cols="30" rows="5" class="form-control" placeholder="Enter the message to send here"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i>&nbsp;&nbsp;&nbsp;send</button>
        </form>
    </div>
    <script src="js/init.js"></script>
    <script src="js/jquery.dataTables.js"></script>
</body>
</html>