<?php
require_once('../models/SaleModel.php');


$path = "modules/sale/views/";

$model = new SaleModel;

if(!isset($_GET['action'])){
    $sale = $model->getSaleBy();
    // echo "<script>console.log(".count($sale).");</script>";
    require_once($path.'view.inc.php');

}
else if ($_GET['action'] == 'insert'){
    require_once($path.'insert.inc.php');

}else if ($_GET['action'] == 'update'){
    $sale_id = $_GET['id'];
    $sale = $model->getSaleByID($sale_id);
    require_once($path.'update.inc.php');

}else if ($_GET['action'] == 'delete'){
    $sale = $model->deleteSaleById($_GET['id']);
    ?>
    <script>window.location="index.php?content=sale"</script>
    <?php

}else if ($_GET['action'] == 'add'){
    

        $data = [];
        $data['sale_firstname'] = $_POST['sale_firstname'];
        $data['sale_lastname'] = $_POST['sale_lastname'];
        $data['sale_telephone'] = $_POST['sale_telephone'];
        $data['sale_email'] = $_POST['sale_email'];
        $data['sale_address'] = $_POST['sale_address'];
        // echo "<script>console.log(".count($data).");</script>";
        $sale = $model->insertSale($data);

        if($sale){
            ?>
            <script>window.location="index.php?content=sale"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
    
}else if ($_GET['action'] == 'edit'){
    
        $data = [];
        $data['sale_firstname'] = $_POST['sale_firstname'];
        $data['sale_lastname'] = $_POST['sale_lastname'];
        $data['sale_telephone'] = $_POST['sale_telephone'];
        $data['sale_email'] = $_POST['sale_email'];
        $data['sale_address'] = $_POST['sale_address'];
        
        $sale = $model->updateSaleByID($_POST['sale_id'],$data);

        if($sale){
            ?>
            <script>window.location="index.php?content=sale"</script>
            <?php
        }else{

            ?>
            <?php
        }
        
    

}
else{

    $sale = $model->getSaleBy($_GET['name'],$_GET['position'],$_GET['email']);
    require_once($path.'view.inc.php');

}
?>