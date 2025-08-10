<?php
$carsData = json_decode(file_get_contents(getProjectPath('data/cars.json')), true);
$clientCars = array_filter($carsData, function($car) {
    return $car['client'] === 'clienta';
});

foreach ($clientCars as &$car) {
    $carAge = date('Y') - $car['year'];
    if ($carAge > 10) {
        $car['rowClass'] = 'old-car';        
    } elseif ($carAge < 2) {
        $car['rowClass'] = 'new-car';        
    } else {
        $car['rowClass'] = 'normal-car';     
    }
}
?>

<div class="cars-list clienta-cars">
    <h2>Liste des Voitures - Client A</h2>
    <table class="cars-table">
        <thead>
            <tr>
                <th>Nom de la voiture</th>
                <th>Marque</th>
                <th>Année</th>
                <th>Puissance (ch)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientCars as $car): ?>
            <tr class="<?php echo $car['rowClass']; ?>" data-car-id="<?php echo $car['id']; ?>">
                <td><?php echo htmlspecialchars($car['name']); ?></td>
                <td><?php echo htmlspecialchars($car['brand']); ?></td>
                <td><?php echo $car['year']; ?></td>
                <td><?php echo $car['horsepower']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> 