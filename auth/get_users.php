<?php
include("../model/database.php");
include("../model/user.php");

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$user_id = $_POST["user_id"];

if (isset($user_id)) {
    $users_request = $user->getUsers($user_id);
    $users_request = $users_request->get_result();
    $users_arr = [];

    while ($users = $users_request->fetch_assoc()) {
        if ($users["id"] != $user_id) {
            $users_arr[] = $users;
        }
    }

    print_r(json_encode($users_arr));
}
