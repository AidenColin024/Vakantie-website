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
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polar & Paradise - Ski Vakanties</title>
    <link rel="stylesheet" href="vakantie.css">
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
            <li><a href="zomer.html">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<!-- HERO -->
<section class="vakantie">
    <img src="\images\image2.png" alt="Zon en Sneeuw vakanties">
    <div class="hero-text">
        <h1>Jouw ultime zon vakantie wacht op je</h1>
    </div>
    <section class="search-bar">
        <input type="date" placeholder="Vertrekdatum">
        <input type="text" placeholder="1 kamer(s), 2 reizigers">
        <select>
            <option>8-11 dagen</option>
            <option>12-15 dagen</option>
        </select>
        <input type="text" placeholder="Bestemming">
        <button class="pp-search-btn">Toon 2214 vakanties</button>
    </section>
</section>

<main class="pp-content">
    <aside class="pp-filters">
        <h3>Filter</h3>
        <label>Land
            <select>
                <option>Spanje</option>
                <option>Indonesië</option>
                <option>Bulgarije</option>
                <option>Malta</option>
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
                <option>Solo</option>
                <option>Familie</option>
                <option>Luxueus</option>
            </select>
        </label>
    </aside>

    <section class="pp-destinations">
        <div class="pp-country">
            <a href="spanje.php"><img src="images\Screenshot 2025-05-19 152016.png" alt="Spanje"></a>
            <p>Spanje</p>
        </div>
        <div class="pp-country">
            <a href="griekenland.php"><img src="images\Screenshot 2025-05-19 152022.png" alt="Griekenland"></a>
            <p>Griekenland</p>
        </div>
        <div class="pp-country">
            <a href="bulgarije.php"><img src="images\Screenshot 2025-05-19 152028.png" alt="Bulgarije"></a>
            <p>Bulgarije</p>
        </div>
        <div class="pp-country">

            <a href="malta.php" ><img src="images\Screenshot 2025-05-19 152054.png" alt="Malta"></a>
            <p>Malta</p>
        </div>
        <div class="pp-country">
            <a href="morokko.php"><img src="images\morokko.jpeg" alt="Malta"></a>
            <p>Morokko</p>
        </div>
        <div class="pp-country">
            <a href="portugal.php"><img src="images\portugal - Copy.jpg" alt="Portugal"></a>
            <p>Portugal</p>
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