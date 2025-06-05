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
    <title>Marokko Vakanties - Polar & Paradise</title>
    <link rel="stylesheet" href="../../vakantie.css?v=<?= time() ?>">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="../../index.php"><img src="../../images/image1%20(1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="../../index.php">Home</a></li>
            <li><a href="../../ski.php">Ski vakanties</a></li>
            <li><a href="../zomer.php" class="active">Zomer vakanties</a></li>
            <li><a href="../../overons.php">Over ons</a></li>
            <li><a href="../../contact.php">Contact</a></li>
            <li><a href="../../login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie zomer-hero">
    <img src="../../images/OIP%20(5).jpg" alt="Vakantie in Marokko" class="hero-img" />
    <div class="hero-text">
        <h1>Ervaar het magische Marokko</h1>
        <p>Van Marrakesh tot Casablanca, ontdek jouw perfecte zomerbestemming.</p>
    </div>
</section>

<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw Zomer vakantie</h3>
            <label for="region">Regio</label>
            <select id="region" name="region">
                <option value="">Alle regio's</option>
                <option>Marrakesh</option>
                <option>Agadir</option>
                <option>Casablanca</option>
                <option>Essaouira</option>
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
                <option>Zonvakantie</option>
                <option>Cultuur</option>
                <option>Luxueus</option>
            </select>

            <label><input type="checkbox"> Inclusief vlucht</label>
        </aside>

        <section class="destination-blocks">
            <div class="destination-box" onclick="location.href='riad-marrakesh.php'">
                <img src="../../images/marrakesh.jpg" alt="Riad Marrakesh"/>
                <h3>Riad Marrakesh – 4 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='agadir-beach-resort.php'">
                <img src="../../images/agadir-beach.jpg" alt="Agadir Beach Resort"/>
                <h3>Agadir Beach Resort – 5 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='casablanca-hotel.php'">
                <img src="../../images/casablanca.jpg" alt="Casablanca Hotel"/>
                <h3>Casablanca Hotel – 3 sterren</h3>
            </div>
            <div class="destination-box" onclick="location.href='essaouira-sands.php'">
                <img src="../../images/assaouri-sands.jpg" alt="Essaouira Sands Resort"/>
                <h3>Essaouira Sands Resort – 4 sterren</h3>
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

