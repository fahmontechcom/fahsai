<?php
date_default_timezone_set('Asia/Bangkok');
require_once('../../../../models/ChargeModel.php');
require_once('../../../../models/SaleModel.php');
require_once('../../../../models/StatusModel.php');
require_once('../../../../models/DebtModel.php');


$path = "";

$model = new ChargeModel;
$model_sale = new SaleModel;
$model_status = new StatusModel;
$model_debt = new DebtModel;
$customer_id=$_POST['customer_id'];
$debt_payment_charge_id=$_POST['id'];
$debt_id=$_POST['debt_id'];

if(!isset($_POST['action'])){
    $debts = $model_debt->getDebtByID($debt_id);
    $charge = $model->getChargeBy($debt_id);
    require_once($path.'view.inc.php');

}
else if ($_POST['action'] == 'insert'){
 
}else if ($_POST['action'] == 'update'){

}else if ($_POST['action'] == 'delete'){
    $check_result = $model->deleteChargeByID($debt_payment_charge_id);
    
    $debts = $model_debt->getDebtByID($debt_id);
    $charge = $model->getChargeBy($debt_id);
    require_once($path.'view.inc.php');
    

}else if ($_POST['action'] == 'add'){
     
    $data = [];
    $data['debt_id'] = $_POST['debt_id'];
    $data['debt_payment_charge_detail'] = $_POST['debt_payment_charge_detail'];
    $data['debt_payment_charge_amount'] = $_POST['debt_payment_charge_amount'];
    $data['debt_payment_charge_date'] = $_POST['debt_payment_charge_date'];
    // echo "------------end--------------";
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    // echo "<script>alert('');</script>";
    $check_charge = $model->getChargeBy($debt_id); 
    if(count($check_charge)<=0){ 

        $check_result = $model->insertCharge($data);

        if($check_result){
            $debts = $model_debt->getDebtByID($debt_id);
            $charge = $model->getChargeBy($debt_id);
            require_once($path.'view.inc.php');
        }else{
            echo '0';
        }

    }else{
        $last_charge = $model->getLastChargeBy($debt_id); 
        $old_date=date_create($last_charge['debt_payment_charge_date']);//วันก่อนหน้า
        $new_date=date_create($_POST['debt_payment_charge_date']);//วันที่
        if($old_date<=$new_date){

            $check_result = $model->insertCharge($data);

            if($check_result){
                $debts = $model_debt->getDebtByID($debt_id);
                $charge = $model->getChargeBy($debt_id);
                require_once($path.'view.inc.php');
            }else{
                echo '0';
            }

        }else{
            echo '1';
        }
    }
    
    
    
}else if ($_POST['action'] == 'edit'){
    
    $data = [];
    $data['debt_id'] = $_POST['debt_id'];
    $data['debt_payment_charge_detail'] = $_POST['debt_payment_charge_detail'];
    $data['debt_payment_charge_amount'] = $_POST['debt_payment_charge_amount'];
    $data['debt_payment_charge_date'] = $_POST['debt_payment_charge_date'];
    
    $check_result = $model->updateChargeByID($debt_payment_charge_id,$data);

    if($check_result){
        $debts = $model_debt->getDebtByID($debt_id);
        $charge = $model->getChargeBy($debt_id);
        require_once($path.'view.inc.php');
    }else{
        echo '0';
    }
        
    

}
else{
    $debts = $model_debt->getDebtByID($debt_id);
    $charge = $model->getChargeBy($debt_id);
    
    
    require_once($path.'view.inc.php');

}
?>