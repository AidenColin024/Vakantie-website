<?php
$hotel = isset($_GET['hotel']) ? htmlspecialchars($_GET['hotel']) : 'Onbekend hotel';
$melding = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naam = trim($_POST['naam'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $aantalNachten = intval($_POST['aantal_nachten'] ?? 1);

    if ($naam === '' || $email === '' || $aantalNachten < 1) {
        $melding = "Vul alle velden correct in.";
    } else {
        $melding = "Bedankt voor je boeking bij <strong>$hotel</strong>, $naam! We nemen zo snel mogelijk contact met je op via $email.";
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

            <label for="aantal_nachten">Aantal nachten</label>
            <input type="number" id="aantal_nachten" name="aantal_nachten" min="1" value="1" required />

            <button type="submit" class="btn-submit">Boek nu</button>
        </form>

        <a href="oostenrijk.php" class="link-back">← Terug naar vakanties</a>
    </section>
</main>

<footer class="pp-footer">
    © 2025 Polar Paradise. Alle rechten voorbehouden.
</footer>
</body>
</html>

