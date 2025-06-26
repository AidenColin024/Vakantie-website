<?php
// Maak verbinding met database
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

// Check of id is opgegeven
if (!isset($_GET['id'])) {
    die("Geen hotel geselecteerd.");
}
$id = (int)$_GET['id'];

// Haal hotel info op
$stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$hotel) {
    die("Hotel niet gevonden.");
}

// Verwerk boeken
$bericht = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actie'])) {
    if ($_POST['actie'] === 'boek') {
        $naam = trim($_POST['naam'] ?? '');
        $datum = $_POST['datum'] ?? '';
        if ($naam && $datum) {
            // Sla boeking op in database (maak tabel bookings aan)
            $sql = "INSERT INTO bookings (hotel_id, naam, datum) VALUES (?, ?, ?)";
            $stmtBoek = $conn->prepare($sql);
            $stmtBoek->execute([$id, $naam, $datum]);
            $bericht = "Boeking succesvol!";
        } else {
            $bericht = "Vul naam en datum in.";
        }
    }
}

// Haal reviews op
$stmtReviews = $conn->prepare("SELECT * FROM review WHERE hotel = ?");
$stmtReviews->execute([$hotel['hotel_naam']]);
$reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($hotel['hotel_naam']) ?></title>
</head>
<body>
<h1><?= htmlspecialchars($hotel['hotel_naam']) ?></h1>
<p>Regio: <?= htmlspecialchars($hotel['region']) ?></p>
<p>Prijs: €<?= htmlspecialchars($hotel['prijs']) ?> per nacht</p>
<p>Beschrijving: <?= nl2br(htmlspecialchars($hotel['beschrijving'] ?? 'Geen beschrijving')) ?></p>

<h2>Boeken</h2>
<?php if ($bericht): ?>
    <p><strong><?= htmlspecialchars($bericht) ?></strong></p>
<?php endif; ?>
<form method="post">
    <input type="hidden" name="actie" value="boek">
    Naam: <input type="text" name="naam" required><br>
    Datum: <input type="date" name="datum" required><br>
    <button type="submit">Boek nu</button>
</form>

<h2>Reviews</h2>
<?php if (count($reviews) > 0): ?>
    <?php foreach ($reviews as $rev): ?>
        <p><strong><?= htmlspecialchars($rev['naam']) ?></strong>: <?= nl2br(htmlspecialchars($rev['commentaar'])) ?></p>
    <?php endforeach; ?>
<?php else: ?>
    <p>Er zijn nog geen reviews.</p>
<?php endif; ?>

<h3>Recensie plaatsen</h3>
<form method="post" action="plaats_review.php">
    <input type="hidden" name="hotel" value="<?= htmlspecialchars($hotel['hotel_naam']) ?>">
    Naam: <input type="text" name="naam" required><br>
    Beoordeling:
    <select name="beoordeling" required>
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
    </select><br>
    Commentaar:<br>
    <textarea name="commentaar" rows="4" required></textarea><br>
    <button type="submit">Verstuur recensie</button>
</form>

<p><a href="ski.php">Terug naar Ski vakanties</a></p>
</body>
</html>
