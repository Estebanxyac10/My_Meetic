<?php

require_once "../model/database.php";

$connChange = new MyDatabase();

try {
    $conn = $connChange->connectToDatabase();

    $userNewPass = isset($_POST["newpass"]) ? $_POST["newpass"] : null;
    $userEmail = isset($_POST["email"]) ? $_POST["email"] : null;

    $userNewPass = password_hash($userNewPass, PASSWORD_DEFAULT);

    $sql_change_pass = "UPDATE user SET password_hashed = :newpass WHERE email = :email";
    $stmt_sql_change_pass = $conn->prepare($sql_change_pass);
    $stmt_sql_change_pass->bindParam(":newpass", $userNewPass);
    $stmt_sql_change_pass->bindParam(":email", $userEmail);
    $stmt_sql_change_pass->execute();

    echo json_encode(["success" => "Password changed successfully."]);
} catch (PDOException $e) {
    echo json_encode(["error" => "An error occurred while changing the password."]);
    echo "Log : " . $e->getMessage();
} finally {
    $conn = null;
}