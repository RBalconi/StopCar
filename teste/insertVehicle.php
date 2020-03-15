<?php
include('../util/urls.php');

include(urlBd);

for ($i=0; $i < 10; $i++) { 
    
    $plate = 'plate'.$i;
    $model = 'model'.$i;
    $brand = 'brand'.$i;
    $year = rand(1000,9999);
    $owner = 359;
    $color = 'color'.$i;
    $active = 1; // 1 = active || 0 = desactivated

    echo $plate.'<br>'.$year.'<br>'.$owner;

    $sql = "insert into vehicle(plate, model, brand, year, owner, color, active)" 
        ." values(:plate, :model, :brand, :year, :owner, :color, :active)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':plate' => $plate, ':model' => $model, ':brand' => $brand, ':year' => $year,
    ':owner' => $owner, ':color' => $color, ':active' => $active
    ));

}
?>