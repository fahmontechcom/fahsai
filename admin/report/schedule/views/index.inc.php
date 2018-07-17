<?php
date_default_timezone_set('Asia/Bangkok');

require_once('../../../../models/ScheduleListModel.php');  

$path = "";  
 
$model_schedule_list = new ScheduleListModel;
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
if(!isset($_POST['action'])){  
    require_once($path.'view.inc.php');  
}
else if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){
    
}else if ($_POST['action'] == 'delete'){ 

}else if ($_POST['action'] == 'add'){ 
      
}else if ($_POST['action'] == 'edit'){ 

}else if ($_POST['action'] == 'search'){ 
    $schedule_list = $model_schedule_list->getScheduleListCustomerBy($start_date,$end_date);
    require_once($path.'view.inc.php'); 
}else{ 
    require_once($path.'view.inc.php'); 

}
?>