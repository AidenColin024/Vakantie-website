<?php
session_start();
// Controleer of gebruiker is ingelogd (voorbeeld)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$boeking_id = isset($_GET['boeking_id']) ? intval($_GET['boeking_id']) : 0;
$hotel = "je vakantie";

// Haal optioneel hotelnaam op uit database voor dit boeking_id
if ($boeking_id > 0) {
    $servername = "db";
    $username = "root";
    $password = "rootpassword";
    $database = "mydatabase";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT hotel_naam FROM boekingen WHERE id = :id AND user_id = :uid");
        $stmt->execute([':id' => $boeking_id, ':uid' => $_SESSION['user_id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $hotel = htmlspecialchars($row['hotel_naam']);
        }
    } catch (PDOException $e) {
        $hotel = "je vakantie";
    }
}
?>
<!-- De rest van je HTML -->
<form action="annuleren_verwerk.php" method="POST" class="annuleer-form">
    <input type="hidden" name="boeking_id" value="<?= $boeking_id ?>">
    <label for="email">E-mailadres</label>
    <input type="email" name="email" required>
    <label for="reden">Reden van annulering</label>
    <textarea name="reden" rows="4" required></textarea>
    <button type="submit">Bevestig annulering</button>
</form>