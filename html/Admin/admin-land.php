
<?php
ob_start();
session_start();

/* ------------------- database verbinding ------------------- */
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Fout bij verbinden: " . $e->getMessage());
}

/* ------------------- nieuw land toevoegen ------------------- */
$melding = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["land"])) {
    $land = trim($_POST["land"]);
    if ($land !== '') {
        // Standaard region (verander indien gewenst)
        $region = "Onbekend";
        $stmt = $conn->prepare("INSERT INTO landen (naam, region) VALUES (:naam, :region)");
        $stmt->execute([
            ':naam' => $land,
            ':region' => $region
        ]);
        $melding = "✅ Land toegevoegd!";
    } else {
        $melding = "⚠️ Vul een landnaam in.";
    }
}

/* ------------------- landen ophalen ------------------- */
$landenStmt = $conn->query("SELECT id, naam, region FROM landen ORDER BY naam");
$landen = $landenStmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Landen beheren – Polar & Paradise</title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">
</head>
<body>

<header class="pp-header">
    <div class="logo">
        <a href="../index.php"><img src="/images/image1%20(1).png" alt="Polar & Paradise"></a>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise</title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">


</head>
<body>

<!-- HEADER -->
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


<section class="landen-container">
    <h1>Landen beheren</h1>

    <!-- Tabel met bestaande landen -->

    <table>
        <thead>
        <tr>
            <th>Land</th>

            <th>Regio</th>

            <th>Acties</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($landen as $land): ?>
            <tr>
                <td><?= htmlspecialchars($land['naam']) ?></td>
                <td><?= htmlspecialchars($land['region']) ?></td>
                <td class="actions">
                    <button onclick="if(confirm('Weet je zeker dat je <?= htmlspecialchars($land['naam']) ?> wilt bewerken?')) { window.location.href='admin-land-edit.php?id=<?= $land['id'] ?>'; }">Bewerken</button>
                    <button onclick="if(confirm('Weet je zeker dat je <?= htmlspecialchars($land['naam']) ?> wil verwijderen?')) { window.location.href='admin-land-delete.php?id=<?= $land['id'] ?>'; }">Verwijderen</button>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$landen): ?>
            <tr><td colspan="3">Er zijn nog geen landen toegevoegd.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <form method="POST" action="">

        <!-- Voorbeeldrijen; vervang met PHP code die uit database laadt -->
        <tr>
            <td>Nederland</td>
            <td class="actions">
                <button type="button" onclick="alert('Bewerk Nederland')">Bewerken</button>
                <button type="button" class="delete" onclick="confirm('Weet je zeker dat je Nederland wil verwijderen?')">Verwijderen</button>
            </td>
        </tr>
        <tr>
            <td>Duitsland</td>
            <td class="actions">
                <button type="button" onclick="alert('Bewerk Duitsland')">Bewerken</button>
                <button type="button" class="delete" onclick="confirm('Weet je zeker dat je Duitsland wil verwijderen?')">Verwijderen</button>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Formulier om nieuw land toe te voegen -->
    <form method="POST" action="admin.landen.php">

        <label for="nieuw-land">Nieuw land toevoegen</label>
        <input type="text" id="nieuw-land" name="land" placeholder="Typ een landnaam..." required />
        <button type="submit">Toevoegen</button>
    </form>

</div>

</body>
</html>

</section>

</body>
</html>

