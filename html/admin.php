<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}

// LAND VERWIJDEREN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['actie'] ?? '') === 'verwijder_land') {
    $land = trim($_POST['land'] ?? '');
    if ($land !== '') {
        $conn->prepare("DELETE FROM hotels WHERE name = :land")->execute([':land' => $land]);
    }
    header("Location: admin.php");
    exit;
}

// HOTEL VERWIJDEREN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['actie'] ?? '') === 'verwijder_hotel') {
    $hotel_id = intval($_POST['hotel_id'] ?? 0);
    if ($hotel_id > 0) {
        $conn->prepare("DELETE FROM hotels WHERE id = :id")->execute([':id' => $hotel_id]);
    }
    header("Location: admin.php");
    exit;
}

// LAND TOEVOEGEN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['actie'] ?? '') === 'voeg_land_toe') {
    $land = trim($_POST['nieuw_land'] ?? '');
    $region = trim($_POST['region'] ?? '');
    $stars = trim($_POST['stars'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $link = trim($_POST['link'] ?? '');
    if ($land !== '') {
        $stmt = $conn->prepare("INSERT INTO hotels (name, region, stars, type, category, image, link) VALUES (:name, :region, :stars, :type, :category, :image, :link)");
        $stmt->execute([
            ':name' => $land,
            ':region' => $region,
            ':stars' => $stars,
            ':type' => $type,
            ':category' => $category,
            ':image' => $image,
            ':link' => $link
        ]);
    }
    header("Location: admin.php");
    exit;
}

// HOTEL TOEVOEGEN AAN LAND (incl. prijs en beschikbaar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['actie'] ?? '') === 'hotel_toevoegen_per_land') {
    $land = trim($_POST['land'] ?? '');
    $hotel_naam = trim($_POST['hotel_naam'] ?? '');
    $region = trim($_POST['region'] ?? '');
    $stars = trim($_POST['stars'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $link = trim($_POST['link'] ?? '');
    $prijs = trim($_POST['prijs'] ?? '');
    $beschikbaar = trim($_POST['beschikbaar'] ?? '');
    if ($land !== '' && $hotel_naam !== '') {
        $stmt = $conn->prepare("INSERT INTO hotels (name, hotel_naam, region, stars, type, category, image, link, prijs, beschikbaar) VALUES (:name, :hotel_naam, :region, :stars, :type, :category, :image, :link, :prijs, :beschikbaar)");
        $stmt->execute([
            ':name' => $land,
            ':hotel_naam' => $hotel_naam,
            ':region' => $region,
            ':stars' => $stars,
            ':type' => $type,
            ':category' => $category,
            ':image' => $image,
            ':link' => $link,
            ':prijs' => $prijs,
            ':beschikbaar' => $beschikbaar
        ]);
    }
    header("Location: admin.php");
    exit;
}

// LAND WIJZIGEN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['actie'] ?? '') === 'wijzig_land') {
    $land_id = intval($_POST['land_id'] ?? 0);
    $naam = trim($_POST['naam'] ?? '');
    $region = trim($_POST['region'] ?? '');
    $stars = trim($_POST['stars'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $link = trim($_POST['link'] ?? '');
    if ($land_id > 0 && $naam !== '') {
        $stmt = $conn->prepare("UPDATE hotels SET name = :naam, region = :region, stars = :stars, type = :type, category = :category, image = :image, link = :link WHERE id = :id");
        $stmt->execute([
            ':naam' => $naam,
            ':region' => $region,
            ':stars' => $stars,
            ':type' => $type,
            ':category' => $category,
            ':image' => $image,
            ':link' => $link,
            ':id' => $land_id
        ]);
    }
    header("Location: admin.php");
    exit;
}

// HOTEL WIJZIGEN (nu met prijs en beschikbaar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['actie'] ?? '') === 'wijzig_hotel') {
    $hotel_id = intval($_POST['hotel_id'] ?? 0);
    $hotel_naam = trim($_POST['hotel_naam'] ?? '');
    $region = trim($_POST['region'] ?? '');
    $stars = trim($_POST['stars'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $link = trim($_POST['link'] ?? '');
    $prijs = trim($_POST['prijs'] ?? '');
    $beschikbaar = trim($_POST['beschikbaar'] ?? '');
    if ($hotel_id > 0 && $hotel_naam !== '') {
        $stmt = $conn->prepare("UPDATE hotels SET hotel_naam = :hotel_naam, region = :region, stars = :stars, type = :type, category = :category, image = :image, link = :link, prijs = :prijs, beschikbaar = :beschikbaar WHERE id = :id");
        $stmt->execute([
            ':hotel_naam' => $hotel_naam,
            ':region' => $region,
            ':stars' => $stars,
            ':type' => $type,
            ':category' => $category,
            ':image' => $image,
            ':link' => $link,
            ':prijs' => $prijs,
            ':beschikbaar' => $beschikbaar,
            ':id' => $hotel_id
        ]);
    }
    header("Location: admin.php");
    exit;
}

// OPHALEN
$landen = $conn->query("SELECT * FROM hotels WHERE hotel_naam IS NULL OR hotel_naam = '' ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$hotels = $conn->query("SELECT * FROM hotels WHERE hotel_naam IS NOT NULL AND hotel_naam != '' ORDER BY name, hotel_naam ASC")->fetchAll(PDO::FETCH_ASSOC);
$hotels_per_land = [];
foreach ($hotels as $hotel) {
    $hotels_per_land[$hotel['name']][] = $hotel;
}

// BOEKINGEN OPHALEN UIT 'boeking' TABEL
$boekingen = [];
try {
    $boekingen = $conn->query("SELECT * FROM boeking ORDER BY datum DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // als de tabel niet bestaat of iets anders fout gaat, negeer het voor nu
}

// VRAGEN OPHALEN UIT 'Vragen' TABEL (let op hoofdlettergevoeligheid)
$vragen = [];
try {
    $vragen = $conn->query("SELECT * FROM Vragen ORDER BY Naam ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // als de tabel niet bestaat of iets anders fout gaat, negeer het voor nu
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
    <link rel="stylesheet" href="admin.css?v=<?= time() ?>">
</head>
<body>
<main>
    <h1>Admin: Landen en hun hotels beheren</h1>
    <form class="add-land-form" method="POST">
        <input type="hidden" name="actie" value="voeg_land_toe">
        <input type="text" name="nieuw_land" required placeholder="Landnaam (bijv. Spanje)">
        <input type="text" name="region" placeholder="Regio">
        <input type="number" name="stars" min="1" max="5" placeholder="Sterren">
        <input type="text" name="type" placeholder="Type (bijv. Wintersport)">
        <input type="text" name="category" placeholder="Categorie (bijv. ski)">
        <input type="text" name="image" placeholder="Afbeelding (url of pad)">
        <input type="text" name="link" placeholder="Link">
        <button type="submit">Nieuw land toevoegen</button>
    </form>

    <div class="card-row">
        <?php foreach($landen as $land): ?>
            <div class="land-card">
                <img src="<?= htmlspecialchars($land['image']) ?>" alt="<?= htmlspecialchars($land['name']) ?>">
                <h2><?= htmlspecialchars($land['name']) ?></h2>
                <div>Regio: <?= htmlspecialchars($land['region']) ?></div>
                <div>Sterren: <?= htmlspecialchars($land['stars']) ?></div>
                <div>Type: <?= htmlspecialchars($land['type']) ?></div>
                <a href="<?= htmlspecialchars($land['link']) ?>">Meer info</a>

                <!-- Land wijzigen -->
                <form class="edit-land-form" method="POST" style="margin-top: 1rem;">
                    <input type="hidden" name="actie" value="wijzig_land">
                    <input type="hidden" name="land_id" value="<?= $land['id'] ?>">
                    <input type="text" name="naam" value="<?= htmlspecialchars($land['name']) ?>" required>
                    <input type="text" name="region" value="<?= htmlspecialchars($land['region']) ?>">
                    <input type="number" name="stars" min="1" max="5" value="<?= htmlspecialchars($land['stars']) ?>">
                    <input type="text" name="type" value="<?= htmlspecialchars($land['type']) ?>">
                    <input type="text" name="category" value="<?= htmlspecialchars($land['category']) ?>">
                    <input type="text" name="image" value="<?= htmlspecialchars($land['image']) ?>">
                    <input type="text" name="link" value="<?= htmlspecialchars($land['link']) ?>">
                    <button type="submit">Wijzig land</button>
                </form>

                <div class="hotel-list-in-land">
                    <strong>Hotels in dit land:</strong>
                    <?php if (!empty($hotels_per_land[$land['name']])): ?>
                        <?php foreach ($hotels_per_land[$land['name']] as $hotel): ?>
                            <div class="hotel-in-land">
                                <div class="hotel-in-land-title">
                                    <?= htmlspecialchars($hotel['hotel_naam']) ?> (<?= htmlspecialchars($hotel['stars']) ?>★)
                                </div>
                                <div>Regio: <?= htmlspecialchars($hotel['region']) ?></div>
                                <div>Type: <?= htmlspecialchars($hotel['type']) ?></div>
                                <div>Prijs: €<?= isset($hotel['prijs']) ? number_format($hotel['prijs'], 2, ',', '.') : 'n.v.t.'; ?></div>
                                <div>Beschikbaar vanaf: <?= isset($hotel['beschikbaar']) ? date('d-m-Y', strtotime($hotel['beschikbaar'])) : 'n.v.t.'; ?></div>
                                <a href="<?= htmlspecialchars($hotel['link']) ?>">Meer info</a>

                                <!-- Hotel wijzigen -->
                                <form class="hotel-edit-form" method="POST" style="margin-top:0.7rem; margin-bottom:0.3rem;">
                                    <input type="hidden" name="actie" value="wijzig_hotel">
                                    <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
                                    <input type="text" name="hotel_naam" value="<?= htmlspecialchars($hotel['hotel_naam']) ?>" required>
                                    <input type="text" name="region" value="<?= htmlspecialchars($hotel['region']) ?>">
                                    <input type="number" name="stars" min="1" max="5" value="<?= htmlspecialchars($hotel['stars']) ?>">
                                    <input type="text" name="type" value="<?= htmlspecialchars($hotel['type']) ?>">
                                    <input type="text" name="category" value="<?= htmlspecialchars($hotel['category']) ?>">
                                    <input type="text" name="image" value="<?= htmlspecialchars($hotel['image']) ?>">
                                    <input type="text" name="link" value="<?= htmlspecialchars($hotel['link']) ?>">
                                    <input type="text" name="prijs" value="<?= htmlspecialchars($hotel['prijs']) ?>">
                                    <input type="date" name="beschikbaar" value="<?= htmlspecialchars($hotel['beschikbaar']) ?>">
                                    <button type="submit">Wijzig hotel</button>
                                </form>

                                <!-- Hotel verwijderen -->
                                <form method="POST" onsubmit="return confirm('Weet je zeker dat je dit hotel wilt verwijderen?');">
                                    <input type="hidden" name="actie" value="verwijder_hotel">
                                    <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
                                    <button type="submit">Verwijder hotel</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <em>Geen hotels gevonden voor dit land.</em>
                    <?php endif; ?>
                </div>

                <!-- Hotel toevoegen aan dit land -->
                <form class="add-hotel-form" method="POST" style="margin-top: 1rem;">
                    <input type="hidden" name="actie" value="hotel_toevoegen_per_land">
                    <input type="hidden" name="land" value="<?= htmlspecialchars($land['name']) ?>">
                    <input type="text" name="hotel_naam" placeholder="Hotelnaam" required>
                    <input type="text" name="region" placeholder="Regio">
                    <input type="number" name="stars" min="1" max="5" placeholder="Sterren">
                    <input type="text" name="type" placeholder="Type">
                    <input type="text" name="category" placeholder="Categorie">
                    <input type="text" name="image" placeholder="Afbeelding (url of pad)">
                    <input type="text" name="link" placeholder="Link">
                    <input type="text" name="prijs" placeholder="Prijs">
                    <input type="date" name="beschikbaar" placeholder="Beschikbaar vanaf">
                    <button type="submit">Hotel toevoegen</button>
                </form>

                <!-- Land verwijderen -->
                <form method="POST" onsubmit="return confirm('Weet je zeker dat je dit land wilt verwijderen?');" style="margin-top: 1rem;">
                    <input type="hidden" name="actie" value="verwijder_land">
                    <input type="hidden" name="land" value="<?= htmlspecialchars($land['name']) ?>">
                    <button type="submit">Verwijder land</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>Vragen van bezoekers</h2>
    <?php if (!empty($vragen)): ?>
        <table>
            <thead>
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Telefoon</th>
                <th>Vraag</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vragen as $vraag): ?>
                <tr>
                    <td><?= htmlspecialchars($vraag['Naam']) ?></td>
                    <td><?= htmlspecialchars($vraag['Email']) ?></td>
                    <td><?= htmlspecialchars($vraag['Telefoon']) ?></td>
                    <td><?= nl2br(htmlspecialchars($vraag['Vraag'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen vragen gevonden.</p>
    <?php endif; ?>

    <h2>Boekingen</h2>
    <?php if (!empty($boekingen)): ?>
        <table>
            <thead>
            <tr>
                <th>Boekingsnummer</th>
                <th>Land</th>
                <th>Hotel</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Telefoon</th>
                <th>Datum</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($boekingen as $boeking): ?>
                <tr>
                    <td><?= htmlspecialchars($boeking['boekingnummer'] ?? '') ?></td>
                    <td><?= htmlspecialchars($boeking['land'] ?? '') ?></td>
                    <td><?= htmlspecialchars($boeking['hotel'] ?? '') ?></td>
                    <td><?= htmlspecialchars($boeking['naam'] ?? '') ?></td>
                    <td><?= htmlspecialchars($boeking['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($boeking['telefoon'] ?? '') ?></td>
                    <td><?= isset($boeking['datum']) ? date('d-m-Y', strtotime($boeking['datum'])) : '' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen boekingen gevonden.</p>
    <?php endif; ?>

</main>
</body>
</html>
