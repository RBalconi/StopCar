<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

include('../util/urls.php');
include(urlBd); 
include(urlVerifyLogin);

date_default_timezone_set('America/Sao_Paulo');

$view = false;

$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;
// $view = (isset($_POST['view'])) ? true : false ;

try {
    $sql = "SELECT * FROM serviceorder WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $row = $stmt->fetch();
} catch(PDOException $e){
}

if ($view) {

}
?>

<form method="post" id="formServiceOrder" name="formServiceOrder" onsubmit="return sendForm('formServiceOrder', '<?php echo urlServiceOrderRegisterEdit ?>'); ">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Salvar
            </button>
            <button class="btn btn-warning" onclick="clearAllInputs();">
                <i class='fas fa-eraser'></i> Limpar Campos
            </button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
            <div class="form-group">
                <label for="">Código:</label>
                <input type="text" class="form-control" name="code" id="code" aria-describedby="helpId" placeholder="" value="<?php echo $row['id']; ?>" readonly >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-9">
            <div class="form-group">
                <label for="">Título da Ordem de Serviço</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $row['title']; ?>" required>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="">Status:</label>
                <select class="form-control" name="status" id="status" onchange="statusOrderService()" required>
                    <option value="Aberto" <?php echo $row['status'] == 'Aberto' ? ' selected="selected"' : '';?> class="text-white bg-danger">Aberto</option>
                    <option value="Pendente" <?php echo $row['status'] == 'Pendente' ? ' selected="selected"' : '';?> class="text-white bg-warning">Pendente</option>
                    <option value="Concluido" <?php echo $row['status'] == 'Concluido' ? ' selected="selected"' : '';?> class="text-white bg-success">Concluído</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="">Cliente:</label>
                <?php
                    $sql = "SELECT * FROM client WHERE active = 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                ?>
                <select class="form-control" name="client" id="client" required>
                    <?php foreach ($stmt as $row1) { ?>
                        <option value="<?php echo $row1['id']?>" <?php echo $row1['id'] == $row['client'] ? ' selected="selected"' : '';?>><?php echo $row1['name']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="">Veículo:</label>
                <?php
                    // $sql = "SELECT * FROM vehicle WHERE active = 1";
                    $sql = "SELECT v.id as vid, v.plate, v.model, c.name FROM vehicle v INNER JOIN client c on v.owner = c.id WHERE v.active = 1 ORDER BY plate";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                ?>
                <select class="form-control" name="vehicle" id="vehicle" required>
                    <?php foreach ($stmt as $row1) { ?>
                        <option value="<?php echo $row1['vid']?>" <?php echo $row1['vid'] == $row['vehicle'] ? ' selected="selected"' : '';?>><?php echo $row1['plate'].' - '.$row1['model'].' - '.$row1['name']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label for="">Valor:</label>
                        <input type="text" class="form-control" name="price" id="price" value="<?php echo $row['price']; ?>" onkeydown="$(this).mask('000.000.000.000.000,00', {reverse: true});" required>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <label for="">Forma de Pagamento:</label>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input notClear" type="radio" name="radioPaymentType" id="radioMoney" value="Dinheiro" checked>
                                <label class="form-check-label" for="radioMoney">Dinheiro</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input notClear" type="radio" name="radioPaymentType" id="radioCheck" value="Cheque" <?php echo (!empty($row['paymentType']) && $row['paymentType'] == 'Cheque') ? 'checked' : ''?>>
                                <label class="form-check-label" for="radioCheck">Cheque</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input notClear" type="radio" name="radioPaymentType" id="radiobanktransfer" value="Depósito Bancário" <?php echo (!empty($row['paymentType']) && $row['paymentType'] == 'Depósito Bancário') ? 'checked' : ''?>>
                                <label class="form-check-label" for="radiobanktransfer">Depósito Bancário</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <label for="">Status do Pagamento:</label>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input notClear" type="radio" name="radioPaymentStatus" id="radioReceiver" value="A Receber" onclick="satatusDateReceveid();" checked>
                                <label class="form-check-label" for="radioReceiver">A Receber</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input notClear" type="radio" name="radioPaymentStatus" id="radioReceiveid" value="Recebido" onclick="satatusDateReceveid();" <?php echo (!empty($row['paymentStatus']) && $row['paymentStatus'] == 'Recebido') ? 'checked' : ''?>>
                                <label class="form-check-label" for="radioReceiveid">Recebido</label>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="col-12 col-sm-12 col-md-2 col-lg-3">
                    <div class="form-group">
                        <label for="">Data de Recebimento:</label>
                        <input type="date" class="form-control" name="dateReceveid" id="dateReceveid" 
                            value="<?php echo (!empty($row['dateReceveid']) && $row['dateReceveid'] != '0000-00-00') ? date("Y-m-d", strtotime($row['dateReceveid'])) : ''?>" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="">Data de Cadastro:</label>
                <input type="date" class="form-control notClear" name="dateRegister" id="dateRegister" 
                    value="<?php echo (!empty($row['dateRegister'])) ? date("Y-m-d", strtotime($row['dateRegister'])) : date('Y-m-d')?>" readonly>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="">Data Prevista de Conclusão:</label>
                <input type="date" class="form-control" min="<?php echo date('Y-m-d');?>" name="dateExpectedCompleted" id="dateExpectedCompleted" value="<?php echo $row['dateExpectedCompleted']?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="">Data de Conclusão:</label>
                <input type="date" class="form-control" name="dateCompleted" id="dateCompleted" 
                    value="<?php echo (!empty($row['dateCompleted']) && $row['dateCompleted'] != '0000-00-00') ? date("Y-m-d", strtotime($row['dateCompleted'])) : ''?>" readonly>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label for="">Detalhes da Ordem de Serviço:</label>
                <textarea class="form-control" name="detail" id="detail" rows="5"><?php echo $row['detail']?></textarea>
            </div>
        </div>
        
    </div>
</form>