<?php
// Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=plant_db;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Inclure le contrôleur des plantes
require_once 'Plants.php';

// Router très basique
$method = $_SERVER['REQUEST_METHOD'];
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = str_replace('/ExamenGEBDPlants/Index.php', '', $request);

if (preg_match('#^/Plants/?$#', $request)) {
    if ($method === 'GET') {
        getAllPlants();
    } elseif ($method === 'POST') {
        createPlant();
    }
} elseif (preg_match('#^/Plants/(\d+)$#', $request, $matches)) {
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
