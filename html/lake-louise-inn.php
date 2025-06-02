<?php
$servername = "db"; // Docker-service naam
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Verbinding met database is gelukt!";
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lake Louise Inn - Canada</title>
    <link rel="stylesheet" href="vakantie.css" />
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise" /></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="ski.php">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main class="pp-content">
    <section class="hotel-detail">
        <h1>Lake Louise Inn – 3 sterren</h1>
        <div class="hotel-images">
            <img src="images/canada-lakelouise.jpg" alt="Lake Louise Inn" />
        </div>
        <div class="hotel-info">
            <h2>Beschrijving</h2>
            <p>Lake Louise Inn biedt een betaalbaar en gezellig verblijf dicht bij het beroemde meer en de skipistes van Lake Louise.</p>

            <h2>Prijs</h2>
            <p>Vanaf €90 per nacht</p>

            <h2>Faciliteiten</h2>
            <ul>
                <li>Zwembad</li>
                <li>Restaurant & bar</li>
                <li>Skiverhuur</li>
                <li>Gratis WiFi</li>
            </ul>
        </div>
        <a href="canada.php" class="pp-back-btn">Terug naar Canada vakanties</a>
    </section>
</main>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
