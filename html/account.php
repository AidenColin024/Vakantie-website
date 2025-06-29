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

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$naam = $_SESSION['naam'];
$foutmelding = "";
$succes = "";

// Profiel bijwerken
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["profiel_update"])) {
    $nieuwe_naam = $_GET["naam"];
    $nieuwe_email = $_GET["email"];

    if ($nieuwe_naam != "" && $nieuwe_email != "") {
        $stmt = $conn->query("SELECT * FROM Gebruikers WHERE Email='$nieuwe_email' AND Email != '$email'");
        if ($stmt->rowCount() == 0) {
            $conn->query("UPDATE Gebruikers SET Naam='$nieuwe_naam', Email='$nieuwe_email' WHERE Email='$email'");
            $_SESSION['naam'] = $nieuwe_naam;
            $_SESSION['email'] = $nieuwe_email;
            $naam = $nieuwe_naam;
            $email = $nieuwe_email;
            $succes = "Gegevens bijgewerkt.";
        } else {
            $foutmelding = "E-mailadres is al in gebruik.";
        }
    } else {
        $foutmelding = "Vul alle velden in.";
    }
}

// Wachtwoord wijzigen
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["wachtwoord_update"])) {
    $oud = $_GET["oud_wachtwoord"];
    $nieuw = $_GET["nieuw_wachtwoord"];
    $herhaal = $_GET["nieuw_wachtwoord2"];

    $stmt = $conn->query("SELECT Wachtwoord FROM Gebruikers WHERE Email='$email'");
    $user = $stmt->fetch();

    if ($oud != "" && $nieuw != "" && $herhaal != "") {
        if ($nieuw != $herhaal) {
            $foutmelding = "Nieuw wachtwoord komt niet overeen.";
        } elseif ($user["Wachtwoord"] != $oud) {
            $foutmelding = "Huidig wachtwoord is onjuist.";
        } else {
            $conn->query("UPDATE Gebruikers SET Wachtwoord='$nieuw' WHERE Email='$email'");
            $succes = "Wachtwoord gewijzigd.";
        }
    } else {
        $foutmelding = "Vul alle wachtwoordvelden in.";
    }
}

// Boekingen ophalen
$boekingen = $conn->query("SELECT * FROM boeking WHERE email='$email' ORDER BY aankomst DESC")->fetchAll(PDO::FETCH_ASSOC);

// Annuleren
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["annuleer_id"])) {
    $id = (int)$_GET["annuleer_id"];
    $conn->query("DELETE FROM boeking WHERE id=$id AND email='$email'");
    header("Location: account.php");
    exit;
}
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

        <?php if ($foutmelding) echo "<p style='color:red;'>$foutmelding</p>"; ?>
        <?php if ($succes) echo "<p style='color:green;'>$succes</p>"; ?>

        <div class="account-section">
            <h2>Profielinformatie</h2>
            <form method="get" action="account.php" class="account-form">
                <input type="hidden" name="profiel_update" value="1">
                <label for="name">Naam</label>
                <input type="text" id="name" name="naam" value="<?= $naam ?>" required>

                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" value="<?= $email ?>" required>

                <button type="submit">Wijzigingen opslaan</button>
            </form>
        </div>

        <div class="account-section">
            <h2>Wachtwoord wijzigen</h2>
            <form method="get" action="account.php" class="account-form">
                <input type="hidden" name="wachtwoord_update" value="1">
                <label for="oud_wachtwoord">Huidig wachtwoord</label>
                <input type="password" id="oud_wachtwoord" name="oud_wachtwoord" required>

                <label for="nieuw_wachtwoord">Nieuw wachtwoord</label>
                <input type="password" id="nieuw_wachtwoord" name="nieuw_wachtwoord" required>

                <label for="nieuw_wachtwoord2">Herhaal nieuw wachtwoord</label>
                <input type="password" id="nieuw_wachtwoord2" name="nieuw_wachtwoord2" required>

                <button type="submit">Wijzig wachtwoord</button>
            </form>
        </div>

        <div class="account-section">
            <h2>Mijn Boeking</h2>
            <ul class="booking-list">
                <?php if ($boekingen): ?>
                    <?php foreach ($boekingen as $b): ?>
                        <li>
                            <?= $b['hotel'] ?> – aankomst: <?= $b['aankomst'] ?> – vertrek: <?= $b['vertrek'] ?> – personen: <?= $b['personen'] ?>
                            <form method="get" action="account.php" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je deze boeking wilt annuleren?');">
                                <input type="hidden" name="annuleer_id" value="<?= $b['id'] ?>">
                                <button type="submit" style="margin-left:10px; background:#e74c3c; color:#fff; border:none; border-radius:4px; padding:2px 10px;">Annuleren</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><em>Geen boeking gevonden.</em></li>
                <?php endif; ?>
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
