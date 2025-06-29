<?php

$pdo = new PDO(
    "mysql:host=db;dbname=mydatabase;charset=utf8mb4",
    "root",
    "rootpassword",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$filterStars = isset($_GET['stars']) ? $_GET['stars'] : '';
$filterType = isset($_GET['type']) ? $_GET['type'] : '';
$filterCountry = isset($_GET['country']) ? $_GET['country'] : '';

// Alle landen ophalen
$landenStmt = $pdo->query("SELECT id, naam, region FROM landen ORDER BY naam");
$landen = $landenStmt->fetchAll(PDO::FETCH_ASSOC);

$landHotelData = [];

// Query voorbereiden
$sql = "SELECT id, hotel_naam, stars, prijs, type FROM hotels WHERE category = 'zomer'";

if ($filterCountry !== '') {
    $sql .= " AND name = :land";
}

if ($filterStars !== '') {
    $sql .= " AND stars = :stars";
}

if ($filterType !== '') {
    $sql .= " AND type = :type";
}

// Loop over landen en haal hotels op
foreach ($landen as $land) {

    if ($filterCountry !== '' && $filterCountry !== $land['naam']) {
        continue;
    }

    $stmt = $pdo->prepare($sql);

    if ($filterCountry !== '') {
        $stmt->bindValue(':land', $land['naam']);
    }

    if ($filterStars !== '') {
        $stmt->bindValue(':stars', $filterStars);
    }

    if ($filterType !== '') {
        $stmt->bindValue(':type', $filterType);
    }

    $stmt->execute();
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $landHotelData[] = [
        'land' => $land,
        'hotels' => $hotels
    ];
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Zomer vakanties</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>

<header class="pp-header">
    <div class="logo">
        <a href="index.php">
            <img src="images/image1 (1).png" alt="Polar & Paradise">
        </a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie zomer-hero">
    <img src="images/ChatGPT Image 21 mei 2025, 11_02_07.png" alt="Zomer vakanties" class="hero-img" />
    <div class="hero-text">
        <h1>Vind jouw perfecte zomervakantie</h1>
        <p>Van de zonnige stranden tot groene natuurgebieden, wij helpen je de beste plek te vinden.</p>
    </div>
</section>

<form method="GET" action="zoekresultaat.php" style="text-align:center; margin-top: 30px;">
    <input type="text" name="zoekterm" placeholder="Zoek land of hotel..." style="padding: 8px; width: 250px;">
    <input type="date" name="beschikbaar_op" style="padding: 8px;">
    <button type="submit" style="padding: 8px;">Zoeken</button>
</form>

<?php foreach ($landHotelData as $entry): ?>
    <div>
        <h2>
            <a href="land.php?naam=<?= urlencode($entry['land']['naam']) ?>">
                <?= htmlspecialchars($entry['land']['naam']) ?>
            </a>
        </h2>

        <p>Regio: <?= htmlspecialchars($entry['land']['region']) ?></p>

        <?php if ($entry['hotels']): ?>
            <ul>
                <?php foreach ($entry['hotels'] as $hotel): ?>
                    <li>
                        <?= htmlspecialchars($hotel['hotel_naam']) ?> -
                        <?= htmlspecialchars($hotel['stars']) ?>★ -
                        €<?= htmlspecialchars($hotel['prijs']) ?> -
                        <a href="hotels.php?id=<?= $hotel['id'] ?>">Bekijk</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Geen zomerhotels gevonden.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>
