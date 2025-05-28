<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise - Frankrijk</title>
    <link rel="stylesheet" href="vakantie.css" />
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
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<section class="vakantie">
    <img src="images/frankrijk-hero.jpg" alt="Skiën in Frankrijk">
    <div class="hero-text">
        <h1>Geniet van de Franse Alpen</h1>
    </div>
    <section class="search-bar">
        <input type="date" placeholder="Vertrekdatum">
        <input type="text" placeholder="1 kamer(s), 2 reizigers">
        <select>
            <option>8-11 dagen</option>
            <option>12-15 dagen</option>
        </select>
        <input type="text" placeholder="Frankrijk">
        <button class="pp-search-btn">Toon vakanties</button>
    </section>
</section>

<main class="pp-content">
    <aside class="pp-filters">
        <h3>Filter</h3>
        <label>Regio
            <select>
                <option>Les Arcs</option>
                <option>La Plagne</option>
                <option>Serre Chevalier</option>
            </select>
        </label>
        <label>Sterren
            <select>
                <option>Alle</option>
                <option>3 sterren</option>
                <option>4 sterren</option>
                <option>5 sterren</option>
            </select>
        </label>
        <label>Soort vakantie
            <select>
                <option>Wintersport</option>
                <option>Familie</option>
                <option>Luxueus</option>
                <option>Chamonix</option>
            </select>
        </label>
        <label>
            <input type="checkbox"> Ski pas inbegrepen
        </label>
    </aside>

    <section class="pp-destinations">
        <div class="pp-country">
            <a href="les-arcs-chalet.php">
                <img src="images/frankrijk-hotel1.jpg" alt="Les Arcs Chalet" />
                <p>Les Arcs Chalet – 4 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="la-plagne-resort.php">
                <img src="images/frankrijk-hotel2.jpg" alt="La Plagne Resort" />
                <p>La Plagne Resort – 5 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="serre-chevalier-lodge.php">
                <img src="images/frankrijk-hotel3.jpg" alt="Serre Chevalier Lodge" />
                <p>Serre Chevalier Lodge – 3 sterren</p>
            </a>
        </div>
        <div class="pp-country">
            <a href="chalet-mont-blanc.php">
                <img src="images/chalet-mont-blanc.jpg" alt="Chalet Mont Blanc" />
                <p>Chalet Mont Blanc – 5 sterren</p>
            </a>
        </div>
    </section>
</main>

<footer style="text-align: center; padding: 1rem; font-size: 0.9rem; color: #666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>
</body>
</html>
