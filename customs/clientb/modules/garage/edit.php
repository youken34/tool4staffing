<?php
$garageId = $_GET['garage_id'] ?? '';
$garagesData = json_decode(file_get_contents(getProjectPath('data/garages.json')), true);

$garage = null;
foreach ($garagesData as $g) {
    if ($g['id'] == $garageId && $g['client'] === 'clientb') {
        $garage = $g;
        break;
    }
}

if (!$garage) {
    echo '<p>Garage non trouvé</p>';
    exit;
}
?>

<div class="garage-detail clientb-garage-detail">
    <h2>Détails du Garage - Client B</h2>
    <div class="garage-info">
        <div class="info-row">
            <label>Nom :</label>
            <span><?php echo htmlspecialchars($garage['name']); ?></span>
        </div>
        <div class="info-row">
            <label>Adresse :</label>
            <span><?php echo htmlspecialchars($garage['address']); ?></span>
        </div>
        <div class="info-row">
            <label>Téléphone :</label>
            <span><?php echo htmlspecialchars($garage['phone']); ?></span>
        </div>
        <div class="info-row">
            <label>Responsable :</label>
            <span><?php echo htmlspecialchars($garage['manager']); ?></span>
        </div>
        <div class="info-row">
            <label>Email :</label>
            <span><?php echo htmlspecialchars($garage['email']); ?></span>
        </div>
        <div class="info-row">
            <label>Horaires :</label>
            <span><?php echo htmlspecialchars($garage['hours']); ?></span>
        </div>
    </div>
    <button class="back-btn" onclick="loadModule('garage', 'list')">Retour à la liste</button>
</div> 