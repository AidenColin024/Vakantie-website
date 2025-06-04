<?php
$servername = "db";
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
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Ski Vakanties Frankrijk - Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1%20(1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="ski.php" class="active">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie ski-hero">
    <img src="images/wintersport-frankrijk.webp" alt="Skiën in Frankrijk" class="hero-img" />
    <div class="hero-text">
        <h1>Geniet van de Franse Alpen</h1>
        <p>Van Les Arcs tot Chamonix, beleef jouw ultieme wintersportervaring.</p>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw Ski vakantie</h3>
            <label for="region">Regio</label>
            <select id="region" name="region">
                <option value="">Alle regio's</option>
                <option>Les Arcs</option>
                <option>La Plagne</option>
                <option>Serre Chevalier</option>
            </select>

            <label for="stars">Sterren</label>
            <select id="stars" name="stars">
                <option value="">Alle</option>
                <option>3 sterren</option>
                <option>4 sterren</option>
                <option>5 sterren</option>
            </select>

            <label for="type">Soort vakantie</label>
            <select id="type" name="type">
                <option value="">Alle</option>
                <option>Wintersport</option>
                <option>Familie</option>
                <option>Luxueus</option>
            </select>

            <label><input type="checkbox"> Ski pas inbegrepen</label>
        </aside>

        <section class="destination-blocks">
            <div class="destination-box" onclick="location.href='les-arcs-chalet.php'">
                <img src="images/les arcs chalet.jpg" alt="Les Arcs Chalet"/>
                <h3>Les Arcs Chalet – 4 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='la-plagne-resort.php'">
                <img src="images/les plagne resort.jpg" alt="La Plagne Resort"/>
                <h3>La Plagne Resort – 5 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='serre-chevalier-lodge.php'">
                <img src="images/serra chavalier lodge.webp" alt="Serre Chevalier Lodge"/>
                <h3>Serre Chevalier Lodge – 3 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='chalet-mont-blanc.php'">
                <img src="images/chalet mont blanc.jpg" alt="Chalet Mont Blanc"/>
                <h3>Chalet Mont Blanc – 5 sterren</h3>
            </div>
        </section>
    </div>
</main>

<footer>
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const forms = document.querySelectorAll("form");

        forms.forEach(form => {
            form.addEventListener("submit", e => {
                const inputs = form.querySelectorAll("input[required], textarea[required]");
                let allFilled = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.style.borderColor = "red";
                        allFilled = false;
                    } else {
                        input.style.borderColor = "#ccc";
                    }
                });

                if (!allFilled) {
                    e.preventDefault();
                    alert("⚠️ Vul alle verplichte velden in.");
                }
            });
        });
    });
</script>
</body>
</html>

