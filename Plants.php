<?php
require 'Index.php';

function getAllPlants() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM plants");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getPlant($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM plants WHERE id = ?");
    $stmt->execute([$id]);
    $plant = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($plant) {
        echo json_encode($plant);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
    }
}

function createPlant() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO plants (name, species, sunlight, watering, pet_friendly, height_cm) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['name'],
        $data['species'],
        $data['sunlight'],
        $data['watering'],
        $data['pet_friendly'],
        $data['height_cm']
    ]);
    http_response_code(201);
    echo json_encode(['id' => $pdo->lastInsertId()]);
}

function updatePlant($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE plants SET name = ?, species = ?, sunlight = ?, watering = ?, pet_friendly = ?, height_cm = ? WHERE id = ?");
    $stmt->execute([
        $data['name'],
        $data['species'],
        $data['sunlight'],
        $data['watering'],
        $data['pet_friendly'],
        $data['height_cm'],
        $id
    ]);
    echo json_encode(['status' => 'updated']);
}

function deletePlant($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM plants WHERE id = ?");
    $stmt->execute([$id]);
    http_response_code(204);
}
