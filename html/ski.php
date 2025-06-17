<?php
// Database configuratie
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    // Maak verbinding
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
    exit;
}

// Basis query: alleen landen (hotel_naam leeg of NULL) en category = 'ski'
$sql = "SELECT name, region, prijs, stars, type, image, link FROM hotels WHERE (hotel_naam = '' OR hotel_naam IS NULL) AND category = 'ski'";
$params = [];

// Filters toevoegen als ze bestaan
if (!empty($_GET['land'])) {
    $sql .= " AND name = :land";
    $params[':land'] = $_GET['land'];
}

if (!empty($_GET['stars'])) {
    $sql .= " AND stars = :stars";
    $params[':stars'] = (int)$_GET['stars'];
}

if (!empty($_GET['maxprijs'])) {
    $sql .= " AND prijs <= :maxprijs";
    $params[':maxprijs'] = (float)$_GET['maxprijs'];
}

if (!empty($_GET['type'])) {
    $sql .= " AND type = :type";
    $params[':type'] = $_GET['type'];
}

// Query voorbereiden en uitvoeren
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Unieke landen ophalen voor dropdown filter
$landenStmt = $conn->query("SELECT DISTINCT name FROM hotels WHERE (hotel_naam = '' OR hotel_naam IS NULL) AND category = 'ski'");
$landenOptions = $landenStmt->fetchAll(PDO::FETCH_COLUMN);
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
        <form method="GET" action="" onsubmit="return redirectToLand();">
            <input type="text" id="landZoek" name="land" placeholder="Typ een land, bijv. Frankrijk" required>
            <button type="submit">Zoek</button>
        </form>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw Ski vakantie</h3>
            <form method="GET" action="ski.php">
                <label for="land">Land</label>
                <select id="land" name="land">
                    <option value="">Alle landen</option>
                    <?php foreach ($landenOptions as $landOpt): ?>
                        <option value="<?= htmlspecialchars($landOpt) ?>" <?= (isset($_GET['land']) && $_GET['land'] === $landOpt) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($landOpt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="stars">Sterren</label>
                <select id="stars" name="stars">
                    <option value="">Alle</option>
                    <option value="3" <?= (isset($_GET['stars']) && $_GET['stars'] == '3') ? 'selected' : '' ?>>3 sterren</option>
                    <option value="4" <?= (isset($_GET['stars']) && $_GET['stars'] == '4') ? 'selected' : '' ?>>4 sterren</option>
                    <option value="5" <?= (isset($_GET['stars']) && $_GET['stars'] == '5') ? 'selected' : '' ?>>5 sterren</option>
                </select>

                <label for="maxprijs">Max prijs (€)</label>
                <input type="number" id="maxprijs" name="maxprijs" step="0.01" min="0" value="<?= isset($_GET['maxprijs']) ? htmlspecialchars($_GET['maxprijs']) : '' ?>" placeholder="Bijv. 150">

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
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $result): ?>
                    <div class="destination-box">
                        <?php if (!empty($result['image'])): ?>
                            <img src="<?= htmlspecialchars($result['image']) ?>" alt="<?= htmlspecialchars($result['name']) ?>" style="width:100%;max-width:220px;height:auto;border-radius:6px;margin-bottom:10px;">
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($result['name']) ?></h3>
                        <p>Regio: <?= htmlspecialchars($result['region']) ?></p>
                        <p>Sterren: <?= htmlspecialchars($result['stars']) ?></p>
                        <p>Prijs vanaf: €<?= number_format($result['prijs'], 2) ?></p>
                        <p>Type: <?= htmlspecialchars($result['type']) ?></p>
                        <?php if (!empty($result['link'])): ?>
                            <p><a href="<?= htmlspecialchars($result['link']) ?>" target="_blank" rel="noopener">Meer info</a></p>
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

<script>
    function redirectToLand() {
        const land = document.getElementById('landZoek').value.trim().toLowerCase();

        // Maak een lijst van toegestane landen
        const landen = ['oostenrijk', 'frankrijk', 'italie', 'zwitserland'];

        if (landen.includes(land)) {
            // Doorverwijzen naar juiste pagina
            window.location.href = `/winter/${land}/${land}.php`;
        } else {
            alert("Land niet gevonden. Probeer: Oostenrijk, Frankrijk, Italië of Zwitserland.");
        }

        return false; // Voorkom standaard form-submissie
    }
</script>

</body>
</html>
