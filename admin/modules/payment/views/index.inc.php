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
function payment_cal($old_date_var,$new_date_var,$value_balance_var,$interest_balance_var,$debt_payment_pay_var,$charge_amount_balance_var,$debt_id,$gateway_id,$remark,$discount){
        $old_date=date_create($old_date_var);//วันก่อนหน้า
        $new_date=date_create($new_date_var);//วันที่
        $diff=date_diff($old_date,$new_date);
        $date_amount = intval($diff->format("%a")); 

        //ดอกเบี้ย
        $debt_value_last = $value_balance_var;
        $interest = round(($debt_value_last*(1.25/30))/100*$date_amount,2); 

        //ดอกเบี้ยยกมา
        $interest_balance_last = $interest_balance_var;
        $interest_sum = $interest+$interest_balance_last;
 
        //ดอกเบี้ยคงเหลือ
        $interest_balance = 0;
        if(($interest_sum-$debt_payment_pay_var)>0){
            $interest_balance = $interest_sum-$debt_payment_pay_var;
            
        }

        //จ่ายดอกเบี้ย
        $interest_pay = $interest_sum-$interest_balance; 

        

        //ค่าใช้จ่ายยกมา 
        $charge_amount_last = $charge_amount_balance_var;
        $charge_amount = 0;
        if($charge_amount_last!=''){ 
            $charge_amount = $charge_amount_last;
        }
        echo '--'.$charge_amount_balance_var.'--'; 
        echo '--'.$charge_amount.'--'; 
        //ค่าใช้จ่ายคงเหลือ
        $charge_amount_balance = $charge_amount;

        $charge_amount_pay= 0;
        if($interest_balance==0&&($debt_payment_pay_var-$interest_sum)>0){
            $charge_amount_balance = $charge_amount-($debt_payment_pay_var-$interest_sum); 
            // echo $charge_amount_balance.' = '.$charge_amount.'-('.$debt_payment_pay_var.'-'.$interest_sum.')'; 
            $charge_amount_pay = $charge_amount-$charge_amount_balance;   //จ่ายค่าใช้จ่าย
        }

        
        

        //เงินต้นยกมา
        $debt_value=0;
        if($debt_value_last!=''){ 
            $debt_value = $debt_value_last;
        }

        //เงินต้นคงเหลือ
        $value_balance=$debt_value; 
        $value_pay = 0;
        if($charge_amount_balance==0&&$value_balance!=0&&($debt_payment_pay_var-$interest_sum-$charge_amount)>0){
            $value_balance = $value_balance - ($debt_payment_pay_var-$interest_sum-$charge_amount);
            $value_pay = $debt_value-$value_balance;  //จ่ายเงินต้น
        }
        
        
        

        $data = [];
        $data['debt_id'] = $debt_id;
        $data['debt_payment_gateway_id'] = $gateway_id;  
        $data['debt_payment_pay'] = round($debt_payment_pay_var,2);
        $data['debt_payment_remark'] = $remark;
        $data['debt_payment_date'] = $new_date_var;
        $data['debt_payment_date_amount'] = $date_amount;
        $data['debt_payment_interest_cal'] = round($interest,2); 
        $data['debt_payment_interest'] = round($interest_sum,2); 
        $data['debt_payment_discount'] = round($discount,2); 
        $data['debt_payment_charge_amount'] = round($charge_amount,2); 
        $data['debt_payment_value'] = round($debt_value,2); 
        $data['debt_payment_interest_balance'] = round($interest_balance,2); 
        $data['debt_payment_charge_amount_balance'] = round($charge_amount_balance,2); 
        $data['debt_payment_value_balance'] = round($value_balance,2); 
        $data['debt_payment_interest_pay'] = round($interest_pay,2); 
        $data['debt_payment_charge_amount_pay'] = round($charge_amount_pay,2); 
        $data['debt_payment_value_pay'] = round($value_pay,2);

        echo ' วันก่อนหน้า = '.$old_date_var.' วันที่ = '.$data['debt_payment_date'].' จำนวนเงิน = '.$data['debt_payment_pay'].' จำนวนวัน = '.$date_amount.' ดอกเบี้ย = '.$data['debt_payment_interest_cal'].' ดอกเบี้ยยกมา = '.$data['debt_payment_interest'].' ดอกเบี้ยคงเหลือ = '.$data['debt_payment_interest_balance'].' ค่าใช้จ่ายยกมา = '.$data['debt_payment_charge_amount'].' ค่าใช้จ่ายคงเหลือ = '.$data['debt_payment_charge_amount_balance'].' เงินต้นยกมา = '.$data['debt_payment_value'].' เงินต้นคงเหลือ = '.$data['debt_payment_value_balance'];

        return $data;
        
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

        
        
        $data = []; 
        $data = payment_cal(
            $last_payment['debt_payment_date'],
            $_POST['debt_payment_date'],
            $last_payment['debt_payment_value_balance'],
            $last_payment['debt_payment_interest_balance'],
            $_POST['debt_payment_pay'],
            $last_payment['debt_payment_charge_amount_balance'],
            $_POST['debt_id'],
            $_POST['debt_payment_gateway_id'],
            $_POST['debt_payment_remark'],
            $_POST['debt_payment_discount']
        );

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

        $data = [];
        $data = payment_cal(
            $debt['debt_date'],
            $_POST['debt_payment_date'],
            $debt['debt_value'],'0',
            $_POST['debt_payment_pay'],
            $charge['charge_amount'],
            $_POST['debt_id'],
            $_POST['debt_payment_gateway_id'],
            $_POST['debt_payment_remark'],
            $_POST['debt_payment_discount']
        );

        $check_result = $model->insertPayment($data);
        
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
        }else{
            echo '0';
        }  
    }
   
}else if ($_POST['action'] == 'edit'){  

    $before_payment = $model->getBeforePaymentByID($id,$debt_id);  

    if($before_payment['debt_payment_date']!=''){
       
        $before_payment = $model->getBeforePaymentByID($id,$debt_id);   
    
    
        $data = [];  
        $data = payment_cal(
            $before_payment['debt_payment_date'],
            $_POST['debt_payment_date'],
            $before_payment['debt_payment_value_balance'],
            $before_payment['debt_payment_interest_balance'],
            $_POST['debt_payment_pay'],
            $before_payment['debt_payment_charge_amount_balance'],
            $_POST['debt_id'],
            $_POST['debt_payment_gateway_id'],
            $_POST['debt_payment_remark'],
            $_POST['debt_payment_discount']
        ); 
        
        $check_result = $model->updatePaymentByID($id,$data);
    
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
        }else{
     
        } 
    }
    else{
        
        //เงินต้น
        $debt = $model_debt->getDebtByID($debt_id); 

        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id);   

        $data = [];
        $data = payment_cal(
            $debt['debt_date'],
            $_POST['debt_payment_date'],
            $debt['debt_value'],'0',
            $_POST['debt_payment_pay'],
            $charge['charge_amount'],
            $_POST['debt_id'],
            $_POST['debt_payment_gateway_id'],
            $_POST['debt_payment_remark'],
            $_POST['debt_payment_discount']
        ); 
        
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