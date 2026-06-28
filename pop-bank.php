<?PHP 
//session_start();
$payment_total = number_format($final_total,2);
?>



<div id="popBank" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-black w3-round-xlarge w3-card-4 w3-animate-zoom" style="max-width:500px">
		<header class="w3-container "> 
			<img src="images/m2u.jpg" style="width:220px">
			<span onclick="document.getElementById('popBank').style.display='none'" 
			class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
		</header>

		<div class="w3-padding w3-round">
		<div class="w3-container w3-padding w3-border w3-white w3-round-xlarge">
			<div class="w3-center w3-padding-16">
				<div class="w3-padding"></div>
				<img src="images/fpx.jpg" style="width:100px"><br>
				Timeout in 03:52
				<div class="w3-padding"></div>
				<b>Step 1 of 3</b>
			</div>
			
			<div class="w3-light-grey w3-padding w3-padding-small w3-border w3-round-xlarge">
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">From Account</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>1643127899 SA-i</b></div>
				</div>
				<div class="w3-padding"></div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">Merchant Name</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>AISYAH SOFIA</b></div>
				</div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">Payment Reference</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>15487752</b></div>
				</div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">FPX Transaction ID</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>191121750055931</b></div>
				</div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">Amount</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>RM<?PHP echo $payment_total;?></b></div>
				</div>

			</div>
			<div class="w3-padding-16">
				<div class="w3-center">
					<a href="#" onclick="document.getElementById('popBank').style.display='none'; document.getElementById('popBank2').style.display='block'" class="w3-button w3-amber w3-round-large"><b>Continue</b></a>&nbsp;&nbsp;&nbsp;
					<a href="#" onclick="document.getElementById('popBank').style.display='none'"><b class="w3-text-indigo	">Cancel</b></a>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>






<div id="popBank2" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-black w3-round-xlarge w3-card-4 w3-animate-zoom" style="max-width:500px">
		<header class="w3-container "> 
			<img src="images/m2u.jpg" style="width:220px">
			<span onclick="document.getElementById('popBank2').style.display='none'" 
			class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
		</header>

		<div class="w3-padding w3-round">
		<div class="w3-container w3-padding w3-border w3-white w3-round-xlarge">
			<div class="w3-center w3-padding-16"><b>Welcome</b></div>
			<div class="w3-light-grey w3-padding w3-padding-small w3-border w3-round-xlarge">
				<div class="w3-padding-small">
				<b>Log in to Maybank2u.com online banking</b>
				</div>
				<div class="w3-white w3-padding w3-padding-small w3-border w3-round-xlarge">
					<div class="w3-padding-small">
					Note : <br>
					You are in secured site
					</div>
				</div>
				
				<div class="w3-padding-16 w3-padding">
				<b>Username : </b>
				<input class="w3-input w3-border w3-padding w3-round" type="text" name="uname"  required>
				<b>Password :</b>
<input class="w3-input w3-border w3-padding w3-round" type="password" name="uname" required>
<a href="#" onclick="document.getElementById('popBank2').style.display='none'; document.getElementById('popBank3').style.display='block'" class="w3-button w3-amber w3-round-large"><b>Login</b></a>&nbsp;&nbsp;&nbsp;
				</div>
				
				<div class="w3-padding-16">
					Don't have a Maybank2U account?<br>
					<span class="w3-text-indigo">Click here for information on opening an account</span>
				</div>
				

			</div>
			<div class="w3-padding-16">
				<b>Forgot our Online Bangking password?</b><br>
				Call our customer care hotline at 1-300-88-6688.
			</div>
		</div>
		</div>
	</div>
</div>




<div id="popBank3" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-black w3-round-xlarge w3-card-4 w3-animate-zoom" style="max-width:500px">
		<header class="w3-container "> 
			<img src="images/m2u.jpg" style="width:220px">
			<span onclick="document.getElementById('popBank3').style.display='none'" 
			class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
		</header>

		<div class="w3-padding w3-round">
		<div class="w3-container w3-padding w3-border w3-white w3-round-xlarge">
			<div class="w3-center w3-padding-16">
				<div class="w3-padding"></div>
				<img src="images/fpx.jpg" style="width:100px"><br>
				Timeout in 03:52
				<div class="w3-padding"></div>
				<b>Step 1 of 3</b>
			</div>
			
			<div class="w3-light-grey w3-padding w3-padding-small w3-border w3-round-xlarge">
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">From Account</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>1643127899 SA-i</b></div>
				</div>
				<div class="w3-padding"></div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">Merchant Name</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>BLUEHAUL RORO</b></div>
				</div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">Payment Reference</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>15487752</b></div>
				</div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">FPX Transaction ID</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>191121750055931</b></div>
				</div>
				<div class="w3-row">
					<div class="w3-col s6 w3-right-align w3-padding-small">Amout</div>
					<div class="w3-col s6 w3-left-align w3-padding-small"><b>RM<?PHP echo $payment_total;?></b></div>
				</div>

			</div>
			<div class="w3-padding-16">
				<div class="w3-center">
					<a href="completed.php?booking_id=<?PHP echo $booking_id;?>" onclick="document.getElementById('popBank').style.display='none'; document.getElementById('popBank3').style.display='block'" class="w3-button w3-amber w3-round-large"><b>Confirm</b></a>&nbsp;&nbsp;&nbsp;
					<a href="#" onclick="document.getElementById('popBank3').style.display='none'"><b class="w3-text-indigo	">Cancel</b></a>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>