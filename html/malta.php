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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polar & Paradise - Malta Vakanties</title>
    <link rel="stylesheet" href="vakantie.css">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php">
            <img src="images/image1%20(1).png" alt="Polar & Paradise">
        </a>
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

<!-- HERO -->
<section class="vakantie">
    <img src="images/Screenshot%202025-05-19%20152054.png" alt="Malta zonvakantie">
    <div class="hero-text">
        <h1>Ontdek zonnig Malta</h1>
    </div>
    <section class="search-bar">
        <input type="date" placeholder="Vertrekdatum">
        <input type="text" placeholder="1 kamer(s), 2 reizigers">
        <select>
            <option>8-11 dagen</option>
            <option>12-15 dagen</option>
        </select>
        <input type="text" placeholder="Malta">
        <button class="pp-search-btn">Toon vakanties naar Malta</button>
    </section>
</section>

<main class="pp-content">
    <aside class="pp-filters">
        <h3>Filter</h3>
        <label>Regio
            <select>
                <option>Valletta</option>
                <option>Sliema</option>
                <option>St. Julian's</option>
                <option>Valletta</option>
            </select>
        </label>
        <label>Sterren
            <select>
                <option>Alle</option>
                <option>3 sterren</option>
                <option>4 sterren</option>
                <option>5 sterren</option>
            </select>
        </label>
        <label>Soort vakantie
            <select>
                <option>Relax</option>
                <option>Cultuur</option>
                <option>Avontuur</option>
            </select>
        </label>
    </aside>

    <section class="pp-destinations">
        <a href="hotel-malta-vista.php" class="pp-country">
            <img src="images/malta-hotel1.jpg" alt="Hotel Malta Vista">
            <p>Hotel Malta Vista – 4 sterren</p>
        </a>
        <a href="resort-zon-en-zee.php" class="pp-country">
            <img src="images/malta-hotel2.jpg" alt="Resort Zon & Zee">
            <p>Resort Zon & Zee – 5 sterren</p>
        </a>
        <a href="budget-inn-malta.php" class="pp-country">
            <img src="images/malta-hotel3.jpg" alt="Budget Inn Malta">
            <p>Budget Inn Malta – 3 sterren</p>
        </a>
        <a href="valletta-seaview-suites.php" class="pp-country">
            <img src="images/valletta-seaview.jpg" alt="Valletta Seaview Suites">
            <p>Valletta Seaview Suites – 4 sterren</p>
        </a>
    </section>
</main>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
