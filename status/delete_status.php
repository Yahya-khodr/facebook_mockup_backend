<?php

include("../model/database.php");
include("../model/status.php");


$database = new Database();
$db = $database->getConnection();
$status = new Status($db);

$status_id = $_POST["post_id"];
$status->id = $status_id;
//DELETE status
if (isset($status_id)) {
    $status->deleteStatus($status_id);
}
