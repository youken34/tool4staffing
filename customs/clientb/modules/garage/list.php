<?php
$garagesData = json_decode(file_get_contents(getProjectPath('data/garages.json')), true);
$clientGarages = array_filter($garagesData);
?>

<div class="garages-list clientb-garages">
    <h2>Liste des Garages</h2>
    <table class="garages-table">
        <thead>
            <tr>
                <th>Nom du garage</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientGarages as $garage): ?>
            <tr data-garage-id="<?php echo htmlspecialchars($garage['id']); ?>">
                <td><?php echo htmlspecialchars($garage['name']); ?></td>
                <td><?php echo htmlspecialchars($garage['address']); ?></td>
                <td><?php echo htmlspecialchars($garage['phone']); ?></td>
                <td><?php echo htmlspecialchars($garage['manager']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> 