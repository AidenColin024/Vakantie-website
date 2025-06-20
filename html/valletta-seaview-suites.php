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
<head> ... <title>Valletta Seaview Suites - Malta</title> ... </head>
<body>
<header> ... </header>

<main class="pp-content">
    <section class="hotel-detail">
        <h1>Valletta Seaview Suites – 4 sterren</h1>
        <div class="hotel-images">
            <img src="images/valletta-seaview.jpg" alt="Valletta Seaview Suites" />
        </div>
        <div class="hotel-info">
            <h2>Beschrijving</h2>
            <p>Moderne suites met uitzicht op de Middellandse Zee, ideaal voor koppels en gezinnen die comfort zoeken.</p>

            <h2>Prijs</h2>
            <p>Vanaf €95 per nacht</p>

            <h2>Faciliteiten</h2>
            <ul>
                <li>Panoramisch balkon</li>
                <li>Airco</li>
                <li>Kitchenette</li>
                <li>Dagelijkse schoonmaak</li>
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
