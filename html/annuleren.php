<?php
$hotel = isset($_GET['hotel']) ? htmlspecialchars($_GET['hotel']) : 'je vakantie';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuleer Vakantie | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css">
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
        <h1>Annuleer je boeking</h1>
        <p>Gebruik onderstaand formulier om je boeking van <strong><?= $hotel ?></strong> te annuleren.</p>

        <form action="annuleren_verwerk.php" method="POST" class="annuleer-form">
            <input type="hidden" name="hotel" value="<?= $hotel ?>">
            <label for="email">E-mailadres</label>
            <input type="email" name="email" required>

            <label for="reden">Reden van annulering</label>
            <textarea name="reden" rows="4" required></textarea>

            <button type="submit">Bevestig annulering</button>
        </form>

        <a href="index.php" class="pp-back-btn">← Terug naar home</a>
    </section>
</main>

<footer class="pp-footer">
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.
</footer>
</body>
</html>
