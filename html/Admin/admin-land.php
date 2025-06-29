<?php
session_start();

// Databaseverbinding
try {
    $conn = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8", "root", "rootpassword");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Fout bij verbinden: " . $e->getMessage());
}

// Nieuw land toevoegen
$melding = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["land"])) {
    $land = trim($_POST["land"]);
    $region = "Onbekend"; // standaard

    $stmt = $conn->prepare("INSERT INTO landen (naam, region) VALUES (?, ?)");
    $stmt->execute([$land, $region]);
    $melding = "✅ Land toegevoegd!";
}

// Alle landen ophalen
$landen = $conn->query("SELECT id, naam, region FROM landen ORDER BY naam")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Landen beheren – Polar & Paradise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">
</head>
<body>

<header class="pp-header">
    <div class="logo">
        <a href="../index.php"><img src="/images/image1 (1).png" alt="Polar & Paradise"></a>
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
    <h1>Landen beheren</h1>

    <?php if ($melding): ?>
        <div class="melding"><?= htmlspecialchars($melding) ?></div>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>Land</th>
            <th>Regio</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($landen): ?>
            <?php foreach ($landen as $land): ?>
                <tr>
                    <td><?= htmlspecialchars($land['naam']) ?></td>
                    <td><?= htmlspecialchars($land['region']) ?></td>
                    <td>
                        <a href="admin-land-edit.php?id=<?= $land['id'] ?>">Bewerken</a> |
                        <a href="admin-land-delete.php?id=<?= $land['id'] ?>" onclick="return confirm('Weet je zeker dat je <?= htmlspecialchars($land['naam']) ?> wilt verwijderen?');">Verwijderen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">Er zijn nog geen landen toegevoegd.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <h2>Nieuw land toevoegen</h2>
    <form method="POST" action="admin-land.php">
        <input type="text" name="land" placeholder="Typ een landnaam..." required>
        <button type="submit">Toevoegen</button>
    </form>
</div>

</body>
</html>

