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

    if ($friend->unblockFriend()) {
        $unblock_arr = array(
            "status" => true,
            "message" => "Successfully Unblocked $user_two ",
        );
    } else {
        $unblock_arr = array(
            "status" => false,
            "message" => "Failed to Unblocked $user_two ",
        );
    }
    print_r(json_encode($unblock_arr));
}
