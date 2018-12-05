<? php

session_start(); //start session

if (isset($_POST['submit'])){
	
	include 'dbh.inc.php';
	
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	
	//error handlers
	//check if inputz are empty
	if (empty($email) || empty($password)) {
		header("Location: ../login.html?login=empty");
		exit();	
	} else {
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result); //shows how many rows were found in the database
		if ($resultCheck < 1) { // if there are no rows that were added
			header("Location: ../login.html?login=error");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)){ //takes data from email and insert it in an arrow called $row
				//dehashing the password
				$hashedPwdCheck = password_verify($pwd, $row['user_password']); //match password with database password, not sure if user_password is correct variable 1:16:32
				if ($hashedPwdCheck == false) {
					header("Location: ../login.html?login=error");
					exit();
				} elseif ($hashedPwdCheck == true) {
					//log in the user here
					$_SESSION['u_id'] = $row['user_id']; //row is data inside database, set ID of user u_id
					$_SESSION['u_firstname'] = $row['user_firstname'];
					$_SESSION['u_lastname'] = $row['user_lastname'];
					$_SESSION['u_email'] = $row['user_email']; //not sure if the variable name for this is right, add more variables later
					header("Location: ../login.html?login=success");
					exit(); //exit the script
				}
				}
			}
		}
	}

} else {
	header("Location: ../login.html?login=error");
	exit();
}