<?php
// Verbinding maken met de database
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden: " . $e->getMessage());
}

if (!isset($_GET['id'])) {
    die("Geen hotel geselecteerd.");
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$hotel) {
    die("Hotel niet gevonden.");
}

// Boeking verwerken
$bericht = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actie']) && $_POST['actie'] === 'boek') {
    $naam = trim($_POST['naam'] ?? '');
    $datum = $_POST['datum'] ?? '';
    if ($naam && $datum) {
        $sql = "INSERT INTO bookings (hotel_id, naam, datum) VALUES (?, ?, ?)";
        $stmtBoek = $conn->prepare($sql);
        $stmtBoek->execute([$id, $naam, $datum]);
        $bericht = "Boeking succesvol!";
    } else {
        $bericht = "Vul naam en datum in.";
    }
}

// Reviews ophalen
$stmtReviews = $conn->prepare("SELECT * FROM review WHERE hotel = ?");
$stmtReviews->execute([$hotel['hotel_naam']]);
$reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($hotel['hotel_naam']) ?> – Polar & Paradise</title>
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
            <li><a href="hotels.php">Hotels</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main class="hotel-detail-container">
    <h1><?= htmlspecialchars($hotel['hotel_naam']) ?></h1>

    <?php if (!empty($hotel['image'])): ?>
        <img src="<?= htmlspecialchars($hotel['image']) ?>" alt="Afbeelding van <?= htmlspecialchars($hotel['hotel_naam']) ?>" class="hotel-image">
    <?php endif; ?>


    <div class="hotel-info">
        <p><strong>Regio:</strong> <?= htmlspecialchars($hotel['region']) ?></p>
        <p><strong>Prijs:</strong> €<?= number_format($hotel['prijs'], 2, ',', '.') ?> per nacht</p>
        <p><strong>Beschrijving:</strong><br><?= nl2br(htmlspecialchars($hotel['beschrijving'] ?? 'Geen beschrijving')) ?></p>
    </div>

    <section class="booking-link">
        <a href="boeking.php?id=<?= $hotel['id'] ?>"
           class="btn-book">Boek dit hotel</a>
    </section>


    <section class="review-section">
        <h2>Reviews</h2>
        <?php if (count($reviews) > 0): ?>
            <?php foreach ($reviews as $rev): ?>
                <div class="review-block">
                    <strong><?= htmlspecialchars($rev['naam']) ?></strong>
                    <p><?= nl2br(htmlspecialchars($rev['commentaar'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Er zijn nog geen reviews.</p>
        <?php endif; ?>
    </section>

    <section class="review-form">
        <h3>Recensie plaatsen</h3>
        <form method="post" action="plaats_review.php">
            <input type="hidden" name="hotel" value="<?= htmlspecialchars($hotel['hotel_naam']) ?>">
            <label>Naam: <input type="text" name="naam" required></label>
            <label>Beoordeling:
                <select name="beoordeling" required>
                    <option value="5">5 sterren</option>
                    <option value="4">4 sterren</option>
                    <option value="3">3 sterren</option>
                    <option value="2">2 sterren</option>
                    <option value="1">1 ster</option>
                </select>
            </label>
            <label>Commentaar:
                <textarea name="commentaar" rows="4" required></textarea>
            </label>
            <button type="submit">Verstuur recensie</button>
        </form>
    </section>

    <p><a href="ski.php">← Terug naar Ski vakanties</a></p>
</main>

<footer class="site-footer">
    © 2025 Polar & Paradise – alle rechten voorbehouden.
</footer>
</body>
</html>
