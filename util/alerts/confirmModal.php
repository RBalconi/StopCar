<?php

$id = (isset($_POST['code'])) ? $_POST['code'] : 0 ;
$area = (isset($_POST['area'])) ? $_POST['area'] : '' ;

?>

<div class="modal fade" id="modalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Confirmar exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <p>Deseja mesmo excluir o item?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="deleteRegister(<?php echo $id.', \''.$area.'Delete.php\''?>)">Excluir</button>
            </div>
        </div>
    </div>
</div>