<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "Reis";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actie = $_POST['actie'] ?? '';

    if ($actie === 'create') {
        $stmt = $conn->prepare("INSERT INTO Reizen (hotel_id, prijs, startdatum, einddatum, beschikbaarheid) VALUES (:hotel_id, :prijs, :startdatum, :einddatum, :beschikbaarheid)");
        $stmt->execute([
            ':hotel_id' => $_POST['hotel_id'],
            ':prijs' => $_POST['prijs'],
            ':startdatum' => $_POST['startdatum'],
            ':einddatum' => $_POST['einddatum'],
            ':beschikbaarheid' => $_POST['beschikbaarheid']
        ]);
    } elseif ($actie === 'update') {
        $stmt = $conn->prepare("UPDATE Reizen SET hotel_id = :hotel_id, prijs = :prijs, startdatum = :startdatum, einddatum = :einddatum, beschikbaarheid = :beschikbaarheid WHERE id = :id");
        $stmt->execute([
            ':id' => $_POST['id'],
            ':hotel_id' => $_POST['hotel_id'],
            ':prijs' => $_POST['prijs'],
            ':startdatum' => $_POST['startdatum'],
            ':einddatum' => $_POST['einddatum'],
            ':beschikbaarheid' => $_POST['beschikbaarheid']
        ]);
    } elseif ($actie === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Reizen WHERE id = :id");
        $stmt->execute([':id' => $_POST['id']]);
    }

    header("Location: admin.php");
    exit;
}

$reizen = $conn->query("SELECT Reizen.*, Hotels.naam AS hotelnaam FROM Reizen JOIN Hotels ON Reizen.hotel_id = Hotels.id ORDER BY startdatum ASC")->fetchAll(PDO::FETCH_ASSOC);
$hotels = $conn->query("SELECT id, naam FROM Hotels ORDER BY naam ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>

<main class="admin-container">
    <h1>Admin Dashboard</h1>

    <section>
        <h2>Reizen beheren</h2>

        <form method="POST">
            <input type="hidden" name="actie" value="create">
            <label>Hotel:
                <select name="hotel_id" required>
                    <?php foreach ($hotels as $hotel): ?>
                        <option value="<?= $hotel['id'] ?>"><?= htmlspecialchars($hotel['naam']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Prijs: <input type="number" step="0.01" name="prijs" required></label>
            <label>Startdatum: <input type="date" name="startdatum" required></label>
            <label>Einddatum: <input type="date" name="einddatum" required></label>
            <label>Beschikbaarheid: <input type="number" name="beschikbaarheid" required></label>
            <button type="submit">Toevoegen</button>
        </form>

        <table class="admin-table">
            <thead>
            <tr>
                <th>Hotel</th>
                <th>Prijs</th>
                <th>Startdatum</th>
                <th>Einddatum</th>
                <th>Beschikbaarheid</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reizen as $reis): ?>
                <tr>
                    <form method="POST">
                        <input type="hidden" name="actie" value="update">
                        <input type="hidden" name="id" value="<?= $reis['id'] ?>">
                        <td>
                            <select name="hotel_id">
                                <?php foreach ($hotels as $hotel): ?>
                                    <option value="<?= $hotel['id'] ?>" <?= $hotel['id'] == $reis['hotel_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($hotel['naam']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" step="0.01" name="prijs" value="<?= $reis['prijs'] ?>" required></td>
                        <td><input type="date" name="startdatum" value="<?= $reis['startdatum'] ?>" required></td>
                        <td><input type="date" name="einddatum" value="<?= $reis['einddatum'] ?>" required></td>
                        <td><input type="number" name="beschikbaarheid" value="<?= $reis['beschikbaarheid'] ?>" required></td>
                        <td>
                            <button type="submit">Opslaan</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="actie" value="delete">
                        <input type="hidden" name="id" value="<?= $reis['id'] ?>">
                        <button type="submit" onclick="return confirm('Weet je zeker dat je deze reis wilt verwijderen?')">Verwijderen</button>
                    </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <details class="admin-panel">
        <summary>📬 Inkomende vragen</summary>
        <div class="panel-content">
            <ul class="admin-list">
                <?php
                try {
                    $stmt = $conn->query("SELECT naam, email, bericht FROM Vragen");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li><strong>Naam:</strong> " . htmlspecialchars($row['naam']) . "<br>";
                        echo "<strong>Email:</strong> " . htmlspecialchars($row['email']) . "<br>";
                        echo "<strong>Bericht:</strong> " . nl2br(htmlspecialchars($row['bericht'])) . "<br><button>Beantwoord</button></li>";
                    }
                } catch (PDOException $e) {
                    echo "<li>Fout: " . $e->getMessage() . "</li>";
                }
                ?>
            </ul>
        </div>
    </details>

    <details class="admin-panel">
        <summary>📝 Recensies beheren</summary>
        <div class="panel-content">
            <ul class="admin-list">
                <li>
                    <strong>Naam:</strong> Lisa Janssen<br>
                    <strong>Datum:</strong> 5 juni 2025<br>
                    <strong>Beoordeling:</strong> ⭐⭐⭐⭐⭐<br>
                    <strong>Review:</strong> Geweldige ervaring, alles was perfect geregeld!
                    <button>Reageer</button>
                </li>
                <li>
                    <strong>Naam:</strong> Mark de Groot<br>
                    <strong>Datum:</strong> 22 mei 2025<br>
                    <strong>Beoordeling:</strong> ⭐⭐⭐⭐☆<br>
                    <strong>Review:</strong> Mooie reis, maar de hotelkamer kon schoner.
                    <button>Reageer</button>
                </li>
            </ul>
        </div>
    </details>
</main>

<footer style="text-align:center; font-size:0.9rem; padding:1rem; color:#666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden.
</footer>
</body>
</html>


