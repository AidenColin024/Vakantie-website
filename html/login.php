<?php
ob_start();
session_start();

$servername = "db"; // of localhost als je niet docker gebruikt
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Verbindingsfout: " . $e->getMessage());
}

$foutmelding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $wachtwoord = $_POST["password"] ?? '';

    $stmt = $conn->prepare("SELECT * FROM Gebruikers WHERE Email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($gebruiker && password_verify($wachtwoord, $gebruiker["Wachtwoord"])) {
        $_SESSION["naam"] = $gebruiker["Naam"];
        $_SESSION["email"] = $gebruiker["Email"];
        header("Location: account.php");
        exit;
    } else {
        $foutmelding = "❌ Ongeldige combinatie van e-mailadres en wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inloggen | Polar & Paradise</title>
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

<section class="login-hero">
    <div class="form-container">
        <h1 class="form-title">Inloggen</h1>
        <?php if ($foutmelding): ?>
            <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($foutmelding); ?></p>
        <?php endif; ?>
        <form class="form" method="POST" action="login.php">
            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Inloggen</button>
        </form>
        <p class="form-note">Nog geen account? <a href="registreer.php">Registreer hier</a></p>
        <p class="form-note">Of bent u de eigenaar? <a href="admin-inlog.php">Log dan hier in</a></p>
    </div>
</section>


<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
<script>
    // Simpele veld-validatie feedback
    document.addEventListener("DOMContentLoaded", () => {
        const forms = document.querySelectorAll("form");

        forms.forEach(form => {
            form.addEventListener("submit", e => {
                const inputs = form.querySelectorAll("input[required], textarea[required]");
                let allFilled = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.style.borderColor = "red";
                        allFilled = false;
                    } else {
                        input.style.borderColor = "#ccc";
                    }
                });

                if (!allFilled) {
                    e.preventDefault();
                    alert("⚠️ Vul alle verplichte velden in.");
                }
            });
        });
    });
</script>
</body>
</html>

