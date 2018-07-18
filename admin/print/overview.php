<?PHP 
date_default_timezone_set('Asia/Bangkok'); 
$d1=date("d");
$d2=date("m");
$d3=date("Y");
$d4=date("h");
$d5=date("i");
$d6=date("s"); 
require_once('../../models/PaymentModel.php');
require_once('../../models/GatewayModel.php'); 
require_once('../../models/DebtModel.php'); 
require_once('../../models/ChargeModel.php'); 

$model = new PaymentModel;
$model_gateway = new GatewayModel;
$model_debt = new DebtModel;
$model_charge = new ChargeModel;

$path = ""; 
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$export_type = $_GET['export_type'];
$invoice_list_to_date=date('Y-m-d');
$result = []; 

function payment_cal($old_date_var,$new_date_var,$value_balance_var,$interest_balance_var,$charge_amount_balance_var,$debt_id,$model_charge,$model,$debt_payment_charge_id = '',$charge_amount_new_date = ''){
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
    
    //วันที่รับดอกล่าสุด
    $last_interest_date = '-';
    $interest_date =  $model->getLastPaymentInterestDateBy($debt_id);
    if($interest_date['debt_payment_date']!=''){
        $last_interest_date = $interest_date['debt_payment_date'];
    }
     
    $data = []; 
    $data['debt_payment_interest_cal'] = round($interest,2); 
    $data['debt_payment_interest'] = round($interest_sum,2);  
    $data['debt_payment_interest_last_date'] = $last_interest_date;  
    $data['debt_payment_charge_amount'] = round($charge_amount,2);     
    $data['debt_payment_value_balance'] = round($debt_value_last,2);     
    $data['debt_payment_sum'] = round($debt_value_last,2)+round($charge_amount,2)+round($interest_sum,2);     
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
$debt_data = $model_debt->getDebtAndCustomerByDate($start_date,$end_date); 
for($i=0;$i<count($debt_data);$i++){
    $debt_id=$debt_data[$i]['debt_id'];  
    $last_payment = $model->getLastPaymentBy($debt_id); 
    if($last_payment['debt_payment_date']!=''){ 
        $result[$i] = payment_cal(
            $last_payment['debt_payment_date'],
            $invoice_list_to_date,
            $last_payment['debt_payment_value_balance'],
            $last_payment['debt_payment_interest_balance'], 
            $last_payment['debt_payment_charge_amount_balance'],
            $debt_id,  
            $model_charge,
            $model,
            $last_payment['debt_payment_charge_amount_new_id'],
            $last_payment['debt_payment_charge_amount_new_date']
        );
    }else{//ไม่มีข้อมูลใน payment
        $debt = $model_debt->getDebtByID($debt_id); 
    
        //ค่าใช้จ่าย 
        $charge = $model_charge->getSumChargeBy($debt_id,$invoice_list_to_date);  
        $result[$i] = payment_cal(
                    $debt['debt_date'],
                    $invoice_list_to_date,
                    $debt['debt_value'],
                    '0',
                    $charge['debt_payment_charge_amount'],
                    $debt_id,
                    $model_charge,
                    $model 
                ) ;
                // echo ' วันก่อนหน้า = '.$debt['debt_date'].'
                // วันที่ = '.$invoice_list_to_date.' 
                // ยอดเงิน = '.$debt['debt_value'].' 
                // ค่าใช้จ่ายยกมา = '.$charge['debt_payment_charge_amount'].'  
                // debt_id = '.$debt_id ; 
        // echo $data['debt_payment_interest'];
    }  
}

// echo "------------end--------------";
// echo "<pre>";
// print_r($debt_data);
// echo "</pre>";  
// echo "------------end--------------";
// echo "<pre>";
// print_r($result);
// echo "</pre>";  

$str .= '<style>
table { 
	font-family: "Kanit-Regular";
} 
table, td, th {
    border: 0.5px solid black;
}
td{
    padding:3px;
    padding-top:5px;
}
</style>'.
    '<div style="font-size:18px;" align="center"><strong>รายงานการชำระเงิน</strong></div> '.
    '<div style="font-size:14px;" align="right">ระหว่างวันที่ '.date_format(date_create($start_date),"d-m-Y").' ถึง '.date_format(date_create($end_date),"d-m-Y").' </div> '. 
    '<table width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">'.
        '<thead>'.
            '<tr>'.  
                '<td class="" style="text-align:center;"><strong>ลูกค้า</strong></td>'.
                '<td class="" style="text-align:center;"><strong>เงินต้นคงเหลือ</strong></td>'.
                '<td class="" style="text-align:center;"><strong>ดอกเบี้ย</strong></td>'.
                '<td class="" style="text-align:center;"><strong>วันที่รับดอกเบี้ยล่าสุด</strong></td>'.
                '<td class="" style="text-align:center;"><strong>ค่าใช้จ่าย</strong></td>'.
                '<td class="" style="text-align:center;"><strong>ยอดทั้งหมด</strong></td>'.  
            '</tr>'.      
        '</thead>'.
        '<tbody>';
            $sum_all = 0;
            for($i=0; $i < count($debt_data); $i++){
                $interest_last_date = '';
                $sum_all += $result[$i]['debt_payment_sum'];
                if($result[$i]['debt_payment_interest_last_date']!='-'){
                    $interest_last_date = date_format(date_create($result[$i]['debt_payment_interest_last_date']),"d-m-Y");
                }else{
                    $interest_last_date = $result[$i]['debt_payment_interest_last_date'];
                }
                $str .= '<tr>'. 
                    '<td class="" style="text-align:center;">&nbsp;'.$debt_data[$i]['customer_name'].'&nbsp;</td>'.
                    '<td class="" style="text-align:right;">&nbsp;'.number_format($result[$i]['debt_payment_value_balance'], 2, '.', ',').'&nbsp;</td>'.
                    '<td class="" style="text-align:right;">&nbsp;'.number_format($result[$i]['debt_payment_interest'], 2, '.', ',').'&nbsp;</td>'.
                    '<td class="" style="text-align:center;width:160px;">&nbsp;'.$interest_last_date.'&nbsp;</td>'.
                    '<td class="" style="text-align:right;">&nbsp;'.number_format($result[$i]['debt_payment_charge_amount'], 2, '.', ',').'</td>'.
                    '<td class="" style="text-align:right;">&nbsp;'.number_format($result[$i]['debt_payment_sum'], 2, '.', ',').'&nbsp;</td> '. 
                '</tr>'; 
            
            }
             
        $str .= '</tbody>'.
        '<tfoot> 
            <tr>  
                <td colspan="5" style="text-align:right;border:0.5px solid #000;"><strong>รวม</strong></td> 
                <td style="text-align:right;border:0.5px solid #000;"><strong><span id="rp_sum_all">'.number_format($sum_all, 2, '.', ',').'</span></strong></td> 
            </tr>
        </tfoot>'.
    '</table><div style="font-size:14px;" align="">ออกรายงานวันที่ '.$d1.'-'.$d2.'-'.$d3.'&nbsp;'.date("H").':'.$d5.'</div> ';
   
if($export_type=='excel'){
    header("Content-type: application/vnd.ms-excel");
	// header('Content-type: application/csv'); //*** CSV ***//
    header("Content-Disposition: attachment; filename=rp_pay $d1-$d2-$d3 $d4:$d5:$d6.xls");
}
if($export_type=='pdf'){
    include("../../template/mpdf/mpdf.php");
	$mpdf=new mPDF('th', 'A4', '0', 'garuda');   
	$mpdf->AddPage('L');
	$mpdf->mirrorMargins = true;
	
	$mpdf->SetDisplayMode('fullpage','two');
    //$str1 = convertImg($str);
     

	$mpdf->WriteHTML($str);
	
	$mpdf->Output('rp_pay'.$d1.'-'.$d2.'-'.$d3.' '.$d4.'-'.$d5.'-'.$d6.'.pdf','D');
	exit;
}else {
	echo $str;
	?>
    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>
	<script language="javascript">

		window.print();
	</script>
<?php 
}

    
?> 

