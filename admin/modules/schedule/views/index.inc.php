<?php
require_once('../models/ScheduleModel.php');
require_once('../models/ScheduleListModel.php');
require_once('../models/StatusModel.php');
require_once('../models/CustomerModel.php');


$path = "modules/schedule/views/";

$model = new ScheduleModel;
$model_schedule_list = new ScheduleListModel;
$model_status = new StatusModel;
$model_customer = new CustomerModel;

$debt_schedule_id = $_GET['id'];
$debt_id = $_GET['debt_id'];
$customer_id = $_GET['customer_id'];
$modal_id = $_GET['modal_id'];

if(!isset($_GET['action'])){ 
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
    $debt_schedule_status = $model_status->getStatusBy();
    $debt_schedule = $model->getScheduleByID($debt_schedule_id);
    $schedule_list = $model_schedule_list->getScheduleListBy($debt_schedule_id);

    $customer = $model_customer->getCustomerByID($customer_id);
    $debt_schedule = $model->getScheduleByID($debt_schedule_id); 
    require_once($path.'view.inc.php');    

}else if ($_GET['action'] == 'delete'){ 

    // $customer = $model->deleteScheduleByID($debt_schedule_id);
    $customer = $model->deletedScheduleByID($debt_schedule_id,$user[0][0]); 
    ?>
        <script>window.location="index.php?content=customer&customer_id=<?php echo $customer_id;?>"</script>
    <?php

}else if ($_GET['action'] == 'add'){ 

        $data = [];
        $data['debt_id'] = $_POST['debt_id'];
        $data['debt_schedule_status_id'] = $_POST['debt_schedule_status_id'];
        $data['debt_schedule_detail'] = $_POST['debt_schedule_detail'];
        $data['debt_schedule_remark'] = $_POST['debt_schedule_remark'];
        
        $debt_schedule_id = $model->insertSchedule($data);

        


        if($debt_schedule_id > 0){
            ?>
            
            <!-- <script>window.location="index.php?content=customer&customer_id=<?php echo $customer_id;?>"</script> -->
            <script>window.location="index.php?content=schedule&action=update&customer_id=<?php echo $customer_id;?>&debt_id=<?php echo $_POST['debt_id'];?>&id=<?php echo $debt_schedule_id;?>"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
}else if ($_GET['action'] == 'edit'){ 
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
    // $schedule = $model->getScheduleBy();
    $debt_schedule_status = $model_status->getStatusBy();
    
    // echo "<script>console.log(".count($customer).");</script>";
    require_once($path.'view.inc.php');


}
?>