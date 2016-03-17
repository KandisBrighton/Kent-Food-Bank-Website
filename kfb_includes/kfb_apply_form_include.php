<style>
	 .criminal {color:black;}
	 #courtOrdered {}
	 .notCO {}
	 #highCrime {}
	 #lowCrime {}
	 #highCrimeMessage {color:red}
	 #lift40 {}
	 
	 .required {color: #FF0000;}
     .successful { color: #9ACD32;}
	 
	 body {
		  padding-top: 50px;
		  padding-bottom: 50px;
	 }
</style>

<?php // Create connection
    $conn = new mysqli("127.0.0.1", "kaneses_kfb", "Ru4real2016","kaneses_kfb");
    // echo 'Connected to database!';
?>

<!DOCTYPE html>
<html lang="en">
	 <head>
		  <meta charset="utf-8">
		  <meta http-equiv="X-UA-Compatible" content="IE=edge">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		  
		  <!-- Latest compiled and minified CSS -->
		  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		  <!-- jQuery library -->
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		  <!-- Latest compiled JavaScript -->
		  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	 </head>
	 
	 <body>
	 <?php
		  // volunteer application Form for Kent Food Bank
		  // Kandis Brighton IT 305 Application Form for KaNeSeS Kent Food Bank
		  // include "kfb_head.html";
		  
		  // define variables and set to empty values
		  $fname = $lname = $email = $phonenumber = $apptype = $crime = $lift = $activities = $availability = $whyVolunteer = "";
		  
		  $fnameErr = $lnameErr = $emailErr = $phonenumberErr = $apptypeErr = $crimeErr = $liftErr = $whyVolunteerErr = $activitiesErr = $availabilityErr = "";
		  
		  $isValid = true;
		  
		  if($_SERVER['REQUEST_METHOD'] == 'POST') {
		  
			   // Check first name
			   if(empty($_POST['fname'])) {
					$fnameErr = "required field";
					$isValid = false;
			   } else {
					$fname = $_POST['fname'];
					if(ctype_alpha(str_replace(' ', '', $fname)) === false) {
						 $fnameErr = "only letters and white space are allowed";
						 $isValid = false;
					}
			   }
		  
			   // Check last name
			   if(empty($_POST['lname'])) {
					$lnameErr = "required field";
					$isValid = false;
			   } else {
					$lname = $_POST['lname'];
					if(ctype_alpha(str_replace(' ', '', $lname)) === false) {
						 $lnameErr = "only letters and white space are allowed";
						 $isValid = false;
					}
			   }
		  
			   // Check email
			   if(empty($_POST['email'])) {
					$emailErr = "required field";
					$isValid = false;
			   } else {
					$email = $_POST['email'];
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						 $emailErr = "invalid email format";
						 $isValid = false;
					}
			   }
		  
			   // Check phone number
			   if(empty($_POST['phonenumber'])) {
					$phonenumberErr = "required field";
					$isValid = false;
			   } else {
					$phonenumber = $_POST['phonenumber'];
					if(!ctype_digit($phonenumber)) {
						 $phonenumberErr = "please enter numebers only";
						 $isValid = false;
					}
			   }
			   
			   // Check application type
			   if(isset($_POST['apptype'])) {
					$apptype = $_POST['apptype'];
					$validApptype = array("individual", "group", "organization", "school", "courtordered");
					if(!in_array($apptype, $validApptype)) {
						 $apptypeErr = "please select an application type";
						 $isValid = false;
					}
			   } else {
					$apptypeErr = "required field";
					$isValid = false;
			   }
			   
			   // Check activities
			   if(empty($_POST['activities'])) {
					$activitiesErr = "required field";
					$isValid = false;
			   } else {
					$activities = implode(", ", $_POST['activities']);
			   }
			   
			   // Check availability
			   if(empty($_POST['availability'])) {
					$availabilityErr = "required field";
					$isValid = false;
			   } else {
					$availability = implode(", ", $_POST['availability']);
			   }
			   
			   // Check reason to apply
			   if(!empty($_POST['whyVolunteer'])) {
					$whyVolunteer = $_POST['whyVolunteer'];
			   } else {
					$whyVolunteerErr = "required field";
					$isValid = false;
			   }
			   
			   #if the requirements are met, put the user data into database!!!
			   if ($isValid == true) {
			   
					# write the volunteer info into the data base
					// Escape the data
					$fname = mysqli_real_escape_string($conn, $fname);
					
					$lname = mysqli_real_escape_string($conn, $lname);
					
					$email = mysqli_real_escape_string($conn, $email);
					
					$phone = mysqli_real_escape_string($conn, $phone);
					
					$apptype = mysqli_real_escape_string($conn, $apptype);
					
					$activities = mysqli_real_escape_string($conn, $activities);
					
					$availability = mysqli_real_escape_string($conn, $availability);
					
					$availability_text = $_POST['availability_text'];
					$availability_text = mysqli_real_escape_string($conn, $availability_text);
					
					$reason = $_POST['whyVolunteer'];
					$reason = mysqli_real_escape_string($conn, $reason);
					
					// Define the query
					$sql = "INSERT INTO volunteers (first_name, last_name, email, phone, Type, Activities, Availability)
											VALUES ('$fname', '$lname', '$email', '$phonenumber', '$apptype', '$activities', '$availability')";
											
					$result = @mysqli_query($conn, $sql);
					if(!$result) {
						echo "<p>Error: " .mysqli_error($conn) ."</p>";
					}
		  
					// Send an email to KFB
					$expected = ['fname', 'lname', 'email', 'phonenumber', 'whyVolunteer', 'availability', 'availability_text', 'apptype', 'activities', 'crime', 'lift'];
					$required = ['fname', 'lname', 'email', 'phonenumber', 'whyVolunteer', 'apptype', 'availability', 'activities', 'crime', 'lift'];
					#$to = 'Kandis <kandisbrighton@gmail.com>';  //Kaneses <kaneses@greenrivertech.net>';
					$to = 'Bo <bbx719@gmail.com>';  //Kaneses <kaneses@greenrivertech.net>';
					$subject = 'Feedback from online form';
					$headers = [];
					$headers[] = 'From: kaneses@greenrivertech.net';
					$headers[] = 'Cc: kbrighton@mail.greenriver.edu';
					$headers[] = 'Content-type: text/plain; charset=utf-8';
					$authorized = null; //'-kbrighton@mail.greenriver.edu';
					require 'kfb_process_mail.php';
					// if crime is yes then send email information to kent food bank and the person.
		  
					if ($mailSent) {
					   // call the termination page.
					   print "<div id=summary>";
					   print "<h3>Volunteer Summary</h2>";
					   print "<p>Thank you for your application, $fname $lname.</p>";
					   print "<p>Email: $email</p>";
					   print "<p>Phone Number: $phonenumber</p>";
					   print "<p>Application Type: $apptype</p>";
					   print "<p>Activities: ";
					   for ($i=0; $i<sizeof($activities); $i++) {
							   print "$activities[$i] ";
					   }
					   print "</p>";
					   
					   print "<p>Availability: ";
					   for ($i=0; $i<sizeof($availability); $i++) {
							   print "$availability[$i] ";
					   }
					   print "</p>";
					   
					   print "<p>Reasons for volunteering: ";
					   print "$whyVolunteer</p>";
					   
					   // Send an email to the person who applied
					   $to = $email;
					   $subject = 'Thank you';
					   $headers = [];
					   $headers[] = 'From: kaneses@greenrivertech.net';
					   $headers[] = 'Cc: kbrighton@mail.greenriver.edu';
					   $headers[] = 'Content-type: text/plain; charset=utf-8';
					   $authorized = null; //'-kbrighton@mail.greenriver.edu';
					   $headers = implode("\r\n", $headers);
					   $message =  [];
					   $message[] = "Thank you!";
					   $message[] = "";
					   $message[] = "Thank you for your interest in volunteering with the Kent Food Bank, our agency has volunteer positions to accommodate many different schedules, physical abilities and interests.";
					   $message[] = "";
					   $message[] = "Volunteers are a vital part of our ability to provide the basic needs of our community. Thanks to people like you, we are able to spend 99 cents of every dollar donated on direct client services. Last year, volunteers donated more than 20,000 hours to support Kent Food Bank. Without our caring and dedicated volunteers we cannot achieve our mission to end hunger.";
					   $message[] = "";				
					   $message[] = "Once again, thank you for your interest. A staff member will be in contact with you to set up orientation.";
					   $message[] = "";
					   $message[] = "Jeniece Choate, Executive Director";
					   $message[] = "Kent Food Bank and Emergency Services";
					   $message[] = "";
					   $message = implode("\r\n",$message);
					   
					   if (isset($_POST['crime'])) {
							  $crime = $_POST['crime'];
					   }
					   if ($crime == "yes") {
							 $message = "We are sorry. You do not qualify to complete your community service at the Kent Food Bank. Please call 211 to find other community service agencies.";
							 print $message;
					   }
					   mail($to,$subject,$message,$headers,$authorized);
					   ?>
					   <br>
					   <a href= index.php>Return to website.</a>
					   <?php
					   exit;
					}
			   }
		  }
	 ?>
	 
	 <div class="container">
		  <div class="jumbotron">
			 <h2 style="text-align: center">Volunteer Application Form</h2>
			   <span class="required">* required field.</span>
			 
			   <form class="form-horizontal" id="volunteer_form" action="" method="POST" role="form">
				 
					<?php if ($_POST && ($suspect || isset($errors['mailfail']))) : ?>
						 <span class="warning" style="color: red">Sorry, your mail couldn't be sent.</span>
					<?php endif; ?>
					 
					<!-- First name field -->
					<div class="form-group">
						 <label class="col-sm-2 control-label" for="fname">First Name<span class="required">*</span></label>
						 <div class="col-sm-5">
							  <input type="text" class="form-control" name="fname" id="fname" placeholder="your first name" value="<?php echo $fname; ?>">
						 </div>
						 <div class="col-sm-5">
							  <span class="required"><?php echo $fnameErr; ?></span>
						 </div>
					</div>
					 
					<!-- Last name field -->
					<div class="form-group">
						 <label class="col-sm-2 control-label" for="lname">Last Name<span class="required">*</span></label>
						 <div class="col-sm-5">
							  <input type="text" class="form-control" name="lname" id="lname" placeholder="your last name" value="<?php echo $lname; ?>">
						 </div>
						 <div class="col-sm-5">
							  <span class="required"><?php echo $lnameErr; ?></span>
						 </div>
					</div>
					
					<!-- Email field -->
					<div class="form-group">
						 <label class="col-sm-2 control-label" for="email">Email<span class="required">*</span></label>
						   <div class="col-sm-5">
							 <input type="email" class="form-control" name="email" id="email" placeholder="format: name@email.com" value="<?php echo $email; ?>">
						 </div>
						 <div class="col-sm-5">
							  <span class="required"><?php echo $emailErr; ?></span>
						 </div>
					</div>
		  
					<!-- Phone number field -->
					<div class="form-group">
						 <label class="col-sm-2 control-label" for="phonenumber">Phone Number<span class="required">*</span></label>
						 <div class="col-sm-5">
							  <input type="phonenumber" class="col-sm-5 form-control" name="phonenumber" id="phonenumber" placeholder="numbers only" value="<?php echo $phonenumber; ?>">
						 </div>
						 <div class="col-sm-5">
							  <span class="required"><?php echo $phonenumberErr; ?></span>
						 </div>
					</div>
	 
					<!-- Application type field -->
					<div class="form-group">
						 <label class="col-sm-2 control-label">Application Type<span class="required">*</span></label>
						 <div class="col-sm-5">
							  <div class="radio">
								   <label class="notCO"><input type="radio" value="individual" name="apptype" id="apptype" <?php if ($apptype == "individual") { echo "checked"; } ?>>Individual</label>
							  </div>
							  <div class="radio">
								   <label class="notCO"><input type="radio" value="group" name="apptype" id="apptype" <?php if ($apptype == "group") { echo "checked"; } ?> >Group</label>
							  </div>
							  <div class="radio">
								   <label class="notCO"><input type="radio" value="organization" name="apptype" id="apptype" <?php if ($apptype == "organization") { echo "checked"; } ?> >Organization</label>
							  </div>
							  <div class="radio">
								   <label class="notCO"><input type="radio" value="school" name="apptype" id="apptype" <?php if ($apptype == "school") { echo "checked"; } ?> >School</label>
							  </div>
							  <div class="radio">
								   <label id="courtOrdered"><input type="radio" value="courtordered" name="apptype" id="apptype" <?php if ($apptype == "courtordered") { echo "checked"; } ?> >Court Ordered Community Service</label>
							  </div>
						 </div>
						 <div class="col-sm-5">
							  <span class="required"><?php echo $apptypeErr; ?></span>
						 </div>
					</div>
				 
					<!-- Crime field -->
					<div class="criminal">
						 <div class="form-group">
							<label class="col-sm-2 control-label">I have committed theft, fraud, assault, or a crime against children.<?php if (isset($_POST['crime'])) { $crime = $_POST['crime']; } ?></label>
							<div class="col-sm-5">
								 <div class="radio">
									  <label id="highCrime"><input type="radio" value="yes" name="crime" id="crime" <?php if ($crime == "yes") {echo 'checked="checked"';}?>>Yes</label>
								 </div>
								 <div class="radio">
									  <label id="lowCrime"><input type="radio" value="no" name="crime" id="crime" <?php if ($crime == "no") {echo 'checked="checked"';}?>>No</label>
								 </div>
							</div>
						 </div>
					</div>
				 
					<span id="highCrimeMessage">We are sorry. You do not qualify to complete your community service at the Kent Food Bank. <br>Please call 211 to find other community service agencies.</span>
					
					<!-- Able to lift field -->
					<div class="criminal">
						 <div class="form-group">
							<label class="col-sm-2 control-label">I am able to lift 40 pounds.</label>
							<?php if (isset($_POST['lift'])) {$lift = $_POST['lift'];}?>
							<div class="col-sm-5">
								 <div class="radio">
									  <label><input type="radio" value="yes" name="lift" id="lift" <?php if ($lift == "yes") { echo 'checked="checked"'; }?>>Yes</label>
								 </div>
								 <div class="radio">
									  <label id="lift40"><input type="radio" value="no" name="lift" id="lift" <?php if ($lift == "no") { echo 'checked="checked"'; } ?>>No</label>
								 </div>
							</div>
						 </div>
					</div>
				 
					<!-- Activities field -->
					<div class="form-group">
						<label class="col-sm-2 control-label">Volunteer Activities<span class="required">*</span></label>
						<div class="col-sm-5">
							<div class="checkbox">
								 <label><input type="checkbox" name="activities[]" value="clothing" <?php ?>>Clothing</label>
							</div>
							<div class="checkbox">
								 <label><input type="checkbox" name="activities[]" value="office" <?php ?>>Office</label>
							</div>
							<div class="checkbox">
								 <label><input type="checkbox" name="activities[]" value="food" <?php ?>>Food</label>
							</div>
							<div class="checkbox">
								 <label><input type="checkbox" name="activities[]" value="driver" <?php ?>>Driver</label>
							</div>
						</div>
						<div class="col-sm-5">
							  <span class="required"><?php echo $activitiesErr; ?></span>
						</div>
					</div>
					
					<!-- Availability field -->
					<div class="form-group">
						<label class="col-sm-2 control-label">Availability<span class="required">*</span></label>
						<div class="col-sm-5">
						 <div class="checkbox">
							  <label><input type="checkbox" name="availability[]" value="Monday" <?php ?>>Monday</label>
						 </div>
						 <div class="checkbox">
							  <label><input type="checkbox" name="availability[]" value="Tuesday" <?php ?>>Tuesday</label>
						 </div>
						 <div class="checkbox">
							  <label><input type="checkbox" name="availability[]" value="Wednesday" <?php ?>>Wednesday</label>
						 </div>
						 <div class="checkbox">
							  <label><input type="checkbox" name="availability[]" value="Thursday" <?php ?>>Thursday</label>
						 </div>
						 <div class="checkbox">
							  <label><input type="checkbox" name="availability[]" value="Friday" <?php ?>>Friday</label>
						 </div>
						</div>
						<div class="col-sm-5">
							  <span class="required"><?php echo $availabilityErr; ?></span>
						</div>
					</div>
					
					<!-- Reason to apply field -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="whyVolunteer">Why are you interested in volunteering at the Kent Food Bank?<span class="required">*</span></label>
						<div class="col-sm-5">
						 <textarea rows="5" cols="40" name="whyVolunteer" id="whyVolunteer"><?php echo $whyVolunteer; ?></textarea>
						</div>
						<div class="col-sm-5">
							  <span class="required"><?php echo $whyVolunteerErr; ?></span>
						</div>
					</div><br><br>
				 
					<!-- Submit button field --> 
					<div class="form-group">
						 <div class="text-center">
						   <button type="submit" class="btn btn-info" name="submit">Submit Application</button>
						 </div>
					</div>
			   </form>
		  </div>
	 </div>

	 <script src="http://code.jquery.com/jquery.js"></script>
	 <script>
		  // start with low crime checked even though it is hidden.
		  $("#lowCrime").prop("checked",true);
		  $("#lift40").prop("checked",true);
		  $(".criminal").hide();
		  $("#courtOrdered").click(function(){
				 $(".criminal").show();
		  });
		  $(".notCO").click(function(){
				  $(".criminal").hide();
		  });
		  $("#highCrimeMessage").hide();
		  $("#highCrime").click(function(){
			   $("#highCrimeMessage").show();
		  });
		  $("#lowCrime").click(function(){
			   $("#highCrimeMessage").hide();
		  });
		  // $( document ).ready( function(){
		  //	  if ($("#courtOrdered").attr("checked")=="checked") {
		  //			   
		  //          }
		  //   });
		  // on ready
	 </script>
	 </body>
<html>