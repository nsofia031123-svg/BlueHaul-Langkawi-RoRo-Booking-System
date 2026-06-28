<?PHP
session_start();
include("database.php");
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


<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round-large w3-card" style="max-width:1300px">
		<form id="contactForm" method="post">
		<div class="w3-padding">
			
			<div class="w3-padding-32"></div>
			
			<div class="w3-row ">
				<div class="w3-col m3 w3-center w3-border-right">

					<i class="fas fa-map-marker-alt fa-2x w3-text-pink"></i>
					<div class="w3-xlarge"><b>Address</b></div>
					<div class="w3-text-grey">Kuala Perlis<br>Langkawi</div>

					<div class="w3-padding-16"></div>

					<i class="fas fa-phone-alt fa-2x w3-text-pink"></i>
					<div class="w3-xlarge"><b>Phone</b></div>
					<div class="w3-text-grey">+011 6136 3721<br>+012 3456 7899</div>
					
					<div class="w3-padding-16"></div>

					<i class="fas fa-envelope fa-2x w3-text-pink"></i>
					<div class="w3-xlarge"><b>Email</b></div>
					<div class="w3-text-grey">BlueHaul2024@gmail.com<br>BlueHaulLangkawi@gmail.com</div>

				
				</div>
				
				<div class="w3-col m1 w3-center ">&nbsp;</div>
				
				<div class="w3-col m8 ">
				

				<div class="w3-xlarge w3-text-pink"><b>Send us a message</b></div>
				<p class="w3-large">If you have any questions or queries regarding your booking ticket, you can send us a message here!</p>

				<div class="w3-section">
					<input class="w3-input w3-light-grey w3-padding w3-border w3-round" type="text" id="name" name="name" placeholder="Enter your name" required>
				</div>
				<div class="w3-section">
					<input class="w3-input w3-light-grey w3-padding w3-border w3-round" type="text" id="plateNumber" name="plateNumber" placeholder="Enter your plate number" >
				</div>
				<div class="w3-section">
					<input class="w3-input w3-light-grey w3-padding w3-border w3-round" type="text" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" required>
				</div>
				<div class="w3-section">
					<textarea class="w3-input w3-light-grey w3-padding w3-border w3-round" id="message" rows="4" name="message" placeholder="Enter your message" required></textarea>
				</div>
				
				
				<div>
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $plateNumber = mysqli_real_escape_string($con, $_POST['plateNumber']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // SQL query to insert data into the database
    $sql = "INSERT INTO messages (name, plate_number, phone_number, message_text) VALUES ('$name', '$plateNumber', '$phoneNumber', '$message')";

    // Execute the query
    if ($con->query($sql) === TRUE) {
        echo "Messages sent successfully! We will reach out to you shortly!";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Close the database connection
    $con->close();
}
?>
			</div>
    
	
			<div class="button">
				<input class="w3-button w3-black w3-round w3-large" type="submit" value="Send Now">
			</div>
					
				
				</div>
			</div>
			
		</div>
		</form>
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
