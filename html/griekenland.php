<?php
$servername = "db"; // Docker-service naam
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Verbinding met database is gelukt!";
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Griekenland Vakanties - Polar & Paradise</title>
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
            <li><a href="ski.php">Ski vakanties</a></li>
            <li><a href="zomer.php" class="active">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie zomer-hero">
    <img src="images/foto-mooie-vakantiebestemming-in-griekenland-met-huizen-en-de-zee-in-de-zomer-hd-vakantie-achtergrond.jpg" alt="Vakantie in Griekenland" class="hero-img" />
    <div class="hero-text">
        <h1>Ervaar het magische Griekenland</h1>
        <p>Van Kreta tot Athene, ontdek jouw perfecte zomerbestemming.</p>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw Zomer vakantie</h3>
            <label for="region">Regio</label>
            <select id="region" name="region">
                <option value="">Alle regio's</option>
                <option>Kreta</option>
                <option>Rhodos</option>
                <option>Athene</option>
                <option>Chersonissos</option>
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
                <option>All-inclusive</option>
                <option>Historisch</option>
                <option>Strand</option>
            </select>

            <label><input type="checkbox"> Inclusief vlucht</label>
        </aside>

        <section class="destination-blocks">
            <div class="destination-box" onclick="location.href='kreta-beach-hotel.php'">
                <img src="images/kreta beach.jpg" alt="Kreta Beach Resort"/>
                <h3>Kreta Beach Resort – 4 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='rhodes-luxe-hotel.php'">
                <img src="images/rhodos.jpg" alt="Rhodos Luxe Hotel"/>
                <h3>Rhodos Luxe Hotel – 5 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='athena-hotel.php'">
                <img src="images/athene.jpg" alt="Athene Boutique Hotel"/>
                <h3>Athene Boutique Hotel – 3 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='hotel-olympia.php'">
                <img src="images/olympia beach.jpg" alt="Hotel Olympia Beach"/>
                <h3>Hotel Olympia Beach – 4 sterren</h3>
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
    // Simpele veld-validatie feedback
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

