<?php
session_start();

$host = "mysql_db";
$dbname = "Reis bureau website";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("Verbinding mislukt: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$gebruiker = $_POST['Gebruiker'];
$wachtwoord = $_POST['Wachtwoord'];

$stmt = $conn->prepare("SELECT * FROM Gebruikers WHERE Gebruiker = :Gebruiker AND Wachtwoord = :Wachtwoord");
$stmt->execute([
':Gebruiker' => $gebruiker,
':Wachtwoord' => $wachtwoord
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
$_SESSION['username'] = $user['Gebruiker'];
header("Location: Back-end.php");
exit();
} else {
echo "Ongeldige gebruikersnaam of wachtwoord.";
}
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
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php" >Login</a></li>
        </ul>
    </nav>
</header>
<section class="account-hero">
    <div class="account-container">
        <h1>Mijn Account</h1>

        <div class="account-section">
            <h2>Profielinformatie</h2>
            <form class="account-form">
                <label for="name">Naam</label>
                <input type="text" id="name" name="name" value="Jan Jansen" required>

                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" value="jan@example.com" required>

                <label for="phone">Telefoonnummer</label>
                <input type="tel" id="phone" name="phone" value="06 12345678">

                <button type="submit">Wijzigingen opslaan</button>
            </form>
        </div>

        <div class="account-section">
            <h2>Wachtwoord wijzigen</h2>
            <form class="account-form">
                <label for="current-password">Huidig wachtwoord</label>
                <input type="password" id="current-password" name="current-password" required>

                <label for="new-password">Nieuw wachtwoord</label>
                <input type="password" id="new-password" name="new-password" required>

                <label for="confirm-password">Bevestig nieuw wachtwoord</label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <button type="submit">Wachtwoord bijwerken</button>
            </form>
        </div>

        <div class="account-section">
            <h2>Mijn Boekingen</h2>
            <ul class="booking-list">
                <li>🌴 Zomervakantie Spanje – vertrek: 12 juli 2025</li>
                <li>🏔 Wintersport Oostenrijk – vertrek: 3 januari 2026</li>
                <li>🌊 Roadtrip Portugal – afgerond</li>
            </ul>
        </div>

        <div class="account-section">
            <h2>Contact & Support</h2>
            <p>Heb je vragen? <a href="contact.php">Neem contact met ons op</a>.</p>
        </div>
    </div>
</section>
<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>