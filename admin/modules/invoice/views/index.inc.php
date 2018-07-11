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

if(!isset($_GET['action'])){ 
    $debt = $model_debt->getDebtBy($customer_id);
    $customer = $model_customer->getCustomerByID($customer_id);
    $invoice = $model->getInvoiceBy(); 
    require_once($path.'view.inc.php'); 
}
else if ($_GET['action'] == 'insert'){ 

}else if ($_GET['action'] == 'update'){ 

}else if ($_GET['action'] == 'delete'){
    $model->deleteInvoiceByID($_GET['id']);
    $debt = $model_debt->getDebtBy($customer_id);
    $customer = $model_customer->getCustomerByID($customer_id);
    $invoice = $model->getInvoiceBy(); 
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
                    if ($invoice_list_id[$i] != "" && $invoice_list_id[$i] != '0'){
                        $model_list->updateInvoiceListByID($data,$invoice_list_id[$i]);
                    }else{
                        $model_list->insertInvoiceList($data);
                    }
                    ?>
                            <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
                    <?php 
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
                ?>
                        <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
                <?php 
            }

            ?>
                    <!-- <script>window.location="index.php?content=invoice&action=update&id=<?php echo $invoice_id;?>"</script> -->
            <?php
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
                ?>
                        <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
                <?php 
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
            ?>
                    <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
            <?php 
        }

        ?>
                <!-- <script>window.location="index.php?content=invoice&action=update&id=<?php echo $invoice_id;?>"</script> -->
        <?php
    }else{ 
        ?>
            <script>window.location="index.php?content=invoice&customer_id=<?php echo $customer_id;?>"</script>
        <?php 
    }
        
    

}
else{

    $debt = $model_debt->getDebtBy($customer_id);
    $customer = $model_customer->getCustomerByID($customer_id);
    $invoice = $model->getInvoiceBy(); 
    require_once($path.'view.inc.php'); 

}
?>