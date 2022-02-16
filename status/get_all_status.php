<?php
include("../model/database.php");
include("../model/status.php");


$database = new Database();
$db = $database->getConnection();
$status = new Status($db);




$status_list = $status->getAllStatus();
$status_list = $status_list->get_result();
$status_arr = [];
while ($array = $status_list->fetch_assoc()) {
    $status_arr[] = $array;
}
print_r(json_encode($status_arr));
