<?php
include("../model/database.php");
include("../model/user.php");

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$user_id = $_GET["user_id"];

if (isset($user_id)) {
    $user_request = $user->getUserById($user_id);
    $user_request = $user_request->get_result();
    $user_arr = [];

    while ($user = $user_request->fetch_assoc()) {
        $user_arr[] = $user;
    }

    print_r(json_encode($user_arr));
}
