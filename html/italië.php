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
    <title>Ski Vakanties Italië - Polar & Paradise</title>
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
    <img src="images/italie.jpg" alt="Skiën in Italië" class="hero-img" />
    <div class="hero-text">
        <h1>Skiën in de prachtige Dolomieten</h1>
        <p>Ontdek wintersport in Italië – authentiek, sfeervol en sneeuwzeker!</p>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw Ski vakantie</h3>
            <label for="region">Regio</label>
            <select id="region" name="region">
                <option value="">Alle regio's</option>
                <option>Dolomieten</option>
                <option>Val Gardena</option>
                <option>Cervinia</option>
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
            <div class="destination-box" onclick="location.href='dolomieten-chalet.php'">
                <img src="images/dolomieten lodge.jpg" alt="Dolomieten Chalet"/>
                <h3>Dolomieten Chalet – 4 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='val-gardena-resort.php'">
                <img src="images/val gardana resort.jpg" alt="Val Gardena Resort"/>
                <h3>Val Gardena Resort – 5 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='cervinia-lodge.php'">
                <img src="images/cervinia lodge.jpg" alt="Cervinia Lodge"/>
                <h3>Cervinia Lodge – 3 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='dolomiti-resort.php'">
                <img src="images/dolomiti resort.jpg" alt="Dolomiti Resort"/>
                <h3>Dolomiti Resort – 4 sterren</h3>
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

