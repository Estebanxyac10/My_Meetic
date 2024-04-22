<?php

require_once "../model/database.php";

$connUser = new MyDatabase();

try {
    $conn = $connUser->connectToDatabase();

    $postData = $_POST;
    $connMail = $postData["email"] ?? null;
    $connLastname = $postData["lastname"] ?? null;
    $connFirstname = $postData["firstname"] ?? null;
    $connBirthdate = $postData["birthdate"] ?? null;
    $connGender = $postData["gender"] ?? null;
    $connCity = $postData["city"] ?? null;
    $connPass = $postData["password"] ?? null;
    $connHobbies = $postData["hobbies"] ?? [];

    if (empty($connBirthdate) || !preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $connBirthdate)) {
        $response = array("success" => false, "message" => "Invalid date format. Please use the following format: YYYY-MM-DD.");
        echo json_encode($response);
        exit();
    }

    if (empty($connMail) || empty($connLastname) || empty($connFirstname) || empty($connGender) || empty($connCity) || empty($connPass)) {
        $response = array("success" => false, "message" => "Please fill in all fields.");
        echo json_encode($response);
        exit();
    }

    $connPass = password_hash($connPass, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (email, lastname, firstname, birthdate, gender, city, password_hashed) 
              VALUES (:email, :lastname, :firstname, :birthdate, :gender, :city, :password)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":email", $connMail);
    $stmt->bindParam(":lastname", $connLastname);
    $stmt->bindParam(":firstname", $connFirstname);
    $stmt->bindParam(":birthdate", $connBirthdate);
    $stmt->bindParam(":gender", $connGender);
    $stmt->bindParam(":city", $connCity);
    $stmt->bindParam(":password", $connPass);
    $stmt->execute();

    $userId = $conn->lastInsertId();

    foreach ($connHobbies as $hobbyId) {
        $stmt = $conn->prepare("INSERT INTO user_hobby (id_user, id_hobby) VALUES (:user_id, :hobby_id)");
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":hobby_id", $hobbyId);
        $stmt->execute();
    }

    $response = array("success" => true, "message" => "Registration successful!");
    setcookie("user_cookie", json_encode($postData), time() + 3600, "/");
    echo json_encode($response);
} catch (PDOException $e) {
    echo "Log : " . $e->getMessage();
} finally {
    $conn = null;
}