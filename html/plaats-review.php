<?php
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
// Haal hotel id uit GET, of zet op null als niet aanwezig
$hotelId = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel = $_POST['hotel'] ?? '';
    $naam = trim($_POST['naam'] ?? '');
    $beoordeling = (int)($_POST['beoordeling'] ?? 0);
    $commentaar = trim($_POST['commentaar'] ?? '');

    if ($hotel && $naam && $beoordeling >= 1 && $beoordeling <= 5 && $commentaar) {
        $stmt = $conn->prepare("INSERT INTO review (hotel, naam, beoordeling, commentaar) VALUES (?, ?, ?, ?)");
        $stmt->execute([$hotel, $naam, $beoordeling, $commentaar]);

        // Alleen redirect als hotelId bestaat
        if ($hotelId) {
            header("Location: hotel-details.php?id=" . urlencode($hotelId) . "&bericht=review_success");
            exit;
        } else {
            $bericht = "Recensie succesvol geplaatst, maar geen hotel ID gevonden voor redirect.";
        }
    } else {
        $bericht = "Vul alle velden correct in.";
    }
} else {
    $bericht = "Ongeldige aanvraag.";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Recensie plaatsen</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<div class="container">
    <h1>Recensie plaatsen</h1>
    <?php if (!empty($bericht)): ?>
        <p style="color:<?= ($bericht === 'Recensie succesvol geplaatst, maar geen hotel ID gevonden voor redirect.') ? 'green' : 'red' ?>; font-weight:bold;">
            <?= htmlspecialchars($bericht) ?>
        </p>
    <?php endif; ?>
    <p><a href="hotel-details.php?id=<?= htmlspecialchars($hotelId ?? '') ?>">Terug naar hotel</a></p>
</div>
</body>
</html>
