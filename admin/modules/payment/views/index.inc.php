<?php
date_default_timezone_set('Asia/Bangkok');
require_once('../../../../models/PaymentModel.php');
require_once('../../../../models/GatewayModel.php'); 
require_once('../../../../models/DebtModel.php'); 
require_once('../../../../models/ChargeModel.php'); 

$path = "";

$model = new PaymentModel;
$model_gateway = new GatewayModel;
$model_debt = new DebtModel;
$model_charge = new ChargeModel;

$debt_id=$_POST['debt_id'];
$id=$_POST['id'];

function payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge){
    $gateway = $model_gateway->getGatewayBy(); 
    $payment = $model->getPaymentBy($debt_id);  
    $sum_payment = $model->getSumPaymentBy($debt_id);  
    $debt = $model_debt->getDebtByID($debt_id);  
    $charge = $model_charge->getSumChargeBy($debt_id); 
    $sum = $debt['debt_value']+$debt['debt_interest']+$charge['debt_payment_charge_amount'];
    $balance = $sum-$sum_payment['debt_payment_pay'];
    require_once($path.'view.inc.php');  
}
if(!isset($_POST['action'])){ 
    
    payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);

}
else if ($_POST['action'] == 'insert'){
    

}else if ($_POST['action'] == 'update'){ 
    

}else if ($_POST['action'] == 'delete'){
    $check_result = $model->deletePaymentByID($id); 
    payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);

}else if ($_POST['action'] == 'add'){ 
    $last_payment = $model->getLastPaymentBy($debt_id); 
    if(count($last_payment)>0){

        $last_payment = $model->getLastPaymentBy($debt_id); 

        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id);  

        //จำนวนวัน
        $old_date=date_create($last_payment['debt_payment_date']);//วันก่อนหน้า
        $new_date=date_create($_POST['debt_payment_date']);//วันที่
        $diff=date_diff($old_date,$new_date);
        $date_amount = intval($diff->format("%a"));

        //ดอกเบี้ย
        $interest = round(($last_payment['debt_payment_value_balance']*(1.25/30))/100*$date_amount,2);
 
        //ดอกเบี้ยคงเหลือ
        $interest_balance = 0;
        if(($interest-$_POST['debt_payment_pay'])>0){
            $interest_balance = $interest-$_POST['debt_payment_pay'];
            
        }

        //จ่ายดอกเบี้ย
        $interest_pay = $interest-$interest_balance; 

        //ค่าใช้จ่ายยกมา
        $charge_amount = 0;
        if($charge['charge_amount']!=''){ 
            $charge_amount = intval($charge['charge_amount']);
        }

        //ค่าใช้จ่ายคงเหลือ
        $charge_amount_balance = 0;
        if($interest_balance==0&&$charge_amount_balance!=0){
            $charge_amount_balance = $charge_amount-($_POST['debt_payment_pay']-$interest);
        }

        //จ่ายค่าใช้จ่าย
        $charge_amount_pay = $charge_amount-$charge_amount_balance; 

        //เงินต้นยกมา
        $debt_value=0;
        if($last_payment['debt_payment_value_balance']!=''){ 
            $debt_value = $last_payment['debt_payment_value_balance'];
        }

        //เงินต้นคงเหลือ
        $value_balance=$debt_value; 
        if($charge_amount_balance==0&&$value_balance!=0){
            $value_balance = $value_balance - ($_POST['debt_payment_pay']-$interest-$charge_amount);
        }

        //จ่ายเงินต้น
        $value_pay = $debt_value-$value_balance; 

        // echo ' วันก่อนหน้า = '.$debt['debt_date'].' วันที่ = '.$_POST['debt_payment_date'].' จำนวนเงิน = '.$_POST['debt_payment_pay'].' จำนวนวัน = '.$date_amount.' ดอกเบี้ยยกมา = '.$interest.' ดอกเบี้ยคงเหลือ = '.$interest_balance.' ค่าใช้จ่ายยกมา = '.$charge_amount.' ค่าใช้จ่ายคงเหลือ = '.$charge_amount_balance.' เงินต้นยกมา = '.$debt['debt_value'].' เงินต้นคงเหลือ = '.$value_balance;
        
        $data = [];
        $data['debt_id'] = $_POST['debt_id'];
        $data['debt_payment_gateway_id'] = $_POST['debt_payment_gateway_id'];
        $data['debt_payment_pay'] = $_POST['debt_payment_pay'];
        $data['debt_payment_remark'] = $_POST['debt_payment_remark'];
        $data['debt_payment_date'] = $_POST['debt_payment_date'];
        $data['debt_payment_date_amount'] = $date_amount;
        $data['debt_payment_interest_cal'] = $interest; 
        $data['debt_payment_interest'] = $interest; 
        $data['debt_payment_discount'] = $_POST['debt_payment_discount']; 
        $data['debt_payment_charge_amount'] = $charge_amount; 
        $data['debt_payment_value'] = $debt_value; 
        $data['debt_payment_interest_balance'] = $interest_balance; 
        $data['debt_payment_charge_amount_balance'] = $charge_amount_balance; 
        $data['debt_payment_value_balance'] = $value_balance; 
        $data['debt_payment_interest_pay'] = $interest_pay; 
        $data['debt_payment_charge_amount_pay'] = $charge_amount_pay; 
        $data['debt_payment_value_pay'] = $value_pay; 
        $check_result = $model->insertPayment($data);
        
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
        }else{
            echo '0';
        }  
    }else{//insert ครั้งแรก

        //เงินต้น
        $debt = $model_debt->getDebtByID($debt_id); 

        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id);  

        //จำนวนวัน
        $old_date=date_create($debt['debt_date']);//วันก่อนหน้า
        $new_date=date_create($_POST['debt_payment_date']);//วันที่
        $diff=date_diff($old_date,$new_date);
        $date_amount = intval($diff->format("%a"));

        //ดอกเบี้ย
        $interest = round(($debt['debt_value']*(1.25/30))/100*$date_amount,2);
 
        //ดอกเบี้ยคงเหลือ
        $interest_balance = 0;
        if(($interest-$_POST['debt_payment_pay'])>0){
            $interest_balance = $interest-$_POST['debt_payment_pay'];
            
        }

        //จ่ายดอกเบี้ย
        $interest_pay = $interest-$interest_balance; 

        //ค่าใช้จ่ายยกมา
        $charge_amount = 0;
        if($charge['charge_amount']!=''){ 
            $charge_amount = intval($charge['charge_amount']);
        }

        //ค่าใช้จ่ายคงเหลือ
        $charge_amount_balance = 0;
        if($interest_balance==0&&$charge_amount_balance!=0){
            $charge_amount_balance = $charge_amount-($_POST['debt_payment_pay']-$interest);
        }

        //จ่ายค่าใช้จ่าย
        $charge_amount_pay = $charge_amount-$charge_amount_balance; 

        //เงินต้นยกมา
        $debt_value=0;
        if($debt['debt_value']!=''){ 
            $debt_value = $debt['debt_value'];
        }

        //เงินต้นคงเหลือ
        $value_balance=$debt_value; 
        if($charge_amount_balance==0&&$value_balance!=0){
            $value_balance = $value_balance - ($_POST['debt_payment_pay']-$interest-$charge_amount);
        }

        //จ่ายเงินต้น
        $value_pay = $debt_value-$value_balance; 

        // echo ' วันก่อนหน้า = '.$debt['debt_date'].' วันที่ = '.$_POST['debt_payment_date'].' จำนวนเงิน = '.$_POST['debt_payment_pay'].' จำนวนวัน = '.$date_amount.' ดอกเบี้ยยกมา = '.$interest.' ดอกเบี้ยคงเหลือ = '.$interest_balance.' ค่าใช้จ่ายยกมา = '.$charge_amount.' ค่าใช้จ่ายคงเหลือ = '.$charge_amount_balance.' เงินต้นยกมา = '.$debt['debt_value'].' เงินต้นคงเหลือ = '.$value_balance;
        
        $data = [];
        $data['debt_id'] = $_POST['debt_id'];
        $data['debt_payment_gateway_id'] = $_POST['debt_payment_gateway_id'];
        $data['debt_payment_pay'] = $_POST['debt_payment_pay'];
        $data['debt_payment_remark'] = $_POST['debt_payment_remark'];
        $data['debt_payment_date'] = $_POST['debt_payment_date'];
        $data['debt_payment_date_amount'] = $date_amount;
        $data['debt_payment_interest_cal'] = $interest; 
        $data['debt_payment_interest'] = $interest; 
        $data['debt_payment_discount'] = $_POST['debt_payment_discount']; 
        $data['debt_payment_charge_amount'] = $charge_amount; 
        $data['debt_payment_value'] = $debt_value; 
        $data['debt_payment_interest_balance'] = $interest_balance; 
        $data['debt_payment_charge_amount_balance'] = $charge_amount_balance; 
        $data['debt_payment_value_balance'] = $value_balance; 
        $data['debt_payment_interest_pay'] = $interest_pay; 
        $data['debt_payment_charge_amount_pay'] = $charge_amount_pay; 
        $data['debt_payment_value_pay'] = $value_pay; 
        $check_result = $model->insertPayment($data);
        
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
        }else{
            echo '0';
        }  
    }
   
}else if ($_POST['action'] == 'edit'){ 
    $count_payment = $model->getCountPaymentByID($debt_id); 
    if($count_payment['count_payment']>1){
        $last_payment = $model->getPaymentByID($id); 

        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id);  
    
        //จำนวนวัน
        $old_date=date_create($last_payment['debt_payment_date']);//วันก่อนหน้า
        $new_date=date_create($_POST['debt_payment_date']);//วันที่
        $diff=date_diff($old_date,$new_date);
        $date_amount = intval($diff->format("%a"));
    
        //ดอกเบี้ย
        $interest = round(($last_payment['debt_payment_value_balance']*(1.25/30))/100*$date_amount,2);
    
        //ดอกเบี้ยคงเหลือ
        $interest_balance = 0;
        if(($interest-$_POST['debt_payment_pay'])>0){
            $interest_balance = $interest-$_POST['debt_payment_pay'];
            
        }
    
        //จ่ายดอกเบี้ย
        $interest_pay = $interest-$interest_balance; 
    
        //ค่าใช้จ่ายยกมา
        $charge_amount = 0;
        if($charge['charge_amount']!=''){ 
            $charge_amount = intval($charge['charge_amount']);
        }
    
        //ค่าใช้จ่ายคงเหลือ
        $charge_amount_balance = 0;
        if($interest_balance==0&&$charge_amount_balance!=0){
            $charge_amount_balance = $charge_amount-($_POST['debt_payment_pay']-$interest);
        }
    
        //จ่ายค่าใช้จ่าย
        $charge_amount_pay = $charge_amount-$charge_amount_balance; 
    
        //เงินต้นยกมา
        $debt_value=0;
        if($last_payment['debt_payment_value_balance']!=''){ 
            $debt_value = $last_payment['debt_payment_value_balance'];
        }
    
        //เงินต้นคงเหลือ
        $value_balance=$debt_value; 
        if($charge_amount_balance==0&&$value_balance!=0){
            $value_balance = $value_balance - ($_POST['debt_payment_pay']-$interest-$charge_amount);
        }
    
        //จ่ายเงินต้น
        $value_pay = $debt_value-$value_balance; 
    
        // echo ' วันก่อนหน้า = '.$debt['debt_date'].' วันที่ = '.$_POST['debt_payment_date'].' จำนวนเงิน = '.$_POST['debt_payment_pay'].' จำนวนวัน = '.$date_amount.' ดอกเบี้ยยกมา = '.$interest.' ดอกเบี้ยคงเหลือ = '.$interest_balance.' ค่าใช้จ่ายยกมา = '.$charge_amount.' ค่าใช้จ่ายคงเหลือ = '.$charge_amount_balance.' เงินต้นยกมา = '.$debt['debt_value'].' เงินต้นคงเหลือ = '.$value_balance;
    
        $data = [];
        $data['debt_payment_gateway_id'] = $_POST['debt_payment_gateway_id'];
        $data['debt_payment_pay'] = $_POST['debt_payment_pay'];
        $data['debt_payment_remark'] = $_POST['debt_payment_remark'];
        $data['debt_payment_date'] = $_POST['debt_payment_date'];
        $data['debt_payment_date_amount'] = $date_amount;
        $data['debt_payment_interest_cal'] = $interest; 
        $data['debt_payment_interest'] = $interest; 
        $data['debt_payment_discount'] = $_POST['debt_payment_discount']; 
        $data['debt_payment_charge_amount'] = $charge_amount; 
        $data['debt_payment_value'] = $debt_value; 
        $data['debt_payment_interest_balance'] = $interest_balance; 
        $data['debt_payment_charge_amount_balance'] = $charge_amount_balance; 
        $data['debt_payment_value_balance'] = $value_balance; 
        $data['debt_payment_interest_pay'] = $interest_pay; 
        $data['debt_payment_charge_amount_pay'] = $charge_amount_pay; 
        $data['debt_payment_value_pay'] = $value_pay; 
        
        $check_result = $model->updatePaymentByID($id,$data);
    
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
        }else{
     
        } 
    }else{
        
        //เงินต้น
        $debt = $model_debt->getDebtByID($debt_id); 

        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id);  

        //จำนวนวัน
        $old_date=date_create($debt['debt_date']);//วันก่อนหน้า
        $new_date=date_create($_POST['debt_payment_date']);//วันที่
        $diff=date_diff($old_date,$new_date);
        $date_amount = intval($diff->format("%a"));

        //ดอกเบี้ย
        $interest = round(($debt['debt_value']*(1.25/30))/100*$date_amount,2);
 
        //ดอกเบี้ยคงเหลือ
        $interest_balance = 0;
        if(($interest-$_POST['debt_payment_pay'])>0){
            $interest_balance = $interest-$_POST['debt_payment_pay'];
            
        }

        //จ่ายดอกเบี้ย
        $interest_pay = $interest-$interest_balance; 

        //ค่าใช้จ่ายยกมา
        $charge_amount = 0;
        if($charge['charge_amount']!=''){ 
            $charge_amount = intval($charge['charge_amount']);
        }

        //ค่าใช้จ่ายคงเหลือ
        $charge_amount_balance = 0;
        if($interest_balance==0&&$charge_amount_balance!=0){
            $charge_amount_balance = $charge_amount-($_POST['debt_payment_pay']-$interest);
        }

        //จ่ายค่าใช้จ่าย
        $charge_amount_pay = $charge_amount-$charge_amount_balance; 

        //เงินต้นยกมา
        $debt_value=0;
        if($debt['debt_value']!=''){ 
            $debt_value = $debt['debt_value'];
        }

        //เงินต้นคงเหลือ
        $value_balance=$debt_value; 
        if($charge_amount_balance==0&&$value_balance!=0){
            $value_balance = $value_balance - ($_POST['debt_payment_pay']-$interest-$charge_amount);
        }

        //จ่ายเงินต้น
        $value_pay = $debt_value-$value_balance; 
        $data = [];
        $data['debt_payment_gateway_id'] = $_POST['debt_payment_gateway_id'];
        $data['debt_payment_pay'] = $_POST['debt_payment_pay'];
        $data['debt_payment_remark'] = $_POST['debt_payment_remark'];
        $data['debt_payment_date'] = $_POST['debt_payment_date'];
        $data['debt_payment_date_amount'] = $date_amount;
        $data['debt_payment_interest_cal'] = $interest; 
        $data['debt_payment_interest'] = $interest; 
        $data['debt_payment_discount'] = $_POST['debt_payment_discount']; 
        $data['debt_payment_charge_amount'] = $charge_amount; 
        $data['debt_payment_value'] = $debt_value; 
        $data['debt_payment_interest_balance'] = $interest_balance; 
        $data['debt_payment_charge_amount_balance'] = $charge_amount_balance; 
        $data['debt_payment_value_balance'] = $value_balance; 
        $data['debt_payment_interest_pay'] = $interest_pay; 
        $data['debt_payment_charge_amount_pay'] = $charge_amount_pay; 
        $data['debt_payment_value_pay'] = $value_pay; 
        
        $check_result = $model->updatePaymentByID($id,$data);
    
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
        }else{
     
        } 
    }
    

}
else{ 
    payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
}
?>