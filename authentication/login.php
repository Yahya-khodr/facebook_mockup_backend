<?php




include("../model/database.php");
include("../model/user.php");

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if (isset($_POST["email"])) {
    $user->email = $db->real_escape_string($_POST["email"]);
} else {
    die("Enter an email");
}

if (isset($_POST["password"])) {
    $user->password = $db->real_escape_string($_POST["password"]);
    $password = hash("sha256", $user->password);
} else {
    die("Enter a password");
}

$query = $user->login();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($user_id);
$query->fetch();

if ($num_rows == 0) {
    $user_array = array(
        "status" => false,
        "message" => "Invalid Email or Password",
    );
} else {
    $user_array = array(
        "status" => true,
        "message" => "Successfully Login !",
        "id" => $user_id,
    );
}
print_r(json_encode($user_array));




// $stmt = $user->login();
// if ($stmt->rowCount() > 0) {
//     $row = $statment->fetch();
//     $user_array = array(
//         "status" => true,
//         "message" => "Successfully log in !",
//         "id" => $row["id"],
//         "username" => $row["first_name"] . $row["last_name"],

//     );
// } else {
//     $user_array = array(
//         "status" => false,
//         "message" => "Invalid email or password",
//     );
// }

// print_r(json_encode($user_array));

// include("../model/database.php");

// $database = new Database();
// $db = $database->getConnection();



// if (isset($_POST["email"])) {
//     $email = $db->real_escape_string($_POST["email"]);
// } else {
//     die("Enter an email");
// }

// if (isset($_POST["password"])) {
//     $password = $db->real_escape_string($_POST["password"]);
//     // $password = hash("sha256", $password);
// } else {
//     die("Enter a password");
// }

// $query = $db->prepare("SELECT id FROM users WHERE email = ? AND password = ? ");
// $query->bind_param("ss", $email, $password);
// $query->execute();

// $query->store_result();
// $num_rows = $query->num_rows;
// $query->bind_result($user_id);
// $query->fetch();

// $array_response = [];

// if ($num_rows == 0) {
//     $array_response["status"] = "User not found";
// } else {
//     $array_response["status"] = "Logged In";
//     $array_response["user_id"] = $user_id;
// }

// $json_response = json_encode($array_response);
// echo $json_response;

// $query->close();
// $db->close();
