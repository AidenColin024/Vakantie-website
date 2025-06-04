<?php
ob_start();
session_start();

if (!isset($_SESSION['naam'])) {
    header("Location: login.php");
    exit;
}

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "Reis";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Verbindingsfout: " . $e->getMessage());
}

// Haal gegevens op van ingelogde gebruiker
$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT Naam, Email FROM Gebruikers WHERE Email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();

$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

$naam = htmlspecialchars($gebruiker['Naam'] ?? $_SESSION['naam']);
$email = htmlspecialchars($gebruiker['Email'] ?? $_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Mijn Account | Polar & Paradise</title>
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
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>

<section class="account-hero">
    <div class="account-container">
        <h1>Mijn Account</h1>

        <div class="account-section">
            <h2>Profielinformatie</h2>
            <form method="POST" action="account_update.php" class="account-form">
                <label for="name">Naam</label>
                <input type="text" id="name" name="naam" value="<?php echo $naam; ?>" required>

                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required readonly>

                <button type="submit">Wijzigingen opslaan</button>
            </form>
        </div>

        <div class="account-section">
            <h2>Wachtwoord wijzigen</h2>
            <form method="POST" action="password_change.php" class="account-form">
                <label for="current-password">Huidig wachtwoord</label>
                <input type="password" id="current-password" name="current_password" required>

                <label for="new-password">Nieuw wachtwoord</label>
                <input type="password" id="new-password" name="new_password" required>

                <label for="confirm-password">Bevestig nieuw wachtwoord</label>
                <input type="password" id="confirm-password" name="confirm_password" required>

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
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>

</body>
</html>

<?php ob_end_flush(); ?>

