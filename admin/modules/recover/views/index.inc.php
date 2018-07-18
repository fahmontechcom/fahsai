<?php
date_default_timezone_set('Asia/Bangkok');
require_once('../models/InvoiceModel.php');
require_once('../models/InvoiceListModel.php');
require_once('../models/CustomerModel.php');
require_once('../models/DebtModel.php');  
 
$path = "modules/recover/views/";

$model = new InvoiceModel;
$model_list = new InvoiceListModel;
$model_customer = new CustomerModel;
$model_debt = new DebtModel; 

$customer_id = $_POST['customer_id']; 
$invoice_id = $_POST['invoice_id'];  
if(!isset($_POST['action'])){  
    require_once($path.'view.inc.php'); 

}
else if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){ 

}else if ($_POST['action'] == 'delete'){ 

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else{ 
    require_once($path.'view.inc.php');  
}
?>