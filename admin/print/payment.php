<?PHP 
date_default_timezone_set('Asia/Bangkok'); 
$d1=date("d");
$d2=date("m");
$d3=date("Y");
$d4=date("h");
$d5=date("i");
$d6=date("s");
require_once('../../models/PaymentModel.php');  

$path = ""; 
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$export_type = $_GET['export_type'];


$model_payment = new PaymentModel;
$payment = $model_payment->getPaymentCustomerBy($start_date,$end_date); 
$str .= '<style>
table { 
	font-family: "Kanit-Regular";
} 
table, td, th {
    border: 0.5px solid black;
}
td{
    padding:3px;
}
</style>'.
    '<div style="font-size:32px;" align="center"><strong>รายงานการชำระเงิน</strong></div> '.
    '<div style="font-size:16px;" align="center">ระหว่างวันที่ '.date_format(date_create($start_date),"d-m-Y").' ถึง '.date_format(date_create($end_date),"d-m-Y").' </div> '.
    '<br>'.
    '<table width="90%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">'.
        '<thead>'.
            '<tr>'.  
                '<td class="" style="text-align:center;">ลูกค้า</td>'.
                '<td class="" style="text-align:center;">อินวอย</td>'.
                '<td class="" style="text-align:center;">เงินต้น</td>'.
                '<td class="" style="text-align:center;">ดอกเบี้ย</td>'.
                '<td class="" style="text-align:center;">ช่องทางชำระ</td>'.
                '<td class="" style="text-align:center;">วันที่</td>'. 
                '<td class="" style="text-align:center;">ค่าใช้จ่าย</td>'; 
                if($debt_payment_remark!='false'){
                    $str .= '<td class="" style="text-align:center;">หมายเหตุ</td>'; 
                }
                $str .= '<td class="" style="text-align:center;">ชำระ</td>'. 
            '</tr>'.      
        '</thead>'.
        '<tbody>';
            
            for($i=0; $i < count($payment); $i++){
            
                $str .= '<tr>'. 
                    '<td class="" style="text-align:center;">&nbsp;'.$payment[$i]['customer_name'].'&nbsp;</td>'.
                    '<td class="" style="text-align:center;">&nbsp;'.$payment[$i]['debt_invoice_number'].'&nbsp;</td>'.
                    '<td class="" style="text-align:right;">&nbsp;'.number_format($payment[$i]['debt_payment_value_pay'], 2, '.', ',').'&nbsp;</td>'.
                    '<td class="" style="text-align:right;">&nbsp;'.number_format($payment[$i]['debt_payment_interest_pay'], 2, '.', ',').'&nbsp;</td>'.
                    '<td class="" style="text-align:center;">&nbsp;'.$payment[$i]['debt_payment_gateway_name'].'</td>'.
                    '<td class="" style="text-align:center;">&nbsp;'.date_format(date_create($payment[$i]['debt_payment_date']),"d-m-Y").'&nbsp;</td> '.
                    '<td class="" style="text-align:right;">&nbsp;'.number_format($payment[$i]['debt_payment_charge_amount_pay'], 2, '.', ',').'&nbsp;</td> ';
                     if($debt_payment_remark!='false'){ 
                        $str .= '<td class="" style="text-align:center;">&nbsp;'.$payment[$i]['debt_payment_remark'].'&nbsp;</td> ';
                     }  
                     $str .= '<td class="" style="text-align:right;">&nbsp;'.number_format($payment[$i]['debt_payment_pay'], 2, '.', ',').'&nbsp;</td> '.
                '</tr>'; 
            
            }
             
        $str .= '</tbody>'.
        '<tfoot>'. 
        '</tfoot>'.
    '</table>';
if($export_type=='excel'){
    header("Content-type: application/vnd.ms-excel");
	// header('Content-type: application/csv'); //*** CSV ***//
    header("Content-Disposition: attachment; filename=rp_pay $d1-$d2-$d3 $d4:$d5:$d6.xls");
}
if($export_type=='pdf'){
    include("../../template/mpdf/mpdf.php");
	$mpdf=new mPDF('th', 'A4', '0', 'garuda');   
	
	$mpdf->mirrorMargins = true;
	
	$mpdf->SetDisplayMode('fullpage','two');
    //$str1 = convertImg($str);
     

	$mpdf->WriteHTML($str);
	
	$mpdf->Output('rp_pay'.$d1.'-'.$d2.'-'.$d3.' '.$d4.'-'.$d5.'-'.$d6.'.pdf','D');
	exit;
}else {
	echo $str;
	?>
	<script language="javascript">

		window.print();
	</script>
<?php 
}

    
?> 

