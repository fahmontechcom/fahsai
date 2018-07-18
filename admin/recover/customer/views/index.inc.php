<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/CustomerModel.php');  

$path = "";  
$model_customer = new CustomerModel; 

$customer_id = $_POST['customer_id'];
$summit_customer_id = $_POST['summit_customer_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_customer_id =json_decode($_POST['customer_id']);
    for($i=0; $i < count($summit_customer_id) ; $i++){
        $model_customer->deleteCustomerByID($summit_customer_id[$i]);
    } 
    $deleted = 1;
    $customer = $model_customer->getCustomerBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_customer_id =json_decode($_POST['customer_id']);
    for($i=0; $i < count($summit_customer_id) ; $i++){
        $model_customer->recoverCustomerByID($summit_customer_id[$i]);
    } 
    $deleted = 1;
    $customer = $model_customer->getCustomerBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $customer = $model_customer->getCustomerBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>