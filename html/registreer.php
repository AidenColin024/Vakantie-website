<?php
ob_start();
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naam = trim($_POST["naam"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $wachtwoord = $_POST["password"] ?? '';
    $wachtwoordBevestiging = $_POST["password_confirm"] ?? '';

    if (!$naam || !$email || !$wachtwoord || !$wachtwoordBevestiging) {
        $foutmelding = "Vul alle velden in.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $foutmelding = "Ongeldig e-mailadres.";
    } elseif ($wachtwoord !== $wachtwoordBevestiging) {
        $foutmelding = "Wachtwoorden komen niet overeen.";
    } else {
        // Check of email al bestaat
        $stmt = $conn->prepare("SELECT * FROM Gebruikers WHERE Email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if ($stmt->fetch()) {
            $foutmelding = "Dit e-mailadres is al geregistreerd.";
        } else {
            // Wachtwoord hashen en opslaan
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO Gebruikers (Naam, Email, Wachtwoord) VALUES (:naam, :email, :wachtwoord)");
            $stmt->bindParam(":naam", $naam);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":wachtwoord", $hash);
            $stmt->execute();

            // Sessie starten en doorsturen
            $_SESSION["naam"] = $naam;
            $_SESSION["email"] = $email;
            header("Location: account.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registreren | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=1.2" />
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
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="register-hero">
    <div class="register-form-container">
        <h1>Registreren</h1>
        <?php if ($foutmelding): ?>
            <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($foutmelding); ?></p>
        <?php endif; ?>
                <form class="login-form" method="POST" action="registreer.php">
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam" required value="<?= isset($naam) ? htmlspecialchars($naam) : '' ?>">

                    <label for="email">E-mailadres</label>
                    <input type="email" id="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">

                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password" required>

                    <label for="password_confirm">Bevestig wachtwoord</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>

                    <button type="submit">Registreren</button>
                    <p class="register-note">Al een account? <a href="login.php">Log hier in</a></p>
                </form>
            </div>
        </section>
    </div>
</section>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden

