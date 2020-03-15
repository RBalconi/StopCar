<?php 
if(!isset($_SESSION)) { 
    session_start(); 
} 
include('../util/urls.php');

include(urlVerifyLogin);
include(urlBd);

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');



$sql = "SELECT * FROM client WHERE active = 1";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$number_of_rows_client = $stmt->rowCount();

$sql = "SELECT * FROM vehicle WHERE active = 1";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$number_of_rows_vehicle = $stmt->rowCount();

$sql = "SELECT * FROM serviceorder WHERE active = 1";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$number_of_rows_serviceorder = $stmt->rowCount();


?>


<div class="row">                        
    <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-3">
        <div class="border border-primary">
            <div class="row no-gutters card-painel ">
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 bg-primary p-2 text-center text-white d-flex justify-content-center flex-column">
                    <i class="icon-card-painel fa fa-users "></i>
                </div>
                <div class="col-8 col-sm-8 col-md-8 col-lg-8 bg-primary p-2 text-right text-white d-flex justify-content-center flex-column">
                    <p class="content-card-painel"><?php echo $number_of_rows_client?></p>
                    <p class="title-card-painel">Clientes </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <a class="text-primary pointer" onclick="openDivByAjax('<?php echo urlClientMain ?>');">Visualizar
                        <i class="fa fa-chevron-right text-primary p-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-3">
        <div class="border border-warning">
            <div class="row no-gutters card-painel ">
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 bg-warning p-2 text-center text-white d-flex justify-content-center flex-column">
                    <i class="icon-card-painel fa fa-car"></i>
                </div>
                <div class="col-8 col-sm-8 col-md-8 col-lg-8 bg-warning p-2 text-right text-white d-flex justify-content-center flex-column">
                    <p class="content-card-painel"><?php echo $number_of_rows_vehicle?></p>
                    <p class="title-card-painel">Veículos</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <a class="text-warning pointer" onclick="openDivByAjax('<?php echo urlVehicleMain ?>');">Visualizar
                        <i class="fa fa-chevron-right text-warning p-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-3">
        <div class="border border-success">
            <div class="row no-gutters card-painel ">
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 bg-success p-2 text-center text-white d-flex justify-content-center flex-column">
                    <i class="icon-card-painel fas fa-file-invoice-dollar"></i>
                </div>
                <div class="col-8 col-sm-8 col-md-8 col-lg-8 bg-success p-2 text-right text-white d-flex justify-content-center flex-column">
                    <p class="content-card-painel"><?php echo $number_of_rows_serviceorder?></p>
                    <p class="title-card-painel">Ordens</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <a class="text-success pointer" onclick="openDivByAjax('<?php echo urlServiceOrderMain ?>');">Visualizar
                        <i class="fa fa-chevron-right text-success p-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3" >
        <?php 
        $dateCurrent = date('Y-m-d');
        $data = '';
        $labels = '';

        $sql = "SELECT count(s.client) as countcliente, s.dateCompleted FROM serviceorder s INNER JOIN client c on s.client = c.id "
                ."WHERE MONTH(s.dateCompleted) = ".date('m')." AND YEAR(s.dateCompleted) = ".date('Y')." GROUP BY dateCompleted";
                
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        foreach ($stmt as $row) { 
            $data = $data . '"'. $row['countcliente'].'",';
            $labels = $labels . '"'. date('d/m/Y', strtotime($row['dateCompleted'])) .'",';
        }

        $data = trim($data,",");
        $labels = trim($labels,",");

        $data = '['.$data.']';
        $labels = '['.$labels.']';
        ?>
        <div class="card text-center border-primary">
            <div class="card-header bg-primary text-white">
                Clientes atendidos no mês de <?php echo utf8_encode(strftime('%B de %Y', strtotime($dateCurrent)));

?>
            </div>
            <div class="card-body">
                <canvas id="chart1" height="200%">
                    <script>renderChart('chart1' ,<?php echo $data; ?>, <?php echo $labels; ?>, 'line', 
                        'Estatísticas', 'rgba(0, 123, 255, 0.2)', 'Data do Atendimento', 'Clientes Atendidos');</script>
                </canvas>
            </div>
            <!-- <div class="card-footer text-muted bg-primary text-white"> -->
            <!-- </div> -->
        </div>
    </div>
    
    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3">
        <?php 
        $data = '';
        $labels = '';

        $sql = "SELECT paymentStatus FROM serviceorder s"
                ." WHERE MONTH(s.dateReceveid) = ".date('m')." AND YEAR(s.dateReceveid) = ".date('Y')."" ;

        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        foreach ($stmt as $row) { 
            switch ($row['paymentStatus']){
                case 'A Receber':
                    $data ++;
                    break;        
                case 'Recebido':
                    $labels ++;
                    break;
            }
        }
        
        $data = trim($data,",");
        $labels = trim($labels,",");
        // echo 'A RECEBER: '.$data.'<br>RECEBIDO: '.$labels;

        $data = '['.$data.','.$labels.']';
        ?>
        <div class="card text-center border-success">
            <div class="card-header bg-success text-white">
                Recebidos/A Receber no mês de <?php echo utf8_encode(strftime('%B de %Y', strtotime($dateCurrent)))?>
            </div>
            <div class="card-body">
                <canvas id="chart2" height="200%">
                    <script>renderChart('chart2' ,<?php echo $data ?>, ['A Receber', 'Recebido'], 
                        'pie', '', ['#dc3545','#28a745'], '','' );</script>
                </canvas>
            </div>
        </div>
    </div>

</div>