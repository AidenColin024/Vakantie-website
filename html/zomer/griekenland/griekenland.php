<?php
$servername = "db"; // Docker-service naam
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}

$sql = "SELECT hotel_naam, link FROM hotels WHERE name = 'Griekenland' AND hotel_naam != ''";
$stmt = $conn->prepare($sql);
$stmt->execute();
$griekenlandHotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_GET['hotelSearch'])) {
    $zoekHotel = $_GET['hotelSearch'];

    $stmt = $conn->prepare("SELECT link FROM hotels WHERE name = 'Griekenland' AND hotel_naam = :hotelnaam LIMIT 1");
    $stmt->execute([':hotelnaam' => $zoekHotel]);
    $hotelData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($hotelData && !empty($hotelData['link'])) {
        header("Location: /zomer/griekenland/" . $hotelData['link']);
        exit;
    } else {
        echo "<p style='color:red;'>Hotel niet gevonden. Probeer een andere naam.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Zomervakanties Griekenland - Polar & Paradise</title>
    <link rel="stylesheet" href="../../vakantie.css?v=<?= time() ?>">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="../../index.php"><img src="../../images/image1%20(1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="../../index.php">Home</a></li>
            <li><a href="../../ski.php">Ski vakanties</a></li>
            <li><a href="../../zomer.php" class="active">Zomer vakanties</a></li>
            <li><a href="../../overons.php">Over ons</a></li>
            <li><a href="../../contact.php">Contact</a></li>
            <li><a href="../../login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie zomer-hero">
    <img src="../../images/foto-mooie-vakantiebestemming-in-griekenland-met-huizen-en-de-zee-in-de-zomer-hd-vakantie-achtergrond.jpg" alt="Vakantie in Griekenland" class="hero-img" />
    <div class="hero-text">
        <h1>Ervaar het magische Griekenland</h1>
        <p>Van Kreta tot Athene, ontdek jouw perfecte zomerbestemming.</p>

        <form method="GET" action="" id="hotelSearchForm">
            <label for="hotelSearch">Zoek hotel in Griekenland:</label><br>
            <input list="hotelsList" id="hotelSearch" name="hotelSearch" placeholder="Typ hotelnaam...">
            <datalist id="hotelsList">
                <?php foreach ($griekenlandHotels as $hotel): ?>
                <option value="<?= htmlspecialchars($hotel['hotel_naam']) ?>">
                    <?php endforeach; ?>
            </datalist>
            <button type="submit">Zoek</button>
        </form>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw Zomer vakantie</h3>
            <label for="region">Regio</label>
            <select id="region" name="region">
                <option value="">Alle regio's</option>
                <option>Kreta</option>
                <option>Rhodos</option>
                <option>Athene</option>
                <option>Chersonissos</option>
            </select>

            <label for="stars">Sterren</label>
            <select id="stars" name="stars">
                <option value="">Alle</option>
                <option>3 sterren</option>
                <option>4 sterren</option>
                <option>5 sterren</option>
            </select>

            <label for="type">Soort vakantie</label>
            <select id="type" name="type">
                <option value="">Alle</option>
                <option>All-inclusive</option>
                <option>Historisch</option>
                <option>Strand</option>
            </select>

            <label><input type="checkbox"> Inclusief vlucht</label>
        </aside>

        <section class="destination-blocks">
            <?php
            $stmt = $conn->prepare("SELECT * FROM hotels WHERE name = :land AND hotel_naam IS NOT NULL AND hotel_naam != '' ORDER BY stars DESC, hotel_naam ASC");
            $stmt->execute([':land' => 'Griekenland']);
            $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($hotels)) {
                echo "<p style='margin-left:1rem;'>Er zijn nog geen hotels toegevoegd voor Griekenland.</p>";
            } else {
                foreach ($hotels as $hotel):
                    $hotelLink = htmlspecialchars($hotel['link'] ?: '#');
                    $hotelImage = htmlspecialchars($hotel['image']);
                    $hotelNaam = htmlspecialchars($hotel['hotel_naam']);
                    $hotelSterren = htmlspecialchars($hotel['stars']);
                    $hotelPrijs = isset($hotel['prijs']) ? number_format($hotel['prijs'], 2, ',', '.') : 'n.v.t.';
                    $hotelBeschikbaar = isset($hotel['beschikbaar']) && $hotel['beschikbaar'] !== '0000-00-00'
                        ? date('d-m-Y', strtotime($hotel['beschikbaar']))
                        : 'n.v.t.';
                    ?>
                    <div class="destination-box" onclick="location.href='<?= $hotelLink ?>'">
                        <img src="<?= $hotelImage ?>" alt="<?= $hotelNaam ?>"/>
                        <h3><?= $hotelNaam ?> – <?= $hotelSterren ?> sterren</h3>
                        <div class="hotel-extra-info">
                            <span>Prijs: €<?= $hotelPrijs ?> per nacht</span><br>
                            <span>Beschikbaar vanaf: <?= $hotelBeschikbaar ?></span>
                        </div>
                    </div>
                <?php
                endforeach;
            }
            ?>
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

