<?php

include("../model/database.php");
include("../model/status.php");


$database = new Database();
$db = $database->getConnection();
$status = new Status($db);

$post_content = $_POST["post_content"];
$status->post_content = $post_content;
$post_id = $_POST["post_id"];


if (isset($post_content)) {
    try {
        $status->updateStatus($post_id);
        $update_arr = array(
            "status" => true,
            "message" => "Status has been Updated !",
        );
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
    print_r(json_encode($update_arr));
}
