<?php
$servername = "db"; // Docker-service naam
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Verbinding gelukt, eventueel logging
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tirol Resort – Oostenrijk | Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css" />
    <style>
        /* Extra styling alleen voor deze hotelpagina */
        .hotel-detail {
            max-width: 900px;
            margin: 3rem auto 5rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .hotel-detail h1 {
            font-size: 2.4rem;
            margin-bottom: 1rem;
            color: #004080;
        }

        .hotel-images img {
            width: 100%;
            max-height: 350px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            margin-bottom: 2rem;
        }

        .hotel-info h2 {
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            color: #0066cc;
            font-weight: 700;
        }

        .hotel-info p, .hotel-info ul {
            font-size: 1.05rem;
            line-height: 1.5;
        }

        .hotel-info ul {
            list-style-type: disc;
            padding-left: 1.5rem;
        }

        .pp-booking-btn {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.8rem 2rem;
            background-color: #007acc;
            color: white;
            font-weight: 700;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .pp-booking-btn:hover {
            background-color: #005a99;
        }

        .pp-back-btn {
            display: inline-block;
            margin-top: 3rem;
            color: #555;
            text-decoration: none;
            font-size: 1rem;
        }

        .pp-back-btn:hover {
            text-decoration: underline;
            color: #007acc;
        }
    </style>
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
        </ul>
    </nav>
</header>

<main class="pp-content">
    <section class="hotel-detail">
        <h1>Tirol Resort – 4 sterren</h1>
        <div class="hotel-images">
            <img src="../../images/tyrol%20resort.jpg" alt="Tirol Resort" />
        </div>
        <article class="hotel-info">
            <h2>Beschrijving</h2>
            <p>Tirol Resort ligt midden in de prachtige Alpen, perfect voor wintersport en natuurliefhebbers die van comfort houden.</p>

            <h2>Prijs</h2>
            <p>Vanaf €120 per nacht</p>

            <h2>Faciliteiten</h2>
            <ul>
                <li>Gratis WiFi</li>
                <li>Spa en wellness</li>
                <li>Restaurant met lokale gerechten</li>
                <li>Ski-opslag</li>
            </ul>

            <a href="boeking.php?hotel=TirolResort" class="pp-booking-btn">Boek nu</a>
        </article>

        <a href="oostenrijk.php" class="pp-back-btn">← Terug naar Oostenrijk vakanties</a>
    </section>
</main>

<footer class="pp-footer">
    © 2025 Polar Paradise. Alle rechten voorbehouden.<br />
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise.<br />
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
