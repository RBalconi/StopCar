<?PHP
include('../util/urls.php');

session_start();

include(urlBd); 

$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;
// $id = $_POST['code'];
$plate = $_POST['plate'];
$model = $_POST['model'];
$brand = $_POST['brand'];
$year = $_POST['year'];
$owner = $_POST['owner'];
$color = $_POST['color'];
$active = 1; // 1 = active || 0 = desactivated


if(empty($id) || $id == NULL || $id == ''){ 
    try {
        $sql = "insert into vehicle(plate, model, brand, year, owner, color, active)" 
                           ." values(:plate, :model, :brand, :year, :owner, :color, :active)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':plate' => $plate, ':model' => $model, ':brand' => $brand, ':year' => $year,
            ':owner' => $owner, ':color' => $color, ':active' => $active
        ));

    } catch(PDOException $e){
    }

}else if(!empty($cod) || $id != NULL || $id != ''){ 
    $sql = "update vehicle set plate = :plate, model = :model, brand = :brand, year = :year, owner = :owner, color = :color, active = :active where id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':plate' => $plate, ':model' => $model, ':brand' => $brand, ':year' => $year, ':owner' => $owner, ':color' => $color, 
        ':active' => $active, ':id' => $id
    ));
                    
}

?>