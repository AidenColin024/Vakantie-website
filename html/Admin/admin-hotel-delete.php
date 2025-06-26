<?php
session_start();

/* --- Database connectie --- */
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

/* --- Hotel ID ophalen en checken --- */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Ongeldige hotel ID.");
}
$id = (int)$_GET['id'];

/* --- Hotelgegevens ophalen voor naam tonen --- */
$stmt = $conn->prepare("SELECT hotel_naam, name, image FROM hotels WHERE id = ?");
$stmt->execute([$id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$hotel) {
    die("Hotel niet gevonden.");
}

$melding = '';

/* --- Verwijderen uitvoeren na bevestiging --- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verwijder eventueel afbeeldingbestand van server
    if (!empty($hotel['image']) && file_exists(__DIR__ . '/../' . $hotel['image'])) {
        unlink(__DIR__ . '/../' . $hotel['image']);
    }

    // Verwijder het hotel uit database
    $stmtDel = $conn->prepare("DELETE FROM hotels WHERE id = ?");
    $stmtDel->execute([$id]);

    // Redirect terug naar hotel overzicht van dat land
    header("Location: admin-hotel.php?land=" . urlencode($hotel['name']));
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Hotel verwijderen - <?= htmlspecialchars($hotel['hotel_naam']) ?></title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">
</head>
<body>

<header class="pp-header">
    <div class="logo">
        <a href="../index.php"><img src="/images/image1%20(1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admin-vragen.php">Inkomende vragen</a></li>
            <li><a href="admin-recensies.php">Inkomende reviews</a></li>
            <li><a href="admin-land.php">Landen</a></li>
            <li><a href="admin-hotel.php">Hotels</a></li>
            <li><a href="../uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Hotel verwijderen</h1>

    <p>Weet je zeker dat je het hotel "<strong><?= htmlspecialchars($hotel['hotel_naam']) ?></strong>" wilt verwijderen?</p>

    <form method="post">
        <button type="submit" style="background-color:#d9534f; color:white; padding:0.5rem 1rem; border:none; border-radius:4px; cursor:pointer;">
            Ja, verwijderen
        </button>
        <a href="admin-hotel.php?land=<?= urlencode($hotel['name']) ?>" style="margin-left:1rem; text-decoration:none; color:#004aad;">Nee, terug</a>
    </form>
</div>

</body>
</html>
