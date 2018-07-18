<?php
date_default_timezone_set('Asia/Bangkok');
require_once('../models/NotificationModel.php');
require_once('../models/UserModel.php');
require_once('../models/ScheduleListModel.php');


$path = "modules/notification/views/";

$model = new NotificationModel;
$model_user = new UserModel;
$model_schedule_list = new ScheduleListModel;

$today=date('Y-m-d');
$display_today=date('d-m-Y');
$today_arr = explode("-",date('d-m-Y'));
        $day = $schedule_list_date[2];
        $month= $schedule_list_date[1];
        $year= $schedule_list_date[0];
$display_today = $day.'-'.$month.'-'.$year;

if(!isset($_GET['action'])){
    $user = $_SESSION['user'];
    $notification = $model->getNotificationByUserID($user[0][0],date('Y-m-d'));
    // echo "<script>console.log(".count($notification).");</script>";
    require_once($path.'view.inc.php');

}
else if ($_GET['action'] == 'insert'){
    require_once($path.'insert.inc.php');

}else if ($_GET['action'] == 'update'){
    $notification_id = $_GET['id'];
    $notification = $model->getNotificationByID($notification_id);
    echo "<script>console.log(".count($notification).");</script>";
    require_once($path.'update.inc.php');

}else if ($_GET['action'] == 'delete'){
    $notification = $model->deleteNotificationById($_GET['id']);
    ?>
    <script>window.location="index.php?content=notification"</script>
    <?php

}else if ($_GET['action'] == 'add'){  
    
}else if ($_GET['action'] == 'edit'){
    
        $data = [];
        $data['notification_name'] = $_POST['notification_name'];
        
        
        $notification = $model->updateNotificationByID($_POST['notification_id'],$data);

        if($notification){
            ?>
            <script>window.location="index.php?content=notification"</script>
            <?php
        }else{

            ?>
            <?php
        }
        
    

}
else{

    $notification = $model->getNotificationBy($_GET['name'],$_GET['position'],$_GET['email']);
    require_once($path.'view.inc.php');

}
?>