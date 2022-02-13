<?php

include ("fbmockupdb_info.php");

if(isset($_POST["first_name"]) && isset($_POST["last_name"])){
    $first_name = $mysqli->real_escape_string($_POST["user_name"]);
    $last_name = $mysqli->real_escape_string($_POST["user_name"]);
}else{
    die("Please input all the fields.");
};

if(isset($_POST["password"])){
    $password = $_POST["password"];
    $password = hash("sha256", $password);
}else{
    die("Please input all the fields.");
}; 

if(isset($_POST["email"])){
    $email = $mysqli->real_escape_string($_POST["email"]);
}else{
    die("Please input all the fields.");
};
    $check_query = $mysqli->prepare("SELECT id FROM user_account WHERE email = ?");
    $check_query->bind_param("s", $email);
    $check_query->execute();
    $check_query->store_result();
    $num_rows = $check_query->num_rows;
    $query->bind_result($id);
    $query->fetch();
    $array_response = [];
    
    if($num_rows > 0){
        $array_response["status"] = "Email already has been used!";
        $json_response = json_encode($array_response);
        die($json_response);
    }

$check_query = $mysqli->prepare("INSERT INTO user (`first_name`, `last_name`, `email`, `password`) VALUES (?, ?, ?, ?)"); 
$check_query->bind_param("ssss", $first_name, $last_name, $email, $password);
$check_query->execute();

$array_response["status"] = "Success!";
$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$mysqli->close();
?>