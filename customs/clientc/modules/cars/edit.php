<?php
$carId = $_GET['car_id'] ?? '';
$carsData = json_decode(file_get_contents(getProjectPath('data/cars.json')), true);

$car = null;
foreach ($carsData as $c) {
    if ($c['id'] == $carId && $c['client'] === 'clientc') {
        $car = $c;
        break;
    }
}

if (!$car) {
    echo '<p>Voiture non trouvée</p>';
    exit;
}
?>

<div class="car-detail clientc-detail">
    <h2>Détails de la Voiture - Client C</h2>
    <div class="car-info">
        <div class="info-row">
            <label>Nom :</label>
            <span><?php echo htmlspecialchars($car['name']); ?></span>
        </div>
        <div class="info-row">
            <label>Marque :</label>
            <span><?php echo htmlspecialchars($car['brand']); ?></span>
        </div>
        <div class="info-row">
            <label>Année :</label>
            <span><?php echo $car['year']; ?></span>
        </div>
        <div class="info-row">
            <label>Puissance :</label>
            <span><?php echo $car['horsepower']; ?> ch</span>
        </div>
        <div class="info-row">
            <label>Garage :</label>
            <span><?php echo htmlspecialchars($car['garage']); ?></span>
        </div>
        <div class="info-row">
            <label>Couleur :</label>
            <span>
                <div class="color-indicator" style="background-color: <?php echo $car['color']; ?>; width: 30px; height: 30px; border-radius: 50%; display: inline-block; vertical-align: middle; margin-right: 10px;"></div>
                <?php echo htmlspecialchars($car['color']); ?>
            </span>
        </div>
    </div>
    <button class="back-btn" onclick="loadModule('cars', 'list')">Retour à la liste</button>
</div> 