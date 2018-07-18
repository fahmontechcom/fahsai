<?php
require_once('../models/StatusModel.php');


$path = "modules/status/views/";

$model = new StatusModel;

if(!isset($_GET['action'])){
    $debt_schedule_status = $model->getStatusBy();
    // echo "<script>console.log(".count($debt_schedule_status).");</script>";
    require_once($path.'view.inc.php');

}
else if ($_GET['action'] == 'insert'){
    require_once($path.'insert.inc.php');

}else if ($_GET['action'] == 'update'){
    $debt_schedule_status_id = $_GET['id'];
    $debt_schedule_status = $model->getStatusByID($debt_schedule_status_id);
    echo "<script>console.log(".count($debt_schedule_status).");</script>";
    require_once($path.'update.inc.php');

}else if ($_GET['action'] == 'delete'){
    // $debt_schedule_status = $model->deleteStatusById($_GET['id']);
    $debt_schedule_status = $model->deletedStatusByID($_GET['id'],$user[0][0]); 
    ?>
    <script>window.location="index.php?content=status"</script>
    <?php

}else if ($_GET['action'] == 'add'){
    

        $data = [];
        $data['debt_schedule_status_name'] = $_POST['debt_schedule_status_name'];
        // echo "<script>console.log(".count($data).");</script>";
        $debt_schedule_status = $model->insertStatus($data);

        if($debt_schedule_status){
            ?>
            <script>window.location="index.php?content=status"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
    
}else if ($_GET['action'] == 'edit'){
    
        $data = [];
        $data['debt_schedule_status_name'] = $_POST['debt_schedule_status_name'];
        
        
        $debt_schedule_status = $model->updateStatusByID($_POST['debt_schedule_status_id'],$data);

        if($debt_schedule_status){
            ?>
            <script>window.location="index.php?content=status"</script>
            <?php
        }else{

            ?>
            <?php
        }
        
    

}
else{

    $debt_schedule_status = $model->getStatusBy();
    // echo "<script>console.log(".count($debt_schedule_status).");</script>";
    require_once($path.'view.inc.php');

}
?>