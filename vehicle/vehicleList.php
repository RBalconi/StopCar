<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

include('../util/urls.php');
include(urlBd); 
include(urlVerifyLogin);


$search_Vehicle = (!isset($_POST['search']))? '' : $_POST['search'];
$itens_page = (!isset($_POST['itensPage']))? 5 : intval($_POST['itensPage']);
$page = (!isset($_POST['page']))? 1 : intval($_POST['page']);
$begin = ($page - 1) * $itens_page;
$formated_Search_Vehicle = '%'.$search_Vehicle.'%';

if (empty($search_Vehicle) || $search_Vehicle == '') {
    $sql = "SELECT * FROM vehicle WHERE active = 1 ORDER BY plate LIMIT ?, ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(1, $begin, PDO::PARAM_INT);
    $stmt->bindParam(2, $itens_page, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT * FROM vehicle WHERE active = 1 ORDER BY plate";
    $stmt1 = $conn->prepare($sql); 
    $stmt1->execute();
    $number_of_rows = $stmt1->rowCount();

} else {
    $sql = "SELECT * FROM vehicle WHERE plate LIKE ? AND active = 1 ORDER BY plate LIMIT ?, ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(1, $formated_Search_Vehicle, PDO::PARAM_STR);
    $stmt->bindParam(2, $begin, PDO::PARAM_INT);
    $stmt->bindParam(3, $itens_page, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT * FROM vehicle WHERE plate LIKE ? AND active = 1 ORDER BY plate";
    $stmt1 = $conn->prepare($sql); 
    $stmt1->bindParam(1, $formated_Search_Vehicle, PDO::PARAM_STR);
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
            <td class="col-1 col-sm-1 col-lg-1 d-none d-md-block d-xl-block" ><?php echo $row['id']?></td>  
            <td class="col-6 col-sm-2 col-lg-1"><?php echo $row['plate']?></td>  
            <td class="col-6 col-sm-2 col-lg-2"><?php echo $row['brand']?></td>
            <td class="col-6 col-sm-2 col-lg-3 "><?php echo $row['model']?></td>
            <td class="col-2 col-sm-2 col-lg-2 d-none d-md-block d-xl-block"><?php echo $row['year']?></td>
            <td class="col-6 col-sm-3 col-lg-3"><?php echo $row['color']?></td>          
            <?php
                $sql = "SELECT * FROM client WHERE id = ?";
                $stmt1 = $conn->prepare($sql); 
                $stmt1->bindParam(1, $row['owner'], PDO::PARAM_INT);
                $stmt1->execute();
                $row1 = $stmt1->fetch();
            ?>
            <td class="col-12 col-sm-12 col-lg-3"><?php echo $row1['name']?></td>

            <td class="col-12 col-sm-12 col-lg-12 text-right">
                <button class="btn btn-warning" onclick="changeTab('form-tab'); insertDataEditForm(<?php echo $row['id'].', \''.urlVehicleForm.'\''?>);">
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
            <a class="page-link" id="<?php echo $page_previous;?>" onclick="changePage(<?php echo $page_previous.', '.$itens_page.', \''.$search_Vehicle.'\', \''.urlVehicleList.'\''?>)"><i class="fa fa-caret-left"></i></a>
        </li>  
        <?php 
        for ($i=1; $i < $num_page; $i++) { ?>
            <li class="page-item  <?php echo ($page == $i) ? 'active' : '' ;?>" aria-current="page">
                <a class="page-link" id="<?php echo $i;?>" onclick="changePage(this.id<?php echo ', '.$itens_page.', \''.$search_Vehicle.'\', \''.urlVehicleList.'\''?>)"><?php echo $i?></a>
            </li>
        <?php } ?>
        <li class="page-item <?php echo ($page_next == $num_page) ? 'disabled' : '' ;?>">
        <a class="page-link" id="<?php echo $page_next;?>" onclick="changePage(<?php echo $page_next.', '.$itens_page.', \''.$search_Vehicle.'\', \''.urlVehicleList.'\''?>)"><i class="fa fa-caret-right"></i></a>
        </li>  
    </ul>
</nav>
