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

// Check if 'timestamp' column exists
$timestampExists = false;
$result = $conn->query("SHOW COLUMNS FROM payments LIKE 'timestamp'");
if ($result && $result->num_rows > 0) {
    $timestampExists = true;
}

// Fetch payment records securely
if ($timestampExists) {
    $sql = "SELECT id, phone, amount, status, timestamp FROM payments ORDER BY timestamp DESC";
} else {
    $sql = "SELECT id, phone, amount, status FROM payments ORDER BY id DESC";
}

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Report</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        
        .navbar-cls-top {
            background-color: green;
            padding: 15px;
            color: white;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar-cls-top a {
            color: white;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-default {
            background-color:rgb(64, 52, 52);
            height: 100vh;
            position: fixed;
            width: 220px;
            top: 0;
            left: 0;
            padding-top: 20px;
            color: white;
        }

        .sidebar-collapse ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar-collapse ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            border-bottom: 1px solid #495057;
        }

        .sidebar-collapse ul li a:hover, 
        .sidebar-collapse ul li a.active-menu {
            background-color: #495057;
            text-decoration: none;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
            background-color: #ffffff;
            min-height: 100vh;
        }

        .table {
            background-color: white;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .table td, .table th {
            text-align: center;
            vertical-align: middle;
        }

        .page-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }

        .no-print {
            margin-bottom: 20px;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .content table {
                visibility: visible;
                width: 100%;
            }
            .content table, .content table * {
                visibility: visible;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar navbar-cls-top">
        <a href="index.php" class="navbar-title">Bidii High School Fees Payment</a>
    </div>

    <!-- Sidebar -->
    <nav class="navbar-default">
        <div class="sidebar-collapse">
            <ul id="main-menu">
                <li><a class="active-menu" href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="branch.php"><i class="fa fa-university"></i> Branch</a></li>
                <li><a href="student.php"><i class="fa fa-users"></i> Student</a></li>
                <li><a href="fees.php"><i class="fa fa-file-text"></i> Fees</a></li>
                <li><a href="report.php"><i class="fa fa-file-text"></i> Report</a></li>
                <li><a href="paymentreport.php"><i class="fa fa-file-text"></i> Payment Report</a></li>
                <li><a href="reported.php"><i class="fa fa-file-text"></i> Reported Issues</a></li>
                <li><a href="setting.php"><i class="fa fa-cogs"></i> Settings</a></li>
                <li><a href="email/index.php"><i class="fa fa-envelope"></i> Send Message</a></li>
                <li><a href="announcement.php"><i class="fa fa-bullhorn"></i> Make Announcement</a></li>
                <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <h1 class="page-title">Payment Report</h1>
        <button class="no-print btn btn-primary" onclick="window.print();">Print Table</button>

        <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table id="paymentReport" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Phone Number</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <?php if ($timestampExists): ?>
                        <th>Timestamp</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo number_format($row['amount'], 2); ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <?php if ($timestampExists): ?>
                        <td><?php echo date("d-M-Y H:i:s", strtotime($row['timestamp'])); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p>No payments found.</p>
        <?php endif; ?>
    </div>

    <!-- jQuery and DataTables Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#paymentReport').DataTable();
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
