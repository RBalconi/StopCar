<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: ./view/painel.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StopCar - Login</title>

    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./lib/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="./lib/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./lib/fontawesome-free-5.8.2-web/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">

    
</head>
<!-- background-color: #999     -->
<body id="login">
    <div class="container">
        <div class="row justify-content-center" style="height: 100vh">
            <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 align-self-center">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Entrar</h4>
                        <hr>

                        <?php
                        if (isset($_SESSION['not_authenticated'])) { ?>
                            <p class="text-danger text-center">Usuário ou senha inválido!</p>
                        <?php
                        }
                        unset($_SESSION['not_authenticated']);
                        ?>

                        <form action="login/login.php" method="post">    
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input id="user" name="user" class="form-control" placeholder="Usuário" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input id="pass" name="pass" class="form-control" placeholder="******" type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"> Entrar </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>