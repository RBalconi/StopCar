<?php 
include('../util/urls.php');


include(urlBd);

for ($i=0; $i < 10; $i++) { 
    $name = 'name-'.$i;
    $cpf  = 'cpf-'.$i;
    $address = 'address-'.$i;
    $number = 'number-'.$i;
    $complement =  'complement-'.$i;
    $distric =  'district-'.$i;
    $city =  'city-'.$i;
    $state =  $i;
    $zipcode =  'zipcode-'.$i;
    $telephone =  'telephone-'.$i;
    $cellphone =  'cellphone-'.$i;
    $email =  'email-'.$i;
    $active = 1; // 1 = active || 0 = desactivated



    $sql = "insert into client(name, cpf, address, number, complement, district, city, state, zipcode, telephone, cellphone, email, active)" 
    ."values(:name, :cpf, :address, :number, :complement, :district, :city, :state, :zipcode, :telephone, :cellphone, :email, :active)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':name' => $name, ':cpf' => $cpf, ':address' => $address,  ':number' => $number,
    ':complement' => $complement, ':district' => $distric,  ':city' => $city, ':state' => $state,
    ':zipcode' => $zipcode, ':telephone' => $telephone, ':cellphone' => $cellphone, ':email' => $email, ':active' => $active
    ));

}


?>