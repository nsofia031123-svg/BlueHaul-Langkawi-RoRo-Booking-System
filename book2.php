<?PHP
session_start();
include("database.php");

$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$trip = (isset($_POST['trip'])) ? trim($_POST['trip']) : 'return';
$location = (isset($_POST['location'])) ? trim($_POST['location']) : 'LGK-KP';
$depart_date = (isset($_POST['depart_date'])) ? trim($_POST['depart_date']) : '';
$return_date = (isset($_POST['return_date'])) ? trim($_POST['return_date']) : '';
$vehicle = (isset($_POST['vehicle'])) ? trim($_POST['vehicle']) : '0';
$adult = (isset($_POST['adult'])) ? trim($_POST['adult']) : '0';
$children = (isset($_POST['children'])) ? trim($_POST['children']) : '0';
$senior = (isset($_POST['senior'])) ? trim($_POST['senior']) : '0';
$total = (isset($_POST['total'])) ? trim($_POST['total']) : '0';
$coupon_code = trim($_POST['coupon_code'] ?? '');
$discount_amount = 0;
$final_total = $total;




$depart_time = (isset($_POST['depart_time'])) ? trim($_POST['depart_time']) : '';
$arrival_time = (isset($_POST['arrival_time'])) ? trim($_POST['arrival_time']) : '';
$depart_time2 = (isset($_POST['depart_time2'])) ? trim($_POST['depart_time2']) : '';
$arrival_time2 = (isset($_POST['arrival_time2'])) ? trim($_POST['arrival_time2']) : '';

$vehicle_brand = (isset($_POST['vehicle_brand'])) ? trim($_POST['vehicle_brand']) : '';
$vehicle_model = (isset($_POST['vehicle_model'])) ? trim($_POST['vehicle_model']) : '';
$registration_no = (isset($_POST['registration_no'])) ? trim($_POST['registration_no']) : '';
$chassis_no = (isset($_POST['chassis_no'])) ? trim($_POST['chassis_no']) : '';

$driver_name = (isset($_POST['driver_name'])) ? trim($_POST['driver_name']) : '';
$driver_phone = (isset($_POST['driver_phone'])) ? trim($_POST['driver_phone']) : '';
$driver_gender = (isset($_POST['driver_gender'])) ? trim($_POST['driver_gender']) : '';
$driver_id = (isset($_POST['driver_id'])) ? trim($_POST['driver_id']) : '';

if ($location == "LGK-KP") {
	$from = "Langkawi";
	$to = "Kuala Perlis";
	$sfrom = "LGK";
	$sto = "KP";
	$location = "LGK-KP";

	$from2 = "Kuala Perlis";
	$to2 = "Langkawi";
	$sfrom2 = "KP";
	$sto2 = "LGK";
	$location2 = "KP-LGK";
} else {

	$from = "Kuala Perlis";
	$to = "Langkawi";
	$sfrom = "KP";
	$sto = "LGK";
	$location = "KP-LGK";

	$from2 = "Langkawi";
	$to2 = "Kuala Perlis";
	$sfrom2 = "LGK";
	$sto2 = "KP";
	$location2 = "LGK-KP";
}

$vehicle_name = GetVehicle($con, $vehicle);

// Get Rate Vechicle
$array = GetRate($con, $vehicle);
$vehicle_onewaycharge = $array[0];
$vehicle_roundtripcharge = $array[1];
$vehicle_onewayweb = $array[2];
$vehicle_roundtripbookingweb = $array[3];
if ($trip == "return") {
	$vehicle_rate = $vehicle_roundtripbookingweb + $vehicle_roundtripcharge;
} else {
	$vehicle_rate = $vehicle_onewayweb + $vehicle_onewaycharge;
}

// Adult
$array = GetRate($con, 1);
$adult_onewaycharge = $array[0];
$adult_roundtripcharge = $array[1];
$adult_onewayweb = $array[2];
$adult_roundtripbookingweb = $array[3];
if ($trip == "return") {
	$adult_rate = $adult_roundtripbookingweb + $adult_roundtripcharge;
} else {
	$adult_rate = $adult_onewayweb + $adult_onewaycharge;
}

