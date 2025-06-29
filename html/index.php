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
    <title>Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">


</head>
<body>

<!-- HEADER -->
<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<!-- HERO -->
<section class="vakantie">
    <img src="\images\image3.webp" alt="Zon en Sneeuw vakanties">
    <div class="hero-text">
        <h1>Van zon en zee<br>naar sneeuw en slee</h1>
    </div>
</section>

<!-- DEAL ICONS -->
<section class="deals">
    <p>Zorgvuldig gekozen deals door onze specialisten</p>
    <div class="deal-icons">
        <span>Exclusieve deals</span>
        <span>Vakanties</span>
        <span>Vlucht</span>
        <span>Accommodaties</span>
        <span>All-inclusive</span>
        <!-- voeg meer toe zoals in het voorbeeld -->
    </div>
</section>

<!-- ZOMER / WINTER -->
<section class="seasons">
    <div class="summer">
        <div class="content">
            <h2>Jouw ideale zonvakantie</h2>
            <a href="zomer.php" class="btn btn-primary">Bekijk</a>
        </div>
    </div>



<!-- SERVICE BLOCKS -->
<section class="services">
    <div class="service">
        <h3>Verzekeringen regelen</h3>
        <p>Goed verzekerd op vakantie</p>
    </div>
    <div class="service">
        <h3>Extra services bijboeken</h3>
        <p>Maak jouw vakantie compleet</p>
    </div>
    <div class="service">
        <h3>Vakantiegarantie</h3>
        <p>Alle zekerheden gebundeld</p>
    </div>
    <div class="service">
        <h3>Vragen? Wij helpen graag</h3>
        <p>Direct contact of antwoord</p>
    </div>
</section>
<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
</body>
</html>