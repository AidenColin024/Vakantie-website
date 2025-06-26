<?php
$pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8mb4", "root", "rootpassword", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$filterStars = isset($_GET['stars']) ? $_GET['stars'] : '';
$filterType = isset($_GET['type']) ? $_GET['type'] : '';

$landenStmt = $pdo->query("SELECT id, naam, region FROM landen ORDER BY naam");
$landen = $landenStmt->fetchAll(PDO::FETCH_ASSOC);

$landHotelData = [];
$sql = "SELECT id, hotel_naam, stars, prijs, type FROM hotels WHERE name = :land AND category = 'ski'";
if ($filterStars !== '') $sql .= " AND stars = :stars";
if ($filterType !== '') $sql .= " AND type = :type";

foreach ($landen as $land) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':land', $land['naam']);
    if ($filterStars !== '') $stmt->bindValue(':stars', $filterStars);
    if ($filterType !== '') $stmt->bindValue(':type', $filterType);
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
    <title>Ski vakanties</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<h1>Ski vakanties</h1>

<form method="get" action="ski.php">
    <label>Sterren:
        <select name="stars">
            <option value="">Alle</option>
            <option value="3" <?= $filterStars === '3' ? 'selected' : '' ?>>3 sterren</option>
            <option value="4" <?= $filterStars === '4' ? 'selected' : '' ?>>4 sterren</option>
            <option value="5" <?= $filterStars === '5' ? 'selected' : '' ?>>5 sterren</option>
        </select>
    </label>
    <label>Type:
        <select name="type">
            <option value="">Alle</option>
            <option value="Wintersport" <?= $filterType === 'Wintersport' ? 'selected' : '' ?>>Wintersport</option>
            <option value="Familie" <?= $filterType === 'Familie' ? 'selected' : '' ?>>Familie</option>
            <option value="Luxueus" <?= $filterType === 'Luxueus' ? 'selected' : '' ?>>Luxueus</option>
        </select>
    </label>
    <button type="submit">Filter</button>
</form>

<?php foreach ($landHotelData as $entry): ?>
    <div>
        <h2><a href="land.php?naam=<?= urlencode($entry['land']['naam']) ?>">
                <?= htmlspecialchars($entry['land']['naam']) ?>
            </a></h2>
        <p>Regio: <?= htmlspecialchars($entry['land']['region']) ?></p>

        <?php if ($entry['hotels']): ?>
            <ul>
                <?php foreach ($entry['hotels'] as $hotel): ?>
                    <li>
                        <?= htmlspecialchars($hotel['hotel_naam']) ?> -
                        <?= $hotel['stars'] ?>★ -
                        €<?= $hotel['prijs'] ?> -
                        <a href="hotels.php?id=<?= $hotel['id'] ?>">Bekijk</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Geen ski-hotels gevonden.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</body>
</html>
