<?php
// Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=plant_db;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Inclure le contrôleur des plantes
require 'Plants.php';

// Router très basique
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if (preg_match('#^/plants/?$#', $request)) {
    if ($method === 'GET') {
        getAllPlants();
    } elseif ($method === 'POST') {
        createPlant();
    }
} elseif (preg_match('#^/plants/(\d+)$#', $request, $matches)) {
    $id = (int)$matches[1];
    if ($method === 'GET') {
        getPlant($id);
    } elseif ($method === 'PUT') {
        updatePlant($id);
    } elseif ($method === 'DELETE') {
        deletePlant($id);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
