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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Barlow", sans-serif; font-weight: 500;}

body, html {
  height: 100%;
  line-height: 2;
}

a:link {
  text-decoration: none;
}



.w3-bar .w3-button {
  padding: 16px;
}
html{
	height:100%;
}
.bg {
	background-image: url(images/1.jpg);
	background-size: cover;
	height:calc(100% + 20px);
    background-repeat: no-repeat;

}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: calc(100% + 20px);
    background-color: rgba(0, 0, 0, 0.6);
}

.content {
    position: relative;
    z-index: 1; 
}

.w3-top{
	z-index: 2;
}
.drop-head:hover .th
{
    color: #e91e63 !important;
}

.w3-top{
  line-height: 2;
  font-family: "Barlow", sans-serif;
  font-weight:500;
}
 </style>

<body class="home-page">

<?PHP include("menu.php"); ?>




	<div class="bg">
	<div class="overlay"></div>
    <div class="content">
<br><br><br>
			<div class="row p-5 m-5 mb-0">
				
				
				

			<div class="col-12 col-sm-12 d-flex flex-column justify-content-center align-items-center">
                <div class="w3-xxlarge" style="color:white; text-align:center; line-height:1.5;">
                    Your vehicle. Your island adventure. <div style="text-align:center;"><b>One easy ferry trip.</b></div>
                </div>
                
                <div class="col-12 col-md-7 mt-4">
                    <p class="text-center" style="color: #ADD8E6; line-height:1.5;">
                        Travel between Kuala Perlis and Langkawi with your own vehicle. Check schedules, see transparent fares, and book your RoRo journey in a few simple steps.
                    </p>
                </div>

						<div class="w3-padding-16"></div>
						<div class="home-actions mb-5">
						<?PHP if(!isset($_SESSION["username"])) {?>
						<a href="login.php" class="w3-text-white w3-button w3-wide w3-black w3-padding-16"><b>Book a trip</b></a>
						<?PHP } else { ?>
						<a href="book.php" class="w3-text-white w3-button w3-wide w3-black w3-padding-16"><b>Book a trip</b></a>
						<?PHP }?>

						<?PHP if(!isset($_SESSION["username"])) {?>
						<?PHP } ?>
						<a href="schedule.php" class="secondary-action w3-text-white w3-button w3-wide w3-padding-16"><b>View schedules</b></a>
						
						</div>
						
						
					</div>
					
					
			</div>
			
			
			</div>

			</div>	

<section class="trip-tools">
	<div class="trip-tools-inner">
		<div class="section-kicker">Plan with confidence</div>
		<h2>Everything you need before you sail</h2>
		<div class="trip-tools-grid">
			<a href="schedule.php" class="trip-tool-card">
				<span class="trip-tool-icon"><i class="fa fa-calendar"></i></span>
				<h3>Check ferry schedules</h3>
				<p>Find upcoming departure and arrival times for both routes.</p>
			</a>
			<a href="fare.php" class="trip-tool-card">
				<span class="trip-tool-icon"><i class="fa fa-tags"></i></span>
				<h3>See clear fares</h3>
				<p>Review passenger and vehicle prices before starting your booking.</p>
			</a>
			<a href="guide.php" class="trip-tool-card">
				<span class="trip-tool-icon"><i class="fa fa-compass"></i></span>
				<h3>Prepare for travel</h3>
				<p>Know what to bring and what to expect on your travel day.</p>
			</a>
		</div>
	</div>
</section>
	
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
