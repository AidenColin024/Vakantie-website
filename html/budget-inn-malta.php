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
<head> ... <title>Budget Inn Malta - Malta</title> ... </head>
<body>
<header> ... </header>

<main class="pp-content">
    <section class="hotel-detail">
        <h1>Budget Inn Malta – 3 sterren</h1>
        <div class="hotel-images">
            <img src="images/malta-hotel3.jpg" alt="Budget Inn Malta" />
        </div>
        <div class="hotel-info">
            <h2>Beschrijving</h2>
            <p>Betaalbaar verblijf op loopafstand van het centrum. Perfect voor studenten of korte vakanties.</p>

            <h2>Prijs</h2>
            <p>Vanaf €35 per nacht</p>

            <h2>Faciliteiten</h2>
            <ul>
                <li>Gratis WiFi</li>
                <li>Receptie 08:00–22:00</li>
                <li>Gemeenschappelijke keuken</li>
                <li>Lounge area</li>
            </ul>
        </div>
        <a href="malta.php" class="pp-back-btn">Terug naar Malta vakanties</a>
    </section>
</main>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
