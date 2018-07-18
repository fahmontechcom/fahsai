<?PHP 
date_default_timezone_set('Asia/Bangkok'); 
$d1=date("d");
$d2=date("m");
$d3=date("Y");
$d4=date("h");
$d5=date("i");
$d6=date("s");
require_once('../../models/ScheduleListModel.php');  

$path = ""; 
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$export_type = $_GET['export_type'];


$model_schedule_list = new ScheduleListModel;
$schedule_list = $model_schedule_list->getScheduleListCustomerBy($start_date,$end_date); 
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
    '<div style="font-size:18px;" align="center"><strong>รายงานกำหนดการรวม</strong></div> '.
    '<div style="font-size:14px;" align="right">ระหว่างวันที่ '.date_format(date_create($start_date),"d-m-Y").' ถึง '.date_format(date_create($end_date),"d-m-Y").' </div> '. 
    '<table width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">'.
        '<thead>'.
            '<tr>'.  
                '<td class="" style="text-align:center;"><strong>วันที่</strong></td>'.
                '<td class="" style="text-align:center;"><strong>รายละเอียด</strong></td>'.
                '<td class="" style="text-align:center;"><strong>ลูกค้า</strong></td>'.
                '<td class="" style="text-align:center;"><strong>อินวอย</strong></td>'. 
            '</tr>'.      
        '</thead>'.
        '<tbody>';
            
            for($i=0; $i < count($schedule_list); $i++){ 
                $str .= '<tr>'. 
                    '<td class="" style="text-align:center;">&nbsp;'.date_format(date_create($schedule_list[$i]['debt_schedule_list_date']),"d-m-Y").'&nbsp;</td>'.
                    '<td class="" style="text-align:center;">&nbsp;'.$schedule_list[$i]['debt_schedule_list_detail'].'&nbsp;</td>'.
                    '<td class="" style="text-align:center;">&nbsp;'.$schedule_list[$i]['customer_name'].'&nbsp;</td>'.
                    '<td class="" style="text-align:center;">&nbsp;'.$schedule_list[$i]['debt_invoice_number'].'&nbsp;</td>'. 
                '</tr>'; 
            
            }
             
        $str .= '</tbody>'.
        '<tfoot>'. 
        '</tfoot>'.
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

