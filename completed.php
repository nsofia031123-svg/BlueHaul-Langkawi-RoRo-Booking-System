<?PHP
session_start();

$booking_id = (isset($_GET['booking_id'])) ? trim($_GET['booking_id']) : '';
?>
<!DOCTYPE html>
<html>
<title>BLUEHAUL RORO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Barlow", sans-serif; font-weight: 500;}

body, html {
  height: 100%;
  line-height: 1.5;
}

a:link {
  text-decoration: none;
}

/* Full height bg */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  background-attachment:fixed;
  background-image: url(images/banner.jpg);
  min-height:100%;
 /* background-color: rgba(255, 255, 255, 0.9);
  background-blend-mode: overlay; */
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="w3-pale-red">

<?PHP include("menu.php"); ?>


<div class="" >

		<div class="w3-padding-64"></div>
	

<div class="w3-padding-32"></div>

<div class="w3-container w3-content w3-xlarge " style="max-width:600px;"> Completed	</div>

	
<div class="w3-container">

	<!-- Page Container -->
	<div class="w3-containerx w3-content  w3-padding-16 " style="max-width:600px;">    
		<!-- The Grid -->
		<div class="w3-row ">
			
			<div class="w3-white w3-center w3-padding-large w3-padding-32 w3-round-large w3-border w3-border-green">
				<b class="w3-large">Success!</b>
				<hr>		
				<h3>Thank you!</h3>
				Your booking has been completed.
				<div class="w3-padding-16"></div>
				<a href="history.php" class="w3-button w3-black w3-round">Booking History</a>
				<div class="w3-padding-16"></div>
				<a target="_blank" href="slip.php?booking_id=<?PHP echo $booking_id;?>" class="w3-button w3-black w3-round "><i class="fa fa-fw fa-qrcode fa-lg"></i> Ticket</a>
			</div>	
			
			
		<!-- End Grid -->
		</div>
	  
	<!-- End Page Container -->
	</div>
	
	
	

</div>
<!-- container end -->

	
	<div class="w3-padding-64"></div>
	<div class="w3-padding-32"></div>


	
</div>

 
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