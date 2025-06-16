<?php
$servername = "db"; // Docker-service naam
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=<?= time() ?>">


</head>
<body>
<div id="consent-banner" class="consent-banner">
    <div class="consent-container">
        <h2>Privacyverklaring & Algemene Voorwaarden</h2>
        <p>
            Wij gebruiken cookies om uw ervaring op onze website te verbeteren. Door gebruik te maken van deze website, accepteert u onze
            <strong>Privacyverklaring</strong> en <strong>Algemene Voorwaarden</strong>.
        </p>

        <details class="consent-details">
            <summary>Bekijk volledige voorwaarden en privacyverklaring</summary>
            <div class="consent-text">
                <h3>Privacyverklaring</h3>
                <p>Uw privacy is belangrijk voor ons. Wij verzamelen alleen gegevens die nodig zijn voor het boeken van uw reis, zoals naam, e-mailadres, paspoortgegevens en betaalinformatie. Deze informatie wordt uitsluitend gedeeld met onze partners voor het uitvoeren van de geboekte reizen.</p>

                <h3>Welke gegevens verzamelen wij?</h3>
                <ul>
                    <li>Volledige naam, e-mailadres, telefoonnummer</li>
                    <li>Reisvoorkeuren en bestemmingen</li>
                    <li>Betaalgegevens (via veilige betaalproviders)</li>
                </ul>

                <h3>Waarom verzamelen wij gegevens?</h3>
                <p>Om uw vakantie te boeken, reisdocumenten op te stellen en u te informeren over uw reis.</p>

                <h3>Uw rechten</h3>
                <p>U heeft recht op inzage, correctie en verwijdering van uw gegevens. Mail ons op <a href="mailto:info@reisbureauvoorbeeld.nl">info@reisbureauvoorbeeld.nl</a>.</p>

                <h3>Algemene Voorwaarden</h3>
                <ul>
                    <li>Boekingen zijn pas definitief na betaling.</li>
                    <li>Annulering is mogelijk volgens de annuleringsvoorwaarden die bij elke reis vermeld staan.</li>
                    <li>Wij zijn niet aansprakelijk voor vertragingen of wijzigingen buiten onze controle, zoals weersomstandigheden of vluchtaanpassingen.</li>
                    <li>Alle prijzen zijn inclusief btw en onderhevig aan beschikbaarheid.</li>
                </ul>

                <p>Op alle boekingen is Nederlands recht van toepassing. Geschillen worden behandeld door de rechtbank te [jouw stad].</p>
            </div>
        </details>

        <button id="accept-consent" class="consent-button">Ik accepteer</button>
    </div>
</div>
<!-- HEADER -->
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

<!-- HERO -->
<section class="vakantie">
    <img src="\images\image3.webp" alt="Zon en Sneeuw vakanties">
    <div class="hero-text">
        <h1>Van zon en zee<br>naar sneeuw en slee</h1>
    </div>
</section>

<!-- DEAL ICONS -->
<section class="deals">
    <p>Zorgvuldig gekozen deals door onze specialisten</p>
    <div class="deal-icons">
        <span>Exclusieve deals</span>
        <span>Vakanties</span>
        <span>Vlucht</span>
        <span>Accommodaties</span>
        <span>All-inclusive</span>
        <!-- voeg meer toe zoals in het voorbeeld -->
    </div>
</section>

<!-- ZOMER / WINTER -->
<section class="seasons">
    <div class="summer">
        <div class="content">
            <h2>Jouw ideale zonvakantie</h2>
            <a href="zomer.php" class="btn btn-primary">Bekijk</a>
        </div>
    </div>
    <div class="winter">
        <div class="content">
            <h2>Jouw ideale wintersportvakantie</h2>
            <a href="ski.php" class="btn btn-primary">Bekijk</a>
        </div>
    </div>
</section>



<!-- SERVICE BLOCKS -->
<section class="services">
    <div class="service">
        <h3>Verzekeringen regelen</h3>
        <p>Goed verzekerd op vakantie</p>
    </div>
    <div class="service">
        <h3>Extra services bijboeken</h3>
        <p>Maak jouw vakantie compleet</p>
    </div>
    <div class="service">
        <h3>Vakantiegarantie</h3>
        <p>Alle zekerheden gebundeld</p>
    </div>
    <div class="service">
        <h3>Vragen? Wij helpen graag</h3>
        <p>Direct contact of antwoord</p>
    </div>
</section>
<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
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
    // Toon altijd de banner
    window.addEventListener('load', function () {
        document.getElementById('consent-banner').style.display = 'block';
    });

    document.getElementById('accept-consent').addEventListener('click', function () {
        document.getElementById('consent-banner').style.display = 'none';
    });
</script>
</body>
</html>