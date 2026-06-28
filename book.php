<?PHP
session_start();
include("database.php");

$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$trip 			= (isset($_POST['trip'])) ? trim($_POST['trip']) : 'return';
$location 		= (isset($_POST['location'])) ? trim($_POST['location']) : 'LGK-KP';
$depart_date	= (isset($_POST['depart_date'])) ? trim($_POST['depart_date']) : '';
$return_date	= (isset($_POST['return_date'])) ? trim($_POST['return_date']) : '';
$vehicle 		= (isset($_POST['vehicle'])) ? trim($_POST['vehicle']) : '0';
$adult 			= (isset($_POST['adult'])) ? trim($_POST['adult']) : '0';
$children 		= (isset($_POST['children'])) ? trim($_POST['children']) : '0';
$senior 		= (isset($_POST['senior'])) ? trim($_POST['senior']) : '0';

$depart_time = $arrival_time = $depart_time2 = $arrival_time2 = "";
$rate_display  = "";

if($location == "LGK-KP") {
	$from 	= "Langkawi";
	$to 	= "Kuala Perlis";
	$sfrom	= "LGK";
	$sto 	= "KP";
	$location = "LGK-KP"; 
	
	$from2 	= "Kuala Perlis";
	$to2 	= "Langkawi";
	$sfrom2	= "KP";
	$sto2 	= "LGK";
	$location2 = "KP-LGK";
} else {
	
	$from 	= "Kuala Perlis";
	$to 	= "Langkawi";
	$sfrom	= "KP";
	$sto 	= "LGK";
	$location = "KP-LGK";	
	
	$from2 	= "Langkawi";
	$to2 	= "Kuala Perlis";
	$sfrom2	= "LGK";
	$sto2 	= "KP";
	$location2 = "LGK-KP"; 
}

$enableButton = false;

// Get Rate Vechicle
$array = GetRate($con, $vehicle);
$vehicle_onewaycharge 	 	= $array[0];
$vehicle_roundtripcharge 	= $array[1];
$vehicle_onewayweb 			= $array[2];
$vehicle_roundtripbookingweb= $array[3];
if($trip == "return") {
	$vehicle_rate = $vehicle_roundtripbookingweb + $vehicle_roundtripcharge; 
}else {
	$vehicle_rate = $vehicle_onewayweb + $vehicle_onewaycharge ;
}

// Adult
$array = GetRate($con, 1);
$adult_onewaycharge 	= $array[0];
$adult_roundtripcharge 	= $array[1];
$adult_onewayweb 		= $array[2];
$adult_roundtripbookingweb= $array[3];
if($trip == "return") {
	$adult_rate = $adult_roundtripbookingweb + $adult_roundtripcharge; 
}else {
	$adult_rate = $adult_onewayweb + $adult_onewaycharge ;
}

// Child
$array = GetRate($con, 2);
$children_onewaycharge 	= $array[0];
$children_roundtripcharge 	= $array[1];
$children_onewayweb 		= $array[2];
$children_roundtripbookingweb= $array[3];
if($trip == "return") {
	$children_rate = $children_roundtripbookingweb + $children_roundtripcharge; 
}else {
	$children_rate = $children_onewayweb + $children_onewaycharge ;
}

// Senior
$array = GetRate($con, 3);
$senior_onewaycharge 	= $array[0];
$senior_roundtripcharge 	= $array[1];
$senior_onewayweb 		= $array[2];
$senior_roundtripbookingweb= $array[3];
if($trip == "return") {
	$senior_rate = $senior_roundtripbookingweb + $senior_roundtripcharge; 
}else {
	$senior_rate = $senior_onewayweb + $senior_onewaycharge ;
}

$rate_depart = $vehicle_rate + ($adult * $adult_rate) + ($children * $children_rate) + ($senior * $senior_rate);

if($trip == "return") 
	$rate_display = $rate_depart / 2;
else
	$rate_display = $rate_depart;


$depart_time 	= (isset($_POST['depart_time'])) ? trim($_POST['depart_time']) : '';
$arrival_time 	= (isset($_POST['arrival_time'])) ? trim($_POST['arrival_time']) : '';
$depart_time2 	= (isset($_POST['depart_time2'])) ? trim($_POST['depart_time2']) : '';
$arrival_time2 	= (isset($_POST['arrival_time2'])) ? trim($_POST['arrival_time2']) : '';	

// Fetch available dates
$available_dates_query = mysqli_query($con, "SELECT DISTINCT schedule_date FROM schedule WHERE schedule_date >= CURDATE() ORDER BY schedule_date");
$available_dates = [];
while($row = mysqli_fetch_assoc($available_dates_query)) {
    $available_dates[] = $row['schedule_date'];
}
$available_dates_json = json_encode($available_dates);
?>
<!DOCTYPE html>
<html>
<title>BLUEHAUL RORO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Barlow", sans-serif; font-weight: 500;}

