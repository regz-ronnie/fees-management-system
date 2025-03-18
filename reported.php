<?php
include("php/dbconnect.php");
// include("php/checklogin.php");

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bidii High School Fees Payment System</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

	<link href="css/ui.css" rel="stylesheet" />
	<link href="css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
	<link href="css/datepicker.css" rel="stylesheet" />
	   <link href="css/datatable/datatable.css" rel="stylesheet" />

    <script src="js/jquery-1.10.2.js"></script>
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   <script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>

		 <script src="js/dataTable/jquery.dataTables.min.js"></script>



</head>
<?php
include("php/header.php");
?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Problem Reports

						</h1>

                    </div>
                </div>






                <?php
// Database connection
// include 'php/dbconnect.php';
// Query to fetch problem reports
$sql = "SELECT report_id, student_name, student_id, problem_description, report_date FROM problem_reports";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problem Reports</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2></h2>
    <table>
        <thead>
            <tr>
                <!-- <th>Report ID</th> -->
                <th>Student Name</th>
                <th>Student ID</th>
                <th>Problem Description</th>
                <th>Report Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // echo "<td>" . htmlspecialchars($row['report_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars($row['problem_description'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['report_date']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No problem reports found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

    <!-- BOOTSTRAP SCRIPTS -->
    <script src="js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="js/custom1.js"></script>


</body>
</html>
