<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Verbindingsfout: " . $e->getMessage());
}

$foutmelding = "";
$succes = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['name'];
    $vraag = $_POST['message'];

    if ($naam === "" || $vraag === "") {
        $foutmelding = "Vul alle verplichte velden in!";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO Vragen (Naam, Vraag) VALUES (:naam, :vraag)");
            $stmt->execute([':naam' => $naam, ':vraag' => $vraag]);
            $succes = "Je vraag is succesvol verstuurd.";
        } catch (PDOException $e) {
            $foutmelding = "Er ging iets mis bij het opslaan van je vraag. Probeer het later opnieuw.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise - Contact</title>
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
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php" class="active">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>
<section class="contact-hero">
    <div class="form-container">
        <h1 class="form-title">Contact</h1>
        <?php if ($succes): ?>
            <div class="success-message" style="color: green; margin-bottom: 1em;">
                Je vraag is succesvol verzonden! We nemen zo snel mogelijk contact met je op.
            </div>
        <?php endif; ?>

        <?php if ($foutmelding): ?>
            <div class="error-message" style="color: red; margin-bottom: 1em;">
                <?= htmlspecialchars($foutmelding) ?>
            </div>
        <?php endif; ?>

        <form class="form" method="POST" action="contact.php">
            <label for="name">Naam</label>
            <input type="text" id="name" name="name" required>
            <label for="message">Bericht</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Verzenden</button>
        </form>
    </div>
</section>
<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>