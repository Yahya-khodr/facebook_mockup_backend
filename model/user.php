
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
    public function login()
    {
        $query = $this->con->prepare("SELECT id FROM users WHERE email = ? AND password = ? ");
        $query->bind_param("ss", $this->email, $this->password);
        $query->execute();
        return $query;
    }
    public function signUp()
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

    public function isAlreadyRegistered()
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

    public function getUsers($id)
    {
        $users = $this->con->prepare("SELECT u.id, u.first_name, u.last_name , u.profile_image 
            FROM users u WHERE not exists (SELECT 1 FROM blocked_list b WHERE b.blocked_by = ? AND b.blocked_user = u.id)
            AND not exists (SELECT 1 FROM blocked_list b WHERE b.blocked_by = u.id AND b.blocked_user = ?)
        ");
        $users->bind_param("ii", $id, $id);
        $users->execute();
        return $users;
    }
}
