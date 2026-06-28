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
    <div class="w3-content w3-container w3-white w3-round-large w3-card" style="max-width:1200px">
		<div class="w3-padding">

		<h3><b>Fare Table</b></h3>
			
		<table class="w3-table w3-table-all" width="100%" cellspacing="0">
			<thead >
				<tr class="w3-black">
					<th>BIL</th>	
					<th>CATEGORY</th>
					<th>ONE WAY PORT CHARGE</th>
					<th>ROUND TRIP PORT CHARGE</th>
					<th>ONE WAY WEB</th>
					<th>ROUND TRIP BOOKING</th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `fare`";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>			
				<td><?PHP echo $data["category"] ;?></td>
				<td><?PHP echo $data["onewaycharge"] ;?></td>
				<td><?PHP echo $data["roundtripcharge"] ;?></td>
				<td><?PHP echo $data["onewayweb"] ;?></td>
				<td><?PHP echo $data["roundtripbookingweb"] ;?></td>
			</tr>			
			<?PHP } ?>
			</tbody>
		</table>
			

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
