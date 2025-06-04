<?php
$servername = "db"; // Docker-service naam
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Verbinding gelukt, maar voor productie zou je echo hier vermijden
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Zomer Vakanties - Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise"></a>
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
    <img src="images/ChatGPT Image 21 mei 2025, 11_02_07.png" alt="Zomer vakanties" class="hero-img"/>
    <div class="hero-text">
        <h1>Vind jouw perfecte zomer vakantie</h1>
        <p>Van de zonnige stranden tot groene natuurgebieden, wij helpen je de beste plek te vinden.</p>
    </div>
</section>


<main class="pp-content">
    <div class="page-content">
        <aside class="pp-filters">
            <h3>Filter jouw zomer vakantie</h3>
            <label for="country">Land</label>
            <select id="country" name="country">
                <option value="">Alle landen</option>
                <option>Spanje</option>
                <option>Italië</option>
                <option>Griekenland</option>
                <option>Portugal</option>
                <option>Frankrijk</option>
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
                <option>Familie</option>
                <option>Romantisch</option>
                <option>Actief</option>
            </select>
        </aside>

        <section class="destination-blocks">
            <div class="destination-box" onclick="location.href='spanje.php'">

                <img src="images\OIP4.jpg" alt="Spanje"/>
                <h3>Spanje</h3>
            </div>
            <div class="destination-box" onclick="location.href='griekenland.php'">
                <img src="images/foto-mooie-vakantiebestemming-in-griekenland-met-huizen-en-de-zee-in-de-zomer-hd-vakantie-achtergrond.jpg" alt="Griekenland"/>
                <h3>Griekenland</h3>
            </div>
            <div class="destination-box" onclick="location.href='morokko.php'">
                <img src="images/OIP (5).jpg" alt="Morokko"/>
                <h3>Morokko</h3>
            </div>
            <div class="destination-box" onclick="location.href='turkije.php'">
                <img src="images/downloads (1).jpg" alt="Turkije"/>
                <h3>Turkije</h3>
            </div>
        </section>

</main>

<footer>
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>

<script>
    document.getElementById('searchForm').addEventListener('submit', function (e) {
        const inputs = this.querySelectorAll('input[required], select[required]');
        let allValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.style.borderColor = 'red';
                allValid = false;
            } else {
                input.style.borderColor = '#ccc';
            }
        });

        if (!allValid) {
            e.preventDefault();
            alert('⚠️ Vul alle verplichte velden in.');
        }
    });
</script>

</body>
</html>
