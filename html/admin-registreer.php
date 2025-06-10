<?php
session_start();

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

$foutmelding = "";
$succesmelding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naam = trim($_POST["naam"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $wachtwoord = $_POST["password"] ?? "";
    $wachtwoordBevestig = $_POST["password_confirm"] ?? "";

    if (!$naam || !$email || !$wachtwoord || !$wachtwoordBevestig) {
        $foutmelding = "❌ Vul alle velden in.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $foutmelding = "❌ Vul een geldig e-mailadres in.";
    } elseif ($wachtwoord !== $wachtwoordBevestig) {
        $foutmelding = "❌ Wachtwoorden komen niet overeen.";
    } else {
        // Check of e-mail al bestaat
        $stmt = $conn->prepare("SELECT COUNT(*) FROM Admin WHERE Email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $foutmelding = "❌ Dit e-mailadres is al geregistreerd.";
        } else {
            // Hash het wachtwoord
            $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

            // Insert admin
            $stmt = $conn->prepare("INSERT INTO Admin (Naam, Email, Wachtwoord) VALUES (:naam, :email, :wachtwoord)");
            $stmt->bindParam(":naam", $naam);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":wachtwoord", $hashedWachtwoord);

            if ($stmt->execute()) {
                $succesmelding = "✅ Registratie succesvol! Je kunt nu <a href='admin-inlog.php'>inloggen</a>.";
            } else {
                $foutmelding = "❌ Er is iets misgegaan bij het registreren.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Registreren | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
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
            <li><a href="admin-inlog.php">Admin Login</a></li>
            <li><a href="admin-registreer.php" class="active">Admin Registreren</a></li>
        </ul>
    </nav>
</header>

<section class="login-hero">
    <div class="form-container">
        <h1 class="form-title">Admin Registreren</h1>

        <?php if ($foutmelding): ?>
            <p style="color:red; font-weight:bold;"><?= htmlspecialchars($foutmelding) ?></p>
        <?php endif; ?>

        <?php if ($succesmelding): ?>
            <p style="color:green; font-weight:bold;"><?= $succesmelding ?></p>
        <?php endif; ?>

        <form class="form" method="POST" action="admin-registreer.php">
            <label for="naam">Naam</label>
            <input type="text" id="naam" name="naam" required value="<?= htmlspecialchars($_POST['naam'] ?? '') ?>">

            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirm">Bevestig wachtwoord</label>
            <input type="password" id="password_confirm" name="password_confirm" required>

            <button type="submit">Registreren</button>
        </form>
        <p class="form-note">Heb je al een admin-account? <a href="admin-inlog.php">Log hier in</a></p>
    </div>
</section>

<footer style="text-align:center; padding:1rem; font-size:0.9rem; color:#666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>

