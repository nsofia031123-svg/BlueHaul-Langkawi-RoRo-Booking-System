<?php
session_start();

include("database.php");

if(!verifyAdmin($con))
{
    header("Location: index.php");
    exit;
}
?>
<?PHP
$promotion_id = $_POST['promotion_id'] ?? '';
$act = $_POST['act'] ?? '';

$coupon_code = $_POST['coupon_code'] ?? '';
$discount_type = $_POST['discount_type'] ?? '';
$discount_value = $_POST['discount_value'] ?? '';
$usage_limit = $_POST['usage_limit'] ?? '';
$minimum_purchase = $_POST['minimum_purchase'] ?? '';
$maximum_discount = $_POST['maximum_discount'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$expiry_date = $_POST['expiry_date'] ?? '';
$status = $_POST['status'] ?? '';

$success = "";

if($act=="add")
{
    $SQL_insert = "
    INSERT INTO promotion
    (
        coupon_code,
        discount_type,
        discount_value,
        usage_limit,
        minimum_purchase,
        maximum_discount,
        start_date,
        expiry_date,
        status
    )
    VALUES
    (
        '$coupon_code',
        '$discount_type',
        '$discount_value',
        '$usage_limit',
        '$minimum_purchase',
        '$maximum_discount',
        '$start_date',
        '$expiry_date',
        '$status'
    )";

    mysqli_query($con,$SQL_insert);

    $success = "Promotion Successfully Added";
}

if($act=="edit")
{
    $SQL_update="
    UPDATE promotion
    SET
    coupon_code='$coupon_code',
    discount_type='$discount_type',
    discount_value='$discount_value',
    usage_limit='$usage_limit',
    minimum_purchase='$minimum_purchase',
    maximum_discount='$maximum_discount',
    start_date='$start_date',
    expiry_date='$expiry_date',
    status='$status'
    WHERE promotion_id='$promotion_id'
    ";

    mysqli_query($con,$SQL_update);

    $success="Promotion Successfully Updated";
}

if($act=="del")
{
    $SQL_delete="
    DELETE FROM promotion
    WHERE promotion_id='$promotion_id'
    ";

    mysqli_query($con,$SQL_delete);

    $success="Promotion Successfully Deleted";
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

<link href="css/table.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

<style>
a { text-decoration : none ;}

body,h1,h2,h3,h4,h5,h6 {font-family: "Barlow", sans-serif}

body, html {
  height: 100%;
  line-height: 1.5;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-attachment: fixed;
  background-size: cover;
  background-image: url("images/banner.jpg");
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="w3-pale-red">

<?PHP include("menu-admin.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "a-promotion.php"); }
?>	

<div class="w3-pale-red" >

	<div class="w3-padding-64"></div>
	
	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1400px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
	  
		<div class="w3-xxlarge w3-center"><b>Promotion</b></div>
		
		<div class="w3-padding w3-center">
			<a href="#" onclick="document.getElementById('idAdd').style.display='block'" class="w3-button w3-round w3-blue"><i class="fa fa-plus"></i> Create Promotion</a>
		</div>

		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" style="font-size:10pt" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr class="w3-black">
					<th>BIL</th>
                    <th>Coupon Code</th>
                    <th>Discount Type</th>
                    <th>Discount Value</th>
                    <th>Usage Limit</th>
                    <th>Minimum Purchase</th>
					<th>Maximum Discount</th>
					<th>Start Date</th>
					<th>Expiry Date</th>
					<th>Status</th>
                    <th class="w3-center">Action</th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM promotion ORDER BY promotion_id DESC";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$promotion_id = $data["promotion_id"];
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><?PHP echo $data["coupon_code"] ;?></td>
				<td><?PHP echo $data["discount_type"] ;?></td>
				<td><?PHP echo $data["discount_value"] ;?></td>
				<td><?PHP echo $data["usage_limit"] ;?></td>
				<td><?PHP echo $data["minimum_purchase"] ;?></td>
				<td><?PHP echo $data["maximum_discount"] ;?></td>
				<td><?PHP echo $data["start_date"] ;?></td>
				<td><?PHP echo $data["expiry_date"] ;?></td>
				<td><?PHP echo $data["status"] ;?></td>
				<td class="w3-center">
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-edit fa-lg"></i></a>
				<a href="#" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-text-red"><i class="fa fa-trash fa-lg"></i></a>
				</td>
			</tr>
			
<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding">
			<b class="w3-large">Update Promotion</b>
			<hr>

				<div class="w3-section" >
					<label>Coupon Code *</label>
					<input class="w3-input w3-border w3-round" type="text" name="coupon_code" value="<?PHP echo $data["coupon_code"]; ?>" required>
				</div>
				
				<div class="w3-section" >
					<label>Discount Type *</label>
					<select class="w3-select w3-border w3-round" name="discount_type" required>
						<option value="Percentage" <?php if($data["discount_type"]=="Percentage") echo "selected";?>>Percentage</option>
						<option value="Fixed Amount" <?php if($data["discount_type"]=="Fixed Amount") echo "selected";?>>Fixed Amount</option>
					</select>
				</div>
				
				<div class="w3-section" >
					<label>Discount Value *</label>
					<input class="w3-input w3-border w3-round" type="text" name="discount_value" value="<?PHP echo $data["discount_value"]; ?>" required>
				</div>
				
				<div class="w3-section" >
					<label>Usage Limit </label>
					<input class="w3-input w3-border w3-round" type="number" name="usage_limit" value="<?PHP echo $data["usage_limit"]; ?>" >
				</div>
				
				<div class="w3-section" >
					<label>Minimum Purchase </label>
					<input class="w3-input w3-border w3-round" type="text" name="minimum_purchase" value="<?PHP echo $data["minimum_purchase"]; ?>" >
				</div>

				<div class="w3-section" >
					<label>Maximum Discount </label>
					<input class="w3-input w3-border w3-round" type="text" name="maximum_discount" value="<?PHP echo $data["maximum_discount"]; ?>" >
				</div>

				<div class="w3-section" >
					<label>Start Date *</label>
					<input class="w3-input w3-border w3-round" type="date" name="start_date" value="<?PHP echo $data["start_date"]; ?>" required>
				</div>

				<div class="w3-section" >
					<label>Expiry Date *</label>
					<input class="w3-input w3-border w3-round" type="date" name="expiry_date" value="<?PHP echo $data["expiry_date"]; ?>" required>
				</div>

				<div class="w3-section" >
					<label>Status *</label>
					<select class="w3-select w3-border w3-round" name="status" required>
						<option value="Active" <?php if($data["status"]=="Active") echo "selected";?>>Active</option>
						<option value="Inactive" <?php if($data["status"]=="Inactive") echo "selected";?>>Inactive</option>
					</select>
				</div>
				
			<hr class="w3-clear">
			<input type="hidden" name="promotion_id" value="<?PHP echo $data["promotion_id"];?>" >
			<input type="hidden" name="act" value="edit" >
			<button type="submit" class="w3-button w3-black w3-text-white w3-margin-bottom w3-round">SAVE CHANGES</button>
			</div>
		</form>
		</div>
	</div>
<div class="w3-padding-24"></div>
</div>

<div id="idDelete<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post">
			<div class="w3-padding"></div>
			<b class="w3-large">Confirmation</b>
			  
			<hr class="w3-clear">			
			Are you sure to delete this record ?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="promotion_id" value="<?PHP echo $data["promotion_id"];?>" >
			<input type="hidden" name="act" value="del" >
			<button type="button" onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES, CONFIRM</button>
		</form>
		</div>
	</div>
</div>				
			<?PHP } ?>
			</tbody>
		</table>
		</div>
		</div>

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	<div class="w3-padding-24"></div>
	
</div>

<!-- Add Modal -->
<div id="idAdd" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idAdd').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding">
			<b class="w3-large">Add Promotion</b>
			<hr>

				<div class="w3-section" >
					<label>Coupon Code *</label>
					<input class="w3-input w3-border w3-round" type="text" name="coupon_code" required>
				</div>
				
				<div class="w3-section" >
					<label>Discount Type *</label>
					<select class="w3-select w3-border w3-round" name="discount_type" required>
						<option value="Percentage">Percentage</option>
						<option value="Fixed Amount">Fixed Amount</option>
					</select>
				</div>
				
				<div class="w3-section" >
					<label>Discount Value *</label>
					<input class="w3-input w3-border w3-round" type="text" name="discount_value" required>
				</div>
				
				<div class="w3-section" >
					<label>Usage Limit </label>
					<input class="w3-input w3-border w3-round" type="number" name="usage_limit" >
				</div>
				
				<div class="w3-section" >
					<label>Minimum Purchase </label>
					<input class="w3-input w3-border w3-round" type="text" name="minimum_purchase" >
				</div>

				<div class="w3-section" >
					<label>Maximum Discount </label>
					<input class="w3-input w3-border w3-round" type="text" name="maximum_discount" >
				</div>

				<div class="w3-section" >
					<label>Start Date *</label>
					<input class="w3-input w3-border w3-round" type="date" name="start_date" required>
				</div>

				<div class="w3-section" >
					<label>Expiry Date *</label>
					<input class="w3-input w3-border w3-round" type="date" name="expiry_date" required>
				</div>

				<div class="w3-section" >
					<label>Status *</label>
					<select class="w3-select w3-border w3-round" name="status" required>
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</div>
				
			<hr class="w3-clear">
			<input type="hidden" name="act" value="add" >
			<button type="submit" class="w3-button w3-black w3-text-white w3-margin-bottom w3-round">SAVE</button>
			</div>
		</form>
		</div>
	</div>
<div class="w3-padding-24"></div>
</div>


<script>
$(document).ready(function() {

  
	$('#dataTable').DataTable( {
		paging: true,
		
		searching: true
	} );
		
	
});
</script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

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
