<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

$success = false;
$error = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['name']) && isset($_POST['message'])) {
            $naam = $_POST['name'];
            $vraag = $_POST['message'];

            if ($naam != '' && $vraag != '') {
                $stmt = $conn->prepare("INSERT INTO Vragen (Naam, Vraag) VALUES (?, ?)");
                $stmt->execute([$naam, $vraag]);
                $success = true;
            } else {
                $error = "Vul alle verplichte velden in!";
            }
        }
    }
} catch (PDOException $e) {
    $error = "❌ Databasefout: " . $e->getMessage();
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

<header class="pp-header">
    <div class="logo">
        <a href="index.php">
            <img src="images/image1 (1).png" alt="Polar & Paradise">
        </a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
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
        <?php if ($success): ?>
            <div class="success-message" style="color: green; margin-bottom: 1em;">
                Je vraag is succesvol verzonden! We nemen zo snel mogelijk contact met je op.
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error-message" style="color: red; margin-bottom: 1em;">
                <?= htmlspecialchars($error) ?>
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
