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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Over ons – Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
    <title>Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">

</head>
<body>

<!-- HEADER -->
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
            <li><a href="overons.php" class="active">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<!-- Hero / Banner -->
<section class="hero-section about-hero">
    <img src="images/ChatGPT Image 19 mei 2025, 16_01_26.png" alt="Over ons" class="hero-img">
    <div class="hero-text">
        <h1>Over Polar & Paradise</h1>
        <p>Van zonovergoten stranden tot besneeuwde bergtoppen – wij brengen jouw droomvakantie tot leven.</p>
    </div>
</section>

<!-- Missie & Visie -->
<section class="about-content">
    <div class="about-box">
        <h2>Onze Missie</h2>
        <p>Wij geloven dat iedereen recht heeft op een onvergetelijke vakantie. Of je nu op zoek bent naar ontspanning
            onder een palmboom of actie op de piste, wij maken het mogelijk.</p>
    </div>
    <div class="about-box">
        <h2>Onze Visie</h2>
        <p>Als pioniers in veelzijdige reizen combineren we de beste deals, persoonlijke service en betrouwbare
            garanties. Altijd met oog voor duurzaamheid en lokale cultuur.</p>
    </div>
</section>

<!-- Team -->
<section class="about-team">
    <h2>Ontmoet ons team</h2>
    <div class="team-members">
        <div class="team-member">
            <h3>Aleks</h3>
            <p>Reisexpert Zomerzon</p>
        </div>
        <div class="team-member">
            <h3>Aiden</h3>
            <p>Wintersport Specialist</p>
        </div>
    </div>
</section>


<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const contactService = document.querySelector('.service-contact');
        if (contactService) {
            contactService.addEventListener('click', () => {
                alert('Heb je vragen? Neem gerust contact met ons op via de contactpagina!');
            });
        }
    });
</script>

</body>
</html>
</html>