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
    <title>Polar & Paradise - Portugal</title>
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
    <img src="images/portugal-hero.jpg" alt="Zonvakantie Portugal">
    <div class="hero-text">
        <h1>Zon, zee en cultuur in Portugal</h1>
    </div>
    <section class="search-bar">
        <input type="date" placeholder="Vertrekdatum">
        <input type="text" placeholder="1 kamer(s), 2 reizigers">
        <select>
            <option>8-11 dagen</option>
            <option>12-15 dagen</option>
        </select>
        <input type="text" placeholder="Portugal">
        <button class="pp-search-btn">Toon vakanties</button>
    </section>
</section>

<main class="pp-content">
    <aside class="pp-filters">
        <h3>Filter</h3>
        <label>Regio
            <select>
                <option>Algarve</option>
                <option>Lissabon</option>
                <option>Madeira</option>
                <option>Costa da Caparica / Lissabonregio</option>
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
                <option>Familie</option>
                <option>Stedentrip</option>
            </select>
        </label>
    </aside>

    <section class="pp-destinations">
        <div class="pp-country">
            <a href="algarve-resort.php">
                <img src="images/portugal-algarve.jpg" alt="Algarve Resort">
                <p>Algarve Resort – 4 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="hotel-lissabon.php">
                <img src="images/portugal-lissabon.jpg" alt="Hotel Lissabon">
                <p>Hotel Lissabon – 5 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="madeira-retreat.php">
                <img src="images/portugal-madeira.jpg" alt="Madeira Retreat">
                <p>Madeira Retreat – 3 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="costa-do-sol.php">
                <img src="images/costa-do-sol.jpg" alt="Costa do Sol Hotel">
                <p>Costa do Sol Hotel – 4 sterren</p>
            </a>
        </div>
    </section>
\
</main>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
