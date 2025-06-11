<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$database = "mydatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Verbindingsfout: " . $e->getMessage();
}

// Verwerk formulier als er een review wordt ingestuurd
$bericht = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $hotel = "TirolResort"; // vaste hotelnaam passend bij deze pagina
    $naam = trim(htmlspecialchars($_POST['naam']));
    $beoordeling = (int)$_POST['beoordeling'];
    $commentaar = trim(htmlspecialchars($_POST['commentaar']));

    if ($naam !== "" && $beoordeling >= 1 && $beoordeling <= 5 && $commentaar !== "") {
        $stmt = $conn->prepare("INSERT INTO review (hotel, naam, beoordeling, commentaar, datum) VALUES (:hotel, :naam, :beoordeling, :commentaar, NOW())");

        $stmt->execute([
            ':hotel' => $hotel,
            ':naam' => $naam,
            ':beoordeling' => $beoordeling,
            ':commentaar' => $commentaar,
        ]);
        $bericht = "✅ Bedankt voor je review!";
    } else {
        $bericht = "⚠️ Vul alle velden correct in.";
    }
}

// Haal bestaande reviews op
$stmt = $conn->prepare("SELECT naam, beoordeling, commentaar, datum FROM review WHERE hotel = :hotel ORDER BY datum DESC");
$stmt->execute([':hotel' => "TirolResort"]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            border: none;
            cursor: pointer;
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

        /* Review sectie */
        form label {
            font-weight: 600;
        }
        form input[type="text"],
        form select,
        form textarea {
            width: 100%;
            padding: 0.6rem;
            margin-top: 0.25rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
        }

        ul.reviews-list {
            margin-top: 2rem;
            padding-left: 0;
        }

        ul.reviews-list li {
            list-style: none;
            border-bottom: 1px solid #ddd;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        ul.reviews-list li strong {
            font-size: 1.1rem;
            color: #004080;
        }

        ul.reviews-list li em {
            color: #777;
            font-size: 0.9rem;
        }

        ul.reviews-list li p {
            margin-top: 0.3rem;
            font-size: 1rem;
            white-space: pre-line;
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
            <li><a href="annuleren.php">Annuleren</a></li>
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

            <h2>Reviews</h2>

            <?php if (!empty($bericht)): ?>
                <p><strong><?php echo $bericht; ?></strong></p>
            <?php endif; ?>

            <form method="post" action="">
                <label for="naam">Naam:</label><br />
                <input type="text" id="naam" name="naam" required /><br />

                <label for="beoordeling">Beoordeling:</label><br />
                <select id="beoordeling" name="beoordeling" required>
                    <option value="">Kies</option>
                    <option value="1">1 ster</option>
                    <option value="2">2 sterren</option>
                    <option value="3">3 sterren</option>
                    <option value="4">4 sterren</option>
                    <option value="5">5 sterren</option>
                </select><br />

                <label for="commentaar">Review:</label><br />
                <textarea id="commentaar" name="commentaar" rows="4" required></textarea><br />

                <button type="submit" name="submit_review" class="pp-booking-btn">Plaats review</button>
            </form>

            <?php if ($reviews): ?>
                <ul class="reviews-list">
                    <?php foreach ($reviews as $rev): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($rev['naam']); ?></strong> -
                            <em><?php echo date('d-m-Y', strtotime($rev['datum'])); ?></em><br />
                            Beoordeling: <?php echo str_repeat('⭐', $rev['beoordeling']); ?><br />
                            <p><?php echo nl2br(htmlspecialchars($rev['commentaar'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Er zijn nog geen reviews. Wees de eerste!</p>
            <?php endif; ?>

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
