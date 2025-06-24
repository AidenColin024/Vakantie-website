<?php
$servername = "db"; // of 'localhost'
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT naam, beoordeling, commentaar, datum FROM review ORDER BY datum DESC");
    $recensies = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
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
            <li><a href="Admin/admin-hotel.php">Hotels</a></li>
            <li><a href="../uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>
<section class="admin-hero">
    <div class="admin-container">
        <h1 class="admin-title">Recensies van Gebruikers</h1>

        <div class="admin-section">
            <?php if (!empty($recensies)): ?>
                <?php foreach ($recensies as $recensie): ?>
                    <div class="admin-card">
                        <p><strong>Naam:</strong> <?= htmlspecialchars($recensie['naam']) ?></p>
                        <p><strong>Beoordeling:</strong> <span class="rating"><?= htmlspecialchars($recensie['beoordeling']) ?>/5</span></p>
                        <p><strong>Commentaar:</strong> <?= nl2br(htmlspecialchars($recensie['commentaar'])) ?></p>
                        <p class="date"><em>Datum:</em> <?= htmlspecialchars($recensie['datum']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Er zijn nog geen recensies ontvangen.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

</body>
</html>