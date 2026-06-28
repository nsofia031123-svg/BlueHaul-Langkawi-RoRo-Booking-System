<?php
include("database.php");
$act       = (isset($_POST['act'])) ? trim($_POST['act']) : '';
$email     = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$username  = (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password  = (isset($_POST['password'])) ? trim($_POST['password']) : '';

$found = 0;
$error = "";
$success = false;

if ($act == "register") {
    $found  = numRows($con, "SELECT * FROM `user` WHERE `username` = '$username' ");
    if ($found) $error = "This username has already been taken. Please choose a different username.";

    // Password validation
    $uppercase = preg_match('@[A-Z]@', $password);
    $length = strlen($password);
    $number = preg_match('@[0-9]@', $password);

    if (!$uppercase || $length < 5 || !$number || $password === '123456789') {
        $error .= " Password must have at least one capital letter, be at least 5 characters long, and cannot be '123456789'.";
    }
}

if (($act == "register") && (!$error)) {
    $password = md5($password);

    $SQL_insert = " 
    INSERT INTO `user`(`email`, `username`, `password`) VALUES ( '$email', '$username', '$password') ";
    $result = mysqli_query($con, $SQL_insert) or die("Error in query: " . $SQL_insert . "<br />" . mysqli_error($con));
    $success = true;
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
		background-image: url(images/banner.jpg);
		min-height: 100%;
	}

	a:link {
		text-decoration: none;
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

<body class="w3-pale-red">

	<?PHP include("menu.php"); ?>

	<div class="bg">
	<div class="overlay"></div>
	<div class="content">
	<div>

		<div class="w3-padding-64"></div>


		<div class="w3-container w3-padding-16" id="contact">
			<div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:500px">
				<div class="w3-padding w3-padding-32">

					<?PHP if ($success) { ?>
						<div class="w3-panel w3-green w3-display-container w3-animate-zoom">
							<span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
							<h3>Success!</h3>
							<p>Your registration was successful! You may now <a href="login.php" class="w3-xlarge">Login.</a> </p>
						</div>
					<?PHP  } ?>

					<?PHP if ($error) { ?>
						<div class="w3-panel w3-red w3-display-container w3-animate-zoom">
							<span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
							<h3>Error!</h3>
							<p><?PHP echo $error; ?></p>
						</div>
					<?PHP  } ?>

					<?PHP if (!$success) { ?>

						<form action="" method="post">

							<h3><b>Registration</b></h3>

							<div class="w3-section">
								<label>Email *</label>
								<input class="w3-input w3-border w3-round" type="email" name="email" required>
							</div>

							<div class="w3-section">
								<label>Username *</label>
								<input class="w3-input w3-border w3-round" type="text" name="username" required>
							</div>

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

				<input type="hidden" name="act" value="register">
				<button type="submit" class="w3-button w3-block w3-padding-large w3-black w3-margin-bottom w3-round"><b>SUBMIT</b></button>
				</form>

			<?PHP } ?>
			<div class="w3-center">Already registered? <a href="login.php" class="w3-text-pink">Login here</a></div>

			</div>



		</div>
	</div>

	<div class="w3-padding-24"></div>


	</div>
	</div>
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