<?php
session_start();

/* --- Database verbinden --- */
try {
    $conn = new PDO(
        "mysql:host=db;dbname=mydatabase;charset=utf8mb4",
        "root",
        "rootpassword"
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fout bij verbinden met de database.";
    exit;
}

/* --- Geselecteerd land (via GET) --- */
$selectedLand = isset($_GET['land']) ? $_GET['land'] : '';

/* --- Alle landen ophalen --- */
$landen = [];
$landenStmt = $conn->query("SELECT naam FROM landen ORDER BY naam");
if ($landenStmt) {
    $landen = $landenStmt->fetchAll(PDO::FETCH_COLUMN);
}

/* --- Melding voor het formulier --- */
$melding = '';

/* --- Nieuw hotel toevoegen --- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotelNaam = isset($_POST['hotel_naam']) ? $_POST['hotel_naam'] : '';
    $land      = isset($_POST['land'])       ? $_POST['land']       : '';
    $region    = isset($_POST['region'])     ? $_POST['region']     : '';
    $prijs     = isset($_POST['prijs'])      ? $_POST['prijs']      : 0;
    $beschikbaar = isset($_POST['beschikbaar']) ? $_POST['beschikbaar'] : null;
    $stars     = isset($_POST['stars'])      ? $_POST['stars']      : 0;
    $type      = isset($_POST['type'])       ? $_POST['type']       : '';
    $category  = isset($_POST['category'])   ? $_POST['category']   : '';
    $beschrijving = isset($_POST['beschrijving']) ? $_POST['beschrijving'] : '';

    /* Minimale validatie */
    if ($hotelNaam === '' || $land === '') {
        $melding = '⚠️ Vul minimaal hotelnaam en land in.';
    } else {
        /* Afbeelding uploaden (optioneel) */
        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../images/hotels/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $bestandsnaam = time() . '_' . basename($_FILES['image']['name']);
            $bestemmingsPad = $uploadDir . $bestandsnaam;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $bestemmingsPad)) {
                $imagePath = 'images/hotels/' . $bestandsnaam;
            }
        }

        /* Hotel opslaan */
        $sql = "INSERT INTO hotels
                (hotel_naam, name, region, prijs, beschikbaar, stars, type, category, beschrijving, image)
                VALUES
                (:hotel_naam, :name, :region, :prijs, :beschikbaar, :stars, :type, :category, :beschrijving, :image)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':hotel_naam'   => $hotelNaam,
            ':name'         => $land,
            ':region'       => $region,
            ':prijs'        => $prijs,
            ':beschikbaar'  => $beschikbaar,
            ':stars'        => $stars,
            ':type'         => $type,
            ':category'     => $category,
            ':beschrijving' => $beschrijving,
            ':image'        => $imagePath
        ]);

        header('Location: admin-hotel.php?land=' . urlencode($land));
        exit;
    }
}

/* --- Hotels van het gekozen land ophalen --- */
$hotels = [];
if ($selectedLand !== '') {
    $stmt = $conn->prepare(
        "SELECT id, hotel_naam FROM hotels
         WHERE name = :land
         ORDER BY hotel_naam"
    );
    $stmt->execute([':land' => $selectedLand]);
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels beheren – Polar & Paradise</title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time(); ?>">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise</title>
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
            <li><a class="active" href="admin-hotel.php">Hotels</a></li>
            <li><a href="../uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Hotels beheren</h1>

    <!-- Land kiezen -->
    <form method="get">
        <label for="land-select">Selecteer een land</label>
        <select id="land-select" name="land" onchange="this.form.submit()">
            <option value="">-- Kies een land --</option>
            <?php foreach ($landen as $land): ?>
                <option
                        value="<?= htmlspecialchars($land); ?>"
                    <?= $land === $selectedLand ? 'selected' : ''; ?>
                >
                    <?= htmlspecialchars($land); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($selectedLand): ?>
        <h2>Hotels in <?= htmlspecialchars($selectedLand); ?></h2>

        <?php if ($melding): ?>
            <div class="melding"><?= htmlspecialchars($melding); ?></div>
        <?php endif; ?>

        <!-- Hotel toevoegen -->
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="land" value="<?= htmlspecialchars($selectedLand); ?>">

            <label>Hotelnaam</label>
            <input type="text" name="hotel_naam" required>

            <label>Regio</label>
            <input type="text" name="region">

            <label>Prijs (€)</label>
            <input type="number" name="prijs" step="0.01">

            <label>Beschikbaar vanaf</label>
            <input type="date" name="beschikbaar">

            <label>Sterrenscore</label>
            <input type="number" name="stars" min="1" max="5">

            <label>Type</label>
            <input type="text" name="type">

            <label>Categorie</label>
            <select name="category">
                <option value="ski">Ski</option>
                <option value="zomer">Zomer</option>
            </select>

            <label>Beschrijving</label>
            <textarea name="beschrijving"></textarea>

            <label>Afbeelding</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Toevoegen</button>
        </form>

        <!-- Overzicht hotels -->
        <table>
            <thead>
            <tr><th>Hotelnaam</th><th>Acties</th></tr>
            </thead>
            <tbody>
            <?php if (empty($hotels)): ?>
                <tr><td colspan="2">Er zijn nog geen hotels in dit land.</td></tr>
            <?php else: ?>
                <?php foreach ($hotels as $hotel): ?>
                    <tr>
                        <td><?= htmlspecialchars($hotel['hotel_naam']); ?></td>
                        <td>
                            <a href="admin-hotel-edit.php?id=<?= $hotel['id']; ?>">Bewerken</a>
                            |
                            <a
                                    href="admin-hotel-delete.php?id=<?= $hotel['id']; ?>"
                                    onclick="return confirm('Weet je zeker dat je dit hotel wilt verwijderen?');"
                            >
                                Verwijderen
                            </a>
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
