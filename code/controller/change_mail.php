<?php

require_once "../model/database.php";

$connChange = new MyDatabase();

try {
    $conn = $connChange->connectToDatabase();

    $userNewMail = isset($_POST["newmail"]) ? $_POST["newmail"] : null;
    $userEmail = isset($_POST["email"]) ? $_POST["email"] : null;

    $sql_change_email = "UPDATE user SET email = :newmail WHERE email = :email";
    $stmt_sql_change_email = $conn->prepare($sql_change_email);
    $stmt_sql_change_email->bindParam(":newmail", $userNewMail);
    $stmt_sql_change_email->bindParam(":email", $userEmail);
    $stmt_sql_change_email->execute();

    echo json_encode(["success" => "E-mail changed successfully."]);
} catch (PDOException $e) {
    echo json_encode(["error" => "An error occurred while changing the password."]);
    echo "Log : " . $e->getMessage();
} finally {
    $conn = null;
}