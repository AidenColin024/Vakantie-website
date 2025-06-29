<?php
// Verbinding maken met database
$pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8mb4", "root", "rootpassword");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Hotel-ID ophalen uit de URL
$id = 0;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

// Hotelnaam ophalen
$hotel = 'Onbekend hotel';
$sql = "SELECT hotel_naam FROM hotels WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$result = $stmt->fetch();
if ($result && isset($result['hotel_naam'])) {
    $hotel = $result['hotel_naam'];
}

// Melding tonen na boeking
$melding = "";

// Als formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = isset($_POST['naam']) ? $_POST['naam'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $aankomst = isset($_POST['aankomst']) ? $_POST['aankomst'] : '';
    $vertrek = isset($_POST['vertrek']) ? $_POST['vertrek'] : '';
    $personen = isset($_POST['personen']) ? (int) $_POST['personen'] : 1;

    // Simpele controles
    if ($naam == "" || $email == "" || $aankomst == "" || $vertrek == "" || $personen < 1) {
        $melding = "Vul alles in.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $melding = "E-mailadres is ongeldig.";
    } else if ($aankomst > $vertrek) {
        $melding = "Vertrek moet na aankomst zijn.";
    } else {
        // In database opslaan
        $sql = "INSERT INTO boeking (hotel_id, naam, email, aankomst, vertrek, personen)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id, $naam, $email, $aankomst, $vertrek, $personen]);

        $melding = "Bedankt, " . htmlspecialchars($naam) . "! Je boeking is opgeslagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Boek – <?= htmlspecialchars($hotel) ?></title>
    <link rel="stylesheet" href="vakantie.css">
</head>
<body>
<main class="booking-main">
    <h1>Boeking voor: <?= htmlspecialchars($hotel) ?></h1>

    <?php if ($melding): ?>
        <div class="alert"><?= $melding ?></div>
    <?php endif; ?>

    <form method="post" class="booking-form">
        <label>Naam <input type="text" name="naam" required></label>
        <label>E‑mail <input type="email" name="email" required></label>
        <label>Aankomst <input type="date" name="aankomst" required></label>
        <label>Vertrek <input type="date" name="vertrek" required></label>
        <label>Aantal personen <input type="number" name="personen" value="1" min="1" required></label>
        <button type="submit">Boek nu</button>
    </form>

    <p><a href="hotel-details.php?id=<?= $id ?>">← Terug naar hotel</a></p>
</main>
</body>
</html>
