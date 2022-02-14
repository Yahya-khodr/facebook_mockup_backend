<?php


include("../model/database.php");
include("../model/user.php");
$database = new Database();
$db = $database->getConnection();
$user = new User($db);


if (isset($_POST["email"])) {
    $user->email = $db->real_escape_string($_POST["email"]);
} else {
    die("Enter an email");
}

if (isset($_POST["password"])) {
    $user->password = $db->real_escape_string($_POST["password"]);
    $password = hash("sha256", $user->password);
} else {
    die("Enter a password");
}

$query = $user->login();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($user_id);
$query->fetch();

if ($num_rows == 0) {
    $user_array = array(
        "status" => false,
        "message" => "Invalid Email or Password",
    );
} else {
    $user_array = array(
        "status" => true,
        "message" => "Successfully Login !",
        "id" => $user_id,
    );
}
print_r(json_encode($user_array));
