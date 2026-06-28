<?PHP
session_start();
include("database.php");

$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';



for ($i = 1; $i <= 3; $i++) {
        //$name = $conn->real_escape_string($_POST['name' . $i]);
        //$gender = $conn->real_escape_string($_POST['gender' . $i]);
		
		$name = $_POST['ad_name' . $i];
        $ic = $_POST['ad_ic' . $i];

        // Insert values into MySQL
        $sql = "INSERT INTO your_table_name (name, ic) VALUES ('$name', '$ic')";

echo $sql;
echo "<br>";



    }
	
exit;

$discount_amount =
    (isset($_POST['discount_amount']))
    ? $_POST['discount_amount']
    : 0;

$final_total =
    (isset($_POST['final_total']))
    ? $_POST['final_total']
    : $total;

$trip 			= (isset($_POST['trip'])) ? trim($_POST['trip']) : 'return';
$location 		= (isset($_POST['location'])) ? trim($_POST['location']) : 'LGK-KP';
$depart_date	= (isset($_POST['depart_date'])) ? trim($_POST['depart_date']) : '';
$return_date	= (isset($_POST['return_date'])) ? trim($_POST['return_date']) : '';
$vehicle 		= (isset($_POST['vehicle'])) ? trim($_POST['vehicle']) : '0';
$adult 			= (isset($_POST['adult'])) ? trim($_POST['adult']) : '0';
$children 		= (isset($_POST['children'])) ? trim($_POST['children']) : '0';
$senior 		= (isset($_POST['senior'])) ? trim($_POST['senior']) : '0';
$total 			= (isset($_POST['total'])) ? trim($_POST['total']) : '0';
$coupon_code = trim($_POST['coupon_code'] ?? '');

$depart_time 	= (isset($_POST['depart_time'])) ? trim($_POST['depart_time']) : '';
$arrival_time 	= (isset($_POST['arrival_time'])) ? trim($_POST['arrival_time']) : '';
$depart_time2 	= (isset($_POST['depart_time2'])) ? trim($_POST['depart_time2']) : '';
$arrival_time2 	= (isset($_POST['arrival_time2'])) ? trim($_POST['arrival_time2']) : '';

$vehicle_brand 	= (isset($_POST['vehicle_brand'])) ? trim($_POST['vehicle_brand']) : '';
$vehicle_model 	= (isset($_POST['vehicle_model'])) ? trim($_POST['vehicle_model']) : '';
$registration_no= (isset($_POST['registration_no'])) ? trim($_POST['registration_no']) : '';
$chassis_no 	= (isset($_POST['chassis_no'])) ? trim($_POST['chassis_no']) : '';

$driver_name 	= (isset($_POST['driver_name'])) ? trim($_POST['driver_name']) : '';
$driver_phone 	= (isset($_POST['driver_phone'])) ? trim($_POST['driver_phone']) : '';
$driver_gender 	= (isset($_POST['driver_gender'])) ? trim($_POST['driver_gender']) : '';
$driver_id 		= (isset($_POST['driver_id'])) ? trim($_POST['driver_id']) : '';

if(!empty($coupon_code))
{
    $today = date("Y-m-d");

    $SQL_coupon = "
    SELECT *
    FROM promotion
    WHERE coupon_code = '$coupon_code'
    AND status = 'Active'
    AND start_date <= '$today'
    AND expiry_date >= '$today'
    ";

    $result_coupon = mysqli_query($con,$SQL_coupon);

    if(mysqli_num_rows($result_coupon) > 0)
    {
        $promo = mysqli_fetch_assoc($result_coupon);

        if($total >= $promo['minimum_purchase'])
        {
            if($promo['discount_type'] == 'Percentage')
            {
                $discount_amount =
                    ($total * $promo['discount_value']) / 100;

                if($discount_amount >
                   $promo['maximum_discount'])
                {
                    $discount_amount =
                    $promo['maximum_discount'];
                }
            }
            else
            {
                $discount_amount =
                $promo['discount_value'];
            }

            $final_total =
            $total - $discount_amount;
        }
    }
}

if($location == "LGK-KP") {
	$from 	= "Langkawi";
	$to 	= "Kuala Perlis";
	$sfrom	= "LGK";
	$sto 	= "KP";
	$location2 = "KP-LGK"; 
} else {
	$from2 	= "Kuala Perlis";
	$to2 	= "Langkawi";
	$sfrom2	= "KP";
	$sto2 	= "LGK";
	$location2 = "LGK-KP";
}

$vehicle_name = GetVehicle($con, $vehicle);

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

if($trip == "return") {
	$rate_display = $rate_depart / 2;
	$vehicle_rate_display = $vehicle_rate / 2;
	$adult_rate_display = $adult_rate / 2;
	$children_rate_display = $children_rate / 2;
	$senior_rate_display = $senior_rate / 2;
} else {
	$rate_display = $rate_depart;
	$vehicle_rate_display = $vehicle_rate;
	$adult_rate_display = $adult_rate;
	$children_rate_display = $children_rate;
	$senior_rate_display = $senior_rate;
}
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

<body class="">

<?PHP include("menu.php"); ?>


<div  >

<div class="w3-padding-64"></div>

