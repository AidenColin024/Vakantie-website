<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=Restaurant", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Over ons - Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css" />
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
            <li><a href="ski.html">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>
<!-- HERO -->
<section class="vakantie">
    <img src="\images\image4.webp" alt="Zon en Sneeuw vakanties">
    <div class="hero-text">
        <h1>Ondek de ultieme ski vakantie<br>Van Canada tot Oostenrijk boek jouw vakantie hier!</h1>
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
                <option>Oostenrijk</option>
                <option>Frankrijk</option>
                <option>Zwitserland</option>
                <option>Italië</option>
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
            <a href="oostenrijk.php"><img src="images\Screenshot 2025-05-19 151943.png" alt="Oostenrijk"></a>
            <p>Oostenrijk</p>
        </div>
        <div class="pp-country">
            <a href="frankrijk.php"><img src="images\Screenshot 2025-05-19 151953.png" alt="Frankrijk"></a>
            <p>Frankrijk</p>
        </div>
        <div class="pp-country">
            <a href="zwitserland.php"><img src="images\Screenshot 2025-05-19 151959.png" alt="Zwitserland"></a>
            <p>Zwitserland</p>
        </div>
        <div class="pp-country">
            <a href="italië.php"><img src="images\Screenshot 2025-05-19 152006.png" alt="Italie"></a>
            <p>Italië</p>
        </div>
        <div class="pp-country">
            <a href="canada.php"><img src="images\canada.jpeg" alt="Canada"></a>
            <p>Canada</p>
        </div>
        <div class="pp-country">
            <a href="noorwegen.php"><img src="images\noorwegen.jpeg" alt="Noorwegen"></a>
            <p>Noorwegen</p>
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