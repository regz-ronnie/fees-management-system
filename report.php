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
                        <h1 class="page-head-line">Report

						</h1>

                    </div>
                </div>






<div class="row" style="margin-bottom:20px;">
<div class="col-md-12">
<fieldset class="scheduler-border" >
    <legend  class="scheduler-border">Search:</legend>
<form class="form-inline" role="form" id="searchform">
  <div class="form-group">
    <label for="email">Name</label>
    <input type="text" class="form-control" id="student" name="student">
  </div>

   <div class="form-group">
    <label for="email"> Date Of Joining </label>
    <input type="text" class="form-control" id="doj" name="doj" >
  </div>

  <div class="form-group">
    <label for="email"> Branch </label>
    <select  class="form-control" id="branch" name="branch" >
		<option value="" >Select Branch</option>
                                    <?php
									$sql = "select * from branch where delete_status='0' order by branch.branch asc";
									$q = $conn->query($sql);

									while($r = $q->fetch_assoc())
									{
									echo '<option value="'.$r['id'].'"  '.(($branch==$r['id'])?'selected="selected"':'').'>'.$r['branch'].'</option>';
									}
									?>
	</select>
  </div>

   <button type="button" class="btn btn-success btn-sm" id="find" > Find </button>
  <button type="reset" class="btn btn-danger btn-sm" id="clear" > Clear </button>
</form>
</fieldset>

</div>
</div>

<script type="text/javascript">
$(document).ready( function() {

/*
$('#doj').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        dateFormat: 'mm/yy',
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
	1353c-p function 18cp
*/

/******************/
	 $("#doj").datepicker({

        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/yy',
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });

    $("#doj").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });

/*****************/

$('#student').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : 'ajx.php',
		      			dataType: "json",
						data: {
						   name_startsWith: request.term,
						   type: 'report'
						},
						 success: function( data ) {

							 response( $.map( data, function( item ) {

								return {
									label: item,
									value: item
								}
							}));
						}



		      		});
		      	}
				/*,
		      	autoFocus: true,
		      	minLength: 0,
                 select: function( event, ui ) {
						  var abc = ui.item.label.split("-");
						  //alert(abc[0]);
						   $("#student").val(abc[0]);
						   return false;

						  },
                 */



		      });


$('#find').click(function () {
mydatatable();
        });


$('#clear').click(function () {

$('#searchform')[0].reset();
mydatatable();
        });

function mydatatable()
{

              $("#subjectresult").html('<table class="table table-striped table-bordered table-hover" id="tSortable22"><thead><tr><th>Name/Contact</th><th>Fees</th><th>Balance</th><th>Branch</th><th>DOJ</th><th>Action</th></tr></thead><tbody></tbody></table>');

			    $("#tSortable22").dataTable({
							      'sPaginationType' : 'full_numbers',
							     "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
							       'bProcessing' : true,
							       'bServerSide': true,
							       'sAjaxSource': "datatable.php?"+$('#searchform').serialize()+"&type=report",
							       'aoColumnDefs': [{
                                   'bSortable': false,
                                   'aTargets': [-1] /* 1st one, start by the right */
                                                }]
                                   });


}

////////////////////////////
 $("#tSortable22").dataTable({

                  'sPaginationType' : 'full_numbers',
				  "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,

                  'bProcessing' : true,
				  'bServerSide': true,
                  'sAjaxSource': "datatable.php?type=report",

			      'aoColumnDefs': [{
                  'bSortable': false,
                  'aTargets': [-1] /* 1st one, start by the right */
              }]
            });

///////////////////////////



});


function GetFeeForm(sid)
{

$.ajax({
            type: 'post',
            url: 'getfeeform.php',
            data: {student:sid,req:'2'},
            success: function (data) {
              $('#formcontent').html(data);
			  $("#myModal").modal({backdrop: "static"});
            }
          });


}

</script>




<style>
#doj .ui-datepicker-calendar
{
display:none;
}

</style>

		<div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Fees
                        </div>
                        <div class="panel-body">
                            <div class="table-sorting table-responsive" id="subjectresult">
                                <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                    <thead>
                                        <tr>

                                            <th>Name/Contact</th>
                                            <th>Fees</th>
											<th>Balance</th>
											<th>Branch</th>
											<th>DOJ</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
								    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


	<!-------->

	<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Fee Report</h4>
        </div>
        <div class="modal-body" id="formcontent">

        </div>
        <div class="modal-footer">
        <div class="modal-footer">
  <button type="button" class="btn btn-danger" onclick="printModalContent()">Print</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>

      </div>
    </div>
  </div>


    <!--------->


            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    <div id="footer-sec">
    Bidii High School Fees Payment System | Brought To You By : <a href="#" target="_blank">Bidii High</a>
    </div>
    <script>
      function printModalContent() {
  // Get the content of the modal body
  var modalContent = document.getElementById('formcontent').innerHTML;

  // Create a new window for printing
  var printWindow = window.open('', '_blank', 'height=600,width=800');
  printWindow.document.open();
  printWindow.document.write('<html><head><title>Fee Report</title>');
  printWindow.document.write('<link rel="stylesheet" href="css/bootstrap.css" />'); // Optional: Include Bootstrap CSS
  printWindow.document.write('<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>'); // Add custom styles
  printWindow.document.write('</head><body>');
  printWindow.document.write(modalContent);
  printWindow.document.write('</body></html>');
  printWindow.document.close();

  // Print the new window's content
  printWindow.onload = function () {
    printWindow.print();
    // printWindow.close();
  };
}

    </script>


    <!-- BOOTSTRAP SCRIPTS -->
    <script src="js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="js/custom1.js"></script>


</body>
</html>
