<?php
include("../model/database.php");
include("../model/friend.php");

$database = new Database();
$db = $database->getConnection();
$friend = new Friend($db);
$user_id = $_POST["user_id"];


if(isset($user_id)){
    $friends = $friend->getFriends($user_id);
    $friends = $friends->get_result();
    $friends_arr = [];

    while ($user_friends = $friends->fetch_assoc()){
        $friends_arr[] = $user_friends;
    }

    print_r(json_encode($friends_arr));
}