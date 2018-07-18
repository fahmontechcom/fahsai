<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/DebtModel.php');  

$path = "";  
$model_debt = new DebtModel; 

$debt_id = $_POST['debt_id'];
$summit_debt_id = $_POST['summit_debt_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_debt_id =json_decode($_POST['debt_id']);
    for($i=0; $i < count($summit_debt_id) ; $i++){
        $model_debt->deleteDebtByID($summit_debt_id[$i]);
    } 
    $deleted = 1;
    $debt = $model_debt->getDebtAllBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_debt_id =json_decode($_POST['debt_id']);
    for($i=0; $i < count($summit_debt_id) ; $i++){
        $model_debt->recoverDebtByID($summit_debt_id[$i]);
    } 
    $deleted = 1;
    $debt = $model_debt->getDebtAllBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $debt = $model_debt->getDebtAllBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>