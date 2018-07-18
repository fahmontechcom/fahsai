<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/ScheduleModel.php');  

$path = "";  
$model_schedule = new ScheduleModel; 

$schedule_id = $_POST['schedule_id'];
$summit_schedule_id = $_POST['summit_schedule_id'];

if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

    $summit_schedule_id =json_decode($_POST['schedule_id']);
    for($i=0; $i < count($summit_schedule_id) ; $i++){
        $model_schedule->deleteScheduleByID($summit_schedule_id[$i]);
    } 
    $deleted = 1;
    $schedule = $model_schedule->getScheduleBy($deleted); 
    require_once($path.'view.inc.php');   

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){  

}else if ($_POST['action'] == 'recover'){  
    
    $summit_schedule_id =json_decode($_POST['schedule_id']);
    for($i=0; $i < count($summit_schedule_id) ; $i++){
        $model_schedule->recoverScheduleByID($summit_schedule_id[$i]);
    } 
    $deleted = 1;
    $schedule = $model_schedule->getScheduleBy($deleted); 
    require_once($path.'view.inc.php');   
}else{ 
    $deleted = 1;
    $schedule = $model_schedule->getScheduleBy($deleted); 
    require_once($path.'view.inc.php');   
}
?>