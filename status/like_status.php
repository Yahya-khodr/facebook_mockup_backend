<?php

include("../model/database.php");
include("../model/status.php");


$database = new Database();
$db = $database->getConnection();
$status = new Status($db);
$post_id = $_POST["post_id"];
$user = $_POST["user_id"];

if (isset($post_id)) {
    if ($status->likeStatus($post_id)) {
        $increment_arr = array(
            "status" => true,
            "message" => "Added a like from .'$post_id'.",
        );
    } else {
        $increment_arr = array(
            "status" => false,
            "message" => "Failed to add a like",
        );
    }
    print_r(json_encode($increment_arr));
}
