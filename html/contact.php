<?php
$servername = "db"; // Docker-service naam
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
    exit;
}

$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name !== '' && $message !== '') {
        try {
            // Alleen naam en bericht opslaan, email wordt niet opgeslagen
            $stmt = $conn->prepare("INSERT INTO Vragen (Naam, Vraag) VALUES (:naam, :vraag)");
            $stmt->execute([
                ':naam' => $name,
                ':vraag' => $message
            ]);
            $success = true;
        } catch (PDOException $e) {
            $error = "Er ging iets mis bij het opslaan van je vraag. Probeer het later opnieuw.";
        }
    } else {
        $error = "Vul alle verplichte velden in!";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise - Contact</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">
</head>
<body>

<header class="pp-header">
    <div class="logo">
        <a href="index.php">
            <img src="images/image1 (1).png" alt="Polar & Paradise">
        </a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="ski.php">Ski vakanties</a></li>
            <li><a href="zomer.php">Zomer vakanties</a></li>
            <li><a href="overons.php">Over ons</a></li>
            <li><a href="contact.php" class="active">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="contact-hero">
    <div class="form-container">
        <h1 class="form-title">Contact</h1>

        <?php if ($success): ?>
            <div class="success-message" style="color: green; margin-bottom: 1em;">
                Je vraag is succesvol verzonden! We nemen zo snel mogelijk contact met je op.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-message" style="color: red; margin-bottom: 1em;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form class="form" method="POST" action="contact.php">
            <label for="name">Naam</label>
            <input type="text" id="name" name="name" required>

            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Bericht</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Verzenden</button>
        </form>
    </div>
</section>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
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

