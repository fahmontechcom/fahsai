<?php

require_once('../../../../models/PaymentModel.php');
require_once('../../../../models/GatewayModel.php'); 
require_once('../../../../models/DebtModel.php'); 

$path = "";

$model = new PaymentModel;
$model_gateway = new GatewayModel;
$model_debt = new DebtModel;

$debt_id=$_POST['debt_id'];
$debt_payment_id=$_POST['id'];

function payment_view($model,$model_gateway,$model_debt){
    $payment = $model->getPaymentBy($debt_id);  
    $gateway = $model_gateway->getGatewayBy(); 
    $debt = $model_debt->getDebtByID($debt_id); 
    require_once($path.'view.inc.php');
}
if(!isset($_POST['action'])){ 
    // echo $debt_id;
    payment_view($model,$model_gateway,$model_debt);

}
else if ($_POST['action'] == 'insert'){
    

}else if ($_POST['action'] == 'update'){ 
    

}else if ($_POST['action'] == 'delete'){
    $customer = $model->deletePaymentByID($_POST['id']); 
    $payment = $model->getPaymentBy($debt_id);  
    $gateway = $model_gateway->getGatewayBy(); 
    require_once($path.'view.inc.php');

}else if ($_POST['action'] == 'add'){ 
    $data = [];
    $data['debt_id'] = $_POST['debt_id'];
    $data['debt_payment_gateway_id'] = $_POST['debt_payment_gateway_id'];
    $data['debt_payment_pay'] = $_POST['debt_payment_pay'];
    $data['debt_payment_remark'] = $_POST['debt_payment_remark'];
    $data['debt_payment_date'] = 'NOW()'; 
    $check_result = $model->insertPayment($data);
    
    if($check_result){ 
        $gateway = $model_gateway->getGatewayBy(); 
        $payment = $model->getPaymentBy($debt_id);  
        require_once($path.'view.inc.php');
    }else{
        echo '0';
    }   
}else if ($_POST['action'] == 'edit'){ 
    $data = [];
    $data['debt_payment_gateway_id'] = $_POST['debt_payment_gateway_id'];
    $data['debt_payment_pay'] = $_POST['debt_payment_pay'];
    $data['debt_payment_remark'] = $_POST['debt_payment_remark']; 
    
    $check_result = $model->updatePaymentByID($debt_payment_id,$data);

    if($check_result){ 
        $payment = $model->getPaymentBy($debt_id);  
        $gateway = $model_gateway->getGatewayBy(); 
        require_once($path.'view.inc.php');
    }else{
 
    } 

}
else{ 
    payment_view($model,$model_gateway,$model_debt);
}
?>