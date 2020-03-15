<?PHP
include('../util/urls.php');
include(urlBd); 

$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;

// try {
//     $sql = "DELETE FROM vehicle WHERE id = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bindParam(1, $id);
//     $stmt->execute();

// } catch(PDOException $e){

// }
try {
    $sql = "update vehicle set active = :active where id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':active' => 0, 'id' => $id
    ));
} catch(PDOException $e){

}
?>