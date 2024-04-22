<?php

require_once "../model/database.php";

$hobbies = new MyDatabase();

try {
    $conn = $hobbies->connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM hobby");
    $stmt->execute();

    $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($hobbies) . PHP_EOL;
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage() . PHP_EOL;
} finally {
    $conn = null;
}