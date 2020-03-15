<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 

include('../util/urls.php');
include(urlBd); 
include(urlVerifyLogin);

date_default_timezone_set('America/Sao_Paulo');


$search_ServiceOrder = (!isset($_POST['search']))? '' : $_POST['search'];
$itens_page = (!isset($_POST['itensPage']))? 5 : intval($_POST['itensPage']);
$page = (!isset($_POST['page']))? 1 : intval($_POST['page']);
$begin = ($page - 1) * $itens_page;
$formated_Search_ServiceOrder = '%'.$search_ServiceOrder.'%';

if (empty($search_ServiceOrder) || $search_ServiceOrder == '') {
    $sql = "SELECT * FROM serviceorder WHERE active = 1 ORDER BY dateRegister LIMIT ?, ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(1, $begin, PDO::PARAM_INT);
    $stmt->bindParam(2, $itens_page, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT * FROM serviceorder WHERE active = 1 ORDER BY dateRegister";
    $stmt1 = $conn->prepare($sql); 
    $stmt1->execute();
    $number_of_rows = $stmt1->rowCount();

} else {
    $sql = "SELECT * FROM serviceorder AS s JOIN vehicle AS v ON s.vehicle = v.id WHERE v.plate LIKE ? AND s.active = 1 ORDER BY dateRegister LIMIT ?, ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(1, $formated_Search_ServiceOrder, PDO::PARAM_STR);
    $stmt->bindParam(2, $begin, PDO::PARAM_INT);
    $stmt->bindParam(3, $itens_page, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT * FROM serviceorder AS s JOIN vehicle AS v ON s.vehicle = v.id WHERE v.plate LIKE ? AND s.active = 1 ORDER BY dateRegister";
    $stmt1 = $conn->prepare($sql); 
    $stmt1->bindParam(1, $formated_Search_ServiceOrder, PDO::PARAM_STR);
    $stmt1->execute();
    $number_of_rows = $stmt1->rowCount();
}

$num_page = ($number_of_rows > 0) ? ceil($number_of_rows/$itens_page) : 0 ;
$num_page ++;
?>

<?php
if ($num_page == 0 ) {
?>
<p class="text-center">Nenhum dado encontrado!</p>

<?php
}
?>

<table class="table table-striped ">
    <tbody>
        <?php foreach ($stmt as $row) { ?>
        <tr class="row">
            <?php 
            $colorStatus = '';
            switch ($row['status']) {
                case 'Aberto':
                    $colorStatus = 'bg-danger text-white text-center';
                    break;
                
                case 'Pendente':
                $colorStatus = 'bg-warning text-center'; //text-white
                    break;
                
                case 'Concluido':
                $colorStatus = 'bg-success text-white text-center';
                    break;
            }
            $colorReceveid = '';
            switch ($row['paymentStatus']) {
                case 'A Receber':
                    $colorReceveid = 'bg-danger text-white text-center';
                    break;
                                
                case 'Recebido':
                $colorReceveid = 'bg-success text-white text-center';
                    break;
            }
            ?>
            <td class="col-6 col-sm-3 col-lg-2 <?php echo $colorStatus;?>"><?php echo $row['status']?></td>
            <td class="col-6 col-sm-3 col-lg-2 <?php echo $colorReceveid;?>"><?php echo $row['paymentStatus']?></td>

            <!-- <td class="col-1 col-sm-1 col-lg-1 d-none d-md-block d-xl-block" ><?php //echo $row['id']?></td>   -->
            <td class="col-12 col-sm-8 col-lg-8"><?php echo $row['title']?></td>  

            <?php
                $sql = "SELECT * FROM client WHERE id = ?";
                $stmt1 = $conn->prepare($sql);
                $stmt1->bindParam(1, $row['client'], PDO::PARAM_INT);
                $stmt1->execute();
                $row1 = $stmt1->fetch();
            ?>
            <td class="col-12 col-sm-6 col-lg-6"><?php echo $row1['name']?></td>
            <?php
                $sql = "SELECT * FROM vehicle WHERE id = ?";
                $stmt1 = $conn->prepare($sql);
                $stmt1->bindParam(1, $row['vehicle'], PDO::PARAM_INT);
                $stmt1->execute();
                $row1 = $stmt1->fetch();
            ?>
            <td class="col-6 col-sm-3 col-lg-4"><?php echo $row1['plate'] .' - '.$row1['model']?></td>            
            <td class="col-6 col-sm-3 col-lg-2"><?php echo (!empty($row['dateCompleted']) && $row['dateCompleted'] != '0000-00-00') ? '<p class="title-td">Data de Conclusão:</p>'.date("d/m/Y", strtotime($row['dateCompleted'])) : ''?></td>
            
            <td class="col-6 col-sm-4 col-lg-4">R$ <?php echo $row['price']?></td>
            <td class="col-6 col-sm-5 col-lg-6"><?php echo $row['paymentType']?></td>
            <td class="col-6 col-sm-3 col-lg-2"><?php echo (!empty($row['dateReceveid']) && $row['dateReceveid'] != '0000-00-00') ? '<p class="title-td">Data de Recebimento:</p>'.date("d/m/Y", strtotime($row['dateReceveid'])) : ''?></td>
            

            <td class="col-12 col-sm-12 col-lg-12 text-right">
                <button class="btn btn-primary" onclick="changeTab('form-tab'); insertDataEditForm(<?php echo $row['id'].', \''.urlServiceOrderForm.'\''?>, true);">
                    <i class="fa fa-eye"></i> Visualizar
                </button>
                <button class="btn btn-warning" onclick="changeTab('form-tab'); insertDataEditForm(<?php echo $row['id'].', \''.urlServiceOrderForm.'\''?>);">
                    <i class="fa fa-edit"></i> Editar
                </button>
                <button class="btn btn-danger" onclick="openModal(<?php echo $row['id']?>)">
                    <i class="fa fa-trash"></i> Deletar
                </button>
            </td>
        </tr>              
        <?php }?>
    </tbody>
</table>
<?php
    $page_previous = $page - 1;
    $page_next = $page + 1;
?>
<nav aria-label="..." >
    <ul class="pagination justify-content-center">  
        <li class="page-item <?php echo ($page_previous == 0) ? 'disabled' : '' ;?>">
            <a class="page-link" id="<?php echo $page_previous;?>" onclick="changePage(<?php echo $page_previous.', '.$itens_page.', \''.$search_ServiceOrder.'\', \''.urlServiceOrderList.'\''?>)"><i class="fa fa-caret-left"></i></a>
        </li>  
        <?php 
        for ($i=1; $i < $num_page; $i++) { ?>
            <li class="page-item  <?php echo ($page == $i) ? 'active' : '' ;?>" aria-current="page">
                <a class="page-link" id="<?php echo $i;?>" onclick="changePage(this.id<?php echo ', '.$itens_page.', \''.$search_ServiceOrder.'\', \''.urlServiceOrderList.'\''?>)"><?php echo $i?></a>
            </li>
        <?php } ?>
        <li class="page-item <?php echo ($page_next == $num_page) ? 'disabled' : '' ;?>">
        <a class="page-link" id="<?php echo $page_next;?>" onclick="changePage(<?php echo $page_next.', '.$itens_page.', \''.$search_ServiceOrder.'\', \''.urlServiceOrderList.'\''?>)"><i class="fa fa-caret-right"></i></a>
        </li>  
    </ul>
</nav>
