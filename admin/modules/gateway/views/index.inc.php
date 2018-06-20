<?php
require_once('../models/GatewayModel.php');


$path = "modules/gateway/views/";

$model = new GatewayModel;

if(!isset($_GET['action'])){
    $debt_payment_geteway = $model->getGatewayBy();
    // echo "<script>console.log(".count($debt_payment_geteway).");</script>";
    require_once($path.'view.inc.php');

}
else if ($_GET['action'] == 'insert'){
    require_once($path.'insert.inc.php');

}else if ($_GET['action'] == 'update'){
    $debt_payment_geteway_id = $_GET['id'];
    $debt_payment_geteway = $model->getGatewayByID($debt_payment_geteway_id);
    echo "<script>console.log(".count($debt_payment_geteway).");</script>";
    require_once($path.'update.inc.php');

}else if ($_GET['action'] == 'delete'){
    $debt_payment_geteway = $model->deleteGatewayById($_GET['id']);
    ?>
    <script>window.location="index.php?content=gateway"</script>
    <?php

}else if ($_GET['action'] == 'add'){
    

        $data = [];
        $data['debt_payment_geteway_name'] = $_POST['debt_payment_geteway_name'];
        // echo "<script>console.log(".count($data).");</script>";
        $debt_payment_geteway = $model->insertGateway($data);

        if($debt_payment_geteway){
            ?>
            <script>window.location="index.php?content=gateway"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
    
}else if ($_GET['action'] == 'edit'){
    
        $data = [];
        $data['debt_payment_geteway_name'] = $_POST['debt_payment_geteway_name'];
        
        
        $debt_payment_geteway = $model->updateGatewayByID($_POST['debt_payment_geteway_id'],$data);

        if($debt_payment_geteway){
            ?>
            <script>window.location="index.php?content=gateway"</script>
            <?php
        }else{

            ?>
            <?php
        }
        
    

}
else{

    $debt_payment_geteway = $model->getGatewayBy($_GET['name'],$_GET['position'],$_GET['email']);
    require_once($path.'view.inc.php');

}
?>