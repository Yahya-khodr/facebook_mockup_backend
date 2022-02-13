<?php

include("fbmockupdb_info.php");

if(isset($_POST["email"])){
    $email = $mysqli->real_escape_string($_POST["email"]);
}else{
    die("Enter a valid email address!");
}

if(isset($_POST["password"])){
    $password = $mysqli->real_escape_string($_POST["password"]);
    $password = hash("sha256", $password);
}else{
    die("Enter a valid password!");
}

$query = $mysqli->prepare("SELECT id FROM user WHERE email = ? AND password = ?");
$query->bind_param("ss", $email, $password);
$query->execute();

$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($id);
$query->fetch();

$array_response = [];

if($num_rows == 0){
    $array_response["status"] = "Wrong email or password";
}else{
    $array_response["status"] = "Logged in!";
    $array_response["user_id"] = $id;
}
 
$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$mysqli->close();

?>
