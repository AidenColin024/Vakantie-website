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
$sql = "SELECT name, region, stars, type, image FROM hotels WHERE (hotel_naam IS NULL OR hotel_naam = '') AND category = 'zomer'";
$params = [];

if (!empty($_GET['stars'])) {
    $sql .= " AND stars = :stars";
    $params[':stars'] = $_GET['stars'];
}
if (!empty($_GET['type'])) {
    $sql .= " AND type = :type";
    $params[':type'] = $_GET['type'];
}
if (!empty($_GET['country'])) {
    $sql .= " AND name = :country";
    $params[':country'] = $_GET['country'];
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
    <title>Zomer Vakanties - Polar & Paradise</title>
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
            <li><a href="zomer.php" class="active">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie zomer-hero">
    <img src="images/ChatGPT Image 21 mei 2025, 11_02_07.png" alt="Zomer vakanties" class="hero-img"/>
    <div class="hero-text">
        <h1>Vind jouw perfecte zomer vakantie</h1>
        <p>Van de zonnige stranden tot groene natuurgebieden, wij helpen je de beste plek te vinden.</p>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw zomer vakantie</h3>
            <form method="GET" action="zomer.php">
                <label for="country">Land</label>
                <select id="country" name="country">
                    <option value="">Alle landen</option>
                    <option value="Spanje" <?= (isset($_GET['country']) && $_GET['country'] == 'Spanje') ? 'selected' : '' ?>>Spanje</option>
                    <option value="Italië" <?= (isset($_GET['country']) && $_GET['country'] == 'Italië') ? 'selected' : '' ?>>Italië</option>
                    <option value="Griekenland" <?= (isset($_GET['country']) && $_GET['country'] == 'Griekenland') ? 'selected' : '' ?>>Griekenland</option>
                    <option value="Portugal" <?= (isset($_GET['country']) && $_GET['country'] == 'Portugal') ? 'selected' : '' ?>>Portugal</option>
                    <option value="Frankrijk" <?= (isset($_GET['country']) && $_GET['country'] == 'Frankrijk') ? 'selected' : '' ?>>Frankrijk</option>
                </select>

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
                    <option value="Familie" <?= (isset($_GET['type']) && $_GET['type'] == 'Familie') ? 'selected' : '' ?>>Familie</option>
                    <option value="Romantisch" <?= (isset($_GET['type']) && $_GET['type'] == 'Romantisch') ? 'selected' : '' ?>>Romantisch</option>
                    <option value="Actief" <?= (isset($_GET['type']) && $_GET['type'] == 'Actief') ? 'selected' : '' ?>>Actief</option>
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
                <p>🌞 Geen resultaten gevonden voor jouw filters.</p>
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