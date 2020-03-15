<?php 
include('../util/urls.php');


include(urlBd);

for ($i=0; $i < 50; $i++) { 
    $title = 'title'.$i;
    $status = 'status'.$i;
    $client = rand(360, 382);
    $vehicle = 117;
    // $dateRegister = 'dateRegister'.$i;
    // $dateExpectedCompleted = 'dateExpectedCompleted'.$i;
    $dateCompleted = rand(2000, 2019).'-'.rand(10, 12).'-'.rand(10, 30);
    $detail = 'detail'.$i;
    $price = 'price'.$i;
    $paymentType = 'check';
    $paymentStatus = 'receveid';    
    $active = 1; // 1 = active || 0 = desactivated

    echo $dateCompleted.'<br>';
    

    $sql = "insert into serviceorder(title, status, client, vehicle,  detail, "
                                    ."price, paymentType, paymentStatus, active, dateCompleted) "
                            ."values(:title, :status, :client, :vehicle, :detail, "
                                    .":price, :paymentType, :paymentStatus, :active, :dateCompleted)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':title' => $title, ':status' => $status, ':client' => $client, ':vehicle' => $vehicle, ':detail' => $detail, 
        ':price' => $price, ':paymentType' => $paymentType, ':paymentStatus' => $paymentStatus, ':active' => $active, ':dateCompleted' => $dateCompleted
    ));

    
}


?>