<?PHP

include('../util/urls.php');
include(urlBd); 

$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;
// $id = $_POST['code'];
$name = $_POST['name'];
$cpf  = $_POST['cpf'];
$address = $_POST['address'];
$number = $_POST['number'];
$complement = $_POST['complement'];
$distric = $_POST['district'];
$city = $_POST['city'];
$state = $_POST['state'];
$zipcode = $_POST['zipcode'];
$telephone = $_POST['telephone'];
$cellphone = $_POST['cellphone'];
$email = $_POST['email'];
$active = 1; // 1 = active || 0 = desactivated


if(empty($id) || $id == NULL || $id == ''){ 
    try {
        $sql = "insert into client(name, cpf, address, number, complement, district, city, state, zipcode, telephone, cellphone, email, active)" 
                           ."values(:name, :cpf, :address, :number, :complement, :district, :city, :state, :zipcode, :telephone, :cellphone, :email, :active)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':name' => $name, ':cpf' => $cpf, ':address' => $address,  ':number' => $number,
            ':complement' => $complement, ':district' => $distric,  ':city' => $city, ':state' => $state,
            ':zipcode' => $zipcode, ':telephone' => $telephone, ':cellphone' => $cellphone, ':email' => $email, ':active' => $active
        ));

    } catch(PDOException $e){
    }

}else if(!empty($cod) || $id != NULL || $id != ''){ 
    $sql = "update client set name = :name, cpf = :cpf, address = :address, number = :number, complement = :complement, "
                            ."district = :district, city = :city, state = :state, zipcode = :zipcode, "
                            ."telephone = :telephone, cellphone = :cellphone, email = :email, active = :active where id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':name' => $name, ':cpf' => $cpf, ':address' => $address,  ':number' => $number,
        ':complement' => $complement, ':district' => $distric,  ':city' => $city, ':state' => $state,
        ':zipcode' => $zipcode, ':telephone' => $telephone, ':cellphone' => $cellphone, ':email' => $email, ':active' => $active, 'id' => $id
    ));
                    
}

?>