<?php 
include("php/dbconnect.php");
// include("php/checklogin.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search-query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search-query']);  // Sanitize the input

    // Ensure the search is only applied to studentId
    $sql = "SELECT * FROM student WHERE studentId = '$searchQuery'";  // Exact match for studentId

    // Execute query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Student found
        while ($row = $result->fetch_assoc()) {
            $studentId = $row['studentId'];
            $sname = $row['sname'];
            $joindate = $row['joindate'];
            $contact = $row['contact'];
            $about = $row['about'];
            $emailid = $row['emailid'];
            $branch = $row['branch'];
            $balance = $row['balance'];
            $fees = $row['fees'];

            // Store the student info in a session or pass it through JavaScript to display in the dashboard
            $_SESSION['student_info'] = [
                'studentId' => $studentId,
                'sname' => $sname,
                'joindate' => $joindate,
                'contact' => $contact,
                'about' => $about,
                'emailid' => $emailid,
                'branch' => $branch,
                'balance' => $balance,
                'fees' => $fees
            ];
        }
    } else {
        // No student found
        $_SESSION['student_info'] = null;  // If no student is found, clear the session data
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidii High School - Parent Portal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0, 0, 0); /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4); /* Black with transparency */
    padding-top: 60px;
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Width of the modal */
    border-radius: 8px; /* Rounded corners */
}

/* Modal Header */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
}

.close-btn {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-btn:hover,
.close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Modal Body */
.modal-body {
    margin-top: 20px;
}

/* Input Fields & Textarea */
input[type="text"], textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    margin-bottom: 10px; /* Space between fields */
}

/* Textarea */
textarea {
    resize: vertical;
}

/* Submit Button */
.submit-btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.submit-btn:hover {
    background-color: #45a049;
}

</style>
</head>
<body>

    <header>
        <div class="logo">Bidii High School</div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="index.php">admin</a></li>
                <!-- <li><a href="#">Academic Info</a></li>
                <li><a href="#">Profile Settings</a></li>
                <li><a href="#support-section">Support</a></li> -->
            </ul> -->
        </nav>
    </header>

    <main class="dashboard">
        <!-- Search Form -->
        <section class="search-student">
            <h3>Search Student Information</h3>
            <form id="search-form" method="POST">
                <label for="search-input">Search by Student Name or ID:</label>
                <input type="text" id="search-input" name="search-query" placeholder="Enter Student Name or ID" required>
                <button type="submit">Search</button>
            </form>
        </section>

        <!-- Display student info if search is successful -->
        <section class="student-info-section">
            <?php if (isset($_SESSION['student_info']) && $_SESSION['student_info'] != null): ?>
                <div class="student-info">
                    <h4>Student Found:</h4>
                    <!-- Table to display student information -->
                    <table class="student-table">
                        <tr>
                            <th>Student ID</th>
                            <td><?php echo $_SESSION['student_info']['studentId']; ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo $_SESSION['student_info']['sname']; ?></td>
                        </tr>
                        <tr>
                            <th>Join Date</th>
                            <td><?php echo $_SESSION['student_info']['joindate']; ?></td>
                        </tr>
                        <tr>
                            <th>Contact</th>
                            <td><?php echo $_SESSION['student_info']['contact']; ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $_SESSION['student_info']['emailid']; ?></td>
                        </tr>
                        <tr>
                            <th>Branch</th>
                            <td><?php echo $_SESSION['student_info']['branch']; ?></td>
                        </tr>
                        <tr>
                            <th>Balance</th>
                            <td><?php echo $_SESSION['student_info']['balance']; ?></td>
                        </tr>
                        <tr>
                            <th>Fees</th>
                            <td><?php echo $_SESSION['student_info']['fees']; ?></td>
                        </tr>
                    </table>
                </div>
                <br>
                <hr>

                <!-- Fee Payment Status Section (moved below student info) -->
                <section class="fee-summary">
                    <div class="fee-card">
                    <h3>Fee Payment Status</h3>
                    <p><strong>Outstanding Balance: </strong><span id="outstanding-balance"><?php echo $_SESSION['student_info']['balance']; ?></span></p>
                    <p><strong>Next Payment Due: </strong><span id="next-payment-date">2024-12-15</span></p>
                    <button id="pay-now" onclick="openPaymentModal()">Make Payment</button>
                    </div>
                    <div class="fee-card">
                    <?php
// Assuming you've already established a database connection in $conn
// include("php/dbconnect.php");
// session_start();

// Check if 'student_info' is set in the session and it's not null
if (isset($_SESSION['student_info']) && $_SESSION['student_info'] != null) {
    // Retrieve student data from session (assuming session stores the studentId)
    $studentId = $_SESSION['student_info']['studentId'];
    
    // Fetch student information from the database
    $query = $conn->prepare("SELECT * FROM student WHERE studentId = ?");
    $query->bind_param("i", $studentId);
    $query->execute();
    $result = $query->get_result();

    // Check if data was found for the student
    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();
    }
}
?>

