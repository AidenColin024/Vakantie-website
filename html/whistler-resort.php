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
    <title>Whistler Resort - Canada</title>
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
        <h1>Whistler Resort – 5 sterren</h1>
        <div class="hotel-images">
            <img src="images/canada-whistler.jpg" alt="Whistler Resort" />
        </div>
        <div class="hotel-info">
            <h2>Beschrijving</h2>
            <p>Whistler Resort is een luxe skiresort met directe toegang tot skipistes, perfecte service en adembenemende uitzichten over de bergen.</p>

            <h2>Prijs</h2>
            <p>Vanaf €180 per nacht</p>

            <h2>Faciliteiten</h2>
            <ul>
                <li>Ski-in/ski-out</li>
                <li>Wellnesscentrum</li>
                <li>Gourmetrestaurant</li>
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
