<?php
include("../model/database.php");
include("../model/friend.php");
$database = new Database();
$db = $database->getConnection();
$friend = new Friend($db);

$user_one = $_POST["blocked_user"];
$user_two = $_POST["blocked_by"];


$friend->user_one = $user_one;
$friend->user_two = $user_two;


if (isset($user_one, $user_two)) {
    if ($friend->blockFriend($user_one, $user_two)) {
        $block_arr = array(
            "status" => true,
            "message" => "Blocked user susccessfully !",

        );
    } else {
        $block_arr = array(
            "status" => false,
            "message" => "Failed to block the user",
        );
    }

    print_r(json_encode($block_arr));
}
