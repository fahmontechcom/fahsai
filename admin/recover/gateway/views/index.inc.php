<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/GatewayModel.php');  

$path = "";  
$model_gateway = new GatewayModel; 
 
$summit_gateway_id = $_POST['summit_gateway_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_gateway_id =json_decode($_POST['gateway_id']);
    for($i=0; $i < count($summit_gateway_id) ; $i++){
        $model_gateway->deleteGatewayByID($summit_gateway_id[$i]);
    } 
    $deleted = 1;
    $gateway = $model_gateway->getGatewayBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_gateway_id =json_decode($_POST['gateway_id']);
    for($i=0; $i < count($summit_gateway_id) ; $i++){
        $model_gateway->recoverGatewayByID($summit_gateway_id[$i]);
    } 
    $deleted = 1;
    $gateway = $model_gateway->getGatewayBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $gateway = $model_gateway->getGatewayBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>