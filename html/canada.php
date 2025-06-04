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
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise - Canada</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php">
            <img src="images/image1 (1).png" alt="Polar & Paradise">
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
    <img src="images/Snowboarder-terug-in-resort.png" alt="Skiën in Canada">
    <div class="hero-text">
        <h1>Avontuur in de Canadese Rockies</h1>
    </div>
    <section class="search-bar">
        <input type="date" placeholder="Vertrekdatum">
        <input type="text" placeholder="1 kamer(s), 2 reizigers">
        <select>
            <option>8-11 dagen</option>
            <option>12-15 dagen</option>
        </select>
        <input type="text" placeholder="Canada">
        <button class="pp-search-btn">Toon vakanties</button>
    </section>
</section>

<main class="pp-content">
    <aside class="pp-filters">
        <h3>Filter</h3>
        <label>Regio
            <select>
                <option>Whistler</option>
                <option>Banff</option>
                <option>Lake Louise</option>
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
                <option>Wintersport</option>
                <option>Familie</option>
                <option>Luxueus</option>
            </select>
        </label>
        <label>
            <input type="checkbox"> Ski pas inbegrepen
        </label>
    </aside>

    <section class="pp-destinations">
        <div class="pp-country">
            <a href="whistler-resort.php">
                <img src="images/canada-whistler.jpg" alt="Whistler Resort">
                <p>Whistler Resort – 5 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="banff-lodge.php">
                <img src="images/canada-banff.jpg" alt="Banff Lodge">
                <p>Banff Lodge – 4 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="lake-louise-inn.php">
                <img src="images/canada-lakelouise.jpg" alt="Lake Louise Inn">
                <p>Lake Louise Inn – 3 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="whistler-peak-lodge.php">
                <img src="images/whistler-peak.jpg" alt="Whistler Peak Lodge">
                <p>Whistler Peak Lodge – 4 sterren</p>
            </a>
        </div>
    </section>
</main>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
