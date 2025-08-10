<?php
$carsData = json_decode(file_get_contents(getProjectPath('data/cars.json')), true);
$clientCars = array_filter($carsData, function($car) {
    return $car['client'] === 'clientb';
});
?>

<div class="cars-list clientb-cars">
    <h2>Liste des Voitures - Client B</h2>
    <table class="cars-table">
        <thead>
            <tr>
                <th>Nom de la voiture</th>
                <th>Marque</th>
                <th>Nom du garage</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientCars as $car): ?>
            <tr data-car-id="<?php echo $car['id']; ?>">
                <td><?php echo strtolower(htmlspecialchars($car['name'])); ?> <!-- Original: <?php echo htmlspecialchars($car['name']); ?> --></td>
                <td><?php echo htmlspecialchars($car['brand']); ?></td>
                <td><?php echo htmlspecialchars($car['garage']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> 