<?php
include('../util/urls.php');

session_start();

include(urlBd);

$user = $_POST['user'];
$pass = $_POST['pass'];

if(empty($user) || empty($pass)){
    $_SESSION['not_authenticated'] = true;
    header('Location: '. urlIndex);
    exit();
}

$stmt = $conn->prepare('select id, user from user where user = ? and pass = md5(?)');
$stmt->bindParam(1, $user);
$stmt->bindParam(2, $pass);
$stmt->execute();
$result = $stmt->fetch();

if ($stmt-> rowCount() == "1") { 
    $_SESSION['user'] = $user;
    $_SESSION['id_user'] = $result['id'];

    header('Location: '.urlPainel);
    exit();
}else{
    $_SESSION['not_authenticated'] = true;
    header('Location: '.urlIndex);
    exit();
}


?>