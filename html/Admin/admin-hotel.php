<?php
ob_start();
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
    die("❌ Fout bij verbinden: " . $e->getMessage());
}

/* --- Geselecteerd land ophalen --- */
$selectedLand = $_GET['land'] ?? '';

/* --- Lijst landen voor dropdown --- */
$landenStmt = $conn->query("SELECT naam FROM landen ORDER BY naam");
$landen = $landenStmt->fetchAll(PDO::FETCH_COLUMN);

/* --- Melding voor formulier --- */
$melding = '';

/* --- Nieuwe hotel toevoegen --- */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotelNaam   = trim($_POST["hotel_naam"] ?? '');
    $land        = trim($_POST["land"] ?? '');
    $region      = trim($_POST["region"] ?? '');
    $prijs       = $_POST["prijs"] ?? 0;
    $beschikbaar = $_POST["beschikbaar"] ?? null;
    $stars       = $_POST["stars"] ?? 0;
    $type        = trim($_POST["type"] ?? '');
    $category    = trim($_POST["category"] ?? '');
    $beschrijving= trim($_POST["beschrijving"] ?? '');

    if ($hotelNaam === '' || $land === '') {
        $melding = "⚠️ Vul minimaal hotelnaam en land in.";
    } else {
        // Afbeelding uploaden
        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../images/hotels/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $filename = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'images/hotels/' . $filename;
            }
        }

        $sql = "INSERT INTO hotels 
            (hotel_naam, name, region, prijs, beschikbaar, stars, type, category, beschrijving, image)
            VALUES (:hotel_naam, :name, :region, :prijs, :beschikbaar, :stars, :type, :category, :beschrijving, :image)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':hotel_naam'  => $hotelNaam,
            ':name'        => $land,
            ':region'      => $region,
            ':prijs'       => $prijs,
            ':beschikbaar' => $beschikbaar ?: null,
            ':stars'       => $stars,
            ':type'        => $type,
            ':category'    => $category,
            ':beschrijving'=> $beschrijving,
            ':image'       => $imagePath
        ]);

        header("Location: admin-hotel.php?land=" . urlencode($land));
        exit;
    }
}

/* --- Hotels ophalen van geselecteerd land --- */
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
            <li><a href="admin-hotel.php" class="active">Hotels</a></li>
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

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="land" value="<?= htmlspecialchars($selectedLand) ?>">

            <label for="hotel-naam">Hotelnaam</label>
            <input type="text" id="hotel-naam" name="hotel_naam" required placeholder="Typ hotelnaam…">

            <label for="region">Regio</label>
            <input type="text" id="region" name="region" placeholder="Typ regio…">

            <label for="prijs">Prijs (€)</label>
            <input type="number" step="0.01" id="prijs" name="prijs" placeholder="Prijs per nacht">

            <label for="beschikbaar">Beschikbaar vanaf</label>
            <input type="date" id="beschikbaar" name="beschikbaar">

            <label for="stars">Sterren</label>
            <input type="number" min="1" max="5" id="stars" name="stars" placeholder="Aantal sterren">

            <label for="type">Type</label>
            <input type="text" id="type" name="type" placeholder="Bijv. Wintersport, Familie…">

            <label for="category">Categorie</label>
            <select id="category" name="category">
                <option value="ski">Ski</option>
                <option value="zomer">Zomer</option>
            </select>

            <label for="beschrijving">Beschrijving</label>
            <textarea id="beschrijving" name="beschrijving" placeholder="Beschrijving…"></textarea>

            <label for="image">Afbeelding</label>
            <input type="file" id="image" name="image" accept="image/*">

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
