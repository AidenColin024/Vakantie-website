<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

$hotel = isset($_GET['hotel']) ? htmlspecialchars($_GET['hotel']) : 'Onbekend hotel';
$melding = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $melding = "❌ Verbindingsfout: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naam = trim($_POST['naam'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $aankomst = $_POST['aankomst'] ?? '';
    $vertrek = $_POST['vertrek'] ?? '';
    $personen = intval($_POST['personen'] ?? 1);

    // Validatie
    if (
        $naam === '' ||
        $email === '' ||
        $aankomst === '' ||
        $vertrek === '' ||
        $personen < 1
    ) {
        $melding = "⚠️ Vul alle velden correct in.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $melding = "⚠️ Ongeldig e-mailadres.";
    } else if ($aankomst > $vertrek) {
        $melding = "⚠️ Vertrekdatum moet na aankomstdatum liggen.";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO boeking (hotel, naam, email, aankomst, vertrek, personen) VALUES (:hotel, :naam, :email, :aankomst, :vertrek, :personen)");
            $stmt->execute([
                ':hotel' => $hotel,
                ':naam' => $naam,
                ':email' => $email,
                ':aankomst' => $aankomst,
                ':vertrek' => $vertrek,
                ':personen' => $personen
            ]);
            $melding = "✅ Bedankt voor je boeking bij <strong>$hotel</strong>, $naam! We nemen zo snel mogelijk contact met je op via $email.";
        } catch (PDOException $e) {
            $melding = "❌ Er ging iets mis bij het opslaan van je boeking: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Boeking maken – <?php echo $hotel; ?> | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css" />
    <style>
        .booking-main { background: #f8f8fc; min-height: 80vh; }
        .booking-container {
            max-width: 420px; margin: 2.5rem auto; background: #fff; border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08); padding: 2.2rem 2rem;
        }
        .booking-container h1 { color: #0066cc; font-size: 1.5rem; margin-bottom: 1.5rem; }
        .booking-form label { font-weight: 600; display:block; margin-top: 1rem;}
        .booking-form input, .booking-form select {
            width: 100%; padding: 0.7rem; border: 1px solid #bbb; border-radius: 7px; margin-top: 0.25rem;
        }
        .booking-form button {
            margin-top: 1.5rem; width: 100%; padding: 0.9rem;
            background: #007acc; color: #fff; font-weight: bold; border: none; border-radius: 8px; cursor: pointer;
            transition: background 0.2s;
        }
        .booking-form button:hover { background: #005fa3; }
        .alert { margin: 1rem 0; padding: 0.7rem 1rem; background: #eaf6ff; border: 1px solid #b2dafe; border-radius: 6px; color: #004080; }
        .link-back { display: inline-block; margin-top: 2rem; color: #007acc; text-decoration: none;}
        .link-back:hover { text-decoration: underline; }
    </style>
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

<main class="booking-main">
    <section class="booking-container">
        <h1>Boeking maken voor: <?php echo $hotel; ?></h1>

        <?php if ($melding): ?>
            <div class="alert"><?php echo $melding; ?></div>
        <?php endif; ?>

        <form class="booking-form" method="post" action="">
            <label for="naam">Naam</label>
            <input type="text" id="naam" name="naam" placeholder="Jouw naam" required />

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="voorbeeld@mail.com" required />

            <label for="aankomst">Aankomstdatum</label>
            <input type="date" id="aankomst" name="aankomst" required />

            <label for="vertrek">Vertrekdatum</label>
            <input type="date" id="vertrek" name="vertrek" required />

            <label for="personen">Aantal personen</label>
            <input type="number" id="personen" name="personen" min="1" value="1" required />

            <button type="submit" class="btn-submit">Boek nu</button>
        </form>

        <a href="winter/oostenrijk/oostenrijk.php" class="link-back">← Terug naar vakanties</a>
    </section>
</main>

<footer class="pp-footer">
    © 2025 Polar Paradise. Alle rechten voorbehouden.
</footer>
</body>
</html>