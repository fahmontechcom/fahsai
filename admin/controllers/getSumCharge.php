<?php 
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set('Asia/Bangkok');
require_once('../../models/PaymentModel.php');
require_once('../../models/GatewayModel.php'); 
require_once('../../models/DebtModel.php'); 
require_once('../../models/ChargeModel.php'); 

$path = "";

$model = new PaymentModel;
$model_gateway = new GatewayModel;
$model_debt = new DebtModel;
$model_charge = new ChargeModel;

$debt_id=$_POST['debt_id'];
$invoice_list_to_date=$_POST['invoice_list_to_date']; 

function payment_cal($old_date_var,$new_date_var,$value_balance_var,$interest_balance_var,$charge_amount_balance_var,$debt_id,$model_charge,$debt_payment_charge_id = '',$charge_amount_new_date = ''){
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
     
    $data = []; 
    $data['debt_payment_interest_cal'] = round($interest,2); 
    $data['debt_payment_interest'] = round($interest_sum,2);  
    $data['debt_payment_charge_amount'] = round($charge_amount,2);     
    $data['debt_payment_value_balance'] = round($debt_value_last,2);     
    $data['check'] = '0';     
    if($old_date<=$new_date){
        $data['check'] = '1'; 
    }
    // echo ' วันก่อนหน้า = '.$old_date_var.'
    //  วันที่ = '.$new_date_var.'  
    //  จำนวนวัน = '.$date_amount.' 
    //  ดอกเบี้ย = '.$data['debt_payment_interest_cal'].' 
    //  ดอกเบี้ยยกมา = '.$data['debt_payment_interest'].'  
    //  ค่าใช้จ่ายยกมา = '.$data['debt_payment_charge_amount'] ; 
    return $data; 
    
}

$last_payment = $model->getLastPaymentBy($debt_id); 
if($last_payment['debt_payment_date']!=''){ 
    $data = [];
    $data = payment_cal(
        $last_payment['debt_payment_date'],
        $invoice_list_to_date,
        $last_payment['debt_payment_value_balance'],
        $last_payment['debt_payment_interest_balance'], 
        $last_payment['debt_payment_charge_amount_balance'],
        $debt_id,  
        $model_charge,
        $last_payment['debt_payment_charge_amount_new_id'],
        $last_payment['debt_payment_charge_amount_new_date']
    );
    echo json_encode($data);
}else{//ไม่มีข้อมูลใน payment
    $debt = $model_debt->getDebtByID($debt_id); 

    //ค่าใช้จ่าย 
    $charge = $model_charge->getSumChargeBy($debt_id,$invoice_list_to_date);  
    $data = [];
    $data = payment_cal(
                $debt['debt_date'],
                $invoice_list_to_date,
                $debt['debt_value'],
                '0',
                $charge['debt_payment_charge_amount'],
                $debt_id,
                $model_charge 
            ) ;
            // echo ' วันก่อนหน้า = '.$debt['debt_date'].'
            // วันที่ = '.$invoice_list_to_date.' 
            // ยอดเงิน = '.$debt['debt_value'].' 
            // ค่าใช้จ่ายยกมา = '.$charge['debt_payment_charge_amount'].'  
            // debt_id = '.$debt_id ; 
    // echo $data['debt_payment_interest'];
    echo json_encode($data);
} 
?>