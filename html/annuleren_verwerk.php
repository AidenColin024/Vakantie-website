<?php
// E-mail configuratie
$adminEmail = "aidencolindna@gmail.com"; // <-- Vervang dit met je echte e-mailadres

// Gegevens ophalen
$hotel = isset($_POST['hotel']) ? htmlspecialchars($_POST['hotel']) : 'onbekend hotel';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$reden = isset($_POST['reden']) ? htmlspecialchars($_POST['reden']) : '';

// Verbinding maken met database
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Opslaan in database
    $stmt = $conn->prepare("INSERT INTO annuleren (hotel, email, reden) VALUES (?, ?, ?)");
    $stmt->execute([$hotel, $email, $reden]);

    // E-mail sturen
    $onderwerp = "Nieuwe annulering van $hotel";
    $bericht = "Er is een annulering ontvangen:\n\nHotel: $hotel\nE-mail: $email\nReden:\n$reden";
    mail($adminEmail, $onderwerp, $bericht);

} catch (PDOException $e) {
    die("❌ Databasefout: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Annulering bevestigd | Polar & Paradise</title>
    <link rel="stylesheet" href="annuleren.css">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise" /></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="ski.php">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="annuleren.php">Annuleren</a></li>
        </ul>
    </nav>
</header>

<main class="pp-content">
    <section class="annuleer-container">
        <h1>Annulering ontvangen</h1>
        <p>Bedankt, je boeking voor <strong><?= $hotel ?></strong> is geannuleerd.</p>
        <p>We hebben een bevestiging verwerkt. Als het nodig is, nemen we contact op via <strong><?= $email ?></strong>.</p>
        <p><strong>Reden van annulering:</strong><br><?= nl2br($reden) ?></p>

        <a href="index.php" class="pp-back-btn">← Terug naar home</a>
    </section>
</main>

<footer class="pp-footer">
    © 2025 Polar Paradise. Alle rechten voorbehouden.
</footer>
</body>
</html>
