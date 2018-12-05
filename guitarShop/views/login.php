<?php require('views/farkleberryHeader.php');
	  //require('login.php');
	  //require('loginProcess.php');
	  //require_once('db/UserDAM.php');
?>
<?php
	if(isset($_SESSION['login_time'])){ //check if the login limit time was set
		$time = time();
		if($time >= $_SESSION['login_time']){
			unset($_SESSION['incorrect_login']);
			unset($_SESSION['login_time']);
		}
	}
	if(isset($_SESSION['login'])){ //successfully logged in
		header("Location: profile.php"); //redirect to profile page
	}
	if(isset($_SESSION['attempt_message'])){
	echo $_SESSION['attempt_message'];
	unset($_SESSION['attempt_message']);
	}
	if(isset($_SESSION['limit_message'])){
	echo $_SESSION['limit_message'];
	unset($_SESSION['limit_message']);
	}
	if(isset($_SESSION['logged_in'])){
		echo $_SESSION['logged_in'];
		unset($_SESSION['logged_in']);
	}
	if(@$_GET['Empty']==true){
		echo $_GET['Empty'];
	}
?>
<?php
	if(@$_GET['Invalid']==true){
		echo $_GET['Invalid'];
	}
?>
<!DOCTYPE html>
<html>
<main>
    <section>
        <center><h1>Login Page</h1>
        <div id="content">
            <h2>Please login by entering your e-mail and password.</h2><br/>
			<?php if (isset($vm->errorMsg)) { echo $vm->errorMsg.'<br/>'.'<br/>'; }?>
        <form action="." method="post">
        <input type="hidden" name="ctlr" value="account">
        <input type="hidden" name="action" value="login">
        <label>Username:</label><input type="text" name="email" placeholder="E-Mail"><br/>
        <label>&nbsp;Password:</label><input type="password" name="password" placeholder="Password">
        <br><br>
        <button type="submit" class="loginbutton" name = "submit">Login</button>
    </form>
	</div>
    </section>
</main>
</html>
