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



$profile_image = $_FILES['profile_image']['name'];
$target_dir = "C:/xampp\htdocs/facebook_mockup/backend/images/";
$target_file = $target_dir . basename($_FILES["profile_image"]["name"]);

// Select file type
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Valid file extensions
$extensions_arr = array("jpg", "jpeg", "png", "gif");

// Check extension
if (in_array($imageFileType, $extensions_arr)) {

    // Upload file
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_dir . $profile_image)) {
        // Convert to base64 
        $image_base64 = base64_encode(file_get_contents($target_dir . $profile_image));
        $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;
    }
}

$user->first_name = $first_name;
$user->last_name = $last_name;
$user->email = $email;
$user->password = hash("sha256", $password);
$user->profile_image = $profile_image;




if (isset($first_name, $last_name, $email, $password, $profile_image)) {


    if ($user->signUp()) {

        $user_arr = array(
            "status" => true,
            "message" => "Successfully added a new user",
            "first_name" => $user->first_name,
        );
    } else {
        $user_arr = array(
            "status" => false,
            "message" => "User already exist",
        );
    }
    print_r(json_encode($user_arr));
}
