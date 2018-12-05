<?php

/**
 * @author Group We're Ready and jam
 *
 *
 */
class User {

    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $phone;
    private $address;
    private $city;
	  private $zip;
	  private $country;
	  private $state;
	  private $password; //This should be set for the first time with setPassword
    private $admin;

    /**
     * Builds an object with instance variables set. Only the instance variables
     * will be set that correspond to the input data (i.e., not all instance
     * variables will be set in all cases.
     * @param array $data Optional values to be loaded in instance variables.
     */
    function __construct($data = array()) {
        if (!is_array($data)) {
            trigger_error('Non-array input to ' . get_class() . 'constructor');
        } else

        // If the input array has at least one value, set the corresponding
        // instance variable.
        if ($data !== null && $data > 0) {
            foreach ($data as $name => $value) {
                $this->name = $value;
            }
        }
    }

    function verifyUser($post_var_name) {
        $cleanPassword = hPOST($post_var_name);
        return password_verify($password, $cleanPassword);
    }
    /**
     * should be used to hash and store the plain text password into the user object
     */
    function setPassword($pass) {
        $password = password_hash($pass,PASSWORD_BCRYPT);
    }

    function isAdmin() {
        if ($admin == 1)
            return true;
        else
            return false;
    }

    function __get($name) {
        return $this->$name;
    }

    function __set($name, $value) {
        $this->$name = $value;
    }
}
?>
