<?php

/**
 * User model data access and manipulation (DAM) class.
 *
 * @author Group We're Ready and jam
 */
class UserDAM extends DAM {

    // Database connection is inherited from the parent.
    function __construct() {
        parent::__construct();
    }

    /**
     * Read the User object from the database with the specified email
     * @param type $email the email of the user to be retrieved.
     * @return \User the resulting User object - null if user is
     * not in the database.
     */
    public function getUser($email) {
        $query = 'SELECT * FROM users WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $userDB = $statement->fetch();
        $statement->closeCursor();
        if ($userDB == null) {
            return null;
        } else {
          $foundUser = new User();
          $foundUser->id = $userDB['id'];
          $foundUser->firstname = $userDB['firstname'];
          $foundUser->lastname = $userDB['lastname'];
          $foundUser->email = $userDB['email'];
          $foundUser->phone = $userDB['phone'];
          $foundUser->address = $userDB['address'];
          $foundUser->city = $userDB['city'];
          $foundUser->state = $userDB['state'];
          $foundUser->zip = $userDB['zip'];
          $foundUser->country = $userDB['country'];
          $foundUser->state = $userDB['state'];
          $foundUser->password = $userDB['password'];
          $foundUser->admin = $userDB['admin'];
          return $foundUser;
        }
    }

    /**
     * Write the specified user to the database. If the user is not
     * in the database, the object is added. If the user is already in the
     * database, the object is updated.
     * @param type $user the User object to be written.
     */
    public function createUser(User $newUser) {
        // Check to see if the user is already in the database.
        $query = 'SELECT email FROM users WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $newUser->email);
        $statement->execute();
        $userDB = $statement->fetch();
        $statement->closeCursor();
        if ($userDB == null) {
          // Add a new user to the database
          $query = 'INSERT INTO users
              (firstname, lastname, email,
              phone, address, city, zip, country,
              state, password, admin, id)
            VALUES
              (:firstname, :lastname, :email,
              :phone, :address, :city, :zip,
              :country, :state, :password, :admin, :id)';
          $statement = $this->db->prepare($query);
          $statement->bindValue(':firstname',$newUser->firstname);
          $statement->bindValue(':lastname',$newUser->lastname);
          $statement->bindValue(':email',$newUser->email);
          $statement->bindValue(':phone',$newUser->phone);
          $statement->bindValue(':address',$newUser->address);
          $statement->bindValue(':city',$newUser->city);
          $statement->bindValue(':zip',$newUser->zip);
          $statement->bindValue(':country',$newUser->country);
          $statement->bindValue(':state',$newUser->state);
          $statement->bindValue(':password',$newUser->password);
          $statement->bindValue(':admin', 0 );
          $statement->bindValue(':id', null);
          $statement->execute();
          $statement->closeCursor();
          //no error
          return;
        } else {
          return "email already exists";//error
        }



    }

    // This function should only be used by logged in users on their own user email.
    // This should not be used to create a new user.
    // This function can not be used to update non-existant users.
    public function updateUser($user) {

        // Check to see if the user is already in the database.
        $query = 'SELECT * FROM users
              WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $user->email);
        $statement->execute();
        $userDB = $statement->fetch();
        $statement->closeCursor();
        if ($userDB == null) {
            //nothing
        } else {

            // Update an existing user.
            $query = 'UPDATE users
              SET firstname = :firstname, lastname = :lastname,
                email = :email, phone = :phone, address = :address,
                city = :city, zip = :zip, country = :country,
                state = :state, password = :password, admin = :admin
              WHERE id = :id';

            $statement = $this->db->prepare($query);
            $statement->bindValue(':id',$user->id);
            $statement->bindValue(':firstname',$user->firstname);
            $statement->bindValue(':lastname',$user->lastname);
            $statement->bindValue(':email',$user->email);
            $statement->bindValue(':phone',$user->phone);
            $statement->bindValue(':address',$user->address);
            $statement->bindValue(':city',$user->city);
            $statement->bindValue(':zip',$user->zip);
            $statement->bindValue(':country',$user->country);
            $statement->bindValue(':state',$user->state);
            $statement->bindValue(':password',$user->password);
            $statement->bindValue(':admin',$user->admin);
            $statement->execute();
            $statement->closeCursor();
        }
    }

    // Translate database columnames to object instance variable names
    private function mapColsToVars($colArray) {
        $varArray = array();
        foreach ($colArray as $key => $value) {
            if ($key == 'id') {
                $varArray ['id'] = $value;
            } else if ($key == 'firstname') {
                $varArray ['firstname'] = $value;
            } else if ($key == 'lastname') {
                $varArray ['lastname'] = $value;
            } else if ($key == 'phone') {
                $varArray ['phone'] = $value;
            } else if ($key == 'address') {
                $varArray ['address'] = $value;
            } else if ($key == 'email' ) {
                $varArray ['email'] = $value;
            } else if ($key == 'city') {
                $varArray ['city'] = $value;
            } else if ($key == 'zip') {
                $varArray ['zip'] = $value;
            } else if ($key == 'country') {
                $varArray ['country'] = $value;
            } else if ($key == 'state') {
                $varArray ['state'] = $value;
            } else if ($key == 'password') {
                $varArray ['password'] = $value;
            } else if ($key == 'admin') {
                $varArray ['admin'] = $value;
            }
        }
        return $varArray;
    }
}
