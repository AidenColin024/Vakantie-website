<?php
// Get user input safely
$zoekterm = trim($_GET['zoekterm'] ?? '');
$beschikbaar_op = $_GET['beschikbaar_op'] ?? '';

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start query without WHERE
    $query = "SELECT h.*, l.naam AS land_naam
              FROM hotels h
              LEFT JOIN landen l ON h.region = l.id";

    $params = [];
    $conditions = [];

    // Add conditions if needed
    if ($zoekterm !== '') {
        $conditions[] = "(h.hotel_naam LIKE :term OR h.beschrijving LIKE :term OR l.naam LIKE :term)";
        $params[':term'] = '%' . $zoekterm . '%';
    }

    if ($beschikbaar_op !== '') {
        $conditions[] = "(h.beschikbaar IS NULL OR h.beschikbaar <= :datum)";
        $params[':datum'] = $beschikbaar_op;
    }

    // If we have conditions, add WHERE with AND between them
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    // Prepare and execute query
    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    // Get all results
    $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("❌ Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Zoekresultaten | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css">
</head>
<body>
<h1 style="text-align:center;">Zoekresultaten</h1>

<?php if ($resultaten): ?>
    <ul style="max-width: 700px; margin: 0 auto; padding: 0;">
        <?php foreach ($resultaten as $hotel): ?>
            <li style="margin-bottom: 20px; list-style: none; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                <strong><?= htmlspecialchars($hotel['hotel_naam']) ?></strong><br>
                Land: <?= htmlspecialchars($hotel['land_naam'] ?? 'Onbekend') ?><br>
                Prijs: €<?= htmlspecialchars($hotel['prijs']) ?><br>
                Beschikbaar vanaf: <?= htmlspecialchars($hotel['beschikbaar'] ?? 'Onbekend') ?><br>
                <a class="btn-primary" href="hotel-details.php?id=<?= $hotel['id'] ?>">Bekijk hotel</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p style="text-align:center;">Geen resultaten gevonden voor je zoekopdracht.</p>
<?php endif; ?>
</body>
</html>
