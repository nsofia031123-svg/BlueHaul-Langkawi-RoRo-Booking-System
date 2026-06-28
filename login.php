<?PHP
session_start();
?>
<?PHP
include("database.php");
$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$error = "";

if($act == "login") 
{
	// Get username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
	
	// Hash the password for storage
	$password	= md5($password);

	// Use prepared statement to prevent SQL injection
	$stmt = $con->prepare("SELECT * FROM `user` WHERE username = ? AND password = ?");
	$stmt->bind_param("ss", $username, $password);

	// Execute the query
	$stmt->execute();
	
	// Get the result
	$result = $stmt->get_result();

	// Check if the query returned a row
	if ($result->num_rows > 0) {	
		$data = $result->fetch_assoc();
		$_SESSION["password"] 	= $password;
		$_SESSION["username"] 	= $username;
		$_SESSION["user_id"] 	= $data["user_id"];

		header("Location:book.php");
		exit();
	}else{
		$error = "Invalid";
		header( "refresh:1;url=login.php" );
		//print "<script>alert('Login tidak sah!'); self.location='index.php';</script>";
	}
	
	// Close the statement
	$stmt->close();
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
.bg {
	background-image: url(images/1.jpg);
	background-size: cover;
	height:calc(100% + 20px);
    background-repeat: no-repeat;

}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: calc(100% + 20px);
    background-color: rgba(0, 0, 0, 0.6);
}

.content {
    position: relative;
    z-index: 1; 
}

.w3-top{
	z-index: 2;
}
.drop-head:hover .th
{
    color: #e91e63 !important;
}

.w3-top{
  line-height: 2;
  font-family: "Barlow", sans-serif;
  font-weight:500;
}
 </style>
</style>

<body class="w3-pale-red">

<?PHP include("menu.php"); ?>

<div class="bg">
	<div class="overlay"></div>
	<div class="content">

<div  >

<div class="w3-padding-64"></div>
<div class="w3-padding-32"></div>


<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:500px">
		<div class="w3-padding w3-padding-32">
			<form action="" method="post">

			<h3><b>Login User</b></h3>
			
			<?PHP if($error) { ?>			
			<div class="w3-container w3-padding-32" id="contact">
				<div class="w3-content w3-container w3-red w3-round w3-card" style="max-width:600px">
					<div class="w3-padding w3-center">
					<h3>Error! Invalid login</h3>
					<p>Please try again...</p>
					</div>
				</div>
			</div>	
			<?PHP } ?>
			
			
			  <div class="w3-section" >
				<label>Username *</label>
				<input class="w3-input w3-border w3-round" type="username" name="username"  required>
			  </div>
			  <div class="w3-section">
    <label>Password *</label>
    <input class="w3-input w3-border w3-round" type="password" name="password" id="password" required>
    <input type="checkbox" onclick="showPassword()"> Show Password
</div>

<script>
function showPassword() {
    var passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
</script>

			  
	
			  <input name="act" type="hidden" value="login">
			  <button type="submit" class="w3-button w3-block w3-padding-large w3-black w3-margin-bottom w3-round"><b>LOGIN</b></button>
			</form>
			
		<div class="w3-center w3-padding">Don't have an account yet? <a href="register.php" class="w3-text-pink">Sign Up</a></div>
		
		</div>
		
		

    </div>
</div>

<div class="w3-padding-64"></div>

	
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
