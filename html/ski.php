<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}

// Query met filters opbouwen: alleen landen tonen, geen hotels
$sql = "SELECT name, region, stars, type, image, link FROM hotels WHERE (hotel_naam IS NULL OR hotel_naam = '') AND category = 'ski'";
$params = [];

if (!empty($_GET['stars'])) {
    $sql .= " AND stars = :stars";
    $params[':stars'] = $_GET['stars'];
}
if (!empty($_GET['type'])) {
    $sql .= " AND type = :type";
    $params[':type'] = $_GET['type'];
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$landen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Ski Vakanties - Polar & Paradise</title>
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
            <li><a href="ski.php" class="active">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie ski-hero">
    <img src="images/R.jpg" alt="Ski vakanties" class="hero-img" />
    <div class="hero-text">
        <h1>Vind jouw perfecte ski vakantie</h1>
        <p>Van Oostenrijk tot Italië, wij hebben de beste pistes voor jou geselecteerd.</p>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw Ski vakantie</h3>
            <form method="GET" action="ski.php">
                <label for="stars">Sterren</label>
                <select id="stars" name="stars">
                    <option value="">Alle</option>
                    <option value="3" <?= (isset($_GET['stars']) && $_GET['stars'] == '3') ? 'selected' : '' ?>>3 sterren</option>
                    <option value="4" <?= (isset($_GET['stars']) && $_GET['stars'] == '4') ? 'selected' : '' ?>>4 sterren</option>
                    <option value="5" <?= (isset($_GET['stars']) && $_GET['stars'] == '5') ? 'selected' : '' ?>>5 sterren</option>
                </select>

                <label for="type">Soort vakantie</label>
                <select id="type" name="type">
                    <option value="">Alle</option>
                    <option value="Wintersport" <?= (isset($_GET['type']) && $_GET['type'] == 'Wintersport') ? 'selected' : '' ?>>Wintersport</option>
                    <option value="Familie" <?= (isset($_GET['type']) && $_GET['type'] == 'Familie') ? 'selected' : '' ?>>Familie</option>
                    <option value="Luxueus" <?= (isset($_GET['type']) && $_GET['type'] == 'Luxueus') ? 'selected' : '' ?>>Luxueus</option>
                </select>

                <button type="submit">Filter</button>
            </form>
        </aside>

        <section class="destination-blocks">
            <?php if (count($landen) > 0): ?>
                <?php foreach ($landen as $land): ?>
                    <div class="destination-box">
                        <?php if (!empty($land['image'])): ?>
                            <img src="<?= htmlspecialchars($land['image']) ?>" alt="<?= htmlspecialchars($land['name']) ?>" style="width:100%;max-width:220px;height:auto;border-radius:6px;margin-bottom:10px;">
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($land['name']) ?></h3>
                        <p>Regio: <?= htmlspecialchars($land['region']) ?></p>
                        <p>Sterren: <?= htmlspecialchars($land['stars']) ?></p>
                        <p>Type: <?= htmlspecialchars($land['type']) ?></p>
                        <?php if (!empty($land['link'])): ?>
                            <p><a href="<?= htmlspecialchars($land['link']) ?>" target="_blank">Ga naar vakanties</a></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>❄️ Geen resultaten gevonden voor jouw filters.</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<footer>
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>