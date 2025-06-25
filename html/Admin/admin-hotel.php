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

/* ------------------- geselecteerd land ophalen ------------------- */
$selectedLand = $_GET['land'] ?? '';

/* ------------------- landen ophalen voor dropdown ------------------- */
$landenStmt = $conn->query("SELECT naam FROM landen ORDER BY naam");
$landen = $landenStmt->fetchAll(PDO::FETCH_COLUMN);

/* ------------------- nieuw hotel toevoegen ------------------- */
$melding = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hotel_naam"], $_POST["land"])) {
    $hotelNaam = trim($_POST["hotel_naam"]);
    $land = trim($_POST["land"]);

    if ($hotelNaam !== '' && $land !== '') {
        // Insert in hotels, alleen kolommen die je echt in je tabel hebt
        $stmt = $conn->prepare("INSERT INTO hotels (hotel_naam, name, region, prijs, beschikbaar, stars, type, category, beschrijving) VALUES (:hotel_naam, :name, '', 0, NULL, 0, '', '', '')");
        $stmt->execute([
            ':hotel_naam' => $hotelNaam,
            ':name' => $land,
        ]);
        header("Location: admin-hotel.php?land=" . urlencode($land));
        exit;
    } else {
        $melding = "⚠️ Vul zowel land als hotelnaam in.";
    }
}

/* ------------------- hotels ophalen voor geselecteerd land ------------------- */
$hotels = [];
if ($selectedLand !== '') {
    $hotelStmt = $conn->prepare("SELECT id, hotel_naam FROM hotels WHERE name = :land ORDER BY hotel_naam");
    $hotelStmt->execute([':land' => $selectedLand]);
    $hotels = $hotelStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hotels beheren – Polar & Paradise</title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">
    <style>
        .container {
            padding: 2rem;
            max-width: 900px;
            margin: auto;
        }
        h1, h2 {
            margin-bottom: 1rem;
        }
        form, table {
            margin-top: 1rem;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.3rem;
        }
        input[type="text"], select, button {
            padding: 0.5rem;
            font-size: 1rem;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            margin-bottom: 1rem;
        }
        button {
            background-color: #004aad;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: auto;
            padding: 0.5rem 1.2rem;
        }
        button:hover {
            background-color: #003080;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.6rem;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .actions a {
            margin-right: 0.7rem;
            color: #004aad;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .melding {
            color: #900;
            font-weight: bold;
            margin-bottom: 1rem;
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
    <h1>Hotels beheren</h1>

    <form method="get">
        <label for="land-select">Selecteer een land</label>
        <select id="land-select" name="land" onchange="this.form.submit()">
            <option value="">-- Kies een land --</option>
            <?php foreach ($landen as $land): ?>
                <option value="<?= htmlspecialchars($land) ?>" <?= $land === $selectedLand ? 'selected' : '' ?>>
                    <?= htmlspecialchars($land) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($selectedLand): ?>
        <h2>Hotels in <?= htmlspecialchars($selectedLand) ?></h2>

        <?php if ($melding): ?>
            <div class="melding"><?= htmlspecialchars($melding) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="land" value="<?= htmlspecialchars($selectedLand) ?>">
            <label for="hotel-naam">Nieuwe hotelnaam</label>
            <input type="text" id="hotel-naam" name="hotel_naam" required placeholder="Typ hotelnaam…">
            <button type="submit">Toevoegen</button>
        </form>

        <table>
            <thead>
            <tr>
                <th>Hotelnaam</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($hotels)): ?>
                <tr><td colspan="2">Er zijn nog geen hotels in dit land.</td></tr>
            <?php else: ?>
                <?php foreach ($hotels as $hotel): ?>
                    <tr>
                        <td><?= htmlspecialchars($hotel['hotel_naam']) ?></td>
                        <td class="actions">
                            <a href="admin-hotel-edit.php?id=<?= $hotel['id'] ?>">Bewerken</a>
                            <a href="admin-hotel-delete.php?id=<?= $hotel['id'] ?>" onclick="return confirm('Weet je zeker dat je dit hotel wilt verwijderen?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
