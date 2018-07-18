<?php
date_default_timezone_set('Asia/Bangkok');
// require_once('../../../../models/InvoiceModel.php');
// require_once('../../../../models/InvoiceListModel.php');
// require_once('../../../../models/CustomerModel.php'); 
require_once('../../../../models/DebtModel.php'); 

$path = ""; 

// $model_invoice = new InvoiceModel;
// $model_invoice_list = new InvoiceListModel;
// $model_customer = new CustomerModel; 
$start_date = date('Y-m').'-01';
$end_date = date('Y-m').'-01';
$end_date = date('Y-m-d',strtotime($end_date . "+1 month"));
$end_date = date('Y-m-d',strtotime($end_date . "-1 days"));
$model_debt = new DebtModel; 

if($_POST['start_date']!=''&&$_POST['end_date']!=''){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date']; 
}
if(!isset($_POST['action'])){
    // $customer = $model_customer->getCustomerByID($customer_id); 
    // $invoice_list = $model_invoice_list ->getInvoiceListByInvoiceID($invoice_id);
    // $invoice = $model_invoice ->getInvoiceByID($invoice_id);  
    // $invoice_list_sum = $model_invoice_list ->getSumInvoiceListByInvoiceID($invoice_id);  
    // $debt = $model_debt ->getDebtAndCustomerBy();  
    // echo "------------end--------------";
    // echo "<pre>";
    // print_r($debt);
    // echo "</pre>";  
    require_once($path.'view.inc.php');  
}
else if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){

}else if ($_POST['action'] == 'search'){ 
    $debt = $model_debt ->getDebtAndCustomerByDate($start_date,$end_date);  
    require_once($path.'view.inc.php');  
}else{ 
    // $customer = $model_customer->getCustomerByID($customer_id); 
    // $invoice_list = $model_invoice_list ->getInvoiceListByInvoiceID($invoice_id);
    // $invoice = $model_invoice ->getInvoiceByID($invoice_id);  
    // $invoice_list_sum = $model_invoice_list ->getSumInvoiceListByInvoiceID($invoice_id);  
    // $debt = $model_debt ->getDebtAndCustomerBy();  
    // echo "------------end--------------";
    // echo "<pre>";
    // print_r($debt);
    // echo "</pre>";  
    require_once($path.'view.inc.php');  
}
?>