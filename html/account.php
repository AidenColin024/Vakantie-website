<?php
session_start();

if (!isset($_SESSION['naam']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$conn = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8mb4", "root", "rootpassword");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT id, Naam, Email, Wachtwoord FROM Gebruikers WHERE Email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();
$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

$naam = $gebruiker['Naam'];
$user_id = $gebruiker['id'];

$profiel_update_bericht = '';
$wachtwoord_update_bericht = '';

// PROFIEL BIJWERKEN
if (isset($_POST['profiel_update'])) {
    $nieuwe_naam = trim($_POST['naam']);
    $nieuwe_email = trim($_POST['email']);

    if ($nieuwe_naam && $nieuwe_email) {
        $stmt = $conn->prepare("SELECT id FROM Gebruikers WHERE Email = :email AND id != :id");
        $stmt->execute([':email' => $nieuwe_email, ':id' => $user_id]);

        if ($stmt->fetch()) {
            $profiel_update_bericht = "<span style='color:red'>E-mailadres al in gebruik.</span>";
        } else {
            $stmt = $conn->prepare("UPDATE Gebruikers SET Naam = :naam, Email = :email WHERE id = :id");
            $stmt->execute([':naam' => $nieuwe_naam, ':email' => $nieuwe_email, ':id' => $user_id]);
            $_SESSION['naam'] = $nieuwe_naam;
            $_SESSION['email'] = $nieuwe_email;
            $naam = $nieuwe_naam;
            $email = $nieuwe_email;
            $profiel_update_bericht = "<span style='color:green'>Gegevens bijgewerkt.</span>";
        }
    }
}

// WACHTWOORD WIJZIGEN
if (isset($_POST['wachtwoord_update'])) {
    $huidig = $_POST['oud_wachtwoord'];
    $nieuw1 = $_POST['nieuw_wachtwoord'];
    $nieuw2 = $_POST['nieuw_wachtwoord2'];

    if ($nieuw1 !== $nieuw2) {
        $wachtwoord_update_bericht = "<span style='color:red'>Wachtwoorden komen niet overeen.</span>";
    } elseif (strlen($nieuw1) < 6) {
        $wachtwoord_update_bericht = "<span style='color:red'>Wachtwoord moet minimaal 6 tekens bevatten.</span>";
    } elseif (password_verify($huidig, $gebruiker['Wachtwoord'])) {
        $hash = password_hash($nieuw1, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE Gebruikers SET Wachtwoord = :wachtwoord WHERE id = :id");
        $stmt->execute([':wachtwoord' => $hash, ':id' => $user_id]);
        $wachtwoord_update_bericht = "<span style='color:green'>Wachtwoord aangepast.</span>";
    } else {
        $wachtwoord_update_bericht = "<span style='color:red'>Huidig wachtwoord is onjuist.</span>";
    }
}

// BOEKING ANNULEREN
if (isset($_POST['annuleer_id'])) {
    $annuleer_id = (int)$_POST['annuleer_id'];
    $stmt = $conn->prepare("DELETE FROM boeking WHERE id = :id AND email = :email");
    $stmt->execute([':id' => $annuleer_id, ':email' => $email]);
}

// BOEKINGEN OPHALEN
$stmt = $conn->prepare("SELECT b.id, h.hotel_naam AS hotelnaam, b.aankomst, b.vertrek, b.personen, b.datum 
                        FROM boeking b 
                        LEFT JOIN hotels h ON b.hotel_id = h.id 
                        WHERE b.email = :email 
                        ORDER BY b.aankomst DESC");
$stmt->bindParam(":email", $email);
$stmt->execute();
$boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
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

        <div class="account-section">
            <h2>Profielinformatie</h2>
            <?= $profiel_update_bericht ?>
            <form method="POST" class="account-form">
                <input type="hidden" name="profiel_update" value="1">
                <label for="naam">Naam</label>
                <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($naam) ?>" required>

                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

                <button type="submit">Wijzigingen opslaan</button>
            </form>
        </div>

        <div class="account-section">
            <h2>Wachtwoord wijzigen</h2>
            <?= $wachtwoord_update_bericht ?>
            <form method="POST" class="account-form">
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
                    <?php foreach ($boekingen as $boeking): ?>
                        <li>
                            <?= htmlspecialchars($boeking['hotelnaam']) ?> – aankomst: <?= date('d-m-Y', strtotime($boeking['aankomst'])) ?> – vertrek: <?= date('d-m-Y', strtotime($boeking['vertrek'])) ?> – personen: <?= (int)$boeking['personen'] ?>
                            <form method="POST" onsubmit="return confirm('Weet je zeker dat je deze boeking wilt annuleren?');" style="display:inline;">
                                <input type="hidden" name="annuleer_id" value="<?= $boeking['id'] ?>">
                                <button type="submit" style="margin-left:10px; background:#e74c3c; color:#fff; border:none; border-radius:4px; padding:2px 10px;">Annuleren</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><em>Geen boekingen gevonden.</em></li>
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
    © 2025 Polar Paradise. Alle rechten voorbehouden.
</footer>
</body>
</html>


