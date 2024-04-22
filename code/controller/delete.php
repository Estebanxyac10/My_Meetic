<?php
require_once "../model/database.php";

$connDelete = new MyDatabase();

try {
    $conn = $connDelete->connectToDatabase();

    $userEmail = isset($_POST["email"]) ? $_POST["email"] : null;

    $sql_delete_user_hobby = "DELETE FROM user_hobby WHERE id_user IN (SELECT id_user FROM user WHERE email = :email)";
    $stmt_delete_user_hobby = $conn->prepare($sql_delete_user_hobby);
    $stmt_delete_user_hobby->bindParam(":email", $userEmail);
    $stmt_delete_user_hobby->execute();

    $sql_delete_user = "DELETE FROM user WHERE email = :email";
    $stmt_delete_user = $conn->prepare($sql_delete_user);
    $stmt_delete_user->bindParam(":email", $userEmail);
    $stmt_delete_user->execute();

    echo json_encode(["success" => "Account deleted successfully."]);
} catch (PDOException $e) {
    echo json_encode(["error" => "An error occurred while deleting the account."]);
    echo "Log : " . $e->getMessage();
} finally {
    $conn = null;
}