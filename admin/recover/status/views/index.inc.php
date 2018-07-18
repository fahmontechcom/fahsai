<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/StatusModel.php');  

$path = "";  
$model_status = new StatusModel; 
 
$summit_status_id = $_POST['summit_status_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_status_id =json_decode($_POST['status_id']);
    for($i=0; $i < count($summit_status_id) ; $i++){
        $model_status->deleteStatusByID($summit_status_id[$i]);
    } 
    $deleted = 1;
    $status = $model_status->getStatusBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_status_id =json_decode($_POST['status_id']);
    for($i=0; $i < count($summit_status_id) ; $i++){
        $model_status->recoverStatusByID($summit_status_id[$i]);
    } 
    $deleted = 1;
    $status = $model_status->getStatusBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $status = $model_status->getStatusBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>