<?php

/**
 * Controller for logins and user self-management.
 *
 * @author Group We're Ready and jam
 */
 class AccountController extends DefaultController {

	 protected $model = null;

	 public function __construct() {
		 parent::__construct();
	 }

	 public function loginGET() {
		 Page::$title = 'Login';
		 //Page::$username = $_SESSION['user']->username;
		 require(APP_NON_WEB_BASE_DIR . 'views/login.php');
	 }

   public function loginPOST() {
     $vm = AccountVm::loginInstance();
     // Redirect to Home page on success
     if ($vm->errorMsg == '') {
       Page::$title = 'Home';
       require(APP_NON_WEB_BASE_DIR . 'views/home.php');
     } else {
       Page::$title = 'Login';
       require(APP_NON_WEB_BASE_DIR . 'views/login.php');
   }
 }

	 public function myAccountGET() {
		Page::$title = 'My Account';
		//Page::$user = $_SESSION['user']->username;
		require(APP_NON_WEB_BASE_DIR . 'views/myAccount.php');
	 }

 	 public function myAccountPOST() {
 		Page::$title = 'My Account';
 		//Page::$user = $_SESSION['user']->username;
 		require(APP_NON_WEB_BASE_DIR . 'views/myAccount.php');
 	 }

	 public function registerGET() {
		 Page::$title = 'Register a new account';
		 require(APP_NON_WEB_BASE_DIR . 'views/register.php');
	 }
   public function registerPOST() {
     $vm = AccountVM::newUserInstance();
     // Redirect to login page on success
     if ($vm->errorMsg == '') {
       Page::$title = 'Login';
       require(APP_NON_WEB_BASE_DIR . 'views/home.php');
     } else {
       Page::$title = 'Register a new account';
       require(APP_NON_WEB_BASE_DIR . 'views/register.php');
     }
   }
     public function logout() {
       if (!isset($_SESSION)) {session_start();}
       session_unset();
       session_destroy();
       Page::$title = 'Farkleberry Home';
       require(APP_NON_WEB_BASE_DIR . 'views/home.php');
     }

   }
?>
