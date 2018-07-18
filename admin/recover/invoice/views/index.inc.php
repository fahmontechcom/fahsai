<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/InvoiceModel.php');  

$path = "";  
$model_invoice = new InvoiceModel; 

$invoice_id = $_POST['invoice_id'];
$summit_invoice_id = $_POST['summit_invoice_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_invoice_id =json_decode($_POST['invoice_id']);
    for($i=0; $i < count($summit_invoice_id) ; $i++){
        $model_invoice->deleteInvoiceByID($summit_invoice_id[$i]);
    } 
    $deleted = 1;
    $invoice = $model_invoice->getInvoiceBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_invoice_id =json_decode($_POST['invoice_id']);
    for($i=0; $i < count($summit_invoice_id) ; $i++){
        $model_invoice->recoverInvoiceByID($summit_invoice_id[$i]);
    } 
    $deleted = 1;
    $invoice = $model_invoice->getInvoiceBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $invoice = $model_invoice->getInvoiceBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>