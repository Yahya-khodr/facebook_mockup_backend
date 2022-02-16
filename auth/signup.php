<?php

include("../model/database.php");
include("../model/user.php");

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$password = $_POST["password"];

$profile_image = $_FILES['profile_image'];

$extension = pathinfo($profile_image['name'], PATHINFO_EXTENSION);
$target_dir = "C:/xampp/htdocs/facebook_mockup/frontend/assets/";
$new_name = time() . '.' . $extension;

move_uploaded_file($profile_image['tmp_name'], $target_dir . $new_name);
$image =  $new_name;



$user->first_name = $first_name;
$user->last_name = $last_name;
$user->email = $email;
$user->password = hash("sha256", $password);
$user->profile_image = $image;




if (isset($first_name, $last_name, $email, $password, $profile_image)) {


    if ($user->signUp()) {

        $user_arr = array(
            "status" => true,
            "message" => "Successfully added a new user",
            "first_name" => $user->first_name,
            "profile_path" => $image,
        );
    } else {
        $user_arr = array(
            "status" => false,
            "message" => "User already exist",
        );
    }
    print_r(json_encode($user_arr));
}
