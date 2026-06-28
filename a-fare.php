<?PHP
session_start();

include("database.php");
if( !verifyAdmin($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$fareid		= (isset($_REQUEST['fareid'])) ? trim($_REQUEST['fareid']) : '0';
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$onewaycharge	= (isset($_POST['onewaycharge'])) ? trim($_POST['onewaycharge']) : 0;
$roundtripcharge= (isset($_POST['roundtripcharge'])) ? trim($_POST['roundtripcharge']) : 0;
$onewayweb		= (isset($_POST['onewayweb'])) ? trim($_POST['onewayweb']) : 0;
$roundtripbookingweb= (isset($_POST['roundtripbookingweb'])) ? trim($_POST['roundtripbookingweb']) : 0;

//$title		=	mysqli_real_escape_string($con, $title);

$success = "";

if($act == "edit")
{	
	$SQL_update = " 
	UPDATE
		`fare`
	SET
		`onewaycharge` = $onewaycharge,
		`roundtripcharge` = $roundtripcharge,
		`onewayweb` = $onewayweb,
		`roundtripbookingweb` = $roundtripbookingweb
	WHERE `fareid` =  '$fareid'";	
						
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	

	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Update'); self.location='a-fare.php';</script>";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `fare` WHERE `fareid` =  '$fareid' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='a-fare.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<title>BLUEHAUL RORO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="css/table.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

<style>
a { text-decoration : none ;}

body,h1,h2,h3,h4,h5,h6 {font-family: "Barlow", sans-serif}

body, html {
  height: 100%;
  line-height: 1.5;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-attachment: fixed;
  background-size: cover;
  background-image: url("images/banner.jpg");
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="w3-pale-red">

<?PHP include("menu-admin.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "a-fare.php"); }
?>	

<div class="w3-pale-red" >

	<div class="w3-padding-64"></div>
	

	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1400px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
	  
		<div class="w3-xxlarge w3-center"><b>Fare</b></div>
		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" style="font-size:10pt" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr class="w3-black">
					<th>BIL</th>
                    <th>CATEGORY</th>
                    <th>ONE WAY PORT CHARGE</th>
                    <th>ROUND TRIP PORT CHARGE</th>
                    <th>ONE WAY WEB</th>
                    <th>ROUND TRIP BOOKING</th>
                    <th class="w3-center">Action</th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `fare` ";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$fareid = $data["fareid"];
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><?PHP echo $data["category"] ;?></td>
				<td><?PHP echo $data["onewaycharge"] ;?></td>
				<td><?PHP echo $data["roundtripcharge"] ;?></td>
				<td><?PHP echo $data["onewayweb"] ;?></td>
				<td><?PHP echo $data["roundtripbookingweb"] ;?></td>
				<td class="w3-center">
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-fw fa-edit fa-lg"></i></a>
				
				<!--<a title="Delete" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-text-red"><i class="fa fa-fw fa-trash fa-lg"></i></a>-->
				</td>
			</tr>
			
<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding">
			<b class="w3-large">Update Fare</b>
			<hr>


				<div class="w3-section" >
					<label>ONE WAY PORT CHARGE *</label>
					<input class="w3-input w3-border w3-round" type="text" name="onewaycharge" value="<?PHP echo $data["onewaycharge"]; ?>" required>
				</div>
				
				<div class="w3-section" >
					<label>ROUND TRIP PORT CHARGE *</label>
					<input class="w3-input w3-border w3-round" type="text" name="roundtripcharge" value="<?PHP echo $data["roundtripcharge"]; ?>" required>
				</div>
				
				<div class="w3-section" >
					<label>ONE WAY WEB	 </label>
					<input class="w3-input w3-border w3-round" type="text" name="onewayweb" value="<?PHP echo $data["onewayweb"]; ?>" >
				</div>
				
				<div class="w3-section" >
					<label>ROUND TRIP BOOKING </label>
					<input class="w3-input w3-border w3-round" type="text" name="roundtripbookingweb" value="<?PHP echo $data["roundtripbookingweb"]; ?>" >
				</div>
				

				
			  
			<hr class="w3-clear">
			<input type="hidden" name="fareid" value="<?PHP echo $data["fareid"];?>" >
			<input type="hidden" name="act" value="edit" >
			<button type="submit" class="w3-button w3-black w3-text-white w3-margin-bottom w3-round">SAVE CHANGES</button>
			</div>
		</form>
		</div>
	</div>
<div class="w3-padding-24"></div>
</div>

<div id="idDelete<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post">
			<div class="w3-padding"></div>
			<b class="w3-large">Confirmation</b>
			  
			<hr class="w3-clear">			
			Are you sure to delete this record ?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="fareid" value="<?PHP echo $data["fareid"];?>" >
			<input type="hidden" name="act" value="del" >
			<button type="button" onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES, CONFIRM</button>
		</form>
		</div>
	</div>
</div>				
			<?PHP } ?>
			</tbody>
		</table>
		</div>
		</div>

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	<div class="w3-padding-24"></div>
	
</div>



<script>
$(document).ready(function() {

  
	$('#dataTable').DataTable( {
		paging: true,
		
		searching: true
	} );
		
	
});
</script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<!--<script src="assets/demo/datatables-demo.js"></script>-->



 
<script>

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

</body>
</html>
