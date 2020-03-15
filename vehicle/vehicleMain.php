<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

include('../util/urls.php');
include(urlBd); 
include(urlVerifyLogin);


?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Cadastros</li>
        <li class="breadcrumb-item active" aria-current="page">Veículos</li>
    </ol>
</nav>
<!-- Includes via Ajax -->
<div id="modal"></div>
<div id="alert"></div>

<!-- *Tabs* -->
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active a-black" id="a-list-tab" data-toggle="tab" href="#list-tab" role="tab" aria-controls="list-tab" aria-selected="true" onclick="clearAllInputs();">Lista</a>
    </li>
    <li class="nav-item">
        <a class="nav-link a-black" id="a-form-tab" data-toggle="tab" href="#form-tab" role="tab" aria-controls="form-tab" aria-selected="false" onclick="clearAllInputs(); <?php echo '\''.urlVehicleList.'\''?>;">Cadastrar</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <!-- Tab "Lista" -->
    <div class="tab-pane active" id="list-tab" role="tabpanel" aria-labelledby="list-tab">
        <!-- <div class="container"> -->
            <br>
            <form action="" class="row" >
                <div class="col-8">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Pesquisar veículo por placa" id="inputSearch" name="inputSearch" >
                    </div>
                </div>                    
                <div class="col-4">                                        
                    <div class="form-group">
                        <select class="form-control" name="selectItens" id="selectItens">
                            <option value="5">5 por página</option>
                            <option value="10">10 por página</option>
                            <option value="30">30 por página</option>
                            <option value="50">50 por página</option>                                                
                        </select>
                    </div>
                </div>
            </form>
            <div class="col-12">
                <div id="list"></div>
            </div>
        <!-- </div> -->
    </div>

<?php

?>
    <!-- Tab "Cadastrar" -->
    <div class="tab-pane" id="form-tab" role="tabpanel" aria-labelledby="form-tab">
        <br>
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col-12">
                    <div id="form"></div>
                </div>
            </div>
        <!-- </div> -->
    </div>
</div>
