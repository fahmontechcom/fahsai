<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/UserModel.php');  

$path = "";  
$model_user = new UserModel; 
 
$summit_user_id = $_POST['summit_user_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_user_id =json_decode($_POST['user_id']);
    for($i=0; $i < count($summit_user_id) ; $i++){
        $model_user->deleteUserByID($summit_user_id[$i]);
    } 
    $deleted = 1;
    $user = $model_user->getUserBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_user_id =json_decode($_POST['user_id']);
    for($i=0; $i < count($summit_user_id) ; $i++){
        $model_user->recoverUserByID($summit_user_id[$i]);
    } 
    $deleted = 1;
    $user = $model_user->getUserBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $user = $model_user->getUserBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>