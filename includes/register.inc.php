<?php

if (isset($_POST['submit'])) { //check if register submit button was clicked

	include_once 'dbh.inc.php';
	
	$firstname = mysqli_real_escape_string($conn, $_POST['firstname']); //insert first name into database
	$lastname = mysqli_real_escape_string($conn, $_POST['lastname']); //insert into database
	$email = mysqli_real_escape_string($conn, $_POST['email']); //insert into database
	$phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']); //insert into database
	$fax = mysqli_real_escape_string($conn, $_POST['fax']); //insert into database
	$company = mysqli_real_escape_string($conn, $_POST['company']); //insert into database	
	$address_1 = mysqli_real_escape_string($conn, $_POST['address_1']); //insert into database
	$city = mysqli_real_escape_string($conn, $_POST['city']); //insert into database
	$postcode = mysqli_real_escape_string($conn, $_POST['postcode']); //insert into database
	$country_id = mysqli_real_escape_string($conn, $_POST['country_id']); //insert into database
	$zone_id = mysqli_real_escape_string($conn, $_POST['zone_id']); //insert into database
	$password = mysqli_real_escape_string($conn, $_POST['password']); //insert into database	
	$confirm = mysqli_real_escape_string($conn, $_POST['confirm']); //insert into database

	//error handler
	//check for empty fields
	if (empty($firstname) || empty($lastname) || empty($email) || empty($phonenumber) || empty($fax) || empty($company) || empty($address_1) ||
		empty($city) || empty($postcode) || empty($country_id) || empty($zone_id) || empty($password) || empty($confirm)
		header("Location: ../register.html?register=empty");
		exit(); //stops the script from running	
	} else {
		//check if input characters are valid
	if (!preg_match("/^[a-zA-Z]*$/", $firstname) || !preg_match("/^[a-zA-Z]*$/", $lastname))){ //if first name are not these characters
			// code, stopped at 54:58 of the video, add more preg matches later
		header("Location: ../register.html?register=invalid");
		exit();
		} else {
			//check if email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //checks if email is not valid
			header("Location: ../register.html?register=invalidemail");
			exit();
			} else {
				$sql = "SELECT * FROM users WHERE user_uid ='$uid'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result); // if there is any result then throw error message
				
				if ($resultCheck > 0){ //check if user has same username already
					header("Location:../register.html?register=usertaken");
					exit();
			} else {
				//hash password
				$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
				//insert the user into the database
				$sql = "INSERT INTO users (user_firstname, user_lastname, user_email, user_uid, user_password) VALUES ('$firstname', '$lastname',
				'$email', '$uid', '$hashedpassword');"; //take the data and insert it into the database
				mysqli_query($conn, $sql);
			header("Location: ../register.html?register=success");
			exit();
			}
		}
	}
	
} else {
	header("Location: ../register.html");
	exit(); //stops the script from running
}