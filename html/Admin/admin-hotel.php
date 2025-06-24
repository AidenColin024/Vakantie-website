
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

        <a href="../index.php"><img src="/images/image1%20(1).png" alt="Polar & Paradise"></a>

    </div>
    <nav class="pp-nav">
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admin-vragen.php">Inkomende vragen</a></li>

            <li><a href="admin-recensies.php">Inkomende reviews</a></li>

            <li><a href="../admin-recensies.php">Inkomende reviews</a></li>

            <li><a href="admin-land.php">Landen</a></li>
            <li><a href="admin-hotel.php">Hotels</a></li>
            <li><a href="../uitlog.php">Uitloggen</a></li>
        </ul>
    </nav>
</header>



<div class="container">
    <h1>Hotels beheren per land</h1>

    <!-- Land selectie -->
    <label for="land-select">Selecteer een land</label>
    <select id="land-select" name="land-select" onchange="toonHotels()">
        <option value="">-- Kies een land --</option>
        <option value="nederland">Nederland</option>
        <option value="duitsland">Duitsland</option>
        <option value="frankrijk">Frankrijk</option>
        <!-- Vervang dit met dynamische opties uit je database -->
    </select>

    <!-- Hotels sectie -->
    <div id="hotels-section" style="display:none; margin-top:2rem;">
        <h2>Hotels in <span id="geselecteerd-land"></span></h2>

        <!-- Hotel toevoegen -->
        <form id="hotel-form" onsubmit="return voegHotelToe()">
            <label for="hotel-naam">Hotelnaam</label>
            <input type="text" id="hotel-naam" name="hotel-naam" placeholder="Typ hotelnaam..." required />

            <button type="submit">Hotel toevoegen</button>
        </form>

        <!-- Hotels tabel -->
        <table id="hotels-table">
            <thead>
            <tr>
                <th>Hotelnaam</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            <!-- Hotels komen hier via JS / PHP -->
            </tbody>
        </table>
    </div>
</div>


</body>


<script>
    // Simuleer hotels per land (normaal via PHP/database)
    const hotelsData = {
        nederland: ['Hotel Amsterdam', 'Hotel Rotterdam'],
        duitsland: ['Hotel Berlin', 'Hotel München'],
        frankrijk: ['Hotel Parijs']
    };

    function toonHotels() {
        const select = document.getElementById('land-select');
        const land = select.value;
        const sectie = document.getElementById('hotels-section');
        const landNaamSpan = document.getElementById('geselecteerd-land');
        const tbody = document.querySelector('#hotels-table tbody');

        if (!land) {
            sectie.style.display = 'none';
            tbody.innerHTML = '';
            return;
        }

        landNaamSpan.textContent = land.charAt(0).toUpperCase() + land.slice(1);
        sectie.style.display = 'block';

        // Toon hotels in tabel
        tbody.innerHTML = '';
        if (hotelsData[land]) {
            hotelsData[land].forEach((hotel, index) => {
                const tr = document.createElement('tr');

                const tdNaam = document.createElement('td');
                tdNaam.textContent = hotel;

                const tdActies = document.createElement('td');
                tdActies.classList.add('actions');

                // Bewerken knop (voor nu alert)
                const btnEdit = document.createElement('button');
                btnEdit.textContent = 'Bewerken';
                btnEdit.onclick = () => alert(`Bewerk hotel: ${hotel}`);

                // Verwijderen knop
                const btnDelete = document.createElement('button');
                btnDelete.textContent = 'Verwijderen';
                btnDelete.classList.add('delete');
                btnDelete.onclick = () => {
                    if (confirm(`Weet je zeker dat je ${hotel} wil verwijderen?`)) {
                        // Verwijder hotel uit data en update tabel
                        hotelsData[land].splice(index, 1);
                        toonHotels();
                    }
                };

                tdActies.appendChild(btnEdit);
                tdActies.appendChild(btnDelete);

                tr.appendChild(tdNaam);
                tr.appendChild(tdActies);

                tbody.appendChild(tr);
            });
        }
    }

    function voegHotelToe() {
        const select = document.getElementById('land-select');
        const land = select.value;
        const hotelInput = document.getElementById('hotel-naam');
        const hotelNaam = hotelInput.value.trim();

        if (!land) {
            alert('Selecteer eerst een land!');
            return false;
        }
        if (!hotelNaam) {
            alert('Typ een hotelnaam!');
            return false;
        }

        // Voeg hotel toe aan data
        if (!hotelsData[land]) {
            hotelsData[land] = [];
        }
        hotelsData[land].push(hotelNaam);

        // Update tabel en clear input
        toonHotels();
        hotelInput.value = '';
        hotelInput.focus();

        return false; // voorkom submit reload
    }
</script>


</body>

</html>