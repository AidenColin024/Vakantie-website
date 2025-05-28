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
    <title>Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=1.2">

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
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="login.php" >Login</a></li>
        </ul>
    </nav>
</header>
<section class="contact-hero">
    <div class="contact-hero-text">
        <h1>Contact</h1>
        <h2>Neem contact met ons op</h2>
        <p>Heb je vragen of wil je je droomreis bespreken? Wij staan voor je klaar!</p>
    </div>
</section>

<section class="contact-form-section">
    <form class="contact-form">
        <label for="name">Naam</label>
        <input type="text" id="name" name="name" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Bericht</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Verzenden</button>
    </form>
</section>
<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>