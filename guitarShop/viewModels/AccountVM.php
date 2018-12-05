<?php

/**
 * @author Group We're Ready and jam
 */
class AccountVM {

  public $User;
  public $errorMsg;
  public $email;
  public $hashedPassword;
  protected $UserDAM;

  public function __construct() {
    $this->errorMsg = '';
    $this->hashedPassword = '';
    $this->email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $this->UserDAM = new UserDAM();
    if ($this->UserDAM->getUser($this->email) !== null) {
      $this->User = $this->UserDAM->getUser($this->email);
    } else {
      $this->User = '';
    }
    if (isset($_SESSION['email'])) {
      $this->user = $this->UserDAM->getUser($email);
    }
  }

  public static function newUserInstance() {
    $vm = new self();
    // $vm->email = hPOST('email');
    $vm->email = $_POST['email'];
    //if block for validation functions for email, phone, zip, and password
    //if (hPOST('phone'))...
    //
    $varArray = array(
      'firstname' => hPOST('firstname'),
      'lastname' => hPOST('lastname'),
      'email' => hPOST('email'),
      'phone' => hPOST('phone'),
      'address' => hPOST('address'),
      'city' => hPOST('city'),
      'state' => hPOST('state'),
      'zip' => hPOST('zip'),
      'country' => hPOST('country'),
      'state' => hPOST('state'),
      'password' => hPOST('password'),
      'admin' => '0' );
    $vm->User = new User($varArray);
    $vm->User->setPassword($varArray['password']);
    $vm->errorMsg = $vm->UserDAM->createUser($vm->User);
    if ($vm->errorMsg === 0) {
      return $vm;
    } else {
      $errorMsg = 'User Creation Failed';
      return $vm;
    }
  }

  //gets password through post paramter
  public static function loginInstance() {
    if ( !isset($_SESSION) ) { session_start(); }
    $vm = new self();
    $vm->email = hPOST('email');
    $vm->User = $vm->UserDAM->getUser($email);
    if ($vm->User->verifyUser('password')) {
      $_SESSION['email'] = $vm->email;
      $_SESSION['logged_in']==1;
      $_SESSION['time'] = time();
      return $vm;
    } else {
      $vm->errorMsg = "Email and password mismatch";
      return $vm;
    }
  }

  //works only if user is logged in.
  public static function accountInstance() {
      if ( !isset($_SESSION) ) { session_start(); }
      $vm = new self();
      if ($vm->email !== '') {
        return $vm->UserDAM->getUser($vm->email);
      } else {
        return null;
      }
  }

}