body, html {
  height: 100%;
  line-height: 1.5;
}

a:link {
  text-decoration: none;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  background-attachment:fixed;
  background-image: url(images/banner.jpg);
  min-height:100%;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="booking-page">

<?PHP include("menu.php"); ?>


<div  >

<div class="w3-padding-64"></div>

<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container" style="max-width:1200px">
		<div class="w3-row">
			<div class="w3-col w3-center m4">
				<span class="w3-circle w3-xlarge w3-padding w3-black ">&nbsp;1&nbsp;</span>
				<div class="w3-padding w3-text-pink">Select Trip</div>	
			</div>
			<div class="w3-col w3-center m4">
				<span class="w3-circle w3-border w3-xlarge w3-padding">2</span>
				<div class="w3-padding ">Booking Details & Payment</div>	
			</div>
			<div class="w3-col w3-center m4">
				<span class="w3-circle w3-border w3-xlarge w3-padding">3</span>
				<div class="w3-padding ">Completed</div>	
			</div>
		</div>
	</div>
</div>

<hr>

<div class="w3-container w3-padding-16 w3-white" id="contact">
    <div class="w3-content w3-container" style="max-width:1400px">
		<div class="w3-padding w3-padding-16">
			<form action="" method="post">
			
				<div class="w3-row">
					<div class="w3-col m6 w3-padding">
						<label>From &nbsp;&nbsp; <i class="fas fa-long-arrow-alt-right"></i> &nbsp;&nbsp; To *</label>
						<select class="w3-select w3-border w3-round w3-padding" name="location"  required>
							<option value="LGK-KP" <?PHP if($location == "LGK-KP") echo "selected";?>>Langkawi - Kuala Perlis</option>
							<option value="KP-LGK" <?PHP if($location == "KP-LGK") echo "selected";?>>Kuala Perlis - Langkawi</option>
						</select>
					</div>
					
					<div class="w3-col m3 w3-padding">
  <label>Departure Date *</label>
  <input class="w3-input w3-border w3-round" type="text" id="depart_date" name="depart_date" value="<?PHP echo $depart_date;?>" required style="background-color: #fff;">
</div>

<div class="w3-col m3 w3-padding">
  <label>Return Date </label>
  <input class="w3-input w3-border w3-round" type="text" id="return_date" name="return_date" value="<?PHP echo $return_date;?>" style="background-color: #fff;">
</div>

					
				</div>
				
				
				
				<div class="w3-row">
					<div class="w3-col m6 w3-padding">
						<label>Vehicle *</label>
						<select class="w3-select w3-border w3-round w3-padding" name="vehicle" required>
							<option value="">- Select - </option>
						<?PHP 
						$rst = mysqli_query($con , "SELECT * FROM `fare` WHERE fareid > 4");
						while ($dat = mysqli_fetch_array($rst) )
						{
						?>
							<option value="<?PHP echo $dat["fareid"];?>" <?PHP if($vehicle == $dat["fareid"]) echo "selected";?>><?PHP echo $dat["category"];?></option>
						<?PHP } ?>
						</select>
					</div>
					
					<div class="w3-col m2 w3-padding">
						<label>Adult (12 years above)</label>
						<input class="w3-input w3-border w3-round" type="number" name="adult" value="<?PHP echo $adult;?>">
						<p class="w3-text-red">Note: Driver is not included</p>
					</div>
					
					<div class="w3-col m2 w3-padding">
						<label>Children (2-11 years)</label>
						<input class="w3-input w3-border w3-round" type="number" name="children" value="<?PHP echo $children;?>">
					</div>
					
					<div class="w3-col m2 w3-padding">
						<label>Senior (60 years above)</label>
						<input class="w3-input w3-border w3-round" type="number" name="senior" value="<?PHP echo $senior;?>">
					</div>
				</div>
				
				<div class="w3-row">
					<div class="w3-col m6 w3-padding">
						<input class="w3-radio" type="radio" name="trip" value="return" <?PHP if($trip == "return") echo "checked";?>>
						<label> Return</label>
						&nbsp;&nbsp;
						<input class="w3-radio" type="radio" name="trip" value="oneway" <?PHP if($trip == "oneway") echo "checked";?>>
						<label> One-Way</label>
					</div>
					<div class="w3-col m6 w3-padding">
						<button type="submit" class="w3-right w3-button w3-padding-large w3-black w3-margin-bottom w3-round"><b>SEARCH</b></button>
					</div>
				</div>
			
			</form>
			
		</div>		
    </div>
</div>


<div class="w3-container w3-padding-16 w3-light-gray" id="contact">
    <div class="w3-content w3-container" style="max-width:1400px">
		<div class="w3-padding ">
		
			<div class="w3-row">
				
				<?PHP
				$SQL_list 	= "SELECT * FROM `schedule` WHERE `location` = '$location' AND `schedule_date` = '$depart_date' ";
				$result 	= mysqli_query($con, $SQL_list) ;
				while ( $data	= mysqli_fetch_array($result) )
				{
					$schedule_date	= $data["schedule_date"];
					$schedule_date	=  date('D, d M Y',strtotime($schedule_date));
					
					$depart_time 	= $data["depart_time"];
					$arrival_time 	= $data["arrival_time"];
				?>	
				
				<div class="w3-col m6 w3-padding">
					
					<div class="w3-row w3-white w3-padding">
						<div class="w3-col m6"><?PHP echo $from; ?> <i class="fas fa-long-arrow-alt-right"></i> <?PHP echo $to; ?></div>
						<div class="w3-col m6"><div class="w3-right"><?PHP echo $schedule_date; ?></div></div>
					</div>
					
					<div class="w3-row w3-padding  w3-center">
						<div class="w3-col m4">Vessel</div>
						<div class="w3-col m4">Departure & Arrival</div>
						<div class="w3-col m4">Price</div>
					</div>
					
					<div class="w3-row w3-card w3-borderx w3-border-pink w3-white w3-padding w3-padding-32 w3-center" style="border-style: dashed; border-width: thin;">
						<div class="w3-col m4"><i class="fa fa-ship fa-3x"></i></div>
						<div class="w3-col m4">
							<div class="w3-row">
								<div class="w3-col s4"><?PHP echo $data["depart_time"]; ?><br><span class="w3-small w3-text-grey"><?PHP echo $sfrom; ?></span></div>
								<div class="w3-col s4"><i class="fas fa-long-arrow-alt-right"></i> </div>
								<div class="w3-col s4"><?PHP echo $data["arrival_time"]; ?><br><span class="w3-small w3-text-grey"><?PHP echo $sto; ?></span></div>
							</div>						
						</div>
						<div class="w3-col m4 w3-xlarge">RM <?PHP echo $rate_display;?></div>
					</div>
					
				</div>				
				<?PHP } ?>
				
				<?PHP if($trip == "return") { ?>
				<?PHP
				$SQL_list = "SELECT * FROM `schedule` WHERE `location` = '$location2' AND `schedule_date` = '$return_date' ";
				$result = mysqli_query($con, $SQL_list) ;
				while ( $data2	= mysqli_fetch_array($result) )
				{
					$schedule_date2	= $data2["schedule_date"];
					$schedule_date2	=  date('D, d M Y',strtotime($schedule_date2));
					
					$depart_time2 	= $data2["depart_time"];
					$arrival_time2 	= $data2["arrival_time"];
				?>
				<div class="w3-col m6 w3-padding">
					
					<div class="w3-row w3-white w3-padding">
						<div class="w3-col m6"><?PHP echo $to; ?> <i class="fas fa-long-arrow-alt-right"></i> <?PHP echo $from; ?></div>
						<div class="w3-col m6"><div class="w3-right"><?PHP echo $schedule_date2; ?></div></div>
					</div>
					
					<div class="w3-row w3-padding  w3-center">
						<div class="w3-col m4">Vessel</div>
						<div class="w3-col m4">Departure & Arrival</div>
						<div class="w3-col m4">Price</div>
					</div>
					
					<div class="w3-row w3-card w3-border-pink w3-white w3-padding w3-padding-32 w3-center" style="border-style: dashed; border-width: thin;">
						<div class="w3-col m4"><i class="fa fa-ship fa-3x"></i></div>
						<div class="w3-col m4">
							<div class="w3-row">
								<div class="w3-col s4"><?PHP echo $data2["depart_time"]; ?><br><span class="w3-small w3-text-grey"><?PHP echo $sto; ?></span></div>
								<div class="w3-col s4"><i class="fas fa-long-arrow-alt-right"></i> </div>
								<div class="w3-col s4"><?PHP echo $data2["arrival_time"]; ?><br><span class="w3-small w3-text-grey"><?PHP echo $sfrom; ?></span></div>
							</div>							
						</div>
						<div class="w3-col m4 w3-xlarge">RM <?PHP echo $rate_display;?></div>
					</div>
					
				</div>
				<?PHP } ?>
				<?PHP } ?>				
				
			</div>
		
		</div>
		<div class="w3-padding-24"></div>		
    </div>
</div>


</div>

<?PHP include 'footer.php'; ?>

<?PHP if($vehicle) { ?>
<div class="w3-bottom w3-card w3-white w3-padding w3-padding-32">
	<div class="w3-row">
		<form action="book2.php" method="post">
		<div class="w3-col m4 w3-center w3-hide-small">
			<div class="w3-row w3-padding w3-border-right">
				<div class="w3-col m4"><i class="fa fa-ship fa-2x"></i></div>
				<div class="w3-col m4">
					<div class="w3-row">
						<div class="w3-col s4"><?PHP echo $depart_time;?><br><span class="w3-small w3-text-grey"><?PHP echo $sfrom; ?></span></div>
						<div class="w3-col s4"><i class="fas fa-long-arrow-alt-right"></i> </div>
						<div class="w3-col s4"><?PHP echo $arrival_time;?><br><span class="w3-small w3-text-grey"><?PHP echo $sto; ?></span></div>
					</div>							
				</div>
				<div class="w3-col m4 w3-xlarge">RM <?PHP echo $rate_display;?></div>
			</div>
		</div>
		<?PHP if($trip == "return") { ?>
		<div class="w3-col m4 w3-center w3-hide-small">
			<div class="w3-row w3-padding w3-border-right">
				<div class="w3-col m4"><i class="fa fa-ship fa-2x"></i></div>
				<div class="w3-col m4">
					<div class="w3-row">
						<div class="w3-col s4"><?PHP echo $depart_time2;?><br><span class="w3-small w3-text-grey"><?PHP echo $sto; ?></span></div>
						<div class="w3-col s4"><i class="fas fa-long-arrow-alt-right"></i> </div>
						<div class="w3-col s4"><?PHP echo $arrival_time2;?><br><span class="w3-small w3-text-grey"><?PHP echo $sfrom; ?></span></div>
					</div>							
				</div>
				<div class="w3-col m4 w3-xlarge">RM <?PHP echo $rate_display;?></div>
			</div>
		</div>
		<?PHP } ?>
<?PHP
if($trip == "return") 
{
	if(($depart_time <> "")&&($depart_time2 <> ""))
		$enableButton = true;
	else
		$enableButton = false;
} else {
	if($depart_time <> "")	
		$enableButton = true;
	else 
		$enableButton = false;
}
?>		
		<div class="w3-col m4 w3-large w3-center">
			<input type="hidden" name="trip" value="<?PHP echo $trip;?>">
			<input type="hidden" name="location" value="<?PHP echo $location;?>">
			<input type="hidden" name="depart_date" value="<?PHP echo $depart_date;?>">
			<input type="hidden" name="return_date" value="<?PHP echo $return_date;?>">
			<input type="hidden" name="vehicle" value="<?PHP echo $vehicle;?>">
			<input type="hidden" name="adult" value="<?PHP echo $adult;?>">
			<input type="hidden" name="children" value="<?PHP echo $children;?>">
			<input type="hidden" name="senior" value="<?PHP echo $senior;?>">
			<input type="hidden" name="total" value="<?PHP echo $rate_depart;?>">
			<input type="hidden" name="depart_time" value="<?PHP echo $depart_time;?>">
			<input type="hidden" name="arrival_time" value="<?PHP echo $arrival_time;?>">
			<input type="hidden" name="depart_time2" value="<?PHP echo $depart_time2;?>">
			<input type="hidden" name="arrival_time2" value="<?PHP echo $arrival_time2;?>">			
			<input type="hidden" name="rate_display" value="<?PHP echo $rate_display;?>">			
			<input type="hidden" name="rate_depart" value="<?PHP echo $rate_depart;?>">			
			<span class="w3-margin-right">Grand Total : <b class="w3-xlarge">RM <?PHP echo $rate_depart;?></b></span>	
			<?PHP if($enableButton) { ?>
			<button type="submit" class="w3-button w3-black w3-round">BOOK NOW</button>
			<?PHP } else { ?>
			<button type="button" class="w3-disabled w3-button w3-black w3-round">NOT AVAILABLE</button>
			<?PHP } ?>
		</div>
		</form>
	</div>
</div>
<?PHP } ?>
 
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    var availableDates = <?php echo $available_dates_json; ?>;
    
    var departPicker = flatpickr("#depart_date", {
        enable: availableDates,
        dateFormat: "Y-m-d",
        disableMobile: true,
        onChange: function(selectedDates, dateStr, instance) {
            // Ensure return date is not before departure date
            returnPicker.set("minDate", dateStr);
        }
    });

    var returnPicker = flatpickr("#return_date", {
        enable: availableDates,
        dateFormat: "Y-m-d",
        disableMobile: true,
        minDate: "<?php echo ($depart_date) ? $depart_date : 'today'; ?>"
    });
</script>

</body>
</html>
