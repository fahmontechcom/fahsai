<?php
require_once('../models/ScheduleModel.php');
require_once('../models/StatusModel.php');


$path = "modules/schedule/views/";

$model = new ScheduleModel;
$model_status = new StatusModel;

if(!isset($_GET['action'])){
    $debt_id = $_GET['debt_id'];
    $customer_id = $_GET['customer_id'];
   
    // $schedule = $model->getScheduleBy();
    $debt_schedule_status = $model_status->getStatusBy();
    
    // echo "<script>console.log(".count($customer).");</script>";
    require_once($path.'view.inc.php');

}
else if ($_GET['action'] == 'insert'){
    ?>
    <script>window.location="index.php?content=customer"</script>
    <?php

}else if ($_GET['action'] == 'update'){
    
    $debt_schedule_id = $_GET['id'];
    $debt_id = $_GET['debt_id'];
    $customer_id = $_GET['customer_id'];
    $debt_schedule_status = $model_status->getStatusBy();
    $debt_schedule = $model->getScheduleByID($debt_schedule_id);
    
    require_once($path.'view.inc.php');    

}else if ($_GET['action'] == 'delete'){
    
    $debt_schedule_id = $_GET['id'];
    $customer_id = $_GET['customer_id'];
    $customer = $model->deleteScheduleByID($debt_schedule_id);
    ?>
        <script>window.location="index.php?content=customer&customer_id=<?php echo $customer_id;?>"</script>
    <?php

}else if ($_GET['action'] == 'add'){
    
        $customer_id = $_GET['customer_id'];
        $data = [];
        $data['debt_id'] = $_POST['debt_id'];
        $data['debt_schedule_status_id'] = $_POST['debt_schedule_status_id'];
        $data['debt_schedule_detail'] = $_POST['debt_schedule_detail'];
        $data['debt_schedule_remark'] = $_POST['debt_schedule_remark'];
        // echo "<script>console.log(".count($data).");</script>";
        $debt_schedule = $model->insertSchedule($data);

        if($debt_schedule){
            ?>
            
            <script>window.location="index.php?content=customer&customer_id=<?php echo $customer_id;?>"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
    
}else if ($_GET['action'] == 'edit'){
        $debt_schedule_id = $_GET['id'];
        $data = [];
        $data['debt_id'] = $_POST['debt_id'];
        $data['debt_schedule_status_id'] = $_POST['debt_schedule_status_id'];
        $data['debt_schedule_detail'] = $_POST['debt_schedule_detail'];
        $data['debt_schedule_remark'] = $_POST['debt_schedule_remark'];
        
        $debt_schedule = $model->updateScheduleByID($debt_schedule_id,$data);

        if($debt_schedule){
            ?>
                <script>window.location="index.php?content=customer&customer_id=<?php echo $_GET['customer_id'];?>"</script>
            <?php
        }else{

            ?>
            
            <?php
        }
        
    

}
else{

    $debt_id = $_GET['debt_id'];
    $customer_id = $_GET['customer_id'];
   
    // $schedule = $model->getScheduleBy();
    $debt_schedule_status = $model_status->getStatusBy();
    
    // echo "<script>console.log(".count($customer).");</script>";
    require_once($path.'view.inc.php');


}
?>