<?php
$carsData = json_decode(file_get_contents(getProjectPath('data/cars.json')), true);
$clientCars = array_filter($carsData, function($car) {
    return $car['client'] === 'clientc';
});
?>

<div class="cars-list clientc-cars">
    <h2>Liste des Voitures - Client C</h2>
    <table class="cars-table">
        <thead>
            <tr>
                <th>Nom de la voiture</th>
                <th>Marque</th>
                <th>Année</th>
                <th>Puissance (ch)</th>
                <th>Garage</th>
                <th>Couleur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientCars as $car): ?>
            <tr data-car-id="<?php echo $car['id']; ?>" style="background-color: <?php echo $car['color']; ?>20;">
                <td><?php echo htmlspecialchars($car['name']); ?></td>
                <td><?php echo htmlspecialchars($car['brand']); ?></td>
                <td><?php echo $car['year']; ?></td>
                <td><?php echo $car['horsepower']; ?></td>
                <td><?php echo htmlspecialchars($car['garage']); ?></td>
                <td>
                    <div class="color-indicator" style="background-color: <?php echo $car['color']; ?>; width: 20px; height: 20px; border-radius: 50%; display: inline-block;"></div>
                    <?php echo htmlspecialchars($car['color']); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> 