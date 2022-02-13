<?php

class Database
{
    public $con;

    public function getConnection()
    {
        $this->con = null;
        try {
            $this->con = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

            if (mysqli_connect_errno()) {
                throw new Exception("Couldn't connect to database");
            } else {
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $this->con;
    }
    public function closeDatabase(){
        $this->con->close();
    }
}

// credentials
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE_NAME", "fbmockupdb");