// Child
$array = GetRate($con, 2);
$children_onewaycharge = $array[0];
$children_roundtripcharge = $array[1];
$children_onewayweb = $array[2];
$children_roundtripbookingweb = $array[3];
if ($trip == "return") {
	$children_rate = $children_roundtripbookingweb + $children_roundtripcharge;
} else {
	$children_rate = $children_onewayweb + $children_onewaycharge;
}

// Senior
$array = GetRate($con, 3);
$senior_onewaycharge = $array[0];
$senior_roundtripcharge = $array[1];
$senior_onewayweb = $array[2];
$senior_roundtripbookingweb = $array[3];
if ($trip == "return") {
	$senior_rate = $senior_roundtripbookingweb + $senior_roundtripcharge;
} else {
	$senior_rate = $senior_onewayweb + $senior_onewaycharge;
}

$rate_depart = $vehicle_rate + ($adult * $adult_rate) + ($children * $children_rate) + ($senior * $senior_rate);

if ($trip == "return") {
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

$total = $rate_depart;
$final_total = $total;
$discount_amount = 0;

$promo_error = "";
if (!empty($coupon_code)) {
	$today = date("Y-m-d");

	$promo_sql = mysqli_query($con, "
        SELECT *
        FROM promotion
        WHERE coupon_code='$coupon_code'
        AND status='Active'
        AND start_date <= '$today'
        AND expiry_date >= '$today'
        LIMIT 1
    ");

	if (mysqli_num_rows($promo_sql) > 0) {
		$promo = mysqli_fetch_assoc($promo_sql);

		if ($total >= $promo['minimum_purchase']) {
			if ($promo['discount_type'] == 'Percentage') {
				$discount_amount = ($total * $promo['discount_value']) / 100;

				if ($discount_amount > $promo['maximum_discount']) {
					$discount_amount = $promo['maximum_discount'];
				}
			} else {
				$discount_amount = $promo['discount_value'];
			}
			$final_total = $total - $discount_amount;
		} else {
			$promo_error = "Minimum purchase for this promo is RM" . number_format($promo['minimum_purchase'], 2);
		}
	} else {
		$promo_error = "Invalid or expired promotion code.";
	}
}
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
		line-height: 1.5;
	}

	a:link {
		text-decoration: none;
	}

	/* Full height image header */
	.bgimg-1 {
		background-position: top;
		background-size: cover;
		background-attachment: fixed;
		background-image: url(images/banner.jpg);
		min-height: 100%;
	}

	.w3-bar .w3-button {
		padding: 16px;
	}
</style>

<body class="">

	<?PHP include("menu.php"); ?>


	<div>

		<div class="w3-padding-64"></div>

		<div class="w3-container w3-padding-16" id="contact">
			<div class="w3-content w3-container" style="max-width:1200px">
				<div class="w3-row">
					<div class="w3-col w3-center m4">
						<span class="w3-circle w3-border w3-xlarge w3-padding">&nbsp;1&nbsp;</span>
						<div class="w3-padding ">Select Trip</div>
					</div>
					<div class="w3-col w3-center m4">
						<span class="w3-circle w3-border w3-xlarge w3-padding w3-black ">2</span>
						<div class="w3-padding w3-text-pink">Booking Details & Payment</div>
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
							<div class="w3-col m8 w3-padding">
								<div class="w3-card w3-round-large w3-padding w3-padding-16">
									<b class="w3-large">Trip Details (Depart)</b>
									<hr>
									<div class="w3-row w3-padding w3-center">
										<div class="w3-col m2"><i class="fa fa-ship fa-3x"></i></div>
										<div class="w3-col m10">
											<div class="w3-row">
												<div class="w3-col s4"><b
														class="w3-large"><?PHP echo $sfrom; ?></b><br><span
														class="w3-text-grey"><?PHP echo $depart_time; ?></span><br><span
														class="w3-text-grey"><?PHP echo $depart_date; ?></span></div>
												<div class="w3-col s4"><i class="fas fa-long-arrow-alt-right"></i>
												</div>
												<div class="w3-col s4"><b
														class="w3-large"><?PHP echo $sto; ?></b><br><span
														class="w3-text-grey"><?PHP echo $arrival_time; ?></span><br><span
														class="w3-text-grey"><?PHP echo $depart_date; ?></span></div>
											</div>
										</div>
									</div>
								</div>

								<?PHP if ($trip == "return") { ?>
									<div class="w3-padding"></div>

									<div class="w3-card w3-round-large w3-padding w3-padding-16">
										<b class="w3-large">Trip Details (Return)</b>
										<hr>
										<div class="w3-row w3-padding w3-center">
											<div class="w3-col m2"><i class="fa fa-ship fa-3x"></i></div>
											<div class="w3-col m10">
												<div class="w3-row">
													<div class="w3-col s4"><b
															class="w3-large"><?PHP echo $sto; ?></b><br><span
															class="w3-text-grey"><?PHP echo $depart_time2; ?></span><br><span
															class="w3-text-grey"><?PHP echo $return_date; ?></span></div>
													<div class="w3-col s4"><i class="fas fa-long-arrow-alt-right"></i>
													</div>
													<div class="w3-col s4"><b
															class="w3-large"><?PHP echo $sfrom; ?></b><br><span
															class="w3-text-grey"><?PHP echo $arrival_time2; ?></span><br><span
															class="w3-text-grey"><?PHP echo $return_date; ?></span></div>
												</div>
											</div>
										</div>
									</div>
								<?PHP } ?>

								<div class="w3-padding"></div>

								<div class="w3-card w3-round-large w3-padding w3-padding-16">
									<b class="w3-large">Vehicle Details</b>
									<hr>
									<div class="w3-row">
										<div class="w3-col m6 w3-padding">
											<label>Vehicle Brand</label>
											<input class="w3-input w3-border w3-round" type="text" name="vehicle_brand"
												value="" required>
										</div>

										<div class="w3-col m6 w3-padding">
											<label>Vehicle Model</label>
											<input class="w3-input w3-border w3-round" type="text" name="vehicle_model"
												value="" required>
										</div>
									</div>

									<div class="w3-row">
										<div class="w3-col m6 w3-padding">
											<label>Registration No</label>
											<input class="w3-input w3-border w3-round" type="text"
												name="registration_no" value="" required>
										</div>

										<div class="w3-col m6 w3-padding">
											<label>Chassis No</label>
											<input class="w3-input w3-border w3-round" type="text" name="chassis_no"
												value="" required>
										</div>
									</div>

									<div class="w3-row">
										<div class="w3-col m6 w3-padding">
											<label>Registration Card</label>
											<input class="w3-input w3-border w3-round" type="file"
												name="registration_card" value="">
											<small class="form-text text-muted">(Surat Pendaftaran Kereta)</small>
										</div>
									</div>

									<hr>

									<div class="w3-text-red w3-padding">Notes: All rental cars are NOT allowed for ferry
										crossing. We do not accept ferry booking for the hire car. You shall not be
										entitled to a refund if we do not proceed with your ferry booking.</div>

								</div>


								<div class="w3-padding"></div>

								<div class="w3-card w3-round-large w3-padding w3-padding-16">
									<b class="w3-large">Driver Details</b>
									<hr>

									<div class="w3-row">
										<div class="w3-col m12 w3-padding">
											<label>Name</label>
											<input class="w3-input w3-border w3-round" type="text" name="driver_name"
												value="" required>
										</div>

									</div>

									<div class="w3-row">
										<div class="w3-col m6 w3-padding">
											<label>Phone No</label>
											<input class="w3-input w3-border w3-round" type="number" name="driver_phone"
												value="" maxlength="12" required>
										</div>


										<div class="w3-col m6 w3-padding">
											<label>Gender</label>
											<select class="w3-input w3-border w3-round" name="driver_gender" value=""
												required>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
									</div>

									<div class="w3-row">
										<div class="w3-col m6 w3-padding">
											<label>Identification No </label>
											<input class="w3-input w3-border w3-round" type="text" name="driver_id"
												value="" maxlength="12" pattern="[0-9]{12}"
												oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>

										</div>

										<div class="w3-col m6 w3-padding">
											<label>Identification Card</label>
											<input class="w3-input w3-border w3-round" type="file" name="driver_card"
												value="">
										</div>
									</div>
								</div>


								<div class="w3-padding"></div>

								<div class="w3-card w3-round-large w3-padding w3-padding-16">
									<b class="w3-large">Passenger Details</b>
									<hr>

									<?PHP for ($bil = 1; $bil <= $adult; $bil++) { ?>
										<b class="w3-padding w3-large">Adult (<?PHP echo $bil; ?>)</b>
										<div class="w3-row">
											<div class="w3-col m6 w3-padding">
												<label>Name</label>
												<input class="w3-input w3-border w3-round" type="text"
													name="ad_name<?PHP echo $bil; ?>" value="" required>
											</div>

											<div class="w3-col m6 w3-padding">
												<label>Identification No </label>
												<input class="w3-input w3-border w3-round" type="text"
													name="ad_ic<?PHP echo $bil; ?>" value="" required>
											</div>
										</div>
										<hr>
									<?PHP } ?>

									<?PHP for ($bil = 1; $bil <= $children; $bil++) { ?>
										<b class="w3-padding w3-large">Children (<?PHP echo $bil; ?>)</b>
										<div class="w3-row">
											<div class="w3-col m6 w3-padding">
												<label>Name</label>
												<input class="w3-input w3-border w3-round" type="text"
													name="ch_name<?PHP echo $bil; ?>" value="" required>
											</div>

											<div class="w3-col m6 w3-padding">
												<label>Identification No </label>
												<input class="w3-input w3-border w3-round" type="text"
													name="ch_ic<?PHP echo $bil; ?>" value="" required>
											</div>
										</div>
										<hr>
									<?PHP } ?>

									<?PHP for ($bil = 1; $bil <= $senior; $bil++) { ?>
										<b class="w3-padding w3-large">Senior (<?PHP echo $bil; ?>)</b>
										<div class="w3-row">
											<div class="w3-col m6 w3-padding">
												<label>Name</label>
												<input class="w3-input w3-border w3-round" type="text"
													name="sn_name<?PHP echo $bil; ?>" value="" required>
											</div>

											<div class="w3-col m6 w3-padding">
												<label>Identification No </label>
												<input class="w3-input w3-border w3-round" type="text"
													name="sn_ic<?PHP echo $bil; ?>" value="" required>
											</div>
										</div>
										<hr>
									<?PHP } ?>



								</div>


								<div class="w3-padding"></div>

								<div class="w3-card w3-round-large w3-padding w3-padding-16">
									<b class="w3-large">Consent</b>
									<hr>
									<div class="w3-row w3-padding ">
										<div class="w3-row">
											<div class="w3-col s1"><i class="fa fa-check-square"></i></div>
											<div class="w3-col s11">All customers need to collect the custom forms from
												the Langkawi office / Kuala Perlis office on the departure day and to
												check in at the Langkawi Port / Kuala Perlis Port at least 1 hour before
												departure time. The custom gate will be closed 20 minutes before
												departure. We will not be responsible if you are late for your check in
												and your entrance is rejected by the custom.</div>

											<div class="w3-col s1"><i class="fa fa-check-square"></i></div>
											<div class="w3-col s11">No booking cancellation is allowed. All bookings are
												FINAL and NON- REFUNDABLE.</div>

											<div class="w3-col s1"><i class="fa fa-check-square"></i></div>
											<div class="w3-col s11"><b>We shall not be liable for any loss of or damage,
													injury or delay to the vehicle, luggage or goods nor for any
													consequential damage howsoever caused during loading or
													discharge.</b></div>

											<div class="w3-col s1"><i class="fa fa-check-square"></i></div>
											<div class="w3-col s11">I acknowledge that I have read, understand, and
												agree to the policies and procedures above.</div>
										</div>
									</div>
								</div>



							</div>

							<div class="w3-col m4 w3-padding">
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
											<?PHP echo $vehicle_name; ?> (1 X RM<?PHP echo $vehicle_rate_display; ?>)
										</div>
										<div class="w3-col s2">
											RM<?PHP echo $vehicle_rate_display; ?>
										</div>
									</div>
									<div class="w3-row">
										<div class="w3-col s10">
											Passenger - Adult (<?PHP echo $adult; ?> X
											RM<?PHP echo $adult_rate_display; ?>)
										</div>
										<div class="w3-col s2">
											RM<?PHP echo ($adult * $adult_rate_display); ?>
										</div>
									</div>
									<div class="w3-row">
										<div class="w3-col s10">
											Passenger - Children (<?PHP echo $children; ?> X
											RM<?PHP echo $children_rate_display; ?>)
										</div>
										<div class="w3-col s2">
											RM<?PHP echo ($children * $children_rate_display); ?>
										</div>
									</div>
									<div class="w3-row">
										<div class="w3-col s10">
											Passenger - Senior (<?PHP echo $senior; ?> X
											RM<?PHP echo $senior_rate_display; ?>)
										</div>
										<div class="w3-col s2">
											RM<?PHP echo ($senior * $senior_rate_display); ?>
										</div>
									</div>

									<?PHP if ($trip == "return") { ?>
										<div class="w3-padding"></div>

										Return Details<br>
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
												<?PHP echo $vehicle_name; ?> (1 X RM<?PHP echo $vehicle_rate_display; ?>)
											</div>
											<div class="w3-col s2">
												RM<?PHP echo $vehicle_rate_display; ?>
											</div>
										</div>
										<div class="w3-row">
											<div class="w3-col s10">
												Passenger - Adult (<?PHP echo $adult; ?> X RM<?PHP echo $adult_rate; ?>)
											</div>
											<div class="w3-col s2">
												RM<?PHP echo ($adult * $adult_rate); ?>
											</div>
										</div>
										<div class="w3-row">
											<div class="w3-col s10">
												Passenger - Children (<?PHP echo $children; ?> X
												RM<?PHP echo $children_rate; ?>)
											</div>
											<div class="w3-col s2">
												RM<?PHP echo ($children * $children_rate); ?>
											</div>
										</div>
										<div class="w3-row">
											<div class="w3-col s10">
												Passenger - Senior (<?PHP echo $senior; ?> X RM<?PHP echo $senior_rate; ?>)
											</div>
											<div class="w3-col s2">
												RM<?PHP echo ($senior * $senior_rate); ?>
											</div>
										</div>
									<?PHP } ?>

									<hr>

									<hr>

									<?php
									$promo = mysqli_query($con, "
									SELECT *
									FROM promotion
									WHERE status='Active'
									AND CURDATE() BETWEEN start_date AND expiry_date
									");
									?>

									<div class="w3-padding">
										<label><b>Promotion Code</b></label>

										<select name="coupon_code" class="w3-input w3-border w3-round"
											onchange="this.form.submit()">


											<option value="">-- Select Promotion --</option>

											<?php while ($row = mysqli_fetch_assoc($promo)) { ?>

												<option value="<?php echo $row['coupon_code']; ?>" <?php if ($coupon_code == $row['coupon_code'])
													   echo 'selected'; ?>>

													<?php echo $row['coupon_code']; ?>
													(<?php echo $row['discount_value']; ?>
													<?php echo $row['discount_type']; ?>)

												</option>

											<?php } ?>

										</select>
										<?php if (!empty($promo_error)) { ?>
											<div class="w3-text-red w3-small w3-margin-top"><?php echo $promo_error; ?>
											</div>
										<?php } ?>
									</div>

									<hr>



									<div class="w3-padding"></div>

									<hr>

									<div class="w3-row">
										<div class="w3-col s10">
											Subtotal
										</div>
										<div class="w3-col s2">
											RM<?php echo number_format($total, 2); ?>
										</div>
									</div>

									<?php if ($discount_amount > 0) { ?>
										<div class="w3-row">
											<div class="w3-col s10">
												Promotion Discount
											</div>
											<div class="w3-col s2">
												-RM<?php echo number_format($discount_amount, 2); ?>
											</div>
										</div>
									<?php } ?>

									<hr>

									<div class="w3-row">
										<div class="w3-col s10">
											<b>Grand Total</b>
										</div>
										<div class="w3-col s2">
											<b>RM<?php echo number_format($final_total, 2); ?></b>
										</div>
									</div>
								</div>
							</div>
						</div>

				</div>
			</div>
		</div>

		<input type="hidden" name="trip" value="<?PHP echo $trip; ?>">
		<input type="hidden" name="location" value="<?PHP echo $location; ?>">
		<input type="hidden" name="depart_date" value="<?PHP echo $depart_date; ?>">
		<input type="hidden" name="return_date" value="<?PHP echo $return_date; ?>">
		<input type="hidden" name="vehicle" value="<?PHP echo $vehicle; ?>">
		<input type="hidden" name="adult" value="<?PHP echo $adult; ?>">
		<input type="hidden" name="children" value="<?PHP echo $children; ?>">
		<input type="hidden" name="senior" value="<?PHP echo $senior; ?>">
		<input type="hidden" name="total" value="<?PHP echo $rate_depart; ?>">
		<input type="hidden" name="depart_time" value="<?PHP echo $depart_time; ?>">
		<input type="hidden" name="arrival_time" value="<?PHP echo $arrival_time; ?>">
		<input type="hidden" name="depart_time2" value="<?PHP echo $depart_time2; ?>">
		<input type="hidden" name="arrival_time2" value="<?PHP echo $arrival_time2; ?>">
		<input type="hidden" name="rate_display" value="<?PHP echo $rate_display; ?>">
		<input type="hidden" name="rate_depart" value="<?PHP echo $rate_depart; ?>">
		<!-- <input type="hidden" name="act" value="add"> -->
		<input type="hidden" name="trip" value="<?PHP echo $trip; ?>">
		<input type="hidden" name="location" value="<?PHP echo $location; ?>">
		<input type="hidden" name="depart_date" value="<?PHP echo $depart_date; ?>">



		<div class="w3-center"><button type="submit" name="act" value="add" class="w3-button w3-black w3-round">
				CONFIRM & PAY
			</button></div>
		</form>

	</div>
	</div>
	</div>




	</div>

	<?php include 'footer.php'; ?>

	<?PHP
	// Using $discount_amount and $final_total calculated at the top of the file which correctly applies minimum_purchase and maximum_discount limits.
	

	if ($act == "add") {
		$booking_no = rand(10000, 99999);

		$SQL_insert = " 
	INSERT INTO `booking`(`booking_no`,`username`, `location`, `depart_date`, `return_date`, 
		`vehicle`, `adult`, `children`, `senior`,
`trip`, `total`,
`coupon_code`,
`discount_amount`,
`final_total`,
`status`,
		`vehicle_brand`, `vehicle_model`, `registration_no`, `chassis_no`, `driver_name`,
		`driver_phone`, `driver_gender`, `driver_id`, `registration_card`, `driver_card`) 
	VALUES ('$booking_no', '" . $_SESSION["username"] . "', '$location',  '$depart_date', '$return_date', 
		'$vehicle',
'$adult',
'$children',
'$senior',
'$trip',
'$total',
'$coupon_code',
'$discount_amount',
'$final_total',
'Paid',
		'$vehicle_brand', '$vehicle_model', '$registration_no', '$chassis_no', '$driver_name',
		'$driver_phone', '$driver_gender', '$driver_id', '', '')
	";




		$result = mysqli_query($con, $SQL_insert);
		$booking_id = mysqli_insert_id($con);

		$success = "Successfully Submitted";

		// Insert Passenger - Adult
		for ($i = 1; $i <= $adult; $i++) {
			$ad_name = $con->real_escape_string($_POST['ad_name' . $i]);
			$ad_ic = $con->real_escape_string($_POST['ad_ic' . $i]);

			$sql = "INSERT INTO `booking_passenger`(`booking_id`, `category`, `name`, `ic`) 
										VALUES ($booking_id,'adult','$ad_name','$ad_ic')";
			$result = mysqli_query($con, $sql);
		}

		// Insert Passenger - Children
		for ($i = 1; $i <= $children; $i++) {
			$ch_name = $con->real_escape_string($_POST['ch_name' . $i]);
			$ch_ic = $con->real_escape_string($_POST['ch_ic' . $i]);

			$sql = "INSERT INTO `booking_passenger`(`booking_id`, `category`, `name`, `ic`) 
										VALUES ($booking_id,'children','$ch_name','$ch_ic')";
			$result = mysqli_query($con, $sql);
		}

		// Insert Passenger - Children
		for ($i = 1; $i <= $senior; $i++) {
			$sn_name = $con->real_escape_string($_POST['sn_name' . $i]);
			$sn_ic = $con->real_escape_string($_POST['sn_ic' . $i]);

			$sql = "INSERT INTO `booking_passenger`(`booking_id`, `category`, `name`, `ic`) 
										VALUES ($booking_id,'senior','$sn_name','$sn_ic')";
			$result = mysqli_query($con, $sql);
		}

		include("pop-bank.php");

		echo "<script>document.getElementById('popBank').style.display='block';</script>";
		exit;
	}


	?>



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