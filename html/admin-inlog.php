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

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $wachtwoord = $_POST['password'] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($wachtwoord)) {
        $stmt = $conn->prepare("SELECT Naam, Email, Wachtwoord FROM Admin WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($wachtwoord, $admin['Wachtwoord'])) {
            $_SESSION['admin_name'] = $admin['Naam'];
            $_SESSION['admin_email'] = $admin['Email'];
            header("Location: admin.php");
            exit;
        } else {
            $error = "Ongeldige login.";
        }
    } else {
        $error = "Vul een geldig e-mailadres en wachtwoord in.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Admin Inloggen - Polar & Paradise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">

</head>
<body>

<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise" /></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="ski.php">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="admin-inlog.php" class="active">Login</a></li>
        </ul>
    </nav>
</header>

<section class="admin-hero">
    <div class="form-container">
        <h1 class="form-title">Admin Inloggen</h1>
        <?php if (!empty($error)): ?>
            <p style="color:red; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form class="form" method="POST" action="admin-inlog.php">
            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Inloggen</button>
        </form>
        <p class="form-note">Nog geen account? <a href="admin-registreer.php">Registreer hier</a></p>
    </div>
</section>

<footer style="text-align:center; padding:1rem; font-size:0.9rem; color:#666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>

</body>
</html>


