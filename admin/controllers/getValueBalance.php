<?php 
// header('Access-Control-Allow-Origin: *');  
// header("Access-Control-Allow-Methods: *");
// header("Content-Type: application/json; charset=UTF-8");

require_once('../../models/PaymentModel.php');
require_once('../../models/DebtModel.php');
$model_value_balance = new PaymentModel;
$model_debt = new DebtModel;
$value_balance = $model_value_balance->getLastPaymentBy($_POST['debt_id']);
$debt = $model_debt->getDebtByID($_POST['debt_id']); 
if($value_balance['debt_payment_value_balance']!=''){
    echo number_format($value_balance['debt_payment_value_balance'], 2, '.', ','); 
}else{
    echo number_format($debt['debt_value'], 2, '.', ',');
}
?>