<?php
require __DIR__ . '/../app/Models/classPlanoDentario.php';
$pl = new PlanoDentario();
$stmt = $pl->viewAll();
if (!$stmt) { echo "no stmt\n"; exit; }
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
    echo "id={$row->id} name={$row->nome}\n";
}
?>