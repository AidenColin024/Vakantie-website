<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden: " . $e->getMessage());
}

// ID ophalen
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Ongeldige land ID.");
}
$id = (int)$_GET['id'];

// Landgegevens ophalen
$stmt = $conn->prepare("SELECT * FROM landen WHERE id = ?");
$stmt->execute([$id]);
$land = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$land) {
    die("Land niet gevonden.");
}

$melding = "";

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $region = trim($_POST['region'] ?? '');

    if ($naam === '') {
        $melding = "⚠️ Vul een landnaam in.";
    } else {
        $stmtUpdate = $conn->prepare("UPDATE landen SET naam = :naam, region = :region WHERE id = :id");
        $stmtUpdate->execute([
            ':naam' => $naam,
            ':region' => $region,
            ':id' => $id,
        ]);
        $melding = "✅ Land is bijgewerkt.";
        // Optioneel: redirect terug naar overzicht na update
        // header("Location: admin-land.php");
        // exit;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Land bewerken – <?= htmlspecialchars($land['naam']) ?></title>
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
    <h1>Land bewerken</h1>

    <?php if ($melding): ?>
        <div class="melding"><?= htmlspecialchars($melding) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="naam">Landnaam</label>
        <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($land['naam']) ?>" required>

        <label for="region">Regio</label>
        <input type="text" id="region" name="region" value="<?= htmlspecialchars($land['region']) ?>">

        <button type="submit">Opslaan</button>
    </form>

    <p><a href="admin-land.php">Terug naar landen overzicht</a></p>
</div>

</body>
</html>
