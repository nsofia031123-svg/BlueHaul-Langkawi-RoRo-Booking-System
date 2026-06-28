<?PHP
session_start();

include("database.php");
if (!verifyAdmin($con)) {
	header("Location: index.php");
	return false;
}
?>
<?PHP
$booking_id = (isset($_REQUEST['booking_id'])) ? trim($_REQUEST['booking_id']) : '0';
$act = (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';

$success = "";

if ($act == "del") {
	$SQL_delete = " DELETE FROM `booking` WHERE `booking_id` =  '$booking_id' ";
	$result = mysqli_query($con, $SQL_delete);

	$success = "Deleted!";
	//print "<script>self.location='a-user.php';</script>";
}
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

	/* Full height image header */
	.bgimg-1 {
		background-position: top;
		background-size: cover;
		background-attachment: fixed;
		background-image: url("images/banner.jpg");
		min-height: 100%;
	}

	a:link {
		text-decoration: none;
	}

	.w3-bar .w3-button {
		padding: 16px;
	}

	.w3-table th,
	.w3-table td {
		text-align: center !important;
		vertical-align: middle !important;
	}
</style>

<body class="w3-pale-red">

	<?PHP include("menu-admin.php"); ?>
	<?PHP
	$search_booking = isset($_GET['search_booking']) ? trim($_GET['search_booking']) : '';
	$trip_option = isset($_GET['trip_option']) ? trim($_GET['trip_option']) : '';
	$coupon_filter = isset($_GET['coupon_code']) ? trim($_GET['coupon_code']) : '';
	$depart_date_filter = isset($_GET['depart_date']) ? trim($_GET['depart_date']) : '';
	$vehicle_filter = isset($_GET['vehicle']) ? trim($_GET['vehicle']) : '';
	$min_amount = isset($_GET['min_amount']) ? trim($_GET['min_amount']) : '';
	$max_amount = isset($_GET['max_amount']) ? trim($_GET['max_amount']) : '';

	$where = "WHERE 1=1";

	if ($search_booking != '') {
		$where .= " AND booking_no LIKE '%$search_booking%'";
	}

	if ($trip_option != '') {
		if ($trip_option == 'oneway_all') {
			$where .= " AND trip = 'oneway'";
		} else if ($trip_option == 'oneway_kp_lgk') {
			$where .= " AND trip = 'oneway' AND location = 'KP-LGK'";
		} else if ($trip_option == 'oneway_lgk_kp') {
			$where .= " AND trip = 'oneway' AND location = 'LGK-KP'";
		} else if ($trip_option == 'return_all') {
			$where .= " AND trip = 'return'";
		} else if ($trip_option == 'return_kp_lgk') {
			$where .= " AND trip = 'return' AND location = 'KP-LGK'";
		} else if ($trip_option == 'return_lgk_kp') {
			$where .= " AND trip = 'return' AND location = 'LGK-KP'";
		}
	}

	if ($coupon_filter != '') {
		if ($coupon_filter == 'NONE') {
			$where .= " AND (coupon_code = '' OR coupon_code IS NULL)";
		} else if ($coupon_filter == 'ALL_PROMO') {
			$where .= " AND coupon_code != '' AND coupon_code IS NOT NULL";
		} else {
			$where .= " AND coupon_code = '$coupon_filter'";
		}
	}

	if ($depart_date_filter != '') {
		$where .= " AND depart_date = '$depart_date_filter'";
	}

	if ($vehicle_filter != '') {
		$where .= " AND vehicle = '$vehicle_filter'";
	}

	if ($min_amount != '') {
		$where .= " AND (IF(final_total > 0, final_total, total) >= $min_amount)";
	}

	if ($max_amount != '') {
		$where .= " AND (IF(final_total > 0, final_total, total) <= $max_amount)";
	}

	$records_per_page = 10;
	$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
	$offset = ($page - 1) * $records_per_page;

	$SQL_count = "SELECT COUNT(*) as total FROM booking $where";
	$count_result = mysqli_query($con, $SQL_count);
	$count_row = mysqli_fetch_array($count_result);
	$total_records = $count_row['total'];
	$total_pages = ceil($total_records / $records_per_page);

	$SQL_list = "SELECT * FROM booking $where ORDER BY depart_date ASC LIMIT $records_per_page OFFSET $offset";
	?>

	<div class="">

		<div class="w3-padding-64"></div>


		<div class="w3-container" id="contact" style="max-width:1400px; margin:auto;">
			<div class="w3-row-padding">

				<!-- Sidebar -->
				<div class="w3-col m3">
					<div class="w3-white w3-round-large w3-card w3-padding">
						<h4><b>FILTER BOOKING</b></h4>
						<hr>
						<form method="GET" action="">
							<label><b>Trip Options</b></label><br>
							One Way Trip<br>
							&nbsp;&nbsp;<input type="radio" name="trip_option" value="oneway_all" <?php if ($trip_option == 'oneway_all')
								echo 'checked data-checked="1"'; ?>
								onclick="toggleRadio(this)"> All<br>
							&nbsp;&nbsp;<input type="radio" name="trip_option" value="oneway_kp_lgk" <?php if ($trip_option == 'oneway_kp_lgk')
								echo 'checked data-checked="1"'; ?>
								onclick="toggleRadio(this)"> KP &rarr; LGK<br>
							&nbsp;&nbsp;<input type="radio" name="trip_option" value="oneway_lgk_kp" <?php if ($trip_option == 'oneway_lgk_kp')
								echo 'checked data-checked="1"'; ?>
								onclick="toggleRadio(this)"> LGK &rarr; KP<br>

							<div class="w3-padding-small"></div>

							Return Trip<br>
							&nbsp;&nbsp;<input type="radio" name="trip_option" value="return_all" <?php if ($trip_option == 'return_all')
								echo 'checked data-checked="1"'; ?>
								onclick="toggleRadio(this)"> All<br>
							&nbsp;&nbsp;<input type="radio" name="trip_option" value="return_kp_lgk" <?php if ($trip_option == 'return_kp_lgk')
								echo 'checked data-checked="1"'; ?>
								onclick="toggleRadio(this)"> KP &rarr; LGK &rarr; KP<br>
							&nbsp;&nbsp;<input type="radio" name="trip_option" value="return_lgk_kp" <?php if ($trip_option == 'return_lgk_kp')
								echo 'checked data-checked="1"'; ?>
								onclick="toggleRadio(this)"> LGK &rarr; KP &rarr; LGK<br>

							<div class="w3-padding-16"></div>

							<label><b>Promotion</b></label>
							<input type="hidden" name="coupon_code" id="coupon_code"
								value="<?php echo $coupon_filter; ?>">
							<div class="w3-dropdown-click w3-block">
								<button type="button"
									class="w3-button w3-border w3-round w3-white w3-block w3-left-align"
									id="coupon_display" style="padding: 8px;"
									onclick="document.getElementById('main_promo_dropdown').classList.toggle('w3-show');">
									<?php
									if ($coupon_filter == '')
										echo 'All';
									else if ($coupon_filter == 'NONE')
										echo 'No Promotion Code';
									else if ($coupon_filter == 'ALL_PROMO')
										echo 'All Promotion Codes';
									else
										echo $coupon_filter;
									?> <i class="fa fa-caret-down w3-right" style="margin-top: 4px;"></i>
								</button>
								<div id="main_promo_dropdown" class="w3-dropdown-content w3-bar-block w3-border"
									style="width:100%; z-index:10; overflow: visible;">
									<a href="javascript:void(0)"
										onclick="document.getElementById('coupon_code').value=''; document.getElementById('coupon_display').innerHTML='All <i class=\'fa fa-caret-down w3-right\' style=\'margin-top: 4px;\'></i>'; document.getElementById('main_promo_dropdown').classList.remove('w3-show');"
										class="w3-bar-item w3-button">All</a>
									<a href="javascript:void(0)"
										onclick="document.getElementById('coupon_code').value='NONE'; document.getElementById('coupon_display').innerHTML='No Promotion Code <i class=\'fa fa-caret-down w3-right\' style=\'margin-top: 4px;\'></i>'; document.getElementById('main_promo_dropdown').classList.remove('w3-show');"
										class="w3-bar-item w3-button">No Promotion Code</a>

									<div class="w3-block" style="position:relative;"
										onmouseenter="document.getElementById('nested_promo').style.display='block'"
										onmouseleave="document.getElementById('nested_promo').style.display='none'">
										<button type="button" class="w3-button w3-block w3-left-align"
											style="background:none;">Promotion Code <i
												class="fa fa-caret-right w3-right"
												style="margin-top: 4px;"></i></button>
										<div id="nested_promo" class="w3-bar-block w3-border w3-white"
											style="display:none; position:absolute; left:100%; top:0; z-index:11; width:200px; max-height: 250px; overflow-y: auto;">
											<a href="javascript:void(0)"
												onclick="document.getElementById('coupon_code').value='ALL_PROMO'; document.getElementById('coupon_display').innerHTML='All Promotion Codes <i class=\'fa fa-caret-down w3-right\' style=\'margin-top: 4px;\'></i>'; document.getElementById('nested_promo').style.display='none'; document.getElementById('main_promo_dropdown').classList.remove('w3-show');"
												class="w3-bar-item w3-button">All Promotion Codes</a>
											<?php
											$promo_sql = mysqli_query($con, "SELECT DISTINCT coupon_code FROM promotion WHERE coupon_code != ''");
											while ($p = mysqli_fetch_array($promo_sql)) {
												$code = $p['coupon_code'];
												echo '<a href="javascript:void(0)" onclick="document.getElementById(\'coupon_code\').value=\'' . $code . '\'; document.getElementById(\'coupon_display\').innerHTML=\'' . $code . ' <i class=\\\'fa fa-caret-down w3-right\\\' style=\\\'margin-top: 4px;\\\'></i>\'; document.getElementById(\'nested_promo\').style.display=\'none\'; document.getElementById(\'main_promo_dropdown\').classList.remove(\'w3-show\');" class="w3-bar-item w3-button">' . $code . '</a>';
											}
											?>
										</div>
									</div>
								</div>
							</div>

							<div class="w3-padding-16"></div>

							<label><b>Departure Date</b></label>
							<input type="date" name="depart_date" value="<?php echo $depart_date_filter; ?>"
								class="w3-input w3-border w3-round">
							<button type="button" class="w3-button w3-light-grey w3-border w3-round w3-block"
								style="margin-top: 5px; font-size: 12px; padding: 4px;"
								onclick="this.previousElementSibling.value=''; this.form.submit();">All Dates</button>

							<div class="w3-padding-16"></div>

							<label><b>Vehicle Type</b></label>
							<input type="hidden" name="vehicle" id="vehicle_type"
								value="<?php echo $vehicle_filter; ?>">
							<div class="w3-dropdown-click w3-block">
								<button type="button"
									class="w3-button w3-border w3-round w3-white w3-block w3-left-align"
									id="vehicle_display" style="padding: 8px;"
									onclick="document.getElementById('vehicle_dropdown').classList.toggle('w3-show');">
									<?php
									if ($vehicle_filter == '') {
										echo 'All Vehicle';
									} else {
										$curr_veh = mysqli_query($con, "SELECT category FROM fare WHERE fareid = '$vehicle_filter'");
										if (mysqli_num_rows($curr_veh) > 0) {
											$v_data = mysqli_fetch_array($curr_veh);
											echo htmlspecialchars($v_data['category']);
										} else {
											echo 'All Vehicle';
										}
									}
									?> <i class="fa fa-caret-down w3-right" style="margin-top: 4px;"></i>
								</button>
								<div id="vehicle_dropdown" class="w3-dropdown-content w3-bar-block w3-border"
									style="width:100%; z-index:10; max-height: 350px; overflow-y: auto;">
									<a href="javascript:void(0)"
										onclick="document.getElementById('vehicle_type').value=''; document.getElementById('vehicle_display').innerHTML='All Vehicle <i class=\'fa fa-caret-down w3-right\' style=\'margin-top: 4px;\'></i>'; document.getElementById('vehicle_dropdown').classList.remove('w3-show');"
										class="w3-bar-item w3-button">All Vehicle</a>
									<?php
									$veh_sql = mysqli_query($con, "SELECT * FROM fare WHERE category != ''");
									while ($v = mysqli_fetch_array($veh_sql)) {
										$f_id = htmlspecialchars($v['fareid']);
										$f_cat = addslashes($v['category']);
										$f_display = htmlspecialchars($v['category']);
										echo '<a href="javascript:void(0)" onclick="document.getElementById(\'vehicle_type\').value=\'' . $f_id . '\'; document.getElementById(\'vehicle_display\').innerHTML=\'' . $f_cat . ' <i class=\\\'fa fa-caret-down w3-right\\\' style=\\\'margin-top: 4px;\\\'></i>\'; document.getElementById(\'vehicle_dropdown\').classList.remove(\'w3-show\');" class="w3-bar-item w3-button">' . $f_display . '</a>';
									}
									?>
								</div>
							</div>

							<div class="w3-padding-16"></div>

							<label><b>Price Range (RM)</b></label>
							<div class="w3-row">
								<div class="w3-col s5">
									<input type="number" name="min_amount" placeholder="Min"
										value="<?php echo $min_amount; ?>" class="w3-input w3-border w3-round w3-small"
										style="padding:8px 4px;">
								</div>
								<div class="w3-col s2 w3-center w3-padding-small">
									&rarr;
								</div>
								<div class="w3-col s5">
									<input type="number" name="max_amount" placeholder="Max"
										value="<?php echo $max_amount; ?>" class="w3-input w3-border w3-round w3-small"
										style="padding:8px 4px;">
								</div>
							</div>

							<div class="w3-padding-16"></div>
							<button type="submit" class="w3-button w3-black w3-block w3-round"><i
									class="fa fa-filter"></i> Apply Filter</button>
							<div class="w3-padding-small"></div>
							<a href="a-history.php" class="w3-button w3-white w3-border w3-block w3-round"><i
									class="fa fa-refresh"></i> Reset</a>
						</form>
					</div>
				</div>

				<!-- Main Content -->
				<div class="w3-col m9">
					<div class="w3-white w3-round-large w3-card" style="padding: 20px;">
						<div class="w3-row">
							<div class="w3-col m6">
								<h2><b>Manage Booking</b></h2>
							</div>
							<div class="w3-col m6">
								<div class="w3-right" style="margin-top: 15px;">
									<form method="GET" action=""
										style="display:flex; align-items:center; justify-content:flex-end;">
										<div
											style="display:flex; align-items:center; border: 1px solid #ccc; border-radius: 20px; overflow: hidden; width: 250px; background: white;">
											<input type="text" name="search_booking" placeholder="Search Booking No."
												value="<?php echo $search_booking; ?>" class="w3-input"
												style="border:none; padding: 8px 16px; width: 100%; outline: none;">
											<button type="submit" class="w3-button w3-white w3-hover-light-grey"
												style="padding: 8px 16px; border:none;"><i
													class="fa fa-search w3-text-grey"></i></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<hr>

						<div class="w3-responsive">
							<table class="w3-table w3-table-all w3-small" width="100%" cellspacing="0">
								<thead>
									<tr class="w3-light-grey">
										<th>#</th>
										<th>Booking No</th>
										<th>Location</th>
										<th>Trip</th>
										<th>Departure Date</th>
										<th>Return Date</th>
										<th>Vehicle</th>
										<th>Total</th>
										<th>Status</th>
										<th>Promotion Code</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?PHP
									$bil = $offset;
									$result = mysqli_query($con, $SQL_list);
									if (mysqli_num_rows($result) == 0) {
										echo '<tr><td colspan="11" class="w3-center w3-padding-32 w3-text-grey"><b>No booking record found.</b></td></tr>';
									}
									while ($data = mysqli_fetch_array($result)) {
										$bil++;
										$booking_id = $data["booking_id"];
										$display_total = ($data["final_total"] > 0) ? $data["final_total"] : $data["total"];
										?>
										<tr>
											<td><?PHP echo $bil; ?></td>
											<td><a class="w3-text-pink" target="_blank"
													href="booking-detail.php?booking_id=<?PHP echo $booking_id; ?>"><?PHP echo $data["booking_no"]; ?></a>
											</td>
											<td><?PHP echo $data["location"]; ?></td>
											<td><?PHP echo $data["trip"]; ?></td>
											<td><?PHP echo $data["depart_date"]; ?></td>
											<td><?PHP echo $data["return_date"]; ?></td>
											<td><?PHP echo GetVehicle($con, $data["vehicle"]); ?></td>
											<td>RM <?PHP echo $display_total; ?></td>
											<td><?PHP echo $data["status"]; ?></td>
											<td><?PHP echo $data["coupon_code"]; ?></td>
											<td style="white-space: nowrap;">
												<a target="_blank" href="slip.php?booking_id=<?PHP echo $booking_id; ?>"
													class="w3-button w3-white w3-border w3-round w3-small"
													style="padding:4px 8px; border-radius: 8px !important; border-width: 2px !important; font-weight: bold;"><i
														class="fa fa-fw fa-qrcode"></i> Ticket</a>
												<a href="?act=del&booking_id=<?PHP echo $booking_id; ?>"
													class="w3-button w3-white w3-border w3-round w3-small"
													style="padding:4px 8px; border-radius: 8px !important; border-width: 2px !important;"
													onclick="return confirm('Delete this booking?');"><i
														class="fa fa-fw fa-trash"></i></a>
											</td>
										</tr>
									<?PHP } ?>
								</tbody>
							</table>
						</div>

						<!-- Pagination -->
						<?PHP if ($total_pages > 1): ?>
						<div class="w3-center w3-padding-16">
							<div style="display:inline-flex; align-items:center; gap:4px; flex-wrap:wrap; justify-content:center;">
								<?PHP
								// Build base URL preserving filters
								$query_params = $_GET;
								unset($query_params['page']);
								$base_url = 'a-history.php?' . http_build_query($query_params);
								$base_url .= ($query_params ? '&' : '');
								?>
								<!-- Prev button -->
								<?PHP if ($page > 1): ?>
								<a href="<?PHP echo $base_url; ?>page=<?PHP echo $page - 1; ?>"
									class="w3-button w3-border w3-round w3-white w3-small"
									style="padding:6px 12px;"><i class="fa fa-chevron-left"></i></a>
								<?PHP else: ?>
								<span class="w3-button w3-border w3-round w3-light-grey w3-small"
									style="padding:6px 12px; cursor:not-allowed;"><i class="fa fa-chevron-left"></i></span>
								<?PHP endif; ?>

								<!-- Page numbers -->
								<?PHP
								$start_page = max(1, $page - 2);
								$end_page = min($total_pages, $page + 2);
								if ($start_page > 1) echo '<span style="padding:6px 4px;">...</span>';
								for ($i = $start_page; $i <= $end_page; $i++):
								?>
								<a href="<?PHP echo $base_url; ?>page=<?PHP echo $i; ?>"
									class="w3-button w3-border w3-round w3-small <?PHP echo ($i == $page) ? 'w3-black' : 'w3-white'; ?>"
									style="padding:6px 12px;"><?PHP echo $i; ?></a>
								<?PHP endfor; ?>
								<?PHP if ($end_page < $total_pages) echo '<span style="padding:6px 4px;">...</span>'; ?>

								<!-- Next button -->
								<?PHP if ($page < $total_pages): ?>
								<a href="<?PHP echo $base_url; ?>page=<?PHP echo $page + 1; ?>"
									class="w3-button w3-border w3-round w3-white w3-small"
									style="padding:6px 12px;"><i class="fa fa-chevron-right"></i></a>
								<?PHP else: ?>
								<span class="w3-button w3-border w3-round w3-light-grey w3-small"
									style="padding:6px 12px; cursor:not-allowed;"><i class="fa fa-chevron-right"></i></span>
								<?PHP endif; ?>
							</div>
							<div class="w3-text-grey w3-small w3-padding-small">
								Showing <?PHP echo min($offset + 1, $total_records); ?>–<?PHP echo min($offset + $records_per_page, $total_records); ?> of <?PHP echo $total_records; ?> records
							</div>
						</div>
						<?PHP endif; ?>

					</div>
				</div>
			</div>
		</div>


		<div class="w3-padding-32"></div>

	</div>


	<script>
		function toggleRadio(radio) {
			if (radio.getAttribute('data-checked') == '1') {
				radio.checked = false;
				radio.setAttribute('data-checked', '0');
			} else {
				document.querySelectorAll('input[name="' + radio.name + '"]').forEach(function (e) {
					e.setAttribute('data-checked', '0');
				});
				radio.setAttribute('data-checked', '1');
			}
		}

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