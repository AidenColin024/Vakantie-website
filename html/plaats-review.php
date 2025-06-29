<?php
// Verbinding maken
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden: " . $e->getMessage());
}

// Haal hotel id uit GET
if (isset($_GET['id'])) {
    $hotelId = $_GET['id'];
} else {
    $hotelId = '';
}

$bericht = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['hotel'])) {
        $hotel = $_POST['hotel'];
    } else {
        $hotel = '';
    }

    if (isset($_POST['naam'])) {
        $naam = $_POST['naam'];
    } else {
        $naam = '';
    }

    if (isset($_POST['beoordeling'])) {
        $beoordeling = (int) $_POST['beoordeling'];
    } else {
        $beoordeling = 0;
    }

    if (isset($_POST['commentaar'])) {
        $commentaar = $_POST['commentaar'];
    } else {
        $commentaar = '';
    }

    // Simpele controle of alles is ingevuld
    if ($hotel != "" && $naam != "" && $beoordeling >= 1 && $beoordeling <= 5 && $commentaar != "") {
        $stmt = $conn->prepare("INSERT INTO review (hotel, naam, beoordeling, commentaar) VALUES (?, ?, ?, ?)");
        $stmt->execute([$hotel, $naam, $beoordeling, $commentaar]);

        if ($hotelId != "") {
            header("Location: hotel-details.php?id=" . $hotelId . "&bericht=review_success");
            exit;
        } else {
            $bericht = "Recensie succesvol geplaatst, maar geen hotel ID gevonden voor redirect.";
        }
    } else {
        $bericht = "Vul alle velden correct in.";
    }
} else {
    $bericht = "Ongeldige aanvraag.";
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Recensie plaatsen</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>
<div class="container">
    <h1>Recensie plaatsen</h1>
    <?php if ($bericht != ""): ?>
        <p style="color:<?php if ($bericht == "Recensie succesvol geplaatst, maar geen hotel ID gevonden voor redirect.") { echo 'green'; } else { echo 'red'; } ?>; font-weight:bold;">
            <?php echo htmlspecialchars($bericht); ?>
        </p>
    <?php endif; ?>
    <p><a href="hotel-details.php?id=<?php echo htmlspecialchars($hotelId); ?>">Terug naar hotel</a></p>
</div>
</body>
</html>
