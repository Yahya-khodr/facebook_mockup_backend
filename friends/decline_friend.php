<?php

include("../model/database.php");
include("../model/friend.php");

$database = new Database();
$db = $database->getConnection();
$friend = new Friend($db);

$user_one = $_POST["sender_id"];
$user_two = $_POST["reciever_id"];


$friend->user_one = $user_one;
$friend->user_two = $user_two;

if (isset($user_one, $user_two)) {
    if ($friend->deleteRequest($user_one, $user_two)) {
        $delete_arr = array(
            "status" => true,
            "message" => "Request Ignored !",
        );
    }
    print_r(json_encode($delete_arr));
}
