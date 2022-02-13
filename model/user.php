
<?php 

class User{
    private $con;

    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $profile_image;


    public function __construct($db){
        $this->con = $db;
    }
    function login(){

        $query = $this->con->prepare("SELECT id FROM users WHERE email = ? AND password = ? ");
        $query->bind_param("ss", $this->email, $this->password);
        $query->execute();
        
        return $query;
    }


    
}