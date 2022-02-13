
<?php
include("../fb_mockup.php");

$post_content = $_POST["post_content"];
$created_by = $_POST["created_by"];

if (isset($post_content, $created_by)) {
    $add_status = $mysqli->prepare("INSERT INTO posts(post_content, created_by) VALUES (?,?)");
    $add_status->bind_param("ss", $post_content, $created_by);
    $add_status->execute();

    $response = [];
    $response["status"] = "New Post Created !";
    $response["created_by"] = $created_by;
    $json_response =  json_encode($response);
    echo $json_response;
} else {
    die("Make sure to add content");
}

$add_status->close();
$mysqli->close();