<!-- Button to trigger the modal -->
<h3>Fee Payment history</h3>
                    <p>view payment history</p>
                    <p></p>
<button id="studentInfoBtn" class="btn">view payment history</button>

<!-- Modal Structure -->
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Student Information</h2>
        
        <?php if (isset($studentData)): ?>
            <!-- Table for student info -->
            <!-- Table for student info -->
<table class="student-table">
    <tr>
        <td><strong>Name:</strong></td>
        <td><?php echo htmlspecialchars($_SESSION['student_info']['sname']); ?></td>
    </tr>
    <tr>
        <td><strong>Email:</strong></td>
        <td><?php echo htmlspecialchars($_SESSION['student_info']['emailid']); ?></td>
    </tr>
    <tr>
        <td><strong>Branch:</strong></td>
        <td><?php echo htmlspecialchars($_SESSION['student_info']['branch']); ?></td>
    </tr>
    <tr>
        <td><strong>Contact:</strong></td>
        <td><?php echo htmlspecialchars($_SESSION['student_info']['contact']); ?></td>
    </tr>
    <tr>
        <td><strong>About:</strong></td>
        <td><?php echo nl2br(htmlspecialchars($_SESSION['student_info']['about'])); ?></td>
    </tr>
</table>


           <!-- Fee summary (emphasized) -->
<div class="fee-summary">
    <h3>Fee Summary</h3>
    <table class="fee-table">
        <tr>
            <td><strong>Balance:</strong></td>
            <td class="balance">
                <?php 
                    // Using session data for balance if available
                    echo htmlspecialchars($_SESSION['student_info']['balance']); 
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>Fees Paid:</strong></td>
            <td class="fees-paid">
                <?php 
                    // Using session data for fees paid if available
                    echo htmlspecialchars($_SESSION['student_info']['fees']); 
                ?>
            </td>
        </tr>
    </table>
</div>


            <!-- Fee Payment History (hardcoded) -->
            <div class="fee-history">
                <h3>Fee Payment History</h3>
                
            </div>

            <!-- Join Date -->
            <div class="join-date">
                <p><strong>Join Date:</strong> <?php echo htmlspecialchars($studentData['joindate']); ?></p>
                <button type="button" class="btn btn-danger" onclick="printModalContent()">Print</button>
            </div>

        <?php else: ?>
            <p>No student data available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal CSS -->
