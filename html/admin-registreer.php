<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase"; // pas eventueel aan

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Verbindingsfout: " . $e->getMessage());
}

$foutmelding = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["naam"]) && isset($_GET["email"]) && isset($_GET["password"]) && isset($_GET["password_confirm"])) {

        $naam = $_GET["naam"];
        $email = $_GET["email"];
        $wachtwoord = $_GET["password"];
        $wachtwoord_confirm = $_GET["password_confirm"];

        if ($naam == "" || $email == "" || $wachtwoord == "" || $wachtwoord_confirm == "") {
            $foutmelding = "Vul alle velden in.";
        } elseif ($wachtwoord != $wachtwoord_confirm) {
            $foutmelding = "Wachtwoorden komen niet overeen.";
        } else {
            $stmt = $conn->prepare("SELECT * FROM Admin WHERE Email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->fetch()) {
                $foutmelding = "E-mailadres bestaat al.";
            } else {
                $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

                try {
                    $stmt = $conn->prepare("INSERT INTO Admin (Naam, Email, Wachtwoord) VALUES (:naam, :email, :wachtwoord)");
                    $stmt->bindParam(":naam", $naam);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":wachtwoord", $hash);
                    $stmt->execute();

                    $_SESSION["admin_naam"] = $naam;
                    $_SESSION["admin_email"] = $email;

                    header("Location: admin.php");
                    exit;
                } catch (PDOException $e) {
                    $foutmelding = "Fout bij opslaan: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Admin Registratie | Polar & Paradise</title>
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
            <li><a href="ski.php">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="register-hero">
    <div class="form-container">
        <h1 class="form-title">Admin Registreren</h1>
        <?php if ($foutmelding): ?>
            <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($foutmelding); ?></p>
        <?php endif; ?>
        <form class="form" method="GET" action="admin-registreer.php">
            <label for="naam">Naam</label>
            <input type="text" id="naam" name="naam" required value="<?= isset($naam) ? htmlspecialchars($naam) : '' ?>">

            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirm">Bevestig wachtwoord</label>
            <input type="password" id="password_confirm" name="password_confirm" required>

            <button type="submit">Registreren</button>
        </form>
        <p class="form-note">Al een admin account? <a href="admin-inlog.php">Log hier in</a></p>
    </div>
</section>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden
</footer>
</body>
</html>
