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
    if (hPOST('firstname') !== null) $vm->errorMsg .= 'first name is required <br />';
    if (hPOST('lastname') !== null) $vm->errorMsg .= 'last name is required <br />';
    if (hPOST('email') !== null) $vm->errorMsg .= 'email is required <br />';
    if (hPOST('phone') !== null) $vm->errorMsg .= 'phone is required <br />';
    if (hPOST('address') !== null) $vm->errorMsg .= 'address is required <br />';
    if (hPOST('city') !== null) $vm->errorMsg .= 'city is required <br />';
    if (hPOST('state') !== null) $vm->errorMsg .= 'state is required <br />';
    if (hPOST('zip') !== null) $vm->errorMsg .= 'zip is required <br />';
    if (hPOST('country') !== null) $vm->errorMsg .= 'country is required <br />';
    if (hPOST('state') !== null) $vm->errorMsg .= 'state is required <br />';
    if (hPOST('password') !== null) $vm->errorMsg .= 'password is required <br />';
    if (hPOST('confirm') !== null) $vm->errorMsg .= 'confirm your password <br />';

    if ($vm->errorMsg !== '') return $vm;
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
