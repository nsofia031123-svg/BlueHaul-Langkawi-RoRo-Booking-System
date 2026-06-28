<?PHP
session_start();
include("database.php");

$booking_id = (isset($_GET['booking_id'])) ? trim($_GET['booking_id']) : '';

$success = "";

$SQL_view 	= " SELECT * FROM `booking` WHERE booking_id =  $booking_id ";

$result 	= mysqli_query($con, $SQL_view) or die("Error in query: ".$SQL_view."<br />".mysqli_error($con));
$data		= mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html>
<title>BLUEHAUL RORO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Barlow", sans-serif; font-weight: 500;}

body, html {
  height: 100%;
  line-height: 1.3;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body >

<div >

	<div class="w3-padding"></div>
	
	<div class="w3-padding w3-xlarge w3-center"><b>- QRCODE TICKET -</b></div>

<div class="w3-container " id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:400px">
		<div class="w3-padding w3-center">

			<div class="w3-row">

				<div class="w3-col">
					<div class="w3-padding">
					
						<div class="w3-padding w3-center">
							<b class="w3-xxlarge"><?PHP echo $data["booking_no"];?></b>
						</div>
							<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?PHP echo $data["booking_no"];?>">
							
							<hr class="w3-clear">

							<div class="w3-padding-small " >
								<label>Trip : </label>
								<label><?PHP echo $data["location"];?></label>
							</div>
							
							<div class="w3-padding-small " >
								<label>Departure Date : </label>
								<label><?PHP echo $data["depart_date"];?></label>
							</div>
							
							<div class="w3-padding-small " >
								<label>Return Date : </label>
								<label><?PHP echo $data["return_date"];?></label>
							</div>
								
							<hr>

							<div class="w3-padding-small " >
								<label>Vehicle Brand : </label>
								<label><?PHP echo $data["vehicle_brand"];?></label>
							</div>

							<div class="w3-padding-small " >
								<label>Registration No : </label>
								<label><?PHP echo $data["registration_no"];?></label>
							</div>

							<div class="w3-padding-small " >
								<label>Driver Name : </label>
								<label><?PHP echo $data["driver_name"];?></label>
							</div>
							
							<div class="w3-padding-small " >
								<label>Driver ID : </label>
								<label><?PHP echo $data["driver_id"];?></label>
							</div>
							
							<hr>

							<div class="w3-padding-small " >
								<label>Passenger : </label><br>
								Adult : <?PHP echo $data["adult"];?> &nbsp; 
								Children : <?PHP echo $data["children"];?> &nbsp; 
								Senior : <?PHP echo $data["senior"];?>
							</div>
						  

						</div>  

					
					</div>
				</div>
			</div>
			
			
		
		</div>

    </div>
</div>

<div class="w3-padding w3-large w3-center"><b>- BLUEHAUL RORO -</b></div>

	
</div>



</body>
</html>
