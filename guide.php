<?PHP
session_start();
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

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
  background-attachment:fixed;
  background-image: url(images/banner.jpg);
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="w3-pale-red">

<?PHP include("menu.php"); ?>


<div class="bgimg-1" >

	<div class="w3-padding-64"></div>
	

<div class="w3-container w3-padding-16 w3-large" id="contact">
    <div class="w3-content w3-container w3-white w3-round-large w3-card" style="max-width:1200px">
		<div class="w3-padding">

			<div class="w3-padding-small"></div>
			
			<div class="w3-block w3-white w3-round-large w3-card w3-padding ">
				<h2><b>Terms and Conditions</b></h2>
				<p><a href="https://www.termsofservicegenerator.net/live.php?token=jiJ5mrvEjo1L0wMLEQSqVxI3pdMMWY4j" class="w3-text-pink">Read our Terms and Conditions</a></p>
			</div>
			
			
			<div class="w3-padding-16"></div>
			
			<div class="w3-block w3-white w3-round-large w3-card w3-padding ">
				<h2><b>Reservation Requirements</b></h2>
				<p>Photocopy of Vehicle Grants (Front & Rear)</p>
				<p>Photocopy of Driver IC (Front & Rear)</p>
				<p>Details of Passenger (Name & IC)</p>
				<p>Driver contact number (Important)</p>
				<p>Any other requirements</p>
				<p>Additional requirement for those who are not the car owner: Authorization letter from car owner</p>
			</div>
			
			
			<div class="w3-padding-16"></div>
			
			<div class="w3-block w3-white w3-round-large w3-card w3-padding ">
				<h2><b>Contact Information:</b></h2>
				<p>WhatsApp: <a href="tel:01161363721" class="w3-text-pink">011 - 6136 3721 / 011 - 6105 9957</a></p>
				<p>Email: <a href="mailto:bluehaullangkawi@gmail.com" class="w3-text-pink">bluehaullangkawi@gmail.com</a></p>
			</div>
			
			<div class="w3-padding-16"></div>
			
			<div class="w3-block w3-white w3-round-large w3-card w3-padding ">
				<h2><b>References:</b></h2>
				<p>Sample of photocopy IC</p>
				<p>Sample of Vehicle Grants</p>
				<p>Sample of reservation request letter / email</p>
				<p>Sample of authorization letter</p>
				<p>Vehicle Fare</p>
				<p>Schedule</p>
				<p>Contact Information</p>
			</div>

		</div>
		<div class="w3-padding-24"></div>
    </div>
</div>


<div class="w3-padding-16"></div>
	
</div>

<?php include 'footer.php'; ?>	
 
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
