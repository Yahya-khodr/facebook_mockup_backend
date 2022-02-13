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
    if ($friend->addFriend()) {
        $request = array(
            "status" => true,
            "message" => "Request Has been Sent !",
            "sender" => $user_one,
            "reciever" => $user_two,
        );
    } else {
        $request = array(
            "status" => false,
            "message" => "Already a friend !",
        );
    }

    print_r(json_encode($request));
}
