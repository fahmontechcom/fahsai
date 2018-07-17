<?php
date_default_timezone_set('Asia/Bangkok');
require_once('../models/InvoiceModel.php');
require_once('../models/InvoiceListModel.php');
require_once('../models/CustomerModel.php');
require_once('../models/DebtModel.php'); 

$path = "modules/invoice/views/";

$model = new InvoiceModel;
$model_list = new InvoiceListModel;
$model_customer = new CustomerModel;
$model_debt = new DebtModel;

$customer_id = $_GET['customer_id'];
$invoice_id = $_GET['invoice_id'];
$btn_click = $_POST['btn_click'];

if(!isset($_GET['action'])){ 
    $debt = $model_debt->getDebtBy($customer_id);
    $customer = $model_customer->getCustomerByID($customer_id);
    $invoice = $model->getInvoiceBy($customer_id); 
    require_once($path.'view.inc.php'); 
}
else if ($_GET['action'] == 'insert'){ 

}else if ($_GET['action'] == 'update'){ 

}else if ($_GET['action'] == 'delete'){
    $model->deleteInvoiceByID($_GET['id']);
    $debt = $model_debt->getDebtBy($customer_id);
    $customer = $model_customer->getCustomerByID($customer_id);
    $invoice = $model->getInvoiceBy($customer_id); 
    require_once($path.'view.inc.php');  
}else if ($_GET['action'] == 'add'){ 
    $invoice_str =''; 
    $invoice_count = $model->getSumInvoiceBy(); 
    $invoice_count_list = $invoice_count[0]['invoice_count']+1;
    if($invoice_count_list%10>0){
        $invoice_str = '00'.$invoice_count_list;
    }else if($invoice_count_list%100>0){
        $invoice_str = '0'.$invoice_count_list;
    }else{
        $invoice_str = $invoice_count_list;
    }  
    
    $data = [];
    $data['customer_id'] = $customer_id;
    $data['invoice_number'] = 'RV'.date('d').date('m').$invoice_str;
    $data['invoice_remark'] = $_POST['invoice_remark'];
    // echo "<script>console.log(".count($data).");</script>";
    $invoice_id = $model->insertInvoice($data);

    if($invoice_id!=false&&$invoice_id!=''){
        $invoice_list_id = $_POST['invoice_list_id'];
        $debt_date = $_POST['debt_date'];
        $debt_id = $_POST['debt_id'];
        $debt_balance = $_POST['debt_balance'];
        $invoice_list_to_date = $_POST['invoice_list_to_date'];
        $debt_charge_amount = $_POST['debt_charge_amount'];
        $interest_balance = $_POST['interest_balance'];
        $sum = $_POST['sum'];
        $model_list->deleteInvoiceListByInvoiceIDNotIN($invoice_id,$invoice_list_id);
        if(is_array($debt_id)){
            for($i=0; $i < count($debt_id) ; $i++){
                $data = [];
                $data['invoice_id'] = $invoice_id;
                $data['invoice_list_debt_date'] = $debt_date[$i];
                $data['debt_id'] = $debt_id[$i];
                $data['invoice_list_debt_balance'] = str_replace(',','',$debt_balance[$i]);
                $data['invoice_list_to_date'] = $invoice_list_to_date[$i];
                $data['invoice_list_debt_charge_amount'] = str_replace(',','',$debt_charge_amount[$i]);
                $data['invoice_list_interest_balance'] = str_replace(',','',$interest_balance[$i]);
                $data['invoice_list_sum'] = str_replace(',','',$sum[$i]); 
                $model_list->insertInvoiceList($data);  
            }
        }else{
            $data = [];
            $data['invoice_id'] = $invoice_id;
            $data['invoice_list_debt_date'] = $debt_date;
            $data['debt_id'] = $debt_id;
            $data['invoice_list_debt_balance'] = str_replace(',','',$debt_balance);
            $data['invoice_list_to_date'] = $invoice_list_to_date;
            $data['invoice_list_debt_charge_amount'] = str_replace(',','',$debt_charge_amount);
            $data['invoice_list_interest_balance'] = str_replace(',','',$interest_balance);
            $data['invoice_list_sum'] = str_replace(',','',$sum); 
            $model_list->insertInvoiceList($data); 
        } 
        if($btn_click=='1'){
            
            ?>
                <script>alert('ส่งอีเมลเรียบร้อยแล้ว');</script>
            <?php 
        }else if($btn_click=='2'){ 
            ?>
                <script>
                    // alert();
                    window.location="index.php?content=invoice&action=print&customer_id=<?php echo $customer_id;?>&invoice_id=<?php echo $invoice_id;?>";
                </script>
            <?php 
        }else{
            ?>
                <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
            <?php 
        }
    }else{ 
        ?>
            <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
        <?php 
    }
 
}else if ($_GET['action'] == 'edit'){
    
    $invoice_str =''; 
    $invoice_count = $model->getSumInvoiceBy(); 
    $invoice_count_list = $invoice_count[0]['invoice_count']+1;
    if($invoice_count_list%10>0){
        $invoice_str = '00'.$invoice_count_list;
    }else if($invoice_count_list%100>0){
        $invoice_str = '0'.$invoice_count_list;
    }else{
        $invoice_str = $invoice_count_list;
    }
    
        
    
    $data = [];
    $data['customer_id'] = $customer_id;
    $data['invoice_number'] = 'RV'.date('d').date('m').$invoice_str;
    $data['invoice_remark'] = $_POST['invoice_remark'];
    // echo "<script>console.log(".count($data).");</script>";
    $check_result = $model->updateInvoiceByID($invoice_id,$data);

    if($invoice_id!=false&&$invoice_id!=''){
        $invoice_list_id = $_POST['invoice_list_id'];
        $debt_date = $_POST['debt_date'];
        $debt_id = $_POST['debt_id'];
        $debt_balance = $_POST['debt_balance'];
        $invoice_list_to_date = $_POST['invoice_list_to_date'];
        $debt_charge_amount = $_POST['debt_charge_amount'];
        $interest_balance = $_POST['interest_balance'];
        $sum = $_POST['sum'];
        $model_list->deleteInvoiceListByInvoiceIDNotIN($invoice_id,$invoice_list_id);
        if(is_array($debt_id)){
            for($i=0; $i < count($debt_id) ; $i++){
                $data = [];
                $data['invoice_id'] = $invoice_id;
                $data['invoice_list_debt_date'] = $debt_date[$i];
                $data['debt_id'] = $debt_id[$i];
                $data['invoice_list_debt_balance'] = str_replace(',','',$debt_balance[$i]);
                $data['invoice_list_to_date'] = $invoice_list_to_date[$i];
                $data['invoice_list_debt_charge_amount'] = str_replace(',','',$debt_charge_amount[$i]);
                $data['invoice_list_interest_balance'] = str_replace(',','',$interest_balance[$i]);
                $data['invoice_list_sum'] = str_replace(',','',$sum[$i]);
                if ($invoice_list_id[$i] != "" && $invoice_list_id[$i] != '0'){
                    $model_list->updateInvoiceListByID($data,$invoice_list_id[$i]);
                }else{
                    $model_list->insertInvoiceList($data);
                }
                
            }
        }else{
            $data = [];
            $data['invoice_id'] = $invoice_id;
            $data['invoice_list_debt_date'] = $debt_date;
            $data['debt_id'] = $debt_id;
            $data['invoice_list_debt_balance'] = str_replace(',','',$debt_balance);
            $data['invoice_list_to_date'] = $invoice_list_to_date;
            $data['invoice_list_debt_charge_amount'] = str_replace(',','',$debt_charge_amount);
            $data['invoice_list_interest_balance'] = str_replace(',','',$interest_balance);
            $data['invoice_list_sum'] = str_replace(',','',$sum);
            if ($invoice_list_id != "" && $invoice_list_id != '0'){
                $model_list->updateInvoiceListByID($data,$invoice_list_id);
            }else{
                $model_list->insertInvoiceList($data);
            } 
        }

        if($btn_click=='1'){ 
            ?>
                <script>
                    // alert();
                window.location="index.php?content=invoice&action=email&customer_id=<?php echo $customer_id;?>&invoice_id=<?php echo $invoice_id;?>";
                </script>
            <?php 
        }else if($btn_click=='2'){ 
            ?>
                <script>
                    // alert();
                window.location="index.php?content=invoice&action=print&customer_id=<?php echo $customer_id;?>&invoice_id=<?php echo $invoice_id;?>";
                </script>
            <?php 
        }else{
            ?>
                <script>alert('ส่งเมล');</script>
            <?php 
        }
    }else{ 
        ?>
            <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
        <?php 
    }
}else if ($_GET['action'] == 'print'){
    $customer = $model_customer->getCustomerByID($customer_id); 
    $invoice_list = $model_list ->getInvoiceListByInvoiceID($invoice_id);
    $invoice = $model ->getInvoiceByID($invoice_id);  
    $invoice_list_sum = $model_list ->getSumInvoiceListByInvoiceID($invoice_id);
    // echo "------------end--------------";
    // echo "<pre>";
    // print_r($invoice_list_sum);
    // echo "</pre>";  
    require_once($path.'detail.inc.php'); 
}else if ($_GET['action'] == 'email'){
    $customer = $model_customer->getCustomerByID($customer_id); 
    $invoice_list = $model_list ->getInvoiceListByInvoiceID($invoice_id);
    $invoice = $model ->getInvoiceByID($invoice_id);  
    $invoice_list_sum = $model_list ->getSumInvoiceListByInvoiceID($invoice_id);
    if($invoice_id > 0){
        /******** setmail ********************************************/
        require("../controllers/mail/class.phpmailer.php");
        $mail = new PHPMailer();
        $body = '<div style="font-size:32px;" align="center"><strong>ใบแจ้งหนี้</strong></div>'.
                '<div>'. 
                    '<p style="font-size: 14px;"><strong>รหัสใบแจ้งหนี้ </strong> '.$invoice['invoice_number'].'</p>'.
                    '<span style="font-size: 14px;"><strong>ชื่อลูกค้า </strong> '.$customer['customer_name'].'</span><br>'.
                    '<span style="font-size: 14px;"><strong>ที่อยู่ </strong> '.$customer['customer_address'].'</span><br>'.
                    '<span style="font-size: 14px;"><strong>อีเมล </strong> '.$customer['customer_email'].'</span><br>'.
                    '<span style="font-size: 14px;"><strong>หมายเหตุ </strong> '.$invoice['invoice_remark'].'</span> '.
                '</div>'.
                '<table width="90%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">'.
                    '<thead>'.
                        '<tr>'. 
                            '<td  style="text-align:center;border:1px solid #000;padding:2px;font-size:14px;">วันที่</td>'.
                            '<td  style="text-align:center;border:1px solid #000;padding:2px;font-size:14px;">อินวอย</td>'.
                            '<td  style="text-align:center;border:1px solid #000;padding:2px;font-size:14px;">ยอด</td>'.
                            '<td  style="text-align:center;border:1px solid #000;padding:2px;font-size:14px;">ถึงวันที่</td>'.
                            '<td  style="text-align:center;border:1px solid #000;padding:2px;font-size:14px;">ค่าใช้จ่าย</td>'.
                            '<td  style="text-align:center;border:1px solid #000;padding:2px;font-size:14px;">ดอกเบี้ย</td>'.
                            '<td  style="text-align:center;border:1px solid #000;padding:2px;font-size:14px;">รวม</td> '.
                        '</tr>'.        
                    '</thead>'.
                    '<tbody>'; 
                    for($i=0; $i < count($invoice_list); $i++){ 
                        $body .= '<tr>'. 
                                    '<td style="padding:2px;font-size:14px;text-align:center;width:110px;border:1px solid #000;">'.date_format(date_create($invoice_list[$i]['invoice_list_debt_date']),"d-m-Y").'</td>'.
                                    '<td style="padding:2px;font-size:14px;text-align:center;width:140px;border:1px solid #000;">'.$invoice_list[$i]['debt_invoice_number'].'</td>'.
                                    '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list[$i]['invoice_list_debt_balance'], 2, '.', ',').'</td>'.
                                    '<td style="padding:2px;font-size:14px;text-align:center;border:1px solid #000;">'. date_format(date_create($invoice_list[$i]['invoice_list_to_date']),"d-m-Y") .'</td>'.
                                    '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list[$i]['invoice_list_debt_charge_amount'], 2, '.', ',').'</td>'.
                                    '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list[$i]['invoice_list_interest_balance'], 2, '.', ',').'</td>'.
                                    '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list[$i]['invoice_list_sum'], 2, '.', ',').'</td> '.
                                '</tr> ';
                    
                    }                     
            $body .= '</tbody>'.
                    '<tfoot>'.
                        '<tr>'. 
                            '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;" colspan="2">รวม</td>'. 
                            '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list_sum[0]['invoice_list_debt_balance'], 2, '.', ',').'</td>'.
                            '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;"></td>'.
                            '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list_sum[0]['invoice_list_debt_charge_amount'], 2, '.', ',').'</td>'.
                            '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list_sum[0]['invoice_list_interest_balance'], 2, '.', ',').'</td>'.
                            '<td style="padding:2px;font-size:14px;text-align: right;border:1px solid #000;">'. number_format($invoice_list_sum[0]['invoice_list_sum'], 2, '.', ',').'</td>'. 
                        '</tr>'. 
                    '</tfoot>'.
                '</table>'.          
                '<p style="font-size: 14px;"><strong>รวมยอด</strong> : เงินต้น + ค่าใช้จ่าย + ดอกเบี้ย = '. number_format($invoice_list_sum[0]['invoice_list_debt_balance'], 2, '.', ',').' + '. number_format($invoice_list_sum[0]['invoice_list_debt_charge_amount'], 2, '.', ',').' + '. number_format($invoice_list_sum[0]['invoice_list_interest_balance'], 2, '.', ',').' = '. number_format($invoice_list_sum[0]['invoice_list_sum'], 2, '.', ',').' บาท</p>';

        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = "mail.revelsoft.co.th"; // SMTP server
        $mail->Port = 587; 
        $mail->Username = "support@revelsoft.co.th"; // account SMTP
        $mail->Password = "revelsoft1234@"; //  SMTP

        $mail->SetFrom("support@revelsoft.co.th", "Revelsoft.co.th");
        $mail->AddReplyTo("support@revelsoft.co.th","Revelsoft.co.th");
        $mail->Subject = "ใบแจ้งหนี้ ถึง ".$customer['customer_name'];

        $mail->MsgHTML($body);

        $mail->AddAddress($customer['customer_email'], "Customer Mail"); //
        //$mail->AddAddress($set1, $name); // 
        if(!$mail->Send()) {
            $result = "Mailer Error: " . $mail->ErrorInfo;
        }else{
            // $output = $purchase_order_model->updatePurchaseOrderStatusByID($purchase_order_id,$data);
            $result = "Send email complete.";
        } 
        ?>
        <script>
            alert("<?php echo $result; ?>");
            window.history.back();
        </script>
        <?php   
    }else{
        ?>
        <script>window.history.back();</script>
        <?php
    } 
    require_once($path.'view.inc.php');  
}else{

    $debt = $model_debt->getDebtBy($customer_id);
    $customer = $model_customer->getCustomerByID($customer_id);
    $invoice = $model->getInvoiceBy($customer_id); 
    require_once($path.'view.inc.php'); 

}
?>