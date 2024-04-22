<?php

require_once "../model/database.php";

$connUser = new MyDatabase();

try {
    $conn = $connUser->connectToDatabase();

    $postData = $_POST;
    $connMail = $postData["email"] ?? null;
    $connPass = $postData["password"] ?? null;

    $query = "SELECT * FROM user WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":email", $connMail);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($connPass, $user["password_hashed"])) {
        $response = array("success" => false, "message" => "Incorrect e-mail or password. Please try again.");
        echo json_encode($response) . PHP_EOL;
        exit();
    }

    $response = array("success" => true, "message" => "Successful connection!", "user" => $user);
    $userData = json_encode($user);
    setcookie("user_cookie", $userData, time() + 3600, "/");

    echo json_encode($response) . PHP_EOL;
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage() . PHP_EOL;
} finally {
    $conn = null;
}