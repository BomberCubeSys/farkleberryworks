<?php
	$error = ''; //error message
	$user = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	
	if (isset($_POST['login'])) { //check if form is submitted
		if(!isset($_SESSION['incorrect_login'])){ //if incorrect login attempt has been made
			$_SESSION['incorrect_login'] = 0; //set incorrect login attempt to 0
		}
		//check if there has been 3 login attempts
		if($_SESSION['incorrect_login'] == 0){
			$_SESSION['attempt_message'] = 'You have attempted to log in incorrectly 1 time. '.'<br>'; //echo that the number of attempts has been reached
		}
		if($_SESSION['incorrect_login'] == 1){
			$_SESSION['attempt_message'] = 'You have attempted to log in incorrectly 2 times. '.'<br>'.'
											The next invalid attempt will block you from logging in for one minute.'.'<br>'; //echo that the number of attempts has been reached
		}
		if($_SESSION['incorrect_login'] == 2){
			$_SESSION['limit_message'] = 'Welcome back. '.'<br>';
	}
		if(isset($_POST['login'])){ //check if login button is pressed
			if(empty($_POST['email']) && empty($_POST['password'])){ //check if both fields are blank
				//header("location:testloginform.php?Empty= Both fields are blank. Please enter your username and password.");
				$error = "Both fields are blank. Please enter your username and password.";
			} else {
					if(empty($_POST['email'])){ //check if username is empty
						//header("location:/?ctrl=account&action=login?Empty= Please enter your username.");
						$error = "Please enter your username.";
					}
					if(empty($_POST['password'])){ //check if password is empty
						$error = "Please enter your password.";
						//header("location:/?ctrl=account&action=login?Empty= Please enter your password.");
					}
				}
		}	
			if($_POST['email'] && $_POST['password']){ //if both username and password are entered
				echo "both email and password are entered";
				$user = new UserDAM; //use the getUser function from UserDAM.php
				$user->getUser('email'); //if there is a user with the same email
				if (isset($user)) {
					$password = $_POST['password']; //set password variable to password input
					$hashedPassword = password_hash($password,PASSWORD_BCRYPT); //hash password
					//if (bool password_verify ($password, $hashedPassword)){
						//echo "You have successfully logged in!";
						//header("Location:/?ctlr=account&action=register");
					//}
					//loginInstance();
					echo "Success";
				}   else {
					echo "You have entered invalid information.";
					$_SESSION['limit_message'] = 'Invalid login information entered. ';
					//increase number of login limit
					$_SESSION['incorrect_login'] += 1; //increment login attempt by 1 attempt
							//set time delay after the third attempt to one hour
							if($_SESSION['incorrect_login'] == 3){
								$_SESSION['incorrect_login'] == 0; 
								sleep(20); //delay script for one hour
								$_SESSION['incorrect_login'] == 0; 
							}
					}
			}			
	}
?>