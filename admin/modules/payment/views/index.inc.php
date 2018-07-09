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

function payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge,$debt_payment_date){
     
    $last_payment = $model->getLastPaymentBy($debt_id); 
    $gateway = $model_gateway->getGatewayBy(); 
    $payment = $model->getPaymentBy($debt_id);  
    $sum_payment = $model->getSumPaymentBy($debt_id);  
    $debt = $model_debt->getDebtByID($debt_id);  
    $charge = $model_charge->getSumChargeBy($debt_id,$debt_payment_date); 
    // $charge = $model_charge->getSumNewChargeBy($debt_id); 

    if(count($payment)>0){
        
        $old_date=date_create($last_payment['debt_payment_date']);//วันก่อนหน้า 
        $new_date=date_create(date("Y-m-d"));
        if($old_date<$new_date){ 
            $diff=date_diff($old_date,$new_date); 
            $date_amount = intval($diff->format("%a"));
        }else{
            $date_amount = 0;
        } 

        //ดอกเบี้ย 
        $debt_value_last = $last_payment['debt_payment_value_balance'];
        $interest = round(($debt_value_last*(1.25/30))/100*$date_amount+$last_payment['debt_payment_interest_balance'],2); 

    }else{
        
        $old_date=date_create($debt['debt_date']);//วันก่อนหน้า 
        $new_date=date_create(date("Y-m-d"));
        $diff=date_diff($old_date,$new_date); 
        $date_amount = intval($diff->format("%a"));
        
        //ดอกเบี้ย
        $debt_value_last = $debt['debt_value'];
        $interest = round(($debt_value_last*(1.25/30))/100*$date_amount,2); 
    }
     
    $charge_amount = 0; 
    if($last_payment['debt_payment_charge_amount']!=''){ 
        $charge_amount = $last_payment['debt_payment_charge_amount_balance']; 
    }else{
        $charge_amount = $charge['debt_payment_charge_amount']; 
    }

    $payment_value = 0;
    if($last_payment['debt_payment_value_balance']!=''){
        $payment_value = $last_payment['debt_payment_value_balance']; 
    }else{
        $payment_value = $debt['debt_value'];
    }  
    $sum = $payment_value+$interest+$charge_amount;
    require_once($path.'view.inc.php');  

}
function payment_cal($old_date_var,$new_date_var,$value_balance_var,$interest_balance_var,$debt_payment_pay_var,$charge_amount_balance_var,$debt_id,$gateway_id,$remark,$discount,$model_charge,$debt_payment_charge_id = '',$charge_amount_new_date = ''){
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
        $charge_sum = [];
        $new = false; 
        if($debt_payment_charge_id==''){
            $charge_sum = $model_charge->getSumChargeBy($debt_id,$new_date_var);
        }else{ 
            $charge_sum_new = $model_charge->getSumNewChargeBy($debt_id,$debt_payment_charge_id,$charge_amount_new_date,$new_date_var); 
            if($charge_sum_new['debt_payment_charge_amount']!=''){
                $new = true;
                $charge_sum = $charge_sum_new;
            }else{
                $charge_sum['debt_payment_charge_amount'] = 0;
                $charge_sum['debt_payment_charge_date'] = $charge_amount_new_date;
                $charge_sum['debt_payment_charge_id'] = $debt_payment_charge_id;
            }

        }
        if($charge_amount_last!=''){  
            $charge_amount = $charge_amount_last; 
        } 
        if($new){
            $charge_amount = $charge_amount + $charge_sum['debt_payment_charge_amount'];
        }

        //ค่าใช้จ่ายคงเหลือ
        $charge_amount_balance = $charge_amount;

        $charge_amount_pay= 0;
        if($charge_amount_balance!=0&&$interest_balance==0&&($debt_payment_pay_var-$interest_sum)>0){
            if($charge_amount-($debt_payment_pay_var-$interest_sum)>0){
                $charge_amount_balance = $charge_amount-($debt_payment_pay_var-$interest_sum); 
            }else{
                $charge_amount_balance = 0;
            }
            
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
            // echo $value_pay.' = '.$debt_value.'-'.$value_balance; 
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
        $data['debt_payment_charge_amount_new'] = round($charge_sum['debt_payment_charge_amount'],2);
        $data['debt_payment_charge_amount_new_date'] = $charge_sum['debt_payment_charge_date'];
        $data['debt_payment_charge_amount_new_id'] =  $charge_sum['debt_payment_charge_id'];

        // echo ' วันก่อนหน้า = '.$old_date_var.'
        //  วันที่ = '.$data['debt_payment_date'].' 
        //  จำนวนเงิน = '.$data['debt_payment_pay'].' 
        //  จำนวนวัน = '.$date_amount.' 
        //  ดอกเบี้ย = '.$data['debt_payment_interest_cal'].' 
        //  ดอกเบี้ยยกมา = '.$data['debt_payment_interest'].' 
        //  ดอกเบี้ยคงเหลือ = '.$data['debt_payment_interest_balance'].' 
        //  ค่าใช้จ่ายยกมา = '.$data['debt_payment_charge_amount'].' 
        //  ค่าใช้จ่ายคงเหลือ = '.$data['debt_payment_charge_amount_balance'].' 
        //  เงินต้นยกมา = '.$data['debt_payment_value'].' 
        //  เงินต้นคงเหลือ = '.$data['debt_payment_value_balance'].' 
        //  จ่ายดอกเบี้ย = '.$data['debt_payment_interest_pay'].' 
        //  จ่ายค่าใช้จ่าย = '.$data['debt_payment_charge_amount_pay'].' 
        //  จ่ายเงินต้น = '.$data['debt_payment_value_pay'].' 
        //  ยอดค่าใช้จ่ายใหม่ = '.$data['debt_payment_charge_amount_new'].' 
        //  ยอดค่าใช้จ่ายใหม่ = '.$data['debt_payment_charge_amount_new_date'].' 
        //  ยอดค่าใช้จ่ายใหม่ = '.$data['debt_payment_charge_amount_new_id'];
        if($old_date<=$new_date){
            return $data;
        }
        
}

if(!isset($_POST['action'])){ 
    
    payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge,date("Y-m-d"));

}
else if ($_POST['action'] == 'insert'){
    

}else if ($_POST['action'] == 'update'){ 
    

}else if ($_POST['action'] == 'delete'){ 
    $check_result = $model->deletePaymentByID($id); 
    payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge,date("Y-m-d"));
    

}else if ($_POST['action'] == 'add'){ 
    $last_payment = $model->getLastPaymentBy($debt_id); 
    if(count($last_payment)>0){ 
        
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
            $_POST['debt_payment_discount'],
            $model_charge,
            $last_payment['debt_payment_charge_amount_new_id'],
            $last_payment['debt_payment_charge_amount_new_date']
        );
        if(count($data)>0){
            $check_result = $model->insertPayment($data); 
            if($check_result){ 
                payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge,$_POST['debt_payment_date']);
            }else{
                echo '0';
            }  
        }else{
            
            echo '1';
        }
        
    }else{//insert ครั้งแรก

        //เงินต้น
        $debt = $model_debt->getDebtByID($debt_id); 

        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id,$_POST['debt_payment_date']);  

        $data = [];
        $data = payment_cal(
            $debt['debt_date'],
            $_POST['debt_payment_date'],
            $debt['debt_value'],
            '0',
            $_POST['debt_payment_pay'],
            $charge['debt_payment_charge_amount'],
            $_POST['debt_id'],
            $_POST['debt_payment_gateway_id'],
            $_POST['debt_payment_remark'],
            $_POST['debt_payment_discount'],
            $model_charge
        );
        

        $check_result = $model->insertPayment($data);
        
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge,$_POST['debt_payment_date']);
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
            $_POST['debt_payment_discount'],
            $model_charge,
            $before_payment['debt_payment_charge_amount_new_id'],
            $before_payment['debt_payment_charge_amount_new_date']
            
        ); 
        
        $check_result = $model->updatePaymentByID($id,$data);
    
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge,$_POST['debt_payment_date']);
        }else{
     
        } 
    }
    else{
        
        //เงินต้น
        $debt = $model_debt->getDebtByID($debt_id); 

        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id,$_POST['debt_payment_date']);   

        $data = [];
        $data = payment_cal(
            $debt['debt_date'],
            $_POST['debt_payment_date'],
            $debt['debt_value'],
            '0',
            $_POST['debt_payment_pay'],
            $charge['debt_payment_charge_amount'],
            $_POST['debt_id'],
            $_POST['debt_payment_gateway_id'],
            $_POST['debt_payment_remark'],
            $_POST['debt_payment_discount'],
            $model_charge,
            '1'
        ); 
        
        $check_result = $model->updatePaymentByID($id,$data);
    
        if($check_result){ 
            payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge);
        }else{
     
        } 
    }
    

}
else{ 
    payment_view($debt_id,$model,$model_gateway,$model_debt,$model_charge,date("Y-m-d"));
}
?>