<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Polar & Paradise</title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">


</head>
<body>

<!-- HEADER -->
<header class="pp-header">
    <div class="logo">
        <a href="../index.php"><img src="../images/image1%20(1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="admin-vragen.php">Inkomende vragen</a></li>
            <li><a href="admin-recensies.php">Inkomende reviews</a></li>
            <li><a href="admin-land.php">Landen</a></li>
            <li><a href="admin-hotel.php">Hotels</a></li>
            <li><a href="admin-boeking.php">Boekingen</a></li>
            <li><a href="../uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>
<!-- HERO -->
<section class="vakantie">
    <div class="hero-text">
        <h1>Welkom op het Admin Dashboard</h1>
        <p>Beheer hier alle onderdelen van Polar & Paradise</p>
    </div>
</section>

<!-- SNELLE LINKS -->
<section class="deals">
    <p>Snelle toegang tot beheerfuncties</p>
    <div class="deal-icons admin-links">
        <a href="admin-vragen.php">Vragen bekijken</a>
        <a href="admin-recensies.php">Reviews bekijken</a>
        <a href="admin-land.php">Landen bewerken</a>
        <a href="admin-hotel.php">Instellingen</a>
    </div>
</section>

<!-- ADMIN INFORMATIE -->
<section class="services">
    <div class="service">
        <h3>Beveiliging</h3>
        <p>Zorg dat je altijd uitlogt na gebruik</p>
    </div>
    <div class="service">
        <h3>Support</h3>
        <p>Neem contact op bij technische problemen</p>
    </div>
    <div class="service">
        <h3>Updates</h3>
        <p>Controleer regelmatig op nieuwe updates</p>
    </div>
    <div class="service">
        <h3>Documentatie</h3>
        <p>Bekijk de handleiding voor beheerfuncties</p>
    </div>
</section>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>

</body>
</html>

