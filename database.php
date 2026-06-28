<?PHP


date_default_timezone_set('Asia/Kuala_Lumpur');


//localhost
$dbHost = "localhost";	// Database host
$dbName = "bluehaul";		// Database name
$dbUser = "root";		// Database user
$dbPass = "";			// Database password

$con = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);


function verifyAdmin($con)
{
	if (isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['username'] && $_SESSION['password']) {
		$result = mysqli_query($con, "SELECT  `username`, `password` FROM `admins` WHERE `username`='$_SESSION[username]' AND `password`='$_SESSION[password]' ");

		if (mysqli_num_rows($result) == 1)
			return true;
	}
	return false;
}

function verifyUser($con)
{
	if (isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['username'] && $_SESSION['password']) {
		$result = mysqli_query($con, "SELECT  `username`, `password` FROM `user` WHERE `username`='$_SESSION[username]' AND `password`='$_SESSION[password]' ");

		if (mysqli_num_rows($result) == 1)
			return true;
	}
	return false;
}

function numRows($con, $query)
{
	$result = mysqli_query($con, $query);
	$rowcount = mysqli_num_rows($result);
	return $rowcount;
}

function GetRate($con, $fareid)
{
	$result = mysqli_query($con, "SELECT * FROM `fare` WHERE `fareid` = $fareid");
	$data = mysqli_fetch_array($result);

	if (mysqli_num_rows($result) > 0) {
		return array($data["onewaycharge"], $data["roundtripcharge"], $data["onewayweb"], $data["roundtripbookingweb"]);
	} else {
		return array(0, 0, 0, 0);
	}
}

function GetVehicle($con, $fareid)
{
	$result = mysqli_query($con, "SELECT * FROM `fare` WHERE `fareid` = $fareid");
	$data = mysqli_fetch_array($result);

	if (mysqli_num_rows($result) > 0) {
		return $data["category"];
	}
}

function Notify($status, $alert, $redirect)
{
	$color = ($status == "success") ? "w3-green" : "w3-red";

	echo '<div class="' . $color . ' w3-top w3-card w3-padding-24" style="z-index=999">
			<span onclick="this.parentElement.style.display=\'none\'" class="w3-button w3-large w3-display-topright">&times;</span>
				<div class="w3-padding w3-center">
				<div class="w3-large">' . $alert . '</div>
				</div>
			</div>';
	if ($_SERVER['HTTP_HOST'] == "localhost")
		header("refresh:1;url=$redirect");
	else
		print "<script>self.location='$redirect';</script>";
}