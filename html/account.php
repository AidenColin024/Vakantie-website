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
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Verbindingsfout: " . $e->getMessage());
}

// Haal huidige gebruiker
$email = $_SESSION['email'] ?? '';
$stmt = $conn->prepare("SELECT id, Naam, Email, Wachtwoord FROM Gebruikers WHERE Email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();
$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

$naam = htmlspecialchars($gebruiker['Naam'] ?? $_SESSION['naam']);
$email = htmlspecialchars($gebruiker['Email'] ?? $_SESSION['email']);
$user_id = $gebruiker['id'] ?? null;

// Verwerk profielwijziging (naam/email)
$profiel_update_bericht = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profiel_update'])) {
    $nieuwe_naam = trim($_POST['naam']);
    $nieuwe_email = trim($_POST['email']);
    // Controleer of e-mail al bestaat (en niet van jezelf is)
    $stmt = $conn->prepare("SELECT id FROM Gebruikers WHERE Email = :email AND id != :id");
    $stmt->execute([':email' => $nieuwe_email, ':id' => $user_id]);
    if ($stmt->fetch()) {
        $profiel_update_bericht = "<span style='color:red'>Dit e-mailadres is al in gebruik.</span>";
    } else {
        $stmt = $conn->prepare("UPDATE Gebruikers SET Naam = :naam, Email = :email WHERE id = :id");
        $stmt->execute([':naam' => $nieuwe_naam, ':email' => $nieuwe_email, ':id' => $user_id]);
        $_SESSION['naam'] = $nieuwe_naam;
        $_SESSION['email'] = $nieuwe_email;
        $naam = htmlspecialchars($nieuwe_naam);
        $email = htmlspecialchars($nieuwe_email);
        $profiel_update_bericht = "<span style='color:green'>Gegevens succesvol bijgewerkt.</span>";
    }
}

// Verwerk wachtwoord wijziging
$wachtwoord_update_bericht = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wachtwoord_update'])) {
    $huidig = $_POST['oud_wachtwoord'] ?? '';
    $nieuw1 = $_POST['nieuw_wachtwoord'] ?? '';
    $nieuw2 = $_POST['nieuw_wachtwoord2'] ?? '';
    if ($nieuw1 !== $nieuw2) {
        $wachtwoord_update_bericht = "<span style='color:red'>Nieuw wachtwoord komt niet overeen.</span>";
    } elseif (strlen($nieuw1) < 6) {
        $wachtwoord_update_bericht = "<span style='color:red'>Nieuw wachtwoord moet minimaal 6 tekens zijn.</span>";
    } else {
        // Controleer huidig wachtwoord
        if (password_verify($huidig, $gebruiker['Wachtwoord'])) {
            $hash = password_hash($nieuw1, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE Gebruikers SET Wachtwoord = :wachtwoord WHERE id = :id");
            $stmt->execute([':wachtwoord' => $hash, ':id' => $user_id]);
            $wachtwoord_update_bericht = "<span style='color:green'>Wachtwoord succesvol gewijzigd.</span>";
        } else {
            $wachtwoord_update_bericht = "<span style='color:red'>Huidig wachtwoord is onjuist.</span>";
        }
    }
}

// Boekingen ophalen
$boekingen = [];
try {
    $stmt = $conn->prepare("SELECT id, hotel, aankomst, vertrek, personen, datum FROM boeking WHERE email = :email ORDER BY aankomst DESC");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}

// Annuleren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['annuleer_id'])) {
    $annuleer_id = (int) $_POST['annuleer_id'];
    $stmt = $conn->prepare("DELETE FROM boeking WHERE id = :id AND email = :email");
    $stmt->execute([':id' => $annuleer_id, ':email' => $email]);
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
                <?php if ($profiel_update_bericht) echo $profiel_update_bericht; ?>
                <form method="POST" action="account.php" class="account-form">
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
                <?php if ($wachtwoord_update_bericht) echo $wachtwoord_update_bericht; ?>
                <form method="POST" action="account.php" class="account-form">
                    <input type="hidden" name="wachtwoord_update" value="1">
                    <label for="oud_wachtwoord">Huidig wachtwoord</label>
                    <input type="password" id="oud_wachtwoord" name="oud_wachtwoord" required autocomplete="current-password">

                    <label for="nieuw_wachtwoord">Nieuw wachtwoord</label>
                    <input type="password" id="nieuw_wachtwoord" name="nieuw_wachtwoord" required autocomplete="new-password">

                    <label for="nieuw_wachtwoord2">Herhaal nieuw wachtwoord</label>
                    <input type="password" id="nieuw_wachtwoord2" name="nieuw_wachtwoord2" required autocomplete="new-password">

                    <button type="submit">Wijzig wachtwoord</button>
                </form>
            </div>

            <div class="account-section">
                <h2>Mijn Boeking</h2>
                <ul class="booking-list">
                    <?php if ($boekingen && count($boekingen) > 0): ?>
                        <?php foreach ($boekingen as $boeking): ?>
                            <li>
                                <?= htmlspecialchars($boeking['hotel']) ?? 'Onbekend hotel' ?>
                                – aankomst: <?= date('d-m-Y', strtotime($boeking['aankomst'])) ?>
                                – vertrek: <?= date('d-m-Y', strtotime($boeking['vertrek'])) ?>
                                – personen: <?= (int)$boeking['personen'] ?>
                                <small style="color:#666;">(Boeking gedaan op <?= date('d-m-Y H:i', strtotime($boeking['datum'])) ?>)</small>
                                <form method="POST" action="account.php" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je deze boeking wilt annuleren?');">
                                    <input type="hidden" name="annuleer_id" value="<?= $boeking['id'] ?>">
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
<?php ob_end_flush(); ?>