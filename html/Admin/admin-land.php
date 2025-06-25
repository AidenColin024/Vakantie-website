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
    <style>
        .container {
            padding: 2rem;
        }
        h1 {
            margin-bottom: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: .6rem;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .actions button {
            margin-right: 0.5rem;
            padding: 0.3rem 0.6rem;
            cursor: pointer;
        }
        form {
            margin-top: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: bold;
        }
        input[type="text"] {
            padding: 0.4rem;
            width: 300px;
            max-width: 100%;
            box-sizing: border-box;
            margin-bottom: 0.8rem;
        }
        button[type="submit"] {
            background-color: #004aad;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 3px;
        }
        button[type="submit"]:hover {
            background-color: #003080;
        }
        .melding {
            margin-top: 1rem;
            font-weight: bold;
        }
    </style>
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
        <?php foreach ($landen as $land): ?>
            <tr>
                <td><?= htmlspecialchars($land['naam']) ?></td>
                <td><?= htmlspecialchars($land['region']) ?></td>
                <td class="actions">
                    <button onclick="alert('Bewerk <?= htmlspecialchars($land['naam']) ?>')">Bewerken</button>
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
        <label for="nieuw-land">Nieuw land toevoegen</label>
        <input type="text" id="nieuw-land" name="land" placeholder="Typ een landnaam..." required />
        <button type="submit">Toevoegen</button>
    </form>
</div>
<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