<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container" style="max-width:1200px">
		<div class="w3-row">
			<div class="w3-col w3-center m3">
				<span class="w3-circle w3-border w3-xlarge w3-padding">&nbsp;1&nbsp;</span>
				<div class="w3-padding ">Select Trip</div>	
			</div>
			<div class="w3-col w3-center m3">
				<span class="w3-circle w3-border w3-xlarge w3-padding">2</span>
				<div class="w3-padding">Passenger & Vehicle Details</div>	
			</div>
			<div class="w3-col w3-center m3">
				<span class="w3-circle w3-border w3-xlarge w3-padding w3-black">3</span>
				<div class="w3-padding w3-text-pink">Payment</div>	
			</div>
			<div class="w3-col w3-center m3">
				<span class="w3-circle w3-border w3-xlarge w3-padding">4</span>
				<div class="w3-padding ">Confirm</div>	
			</div>
		</div>
	</div>
</div>

<hr>

<div class="w3-container w3-padding-16 w3-white" id="contact">
    <div class="w3-content w3-container" style="max-width:1000px">
		<div class="w3-padding w3-padding-16">
			<form action="book3.php" method="post">
			
				<div class="w3-row">
				
					<div class="w3-col m6 w3-padding">
						
						<div class="w3-card w3-round-large w3-padding w3-padding-16">
							<b class="w3-large">Passenger Detail</b>
							<?PHP 
							foreach ($Adult_name as $adult_n)
							{
								echo $adult_n;
							}
							?>
							
						</div>
					</div>
					
					
					<div class="w3-col m6 w3-padding">
						
						<div class="w3-card w3-round-large w3-padding w3-padding-16">
							<b class="w3-large">Booking Summary</b>
							<hr>
							Depart Details<br>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Driver (1 X RM0.00)
								</div>
								<div class="w3-col s2">
								RM0.00
								</div>
							</div>							
							<div class="w3-row">
								<div class="w3-col s10">
								<?PHP echo $vehicle_name;?> (1 X RM<?PHP echo $vehicle_rate_display;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo $vehicle_rate_display;?>
								</div>
							</div>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Adult (<?PHP echo $adult;?> X RM<?PHP echo $adult_rate_display;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo ($adult * $adult_rate_display);?>
								</div>
							</div>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Children (<?PHP echo $children;?> X RM<?PHP echo $children_rate_display;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo ($children * $children_rate_display);?>
								</div>
							</div>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Senior (<?PHP echo $senior;?> X RM<?PHP echo $senior_rate_display;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo ($senior * $senior_rate_display);?>
								</div>
							</div>
							
							<?PHP if($trip == "return") { ?>
							<div class="w3-padding"></div>
							
							Return  Details<br>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Driver (1 X RM0.00)
								</div>
								<div class="w3-col s2">
								RM0.00
								</div>
							</div>							
							<div class="w3-row">
								<div class="w3-col s10">
								<?PHP echo $vehicle_name;?> (1 X RM<?PHP echo $vehicle_rate_display;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo $vehicle_rate_display;?>
								</div>
							</div>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Adult (<?PHP echo $adult;?> X RM<?PHP echo $adult_rate;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo ($adult * $adult_rate);?>
								</div>
							</div>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Children (<?PHP echo $children;?> X RM<?PHP echo $children_rate;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo ($children * $children_rate);?>
								</div>
							</div>
							<div class="w3-row">
								<div class="w3-col s10">
								Passenger - Senior (<?PHP echo $senior;?> X RM<?PHP echo $senior_rate;?>)
								</div>
								<div class="w3-col s2">
								RM<?PHP echo ($senior * $senior_rate);?>
								</div>
							</div>
							<?PHP } ?>
							
							<div class="w3-padding"></div>

							<div class="w3-row">
								<div class="w3-col s10">
								<b>Grand Total:</b>
								</div>
								<div class="w3-col s2">
								<b>RM<?PHP echo number_format($final_total,2);?></b>
								</div>
							</div>

						</div>
						
					</div>
				</div>
				
				
				<input type="hidden" name="trip" value="<?PHP echo $trip;?>">
				<input type="hidden" name="location" value="<?PHP echo $location;?>">
				<input type="hidden" name="depart_date" value="<?PHP echo $depart_date;?>">
				<input type="hidden" name="return_date" value="<?PHP echo $return_date;?>">
				<input type="hidden" name="vehicle" value="<?PHP echo $vehicle;?>">
				<input type="hidden" name="adult" value="<?PHP echo $adult;?>">
				<input type="hidden" name="children" value="<?PHP echo $children;?>">
				<input type="hidden" name="senior" value="<?PHP echo $senior;?>">
				<input type="hidden" name="total" value="<?PHP echo $total;?>">
				<input type="hidden" name="depart_time" value="<?PHP echo $depart_time;?>">
				<input type="hidden" name="arrival_time" value="<?PHP echo $arrival_time;?>">
				<input type="hidden" name="depart_time2" value="<?PHP echo $depart_time2;?>">
				<input type="hidden" name="arrival_time2" value="<?PHP echo $arrival_time2;?>">			
				<input type="hidden" name="rate_display" value="<?PHP echo $rate_display;?>">			
				<input type="hidden" name="rate_depart" value="<?PHP echo $rate_depart;?>">	
				<input type="hidden" name="act" value="add" >
				
				<div class="w3-center"><button type="submit" class="w3-button w3-black w3-round">SUBMIT PAYMENT</button></div>
			</form>
			
		</div>		
    </div>
</div>




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
