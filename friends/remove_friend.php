<?php
include("../model/database.php");
include("../model/friend.php");

$database = new Database();
$db = $database->getConnection();
$friend = new Friend($db);

$user_one = $_POST["user_one"];
$user_two = $_POST["user_two"];

$friend->user_one = $user_one;
$friend->user_two = $user_two;


if (isset($user_one, $user_two)) {
    if ($friend->removeFriend()) {
        $remove_arr = array(
            "status" => true,
            "message" => "Removed Friend Successfully !",
        );
    } else {
        $remove_arr = array(
            "status" => false,
            "message" => "Failed to remove friend!",
        );
    }

    print_r(json_encode($remove_arr));
}
