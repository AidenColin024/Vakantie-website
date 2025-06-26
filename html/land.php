<?php
// Verbinden met de database
$pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8mb4", "root", "rootpassword", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Land ophalen via GET
$landNaam = $_GET['naam'] ?? '';

if ($landNaam === '') {
    die("Geen land opgegeven.");
}

// Info over dit land
$stmt = $pdo->prepare("SELECT * FROM landen WHERE naam = :naam");
$stmt->execute([':naam' => $landNaam]);
$land = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$land) {
    die("Land niet gevonden.");
}

// Hotels voor dit land ophalen
$hotelStmt = $pdo->prepare("SELECT * FROM hotels WHERE name = :land");
$hotelStmt->execute([':land' => $landNaam]);
$hotels = $hotelStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($land['naam']) ?> – Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="ski.php">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>

            <li><a href="hotels.php">Hotels</a></li>
        </ul>
    </nav>
</header>

<main class="pp-content">
    <h1><?= htmlspecialchars($land['naam']) ?></h1>
    <p>Regio: <?= htmlspecialchars($land['region']) ?></p>

    <?php if ($hotels): ?>
        <ul class="hotel-list-in-land">
            <?php foreach ($hotels as $hotel): ?>
                <li class="hotel-in-land">
                    <div class="hotel-in-land-title"><?= htmlspecialchars($hotel['hotel_naam']) ?></div>
                    <p><?= $hotel['stars'] ?>★ – €<?= number_format($hotel['prijs'], 2, ',', '.') ?></p>
                    <a class="btn-primary" href="hotel-details.php?id=<?= $hotel['id'] ?>">Bekijk hotel</a>
                    <a class="btn-primary" href="boeking.php?hotel=<?= $hotel['id'] ?>">Boek</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Geen hotels beschikbaar in dit land.</p>
    <?php endif; ?>
</main>

<footer>
    © 2025 Polar Paradise – alle rechten voorbehouden.
</footer>
</body>
</html>
