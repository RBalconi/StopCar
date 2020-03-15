<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

include('../util/urls.php');
include(urlBd); 
include(urlVerifyLogin);


$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;

try {
    $sql = "SELECT * FROM client WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $row = $stmt->fetch();
} catch(PDOException $e){

}
?>

<form method="post" id="formClient" name="formClient" onsubmit="return sendForm('formClient', '<?php echo urlClientRegisterEdit ?>'); ">
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
        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <div class="form-group">
                <label for="">Nome:</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="" value="<?php echo $row['name']; ?>" required>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-4">
            <div class="form-group">
                <label for="">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" aria-describedby="helpId" placeholder="" value="<?php echo $row['cpf']; ?>" onkeydown="$(this).mask('000.000.000-00', {reverse: true});">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-6">
            <div class="form-group">
                <label for="">Endereço:</label>
                <input type="text" class="form-control" name="address" id="address" aria-describedby="helpId" placeholder="" value="<?php echo $row['address']; ?>" required>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-2">
            <div class="form-group">
                <label for="">Número:</label>
                <input type="number" class="form-control" name="number" id="number" aria-describedby="helpId" placeholder="" value="<?php echo $row['number']; ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <div class="form-group">
                <label for="">Complemento:</label>
                <input type="text" class="form-control" name="complement" id="complement" aria-describedby="helpId" placeholder="" value="<?php echo $row['complement']; ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="">Bairro:</label>
                <input type="text" class="form-control" name="district" id="district" aria-describedby="helpId" placeholder="" value="<?php echo $row['district']; ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="">Cidade:</label>
                <input type="text" class="form-control" name="city" id="city" aria-describedby="helpId" placeholder="" value="<?php echo $row['city']; ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="">Estado:</label>
                <!-- <input type="text" class="form-control" name="state" id="state" aria-describedby="helpId" placeholder="" value="<?php //echo $row['state']; ?>">  -->
                <div class="form-group">
                    <select class="form-control" id="state" name="state">
                        <option value="AC" <?php echo $row['state'] == 'AC' ? ' selected="selected"' : '';?>>Acre</option>
                        <option value="AL" <?php echo $row['state'] == 'AL' ? ' selected="selected"' : '';?>>Alagoas</option>
                        <option value="AP" <?php echo $row['state'] == 'AP' ? ' selected="selected"' : '';?>>Amapá</option>
                        <option value="AM" <?php echo $row['state'] == 'AM' ? ' selected="selected"' : '';?>>Amazonas</option>
                        <option value="BA" <?php echo $row['state'] == 'BA' ? ' selected="selected"' : '';?>>Bahia</option>
                        <option value="CE" <?php echo $row['state'] == 'CE' ? ' selected="selected"' : '';?>>Ceará</option>
                        <option value="DF" <?php echo $row['state'] == 'DF' ? ' selected="selected"' : '';?>>Distrito Federal</option>
                        <option value="ES" <?php echo $row['state'] == 'ES' ? ' selected="selected"' : '';?>>Espírito Santo</option>
                        <option value="GO" <?php echo $row['state'] == 'GO' ? ' selected="selected"' : '';?>>Goiás</option>
                        <option value="MA" <?php echo $row['state'] == 'MA' ? ' selected="selected"' : '';?>>Maranhão</option>
                        <option value="MT" <?php echo $row['state'] == 'MT' ? ' selected="selected"' : '';?>>Mato Grosso</option>
                        <option value="MS" <?php echo $row['state'] == 'MS' ? ' selected="selected"' : '';?>>Mato Grosso do Sul</option>
                        <option value="MG" <?php echo $row['state'] == 'MG' ? ' selected="selected"' : '';?>>Minas Gerais</option>
                        <option value="PA" <?php echo $row['state'] == 'PA' ? ' selected="selected"' : '';?>>Pará</option>
                        <option value="PB" <?php echo $row['state'] == 'PB' ? ' selected="selected"' : '';?>>Paraíba</option>
                        <option value="PR" <?php echo $row['state'] == 'PR' ? ' selected="selected"' : '';?>>Paraná</option>
                        <option value="PE" <?php echo $row['state'] == 'PE' ? ' selected="selected"' : '';?>>Pernambuco</option>
                        <option value="PI" <?php echo $row['state'] == 'PI' ? ' selected="selected"' : '';?>>Piauí</option>
                        <option value="RJ" <?php echo $row['state'] == 'RJ' ? ' selected="selected"' : '';?>>Rio de Janeiro</option>
                        <option value="RN" <?php echo $row['state'] == 'RN' ? ' selected="selected"' : '';?>>Rio Grande do Norte</option>
                        <option value="RS" <?php echo $row['state'] == 'RS' ? ' selected="selected"' : '';?>>Rio Grande do Sul</option>
                        <option value="RO" <?php echo $row['state'] == 'RO' ? ' selected="selected"' : '';?>>Rondônia</option>
                        <option value="RR" <?php echo $row['state'] == 'RR' ? ' selected="selected"' : '';?>>Roraima</option>
                        <option value="SC" <?php echo $row['state'] == 'SC' ? ' selected="selected"' : '';?>>Santa Catarina</option>
                        <option value="SP" <?php echo $row['state'] == 'SP' ? ' selected="selected"' : '';?>>São Paulo</option>
                        <option value="SE" <?php echo $row['state'] == 'SE' ? ' selected="selected"' : '';?>>Sergipe</option>
                        <option value="TO" <?php echo $row['state'] == 'TO' ? ' selected="selected"' : '';?>>Tocantins</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
            <div class="form-group">
                <label for="">CEP:</label>
                <input type="text" class="form-control" name="zipcode" id="zipecode" aria-describedby="helpId" placeholder="" value="<?php echo $row['zipcode']; ?>" onkeydown="$(this).mask('00.000-000', {reverse: true});">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="">Telefone:</label>
                <input type="text" class="form-control" name="telephone" id="telephone" aria-describedby="helpId" placeholder="" value="<?php echo $row['telephone']; ?>"  onkeydown="$(this).mask('(00) 0000-0000');" required>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="">Celular:</label>
                <input type="text" class="form-control" name="cellphone" id="cellphone" aria-describedby="helpId" placeholder="" value="<?php echo $row['cellphone']; ?>"  onkeydown="$(this).mask('(00) 00000-0000');">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="">E-mail:</label>
                <input type="text" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="" value="<?php echo $row['email']; ?>">
            </div>
        </div>
    </div>
</form>