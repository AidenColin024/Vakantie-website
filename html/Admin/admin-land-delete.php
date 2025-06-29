<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Verwijder land met dat id
    $stmt = $conn->prepare("DELETE FROM landen WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// Redirect terug naar admin-land.php
header("Location: admin-land.php");
exit;
