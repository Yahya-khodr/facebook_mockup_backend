<?php
include("../model/database.php");
include("../model/friend.php");

$database = new Database();
$db = $database->getConnection();
$friend = new Friend($db);
$user_id = $_POST["user_id"];


if (isset($user_id)) {
    $friend_requests = $friend->getFriendRequests($user_id);
    $friend_requests = $friend_requests->get_result();
    $requests_arr = [];
    while ($requests = $friend_requests->fetch_assoc()) {
        $requests_arr[] = $requests;
    }

    print_r(json_encode($requests_arr));
}
