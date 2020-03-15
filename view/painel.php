<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

include('../util/urls.php');
include(urlBd); 
include(urlVerifyLogin);


try {
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_SESSION['id_user']);
    $stmt->execute();
    $row = $stmt->fetch();
} catch(PDOException $e){

}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StopCar</title>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/jquery.mask.min.js"></script>
    <script src="../js/Chart.bundle.min.js"></script>
    <script src="../lib/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
    <link rel="stylesheet" href="../lib/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.8.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body class="">
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <a>StopCar</a>
                <div id="close-sidebar">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="sidebar-header">
                <div class="user-pic">
                    <img class="img-responsive img-rounded" src="<?php echo $row['photo']?>"
                        alt="User picture">
                </div>
                <div class="user-info">
                    <span class="user-name"><?php echo $row['firstname']?>
                        <strong><?php echo $row['lastname']?></strong>
                    </span>
                    <!-- <span class="user-role">Administrator</span> -->
                </div>
            </div>
            <div class="sidebar-menu">
                <ul id="menu">
                    <li class="header-menu">
                        <span>Menu</span>
                    </li>
                    <li class="">
                        <a href="<?php echo urlDashboard ?>" class="call-screen-by-href">
                            <i class="fas fa-th"></i>
                            <span>Painel</span>
                        </a>
                    </li>
                    <li class="sidebar-dropdown">
                        <a class="pointer">
                            <i class="fa fa-address-book"></i>
                            <span>Cadastros</span>
                            <!-- <span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li><a href="<?php echo urlClientMain ?>" class="call-screen-by-href"></i>Clientes</a></li>
                                <li><a href="<?php echo urlVehicleMain ?>" class="call-screen-by-href">Veículos</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="">
                        <a href="<?php echo urlServiceOrderMain ?>" class="call-screen-by-href">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Ordens de Serviços</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- sidebar-content  -->
        <div class="sidebar-footer">
            <a href="#">
                <i class="fa fa-cog"></i>
                <span class="badge-sonar"></span>
            </a>
            <a href="<?php echo urlLogout?>">
                <i class="fa fa-power-off"></i>
            </a>
        </div>
    </nav>

    <main class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" id="content">
                    
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>