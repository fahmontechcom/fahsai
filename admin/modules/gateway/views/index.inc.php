<?php
require_once('../models/GatewayModel.php');


$path = "modules/gateway/views/";

$model = new GatewayModel;

if(!isset($_GET['action'])){
    $debt_payment_gateway = $model->getGatewayBy();
    // echo "<script>console.log(".count($debt_payment_gateway).");</script>";
    require_once($path.'view.inc.php');

}
else if ($_GET['action'] == 'insert'){
    require_once($path.'insert.inc.php');

}else if ($_GET['action'] == 'update'){
    $debt_payment_gateway_id = $_GET['id'];
    $debt_payment_gateway = $model->getGatewayByID($debt_payment_gateway_id);
    echo "<script>console.log(".count($debt_payment_gateway).");</script>";
    require_once($path.'update.inc.php');

}else if ($_GET['action'] == 'delete'){
    // $debt_payment_gateway = $model->deleteGatewayById($_GET['id']);
    $debt_payment_gateway = $model->deletedGatewayByID($_GET['id'],$user[0][0]); 
    ?>
    <script>window.location="index.php?content=gateway"</script>
    <?php

}else if ($_GET['action'] == 'add'){
    

        $data = [];
        $data['debt_payment_gateway_name'] = $_POST['debt_payment_gateway_name'];
        // echo "<script>console.log(".count($data).");</script>";
        $debt_payment_gateway = $model->insertGateway($data);

        if($debt_payment_gateway){
            ?>
            <script>window.location="index.php?content=gateway"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
    
}else if ($_GET['action'] == 'edit'){
    
        $data = [];
        $data['debt_payment_gateway_name'] = $_POST['debt_payment_gateway_name'];
        
        
        $debt_payment_gateway = $model->updateGatewayByID($_POST['debt_payment_gateway_id'],$data);

        if($debt_payment_gateway){
            ?>
            <script>window.location="index.php?content=gateway"</script>
            <?php
        }else{

            ?>
            <?php
        }
        
    

}
else{

    $debt_payment_gateway = $model->getGatewayBy($_GET['name'],$_GET['position'],$_GET['email']);
    require_once($path.'view.inc.php');

}
?>