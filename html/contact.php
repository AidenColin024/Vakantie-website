<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "Reis"; // correcte database

$success = false;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $naam = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $bericht = htmlspecialchars($_POST['message']);

        $stmt = $conn->prepare("INSERT INTO Vragen (naam, email, bericht) VALUES (:naam, :email, :bericht)");
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':bericht', $bericht);
        $stmt->execute();

        $success = true; // Trigger JS alert
    }
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
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
        <form class="form" method="POST" action="">
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

<?php if ($success): ?>
    <script>
        alert("✅ Bedankt voor uw vraag! We nemen spoedig contact met u op.");
        // Formulier leegmaken
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.querySelector("form");
            if (form) form.reset();
        });
    </script>
<?php endif; ?>

</body>
</html>

