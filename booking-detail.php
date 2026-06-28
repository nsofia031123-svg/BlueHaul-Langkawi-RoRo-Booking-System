<?PHP
session_start();
include("database.php");

$booking_id = (isset($_GET['booking_id'])) ? trim($_GET['booking_id']) : '';

$success = "";

$SQL_view = " SELECT * FROM `booking` WHERE booking_id =  $booking_id ";

$result = mysqli_query($con, $SQL_view) or die("Error in query: " . $SQL_view . "<br />" . mysqli_error($con));
$data = mysqli_fetch_array($result);


$SQL_view = "SELECT b.*, s.depart_time, s.arrival_time FROM `booking` b
              JOIN `schedule` s ON b.location = s.location
              WHERE b.booking_id = $booking_id";

$result = mysqli_query($con, $SQL_view) or die("Error in query: " . $SQL_view . "<br />" . mysqli_error($con));
$data = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<title>BLUEHAUL RORO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
	crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	body,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6 {
		font-family: "Barlow", sans-serif;
		font-weight: 500;
	}

	body,
	html {
		height: 100%;
		line-height: 1.8;
	}

	a:link {
		text-decoration: none;
	}

	.w3-bar .w3-button {
		padding: 16px;
	}
</style>

<body>

	<div>

		<div class="w3-padding"></div>

		<div class="w3-padding w3-xlarge w3-center"><b>- BOOKING DETAIL -</b></div>

		<div class="w3-container " id="contact">
			<div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:700px">
				<div class="w3-padding">

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Booking No</div>
						<div class="w3-col s7">
							<?PHP echo $data["booking_no"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Trip</div>
						<div class="w3-col s7">
							<?PHP echo $data["trip"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Location</div>
						<div class="w3-col s7">
							<?PHP echo $data["location"]; ?>
						</div>
					</div>


					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Departure Time</div>
						<div class="w3-col s7">
							<?php echo $data["depart_time"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Arrival Time</div>
						<div class="w3-col s7">
							<?php echo $data["arrival_time"]; ?>
						</div>
					</div>




					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Depart Date</div>
						<div class="w3-col s7">
							<?PHP echo $data["depart_date"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Return Date</div>
						<div class="w3-col s7">
							<?PHP echo $data["return_date"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Vehicle</div>
						<div class="w3-col s7">
							<?PHP echo GetVehicle($con, $data["vehicle"]); ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Adult</div>
						<div class="w3-col s7">
							<?PHP echo $data["adult"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Children</div>
						<div class="w3-col s7">
							<?PHP echo $data["children"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Senior</div>
						<div class="w3-col s7">
							<?PHP echo $data["senior"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Total</div>
						<div class="w3-col s7">RM
							<?PHP echo $data["total"]; ?>
						</div>
					</div>

				</div>
			</div>
			<div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:700px">
				<div class="w3-padding">
					<b class="w3-padding-small">Passenger Detail</b>
					<hr style="margin: 10px 0px 10px 0px">

					<?PHP
					$bil = 0;
					$SQL_list = "SELECT * FROM `booking_passenger` WHERE booking_id = $booking_id AND `category`= 'adult'";
					$result = mysqli_query($con, $SQL_list);
					while ($dat = mysqli_fetch_array($result)) {
						$bil++;
						?>
						<div class="w3-row w3-padding-small">
							<div class="w3-col s5">Adult (
								<?PHP echo $bil; ?>)
							</div>
							<div class="w3-col s7">
								<?PHP echo $dat["name"]; ?>&nbsp; -
								<?PHP echo $dat["ic"]; ?>
							</div>
						</div>
					<?PHP } ?>

					<?PHP
					$bil = 0;
					$SQL_list = "SELECT * FROM `booking_passenger` WHERE booking_id = $booking_id AND `category`= 'children'";
					$result = mysqli_query($con, $SQL_list);
					while ($dat = mysqli_fetch_array($result)) {
						$bil++;
						?>
						<div class="w3-row w3-padding-small">
							<div class="w3-col s5">Children (
								<?PHP echo $bil; ?>)
							</div>
							<div class="w3-col s7">
								<?PHP echo $dat["name"]; ?>&nbsp; -
								<?PHP echo $dat["ic"]; ?>
							</div>
						</div>
					<?PHP } ?>

					<?PHP
					$bil = 0;
					$SQL_list = "SELECT * FROM `booking_passenger` WHERE booking_id = $booking_id AND `category`= 'senior'";
					$result = mysqli_query($con, $SQL_list);
					while ($dat = mysqli_fetch_array($result)) {
						$bil++;
						?>
						<div class="w3-row w3-padding-small">
							<div class="w3-col s5">Senior (
								<?PHP echo $bil; ?>)
							</div>
							<div class="w3-col s7">
								<?PHP echo $dat["name"]; ?>&nbsp; -
								<?PHP echo $dat["ic"]; ?>
							</div>
						</div>
					<?PHP } ?>

				</div>
			</div>
			<div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:700px">
				<div class="w3-padding">
					<b class="w3-padding-small">Vehicle Detail</b>
					<hr style="margin: 10px 0px 10px 0px">

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Vehicle Brand</div>
						<div class="w3-col s7">
							<?PHP echo $data["vehicle_brand"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Vehicle Model</div>
						<div class="w3-col s7">
							<?PHP echo $data["vehicle_model"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Registration No</div>
						<div class="w3-col s7">
							<?PHP echo $data["registration_no"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Chassis No</div>
						<div class="w3-col s7">
							<?PHP echo $data["chassis_no"]; ?>
						</div>
					</div>

				</div>
			</div>
			<div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:700px">
				<div class="w3-padding">
					<b class="w3-padding-small">Driver Detail</b>
					<hr style="margin: 10px 0px 10px 0px">

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Driver Name</div>
						<div class="w3-col s7">
							<?PHP echo $data["driver_name"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Driver Phone No</div>
						<div class="w3-col s7">
							<?PHP echo $data["driver_phone"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Driver Gender</div>
						<div class="w3-col s7">
							<?PHP echo $data["driver_gender"]; ?>
						</div>
					</div>

					<div class="w3-row w3-padding-small">
						<div class="w3-col s5">Driver ID</div>
						<div class="w3-col s7">
							<?PHP echo $data["driver_id"]; ?>
						</div>
					</div>

				</div>
			</div>



		</div>

		<div class="w3-padding w3-large w3-center"><b>- BLUEHAUL RORO -</b></div>

		<div class="w3-padding-32"></div>


	</div>



</body>

</html>