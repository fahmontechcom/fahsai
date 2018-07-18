<?php
date_default_timezone_set('Asia/Bangkok'); 
$d1=date("d");
$d2=date("m");
$d3=date("Y");
$d4=date("h");
$d5=date("i");
$d6=date("s");
require_once('../../../../models/PaymentModel.php');  

$path = ""; 

$model_payment = new PaymentModel;

$start_date = date('Y-m').'-01';
$end_date = date('Y-m').'-01';
$end_date = date('Y-m-d',strtotime($end_date . "+1 month"));
$end_date = date('Y-m-d',strtotime($end_date . "-1 days")); 

if($_POST['start_date']!=''&&$_POST['end_date']!=''){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date']; 
}
$debt_payment_remark = $_POST['debt_payment_remark'];
if($_GET['start_date']!=''&&$_GET['end_date']!=''&&$_GET['debt_payment_remark']!=''){
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $debt_payment_remark = $_GET['debt_payment_remark']; 
}
if(!isset($_POST['action'])){  
    require_once($path.'view.inc.php');  
}
else if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){

}else if ($_POST['action'] == 'search'){ 

   $payment = $model_payment->getPaymentCustomerBy($start_date,$end_date);
   require_once($path.'view.inc.php'); 
 
}else{ 
    require_once($path.'view.inc.php'); 

}
?>