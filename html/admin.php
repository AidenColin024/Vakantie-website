<?php
session_start();

if (!isset($_SESSION['admin_name'], $_SESSION['admin_email'])) {
    header("Location: admin-login.php");
    exit;
}

$naam = htmlspecialchars($_SESSION['admin_name']);
$email = htmlspecialchars($_SESSION['admin_email']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Polar & Paradise</title>
    <link rel="stylesheet" href="vakantie.css?v=1.2">
</head>
<body>

<header class="pp-header">
    <div class="logo">
        <a href="index.php"><img src="images/image1 (1).png" alt="Polar & Paradise" /></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="admin.php" class="active">Dashboard</a></li>
            <li><a href="admin-logout.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>

<section class="admin-dashboard">
    <div class="admin-container">
        <h1>Welkom, <?= $naam ?></h1>
        <p>Dit is het beheerdersdashboard.</p>

        <details class="admin-panel">
            <summary>📦 Reizen beheren</summary>
            <div class="panel-content">
                <button>➕ Voeg nieuwe reis toe</button>
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th>Bestemming</th>
                        <th>Prijs</th>
                        <th>Startdatum</th>
                        <th>Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Spanje</td>
                        <td>€899</td>
                        <td>12 juli 2025</td>
                        <td>
                            <button>✏️ Aanpassen</button>
                            <button>🗑 Verwijderen</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Oostenrijk</td>
                        <td>€749</td>
                        <td>3 januari 2026</td>
                        <td>
                            <button>✏️ Aanpassen</button>
                            <button>🗑 Verwijderen</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </details>

        <details class="admin-panel">
            <summary>📬 Inkomende vragen (contactformulier)</summary>
            <div class="panel-content">
                <ul class="admin-list">
                    <li>
                        <strong>Naam:</strong> Anna Pieters<br>
                        <strong>Email:</strong> anna@mail.com<br>
                        <strong>Bericht:</strong> Wanneer vertrekt de reis naar Italië precies?
                        <button>Beantwoord</button>
                    </li>
                    <li>
                        <strong>Naam:</strong> Tom de Vries<br>
                        <strong>Email:</strong> tomvries@mail.com<br>
                        <strong>Bericht:</strong> Zijn er nog last-minute aanbiedingen voor juli?
                        <button>Beantwoord</button>
                    </li>
                </ul>
            </div>
        </details>

    </div>
</section>

<footer style="text-align:center; padding:1rem; font-size:0.9rem; color:#666;">
    © 2025 Polar Paradise. Alle rechten voorbehouden. <br>
    Polar Paradise is een geregistreerd handelsmerk van Polar Paradise. <br>
    Ongeautoriseerd gebruik van inhoud of merktekens is verboden.
</footer>

</body>
</html>

