<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$boeking_id = intval($_POST['boeking_id'] ?? 0);
$email = $_POST['email'] ?? '';
$reden = $_POST['reden'] ?? '';

if ($boeking_id > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $servername = "db";
    $username = "root";
    $password = "rootpassword";
    $database = "mydatabase";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Controleer of deze boeking bij de gebruiker hoort
        $stmt = $conn->prepare("SELECT * FROM boekingen WHERE id = :id AND user_id = :uid");
        $stmt->execute([':id' => $boeking_id, ':uid' => $_SESSION['user_id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Verwijder boeking
            $conn->prepare("DELETE FROM boekingen WHERE id = :id AND user_id = :uid")->execute([
                ':id' => $boeking_id,
                ':uid' => $_SESSION['user_id']
            ]);
            // Optioneel: Sla annuleer reden op in aparte tabel
            // $conn->prepare("INSERT INTO annuleringen ...")->execute([...]);
            $success = true;
        } else {
            $success = false;
        }
    } catch (PDOException $e) {
        $success = false;
    }
} else {
    $success = false;
}

// Geef feedback
if ($success) {
    echo "<p>✅ Boeking succesvol geannuleerd en verwijderd uit je account.</p>";
    echo '<a href="account.php">Terug naar mijn boekingen</a>';
} else {
    echo "<p>❌ Kon de boeking niet annuleren. Neem contact op met support.</p>";
    echo '<a href="account.php">Terug</a>';
}
?>