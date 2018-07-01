<?php
require_once('../models/NotificationModel.php');


$path = "modules/notification/views/";

$model = new NotificationModel;

if(!isset($_GET['action'])){
    $user = $_SESSION['user'];
    $notification = $model->getNotificationBy($user[0][0]);
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
    

        $data = [];
        $data['notification_name'] = $_POST['notification_name'];
        // echo "<script>console.log(".count($data).");</script>";
        $notification = $model->insertNotification($data);

        if($notification){
            ?>
            <script>window.location="index.php?content=notification"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
    
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