<?PHP
include('../util/urls.php');

session_start();

include(urlBd); 

$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;
$title = $_POST['title'];
$status = $_POST['status'];
$client = $_POST['client'];
$vehicle = $_POST['vehicle'];
$dateRegister = $_POST['dateRegister'];
$dateExpectedCompleted = $_POST['dateExpectedCompleted'];
$dateCompleted = $_POST['dateCompleted'];
$detail = $_POST['detail'];
$price = $_POST['price'];
$paymentType = $_POST['radioPaymentType'];
$paymentStatus = $_POST['radioPaymentStatus'];
$dateReceveid = $_POST['dateReceveid'];

$active = 1; // 1 = active || 0 = desactivated

if(empty($id) || $id == NULL || $id == ''){ 
    try {
        $sql = "insert into serviceorder(title, status, client, vehicle, dateRegister, dateExpectedCompleted, dateCompleted, detail, "
                                        ."price, paymentType, paymentStatus, dateReceveid, active) "
                                ."values(:title, :status, :client, :vehicle, :dateRegister, :dateExpectedCompleted, :dateCompleted, :detail, "
                                        .":price, :paymentType, :paymentStatus, :dateReceveid, :active)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':title' => $title, ':status' => $status, ':client' => $client, ':vehicle' => $vehicle, ':dateRegister' => $dateRegister, 
            ':dateExpectedCompleted' => $dateExpectedCompleted, ':dateCompleted' => $dateCompleted, ':detail' => $detail, 
            ':price' => $price, ':paymentType' => $paymentType, ':paymentStatus' => $paymentStatus, ':dateReceveid' => $dateReceveid, ':active' => $active
        ));

    } catch(PDOException $e){
    }

}else if(!empty($cod) || $id != NULL || $id != ''){ 
    $sql = "update serviceorder set title = :title, status = :status, client = :client, vehicle = :vehicle, dateRegister = :dateRegister, "
                            ."dateExpectedCompleted = :dateExpectedCompleted, dateCompleted = :dateCompleted, detail = :detail, price = :price, "
                            ."paymentType = :paymentType, paymentStatus = :paymentStatus, dateReceveid = :dateReceveid, active = :active where id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':title' => $title, ':status' => $status, ':client' => $client, ':vehicle' => $vehicle, ':dateRegister' => $dateRegister, 
        ':dateExpectedCompleted' => $dateExpectedCompleted, ':dateCompleted' => $dateCompleted, ':detail' => $detail, 
        ':price' => $price, ':paymentType' => $paymentType, ':paymentStatus' => $paymentStatus, ':dateReceveid' => $dateReceveid, ':active' => $active, ':id' => $id
    ));
                    
}

?>