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
    die("❌ Fout bij verbinden: " . $e->getMessage());
}

/* --- Hotel ID ophalen en checken --- */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Ongeldige hotel ID.");
}
$id = (int)$_GET['id'];

/* --- Hotelgegevens ophalen --- */
$stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$hotel) {
    die("Hotel niet gevonden.");
}

$melding = '';

/* --- Verwerk formulier update --- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotelNaam   = trim($_POST["hotel_naam"] ?? '');
    $land        = trim($_POST["land"] ?? '');
    $region      = trim($_POST["region"] ?? '');
    $prijs       = $_POST["prijs"] ?? 0;
    $beschikbaar = $_POST["beschikbaar"] ?: null;
    $stars       = $_POST["stars"] ?? 0;
    $type        = trim($_POST["type"] ?? '');
    $category    = trim($_POST["category"] ?? '');
    $beschrijving= trim($_POST["beschrijving"] ?? '');

    if ($hotelNaam === '' || $land === '') {
        $melding = "⚠️ Vul minimaal hotelnaam en land in.";
    } else {
        // Afbeelding uploaden (optioneel)
        $imagePath = $hotel['image']; // huidige afbeelding behouden als niks nieuws

        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../images/hotels/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $filename = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'images/hotels/' . $filename;
                // Optioneel: oude afbeelding verwijderen, kan je toevoegen
            }
        }

        // Update query
        $sql = "UPDATE hotels SET 
                hotel_naam = :hotel_naam,
                name = :name,
                region = :region,
                prijs = :prijs,
                beschikbaar = :beschikbaar,
                stars = :stars,
                type = :type,
                category = :category,
                beschrijving = :beschrijving,
                image = :image
            WHERE id = :id";

        $stmtUpdate = $conn->prepare($sql);
        $stmtUpdate->execute([
            ':hotel_naam'  => $hotelNaam,
            ':name'        => $land,
            ':region'      => $region,
            ':prijs'       => $prijs,
            ':beschikbaar' => $beschikbaar,
            ':stars'       => $stars,
            ':type'        => $type,
            ':category'    => $category,
            ':beschrijving'=> $beschrijving,
            ':image'       => $imagePath,
            ':id'          => $id
        ]);

        $melding = "✅ Hotel succesvol bijgewerkt.";

        // Opnieuw ophalen na update
        $stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
        $stmt->execute([$id]);
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hotel bewerken – <?= htmlspecialchars($hotel['hotel_naam']) ?></title>
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
    <h1>Hotel bewerken: <?= htmlspecialchars($hotel['hotel_naam']) ?></h1>

    <?php if ($melding): ?>
        <p class="melding"><?= htmlspecialchars($melding) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label for="hotel-naam">Hotelnaam</label>
        <input type="text" id="hotel-naam" name="hotel_naam" required value="<?= htmlspecialchars($hotel['hotel_naam']) ?>">

        <label for="land">Land</label>
        <input type="text" id="land" name="land" required value="<?= htmlspecialchars($hotel['name']) ?>">

        <label for="region">Regio</label>
        <input type="text" id="region" name="region" value="<?= htmlspecialchars($hotel['region']) ?>">

        <label for="prijs">Prijs (€)</label>
        <input type="number" step="0.01" id="prijs" name="prijs" value="<?= htmlspecialchars($hotel['prijs']) ?>">

        <label for="beschikbaar">Beschikbaar vanaf</label>
        <input type="date" id="beschikbaar" name="beschikbaar" value="<?= htmlspecialchars($hotel['beschikbaar']) ?>">

        <label for="stars">Sterren</label>
        <input type="number" min="1" max="5" id="stars" name="stars" value="<?= htmlspecialchars($hotel['stars']) ?>">

        <label for="type">Type</label>
        <input type="text" id="type" name="type" value="<?= htmlspecialchars($hotel['type']) ?>">

        <label for="category">Categorie</label>
        <select id="category" name="category">
            <option value="ski" <?= $hotel['category'] === 'ski' ? 'selected' : '' ?>>Ski</option>
            <option value="zomer" <?= $hotel['category'] === 'zomer' ? 'selected' : '' ?>>Zomer</option>
        </select>

        <label for="beschrijving">Beschrijving</label>
        <textarea id="beschrijving" name="beschrijving"><?= htmlspecialchars($hotel['beschrijving']) ?></textarea>

        <label for="image">Afbeelding</label>
        <?php if ($hotel['image']): ?>
            <div>
                <img src="../<?= htmlspecialchars($hotel['image']) ?>" alt="Huidige afbeelding" style="max-width:200px; margin-bottom:0.5rem;">
            </div>
        <?php endif; ?>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit">Opslaan</button>
    </form>

    <p><a href="admin-hotel.php?land=<?= urlencode($hotel['name']) ?>">Terug naar hotels lijst</a></p>
</div>

</body>
</html>
