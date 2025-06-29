<?php
// Connectie
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Verbindingsfout: " . $e->getMessage());
}

// Alle hotels ophalen die category 'ski' hebben
$stmt = $conn->prepare("SELECT id, hotel_naam, name, region, stars, prijs FROM hotels WHERE category = 'ski' ORDER BY hotel_naam");
$stmt->execute();
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Ski Hotels Overzicht</title>
</head>
<body>
<h1>Ski Hotels</h1>

<?php if (count($hotels) > 0): ?>
    <ul>
        <?php foreach ($hotels as $hotel): ?>
            <li>
                <a href="hotel-details.php?id=<?= $hotel['id'] ?>">
                    <?= htmlspecialchars($hotel['hotel_naam']) ?> - <?= htmlspecialchars($hotel['name']) ?> (<?= htmlspecialchars($hotel['region']) ?>)
                </a>
                - <?= htmlspecialchars($hotel['stars']) ?> sterren - €<?= htmlspecialchars($hotel['prijs']) ?> per nacht
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Geen hotels gevonden.</p>
<?php endif; ?>

</body>
</html>
