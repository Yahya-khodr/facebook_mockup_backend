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
    if ($friend->acceptFriend()) {
        //remove requests from both sides
        $friend->deleteRequest($user_one, $user_two);
        $friend->deleteRequest($user_two, $user_one);
        $accept_arr = array(
            "status" => true,
            "message" => "Request Accepted !",
        );
    } else {
        $accept_arr = array(
            "status" => false,
            "message" => "Something Went Wrong !",
        );
    }
    print_r(json_encode($accept_arr));
}
