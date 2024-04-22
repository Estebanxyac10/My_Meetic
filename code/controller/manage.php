<?php
require_once "../model/database.php";

$connUser = new MyDatabase();

try {
    $conn = $connUser->connectToDatabase();

    $userEmail = null;
    if (isset($_COOKIE["user_cookie"])) {
        $cookie_json = $_COOKIE["user_cookie"];
        $cookie_data = json_decode(urldecode($cookie_json), true);

        if (isset($cookie_data["email"])) {
            $userEmail = $cookie_data["email"];
        }
    }

    if ($userEmail) {
        $sql = "SELECT user.email,
            user.lastname,
            user.firstname,
            DATE_FORMAT(user.birthdate, '%Y-%m-%d') as birthdate,
            user.gender,
            user.city,
            hobby.name_hobby as hobby
            FROM user
            LEFT JOIN user_hobby ON user.id_user = user_hobby.id_user
            LEFT JOIN hobby ON user_hobby.id_hobby = hobby.id_hobby
            WHERE user.email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $userEmail);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode(["error" => "User email not found in the cookie"]);
    }
} catch (PDOException $e) {
    echo "Log : " . $e->getMessage();
} finally {
    $conn = null;
}