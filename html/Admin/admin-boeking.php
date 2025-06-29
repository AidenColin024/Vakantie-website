<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}

// Haal alle boekingen op
$stmt = $conn->prepare("
    SELECT b.id, b.naam AS klant_naam, b.email, h.hotel_naam, b.aankomst, b.vertrek, b.personen, b.datum
    FROM boeking b
    LEFT JOIN hotels h ON b.hotel_id = h.id
    ORDER BY b.datum DESC
");
$stmt->execute();
$boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin – Boekingen Overzicht</title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">
</head>
<body>
<main class="booking-main">
    <h1>Alle Boekingen – Admin</h1>

    <?php if (count($boekingen) > 0): ?>
        <table class="booking-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Klantnaam</th>
                <th>E-mail</th>
                <th>Hotel</th>
                <th>Aankomst</th>
                <th>Vertrek</th>
                <th>Personen</th>
                <th>Datum geboekt</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($boekingen as $boeking): ?>
                <tr>
                    <td><?= htmlspecialchars($boeking['id']) ?></td>
                    <td><?= htmlspecialchars($boeking['klant_naam']) ?></td>
                    <td><?= htmlspecialchars($boeking['email']) ?></td>
                    <td><?= htmlspecialchars($boeking['hotel_naam']) ?: 'Onbekend' ?></td>
                    <td><?= htmlspecialchars($boeking['aankomst']) ?></td>
                    <td><?= htmlspecialchars($boeking['vertrek']) ?></td>
                    <td><?= (int)$boeking['personen'] ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($boeking['datum'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><em>Geen boekingen gevonden.</em></p>
    <?php endif; ?>

    <p><a href="admin.php" class="booking-link">← Terug naar homepage</a></p>
</main>
</body>
</html>
