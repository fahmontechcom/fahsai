<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/SaleModel.php');  

$path = "";  
$model_sale = new SaleModel; 

$sale_id = $_POST['sale_id'];
$summit_sale_id = $_POST['summit_sale_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_sale_id =json_decode($_POST['sale_id']);
    for($i=0; $i < count($summit_sale_id) ; $i++){
        $model_sale->deleteSaleByID($summit_sale_id[$i]);
    } 
    $deleted = 1;
    $sale = $model_sale->getSaleBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_sale_id =json_decode($_POST['sale_id']);
    for($i=0; $i < count($summit_sale_id) ; $i++){
        $model_sale->recoverSaleByID($summit_sale_id[$i]);
    } 
    $deleted = 1;
    $sale = $model_sale->getSaleBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $sale = $model_sale->getSaleBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>