<?PHP
session_start();

include("database.php");
if( !verifyAdmin($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP	
$act 	= (isset($_POST['act'])) ? trim($_POST['act']) : '';	

$username	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password	= (isset($_POST['password'])) ? trim($_POST['password']) : '';

$username	=	mysqli_real_escape_string($con, $username);
$password	=	mysqli_real_escape_string($con, $password);

$success = "";

if($act == "edit")
{	
	$SQL_update = " UPDATE `admins` SET 
						`username` = '$username',
						`password` = '$password'
					WHERE `username` =  '{$_SESSION['username']}'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Updated');</script>";
}


$SQL_view 	= " SELECT * FROM `admins` WHERE `username` =  '{$_SESSION['username']}' ";
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="css/table.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
<style>
a {
  text-decoration: none;
}

body,h1,h2,h3,h4,h5,h6 {font-family: "Barlow", sans-serif; font-weight: 500;}

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
if($success) { Notify("success", $success, "a-profile.php"); }
?>	

<div class="bgimg-1" >

	<div class="w3-padding-64"></div>
		
	
<div class="w3-container w3-padding" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:500px">
		<div class="w3-padding">
		
			<form method="post" action="" >
				<h3>Admin Profile</h3>
				<hr class="w3-clear">
				<div class="w3-section" >
					<label>Username *</label>
					<input class="w3-input w3-border w3-round" type="text" name="username" value="<?PHP echo $data["username"]; ?>"  required>
				</div>

				<div class="w3-section">
					<label>Password *</label>
					<input class="w3-input w3-border w3-round" type="password" name="password" value="<?PHP echo $data["password"]; ?>" required>
				</div>
				
				<hr class="w3-clear">
				<input type="hidden" name="act" value="edit" >
				<button type="submit" class="w3-button w3-wide w3-block w3-padding-large w3-black w3-margin-bottom w3-round">UPDATE</button>

			</form>
		</div>
    </div>
</div>


<div class="w3-padding-64"></div>
	
</div>




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