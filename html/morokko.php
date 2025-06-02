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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise - Marokko</title>
    <link rel="stylesheet" href="vakantie.css" />
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

<section class="vakantie">
    <img src="images/marokko-hero.jpg" alt="Vakantie in Marokko">
    <div class="hero-text">
        <h1>Ontdek het magische Marokko</h1>
    </div>
    <section class="search-bar">
        <input type="date" placeholder="Vertrekdatum">
        <input type="text" placeholder="1 kamer(s), 2 reizigers">
        <select>
            <option>8-11 dagen</option>
            <option>12-15 dagen</option>
        </select>
        <input type="text" placeholder="Marokko">
        <button class="pp-search-btn">Toon vakanties</button>
    </section>
</section>

<main class="pp-content">
    <aside class="pp-filters">
        <h3>Filter</h3>
        <label>Regio
            <select>
                <option>Marrakesh</option>
                <option>Agadir</option>
                <option>Casablanca</option>
                <option>Essaouira</option>
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
                <option>Zonvakantie</option>
                <option>Cultuur</option>
                <option>Luxueus</option>
            </select>
        </label>
    </aside>

    <section class="pp-destinations">
        <a href="riad-marrakesh.php" class="pp-country">
            <img src="images/marokko-marrakesh.jpg" alt="Riad Marrakesh">
            <p>Riad Marrakesh – 4 sterren</p>
        </a>
        <a href="agadir-beach-resort.php" class="pp-country">
            <img src="images/marokko-agadir.jpg" alt="Agadir Beach Resort">
            <p>Agadir Beach Resort – 5 sterren</p>
        </a>
        <a href="casablanca-hotel.php" class="pp-country">
            <img src="images/marokko-casablanca.jpg" alt="Casablanca Hotel">
            <p>Casablanca Hotel – 3 sterren</p>
        </a>
        <a href="essaouira-sands.php" class="pp-country">
            <img src="images/essaouira-sands.jpg" alt="Essaouira Sands Resort">
            <p>Essaouira Sands Resort – 4 sterren</p>
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
