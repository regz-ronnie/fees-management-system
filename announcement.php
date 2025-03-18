
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
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
                        <h1 class="page-head-line">Report

						</h1>

                    </div>
                </div>






<?php
include("php/dbconnect.php");
// include("php/checklogin.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $posted_by = $_POST['posted_by'];

    // Insert data into the announcements table
    $query = "INSERT INTO announcements (title, description, posted_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $title, $description, $posted_by);

    if ($stmt->execute()) {
        echo "Announcement added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Announcement</title>
</head>
<body>
    <h2>Add New Announcement</h2>
    <form method="POST" action="announcement.php">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="5" required></textarea><br><br>

        <label for="posted_by">Posted By:</label><br>
        <input type="text" id="posted_by" name="posted_by" value="Admin"><br><br>

        <button type="submit">Add Announcement</button>
    </form>
</body>
</html>


<?php
// Close the database connection

?>

    <!-- BOOTSTRAP SCRIPTS -->
    <script src="js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="js/custom1.js"></script>


</body>
</html>
