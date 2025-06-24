
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polar & Paradise</title>
    <link rel="stylesheet" href="../vakantie.css?v=<?= time() ?>">


</head>
<body>

<!-- HEADER -->
<header class="pp-header">
    <div class="logo">
        <a href="../index.php"><img src="/images/image1 (1).png" alt="Polar & Paradise"></a>
    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admin-vragen.php">Inkomende vragen</a></li>
            <li><a href="admin-recensies.php">Inkomende reviews</a></li>
            <li><a href="admin-land.php">Landen</a></li>
            <li><a href="admin-hotel.php">Hotels</a></li>
            <li><a href="../uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>
<section class="landen-container">
    <h1>Landen beheren</h1>

    <!-- Tabel met bestaande landen -->
    <table>
        <thead>
        <tr>
            <th>Land</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        <!-- Voorbeeldrijen; vervang met PHP code die uit database laadt -->
        <tr>
            <td>Nederland</td>
            <td class="actions">
                <button type="button" onclick="alert('Bewerk Nederland')">Bewerken</button>
                <button type="button" class="delete" onclick="confirm('Weet je zeker dat je Nederland wil verwijderen?')">Verwijderen</button>
            </td>
        </tr>
        <tr>
            <td>Duitsland</td>
            <td class="actions">
                <button type="button" onclick="alert('Bewerk Duitsland')">Bewerken</button>
                <button type="button" class="delete" onclick="confirm('Weet je zeker dat je Duitsland wil verwijderen?')">Verwijderen</button>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Formulier om nieuw land toe te voegen -->
    <form method="POST" action="admin.landen.php">
        <label for="nieuw-land">Nieuw land toevoegen</label>
        <input type="text" id="nieuw-land" name="land" placeholder="Typ een landnaam..." required />
        <button type="submit">Toevoegen</button>
    </form>
</section>

</body>
</html>