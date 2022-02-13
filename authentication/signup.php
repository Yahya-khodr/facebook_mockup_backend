<?php

include("../model/database.php");
include("../model/user.php");

$database = new Database();
$db = $database->getConnection();
$user = new User($db);


$password = $_POST["password"];


$user->first_name = $_POST["first_name"];
$user->last_name = $_POST["last_name"];
$user->email = $_POST["email"];
$user->password = hash("sha256", $password);
$user->profile_image = $_POST["profile_image"];


if ($user->signUp()) {

    $user_arr = array(
        "status" => true,
        "message" => "Successfully added a new user",
        "first_name" => $fname,
    );
} else {
    $user_arr = array(
        "status" => false,
        "message" => "User already exist",
    );
}
print_r(json_encode($user_arr));