<style>
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border-radius: 10px;
        width: 80%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .close-btn {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 20px;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
    }

    .student-table,
    .fee-table,
    .fee-history-table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .student-table td,
    .fee-table td,
    .fee-history-table td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    .student-table tr:last-child td,
    .fee-table tr:last-child td,
    .fee-history-table tr:last-child td {
        border-bottom: none;
    }

    .fee-summary,
    .fee-history {
        margin-top: 30px;
        background-color: #f4f4f4;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .balance {
        color: red;
        font-weight: bold;
        font-size: 18px;
    }

    .fees-paid {
        color: green;
        font-weight: bold;
        font-size: 18px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #0056b3;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
                    </div>
                

<!-- Modal for Reporting Problem -->
<div id="problem-report-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close-btn" onclick="closeproblemreportModal()">&times;</span>
            <h2>Report a Problem</h2>
        </div>
        <div class="modal-body">
            <p>Please fill in the details below to report the issue:</p>
            <form id="problem-report-form" method="POST" action="submit_problem.php">
                <!-- Student Name Field -->
                <label for="student-name">Student Name:</label>
                <input type="text" id="student-name" name="student-name" value="<?php echo $_SESSION['student_info']['sname']; ?>" readonly>
                <br><br>

                <!-- Student ID Field -->
                <label for="student-id">Student ID:</label>
                <input type="text" id="student-id" name="student-id" value="<?php echo $_SESSION['student_info']['studentId'];?>" readonly>
                <br><br>

                <!-- Problem Description Textarea -->
                <label for="problem-description">Problem Description:</label>
                <textarea id="problem-description" name="problem-description" rows="5" placeholder="Describe the issue..." required></textarea>
                <br><br>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Submit Report</button>
            </form>
        </div>
    </div>
</div>

                    </div>
                </section>
                

            <?php elseif (isset($_SESSION['student_info']) && $_SESSION['student_info'] == null): ?>
                <p>No student found matching your search query.</p>
            <?php endif; ?>
        </section>

        <!-- Fee Payment and Academic Summary -->
        <section class="dashboard-summary">
            <div class="academic-summary">
            <h3>Fee Breakdown</h3>
<p><strong>Latest Fee structure: </strong></p>
<button id="view-report" onclick="openPdf()">View fee structure</button>
<div id="attendance-info"></div>
            </div>

            <div class="academic-summary">
    <h3>Announcements</h3>
    <p><strong>Take a look at announcements:</strong></p>
    <p><?php 
    $sql = "SELECT announcement_id, title, description, posted_by, created_at FROM announcements ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    
    ?></p>
    <p><button id="view-announcement" onclick="openAnnouncementModal()">View</button></p>
</div>

<!-- The Modal -->
<div id="announcement-modal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeAnnouncementModal()">&times;</span>
        <h2>Announcement</h2>
        <p>.</p>
        <p><?php $sql = "SELECT announcement_id, title, description, posted_by, created_at FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="announcement">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p>' . nl2br(htmlspecialchars($row['description'])) . '</p>';
        echo '<p class="meta">Posted by ' . htmlspecialchars($row['posted_by']) . ' on ' . htmlspecialchars($row['created_at']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<p>No announcements available.</p>';
}

$conn->close();
?></p>
        <p></p>
    </div>
</div>

            
            <div class="academic-summary">
    <h3>Report problem</h3>
    <p><strong>Report issues related to fee payment:</strong></p>
    <p><button id="view-announcement" onclick="openproblemreportModal()">Report a problem</button></p>
</div>

<!-- Modal for Reporting Problem -->
<div id="problem-report-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close-btn" onclick="closeproblemreportModal()">&times;</span>
            <h2>Report a Problem</h2>
        </div>
        <div class="modal-body">
            <p>Please fill in the details below to report the issue:</p>
            <form id="problem-report-form">
                <!-- Student Name Field -->
                <label for="student-name">Student Name:</label>
                <input type="text" id="student-name" name="student-name" placeholder="Enter Student Name" required>
                <br><br>

                <!-- Student ID Field -->
                <label for="student-id">Student ID:</label>
                <input type="text" id="student-id" name="student-id" placeholder="Enter Student ID" required>
                <br><br>

                <!-- Problem Description Textarea -->
                <label for="problem-description">Problem Description:</label>
                <textarea id="problem-description" name="problem-description" rows="5" placeholder="Describe the issue..." required></textarea>
                <br><br>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Submit Report</button>
            </form>
        </div>
    </div>
</div>


        </section>

    </main>

    <footer>
        <div class="footer-links">
            <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a> | <a href="#">Contact Us</a>
        </div>
    </footer>

    <!-- Modal for Payment -->
    <div id="payment-modal" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closePaymentModal()">&times;</span>
                <h2>Payment Procedure</h2>
            </div>
            <div class="modal-body">
                <p>Enter the amount and phone number to proceed with the payment.</p>
                <form class="row g-3" action="mpesai/stk_initiate.php" method="POST">
                    <div class="col-12">
                        <label for="inputPhone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" required>
                        <input type="text" class="form-control" name="amount" placeholder="Enter Amount">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success" name="submit" value="submit">Make Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function printModalContent() {
    // Get the content of the modal
    const modalContent = document.querySelector('#studentModal .modal-content').innerHTML;

    // Open a new window for printing
    const printWindow = window.open('', '_blank');

    // Write the modal content to the new window
    printWindow.document.write(`
        <html>
            <head>
                <title>Print Fee Payment History</title>
                <style>
                    /* Include your modal styles here for the print view */
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    table, th, td {
                        border: 1px solid black;
                    }
                    th, td {
                        padding: 8px;
                        text-align: left;
                    }
                    h2, h3 {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                ${modalContent}
            </body>
        </html>
    `);

    // Close the document and trigger the print dialog
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    // Close the print window after printing
    // printWindow.close();
}

        function openPaymentModal() {
            var modal = document.getElementById("payment-modal");
            modal.style.display = "block";
        }

        function closePaymentModal() {
            var modal = document.getElementById("payment-modal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("payment-modal");
            if (event.target == modal) {
                closePaymentModal();
            }
        }

        function openAnnouncementModal() {
    var modal = document.getElementById("announcement-modal");
    modal.style.display = "block";
}

function closeAnnouncementModal() {
    var modal = document.getElementById("announcement-modal");
    modal.style.display = "none";
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById("announcement-modal");
    
    if (event.target == modal) {
        closeAnnouncementModal();
    }
}

        // Function to open the modal
function openproblemreportModal() {
    var modal = document.getElementById("problem-report-modal");
    modal.style.display = "block";  // Show the modal
}

// Function to close the modal
function closeproblemreportModal() {
    var modal = document.getElementById("problem-report-modal");
    modal.style.display = "none";  // Hide the modal
}

// Close the modal if the user clicks anywhere outside of it
window.onclick = function(event) {
    var modal = document.getElementById("problem-report-modal");
    if (event.target == modal) {
        closeproblemreportModal();
    }
}
    // Get the modal
    var modal = document.getElementById("studentModal");

    // Get the button that opens the modal
    var btn = document.getElementById("studentInfoBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-btn")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    function openPdf() {
        // Specify the path to your PDF file
        const pdfPath = 'bidii high school.pdf'; // Adjust the path if needed
        
        // Open the PDF in a new tab or window
        window.open(pdfPath, '_blank');
    }

        
    </script>

</body>
</html>
