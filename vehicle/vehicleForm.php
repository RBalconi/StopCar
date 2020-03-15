<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

include('../util/urls.php');
include(urlBd); 
include(urlVerifyLogin);


$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;

try {
    $sql = "SELECT * FROM vehicle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $row = $stmt->fetch();
} catch(PDOException $e){

}
?>

<form method="post" id="formVehicle" name="formVehicle" onsubmit="return sendForm('formVehicle', '<?php echo urlVehicleRegisterEdit ?>'); ">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Salvar
            </button>
            <a class="btn btn-warning" onclick="clearAllInputs();">
                <i class='fas fa-eraser'></i> Limpar Campos
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
            <div class="form-group">
                <label for="">Código:</label>
                <input type="text" class="form-control" name="code" id="code" aria-describedby="helpId" placeholder="" value="<?php echo $row['id']; ?>" readonly >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-3">
            <div class="form-group">
                <label for="">Placa:</label>
                <input type="text" class="form-control" name="plate" id="plate" aria-describedby="helpId" placeholder="" value="<?php echo $row['plate']; ?>" required>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
            <div class="form-group">
                <label for="">Marca:</label>
                <input type="text" class="form-control" name="brand" id="brand" aria-describedby="helpId" placeholder="" value="<?php echo $row['brand']; ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-3">
            <div class="form-group">
                <label for="">Modelo:</label>
                <input type="text" class="form-control" name="model" id="model" aria-describedby="helpId" placeholder="" value="<?php echo $row['model']; ?>" required>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-3">
            <div class="form-group">
                <label for="">Ano:</label>
                <input type="number" class="form-control" name="year" id="year" aria-describedby="helpId" placeholder="" value="<?php echo $row['year']; ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="">Cor:</label>
                <input type="text" class="form-control" name="color" id="color" aria-describedby="helpId" placeholder="" value="<?php echo $row['color']; ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <div class="form-group">
                <label for="">Proprietário:</label>
                    <?php
                        $sql = "SELECT * FROM client WHERE active = 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                    ?>
                    <select class="form-control" name="owner" id="owner">
                        <?php foreach ($stmt as $row1) { ?>
                            <option value="<?php echo $row1['id']?>" <?php echo $row1['id'] == $row['owner'] ? ' selected="selected"' : '';?>><?php echo $row1['name']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>