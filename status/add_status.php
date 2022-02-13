
<?php

include("../model/database.php");
include("../model/status.php");

$database = new Database();
$db = $database->getConnection();
$status = new Status($db);
$post_content = $_POST["post_content"];
$user = $_POST["created_by"];
$status->post_content  = $post_content;
$status->user = $user;
// ADD new status
if (isset($post_content, $user)) {

    try {
        $status->createStatus();
        $status_arr = array(
            "status" => true,
            "message" => "Successfully Added New Status !",
        );
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
    print_r(json_encode($status_arr));
}

$database->closeDatabase();
