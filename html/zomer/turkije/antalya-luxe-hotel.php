<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}
$bericht = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $hotel = "AntalyaLuxeHotel";
    $naam = trim(htmlspecialchars($_POST['naam']));
    $beoordeling = (int)$_POST['beoordeling'];
    $commentaar = trim(htmlspecialchars($_POST['commentaar']));
    if ($naam !== "" && $beoordeling >= 1 && $beoordeling <= 5 && $commentaar !== "") {
        $stmt = $conn->prepare("INSERT INTO review (hotel, naam, beoordeling, commentaar, datum) VALUES (:hotel, :naam, :beoordeling, :commentaar, NOW())");
        $stmt->execute([
            ':hotel' => $hotel,
            ':naam' => $naam,
            ':beoordeling' => $beoordeling,
            ':commentaar' => $commentaar,
        ]);
        $bericht = "✅ Bedankt voor je review!";
    } else {
        $bericht = "⚠️ Vul alle velden correct in.";
    }
}
$stmt = $conn->prepare("SELECT naam, beoordeling, commentaar, datum FROM review WHERE hotel = :hotel ORDER BY datum DESC");
$stmt->execute([':hotel' => "AntalyaLuxeHotel"]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Antalya Luxe Hotel – Turkije | Polar & Paradise</title>
    <link rel="stylesheet" href="../../vakantie.css?v=<?= time() ?>" />
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="../../index.php"><img src="../../images/image1%20(1).png" alt="Polar & Paradise" /></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="../../index.php">Home</a></li>
            <li><a href="../../ski.php">Ski vakanties</a></li>
            <li><a href="../../zomer.php">Zomer vakanties</a></li>
            <li><a href="../../overons.php">Over ons</a></li>
            <li><a href="../../contact.php">Contact</a></li>
            <li><a href="../../login.php">Login</a></li>
            <li><a href="../../boeking.php">Boeking</a></li>
        </ul>
    </nav>
</header>
<main class="pp-content">
    <section class="hotel-detail">
        <h1>Antalya Luxe Hotel – 5 sterren</h1>
        <div class="hotel-images">
            <img src="../../images/antalya.jpg" alt="Antalya Luxe Hotel" />
            <!-- ![image5](image5) -->
        </div>
        <article class="hotel-info">
            <h2>Beschrijving</h2>
            <p>Luxe hotel aan de Turkse Rivièra met privéstrand, spa en meerdere restaurants.</p>
            <h2>Prijs</h2>
            <p>Vanaf €220 per nacht</p>
            <h2>Faciliteiten</h2>
            <ul>
                <li>Privéstrand</li>
                <li>Spa & Wellness</li>
                <li>Zwembaden</li>
                <li>All inclusive</li>
            </ul>
            <a href="../../boeking.php?hotel=AntalyaLuxeHotel" class="pp-booking-btn">Boek nu</a>
            <h2>Reviews</h2>
            <?php if (!empty($bericht)): ?><p><strong><?php echo $bericht; ?></strong></p><?php endif; ?>
            <form method="post" action="">
                <label for="naam">Naam:</label><br />
                <input type="text" id="naam" name="naam" required /><br />
                <label for="beoordeling">Beoordeling:</label><br />
                <select id="beoordeling" name="beoordeling" required>
                    <option value="">Kies</option>
                    <option value="1">1 ster</option>
                    <option value="2">2 sterren</option>
                    <option value="3">3 sterren</option>
                    <option value="4">4 sterren</option>
                    <option value="5">5 sterren</option>
                </select><br />
                <label for="commentaar">Review:</label><br />
                <textarea id="commentaar" name="commentaar" rows="4" required></textarea><br />
                <button type="submit" name="submit_review" class="pp-booking-btn">Plaats review</button>
            </form>
            <?php if ($reviews): ?>
                <ul class="reviews-list">
                    <?php foreach ($reviews as $rev): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($rev['naam']); ?></strong> -
                            <em><?php echo date('d-m-Y', strtotime($rev['datum'])); ?></em><br />
                            Beoordeling: <?php echo str_repeat('⭐', $rev['beoordeling']); ?><br />
                            <p><?php echo nl2br(htmlspecialchars($rev['commentaar'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Er zijn nog geen reviews. Wees de eerste!</p>
            <?php endif; ?>
        </article>
        <a href="turkije.php" class="pp-back-btn">← Terug naar Turkije vakanties</a>
    </section>
</main>
<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br />
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br />
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>