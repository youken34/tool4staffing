<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Accueil</h1>
        <nav>
            <div class="client-selector">
                <label for="client-select">Client :</label>
                <select id="client-select">
                    <option value="clienta">Client A</option>
                    <option value="clientb">Client B</option>
                    <option value="clientc">Client C</option>
                </select>
            </div>
            <div class="module-selector" style="display: none;">
                <label for="module-select">Module :</label>
                <select id="module-select">
                    <option value="cars">Voitures</option>
                    <option value="garage" style="display: none;">Garages</option>
                </select>
            </div>
        </nav>
    </header>

    <main>
        <div class="dynamic-div" 
             data-module="cars" 
             data-script="list">
        </div>
    </main>

    <script src="assets/js/main.js"></script>
</body>
</html> 