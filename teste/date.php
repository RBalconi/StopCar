<?php
date_default_timezone_set('America/Sao_Paulo');

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StopCar</title>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../lib/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
    <link rel="stylesheet" href="../lib/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.8.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body class="">
    <input type="date" class="form-control" name="dateRegister" id="dateRegister" value="<?php echo date('Y-m-d'); ?>" readonly>

    
</body>
</html>
