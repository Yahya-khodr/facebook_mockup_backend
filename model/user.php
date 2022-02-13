
<?php

class User
{
    //Database connection
    private $con;

    // object properties
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $profile_image;

    public function __construct($db)
    {
        $this->con = $db;
    }
    function login()
    {
        $query = $this->con->prepare("SELECT id FROM users WHERE email = ? AND password = ? ");
        $query->bind_param("ss", $this->email, $this->password);
        $query->execute();
        return $query;
    }
    function signUp()
    {
        if ($this->isAlreadyRegistered()) {
          return false; //user already regeistered
            
        } else {
            $add_user = $this->con->prepare("INSERT INTO users(first_name, last_name, email, password, profile_image) VALUES (?,?,?,?,?) ");
            $add_user->bind_param("sssss", $this->first_name, $this->last_name, $this->email, $this->password, $this->profile_image);
            $add_user->execute();
            return $add_user;
        }
    }

    function isAlreadyRegistered()
    {
        $check_user = $this->con->prepare("SELECT email FROM users WHERE email = ?");
        $check_user->bind_param("s", $this->email);
        $check_user->execute();
        $check_user->store_result();
        $check_user->bind_result($this->email);
        $check_user->fetch();
        $num_rows = $check_user->num_rows;
        if ($num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
