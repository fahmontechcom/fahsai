<?php

require_once('../../../../models/DebtModel.php');
require_once('../../../../models/SaleModel.php');


$path = "";

$model = new DebtModel;
$model_sale = new SaleModel;
$customer_id=$_POST['customer_id'];

if(!isset($_POST['action'])){
    
    $debt = $model->getDebtBy($customer_id);
    $sale = $model_sale->getSaleBy();
    require_once($path.'view.inc.php');

}
else if ($_POST['action'] == 'insert'){
    
    ?>
    <script>window.location="index.php?content=customer"</script>
    <?php

}else if ($_POST['action'] == 'update'){
    $customer_id = $_POST['id'];
    $customers = $model->getDebtByID($customer_id);
    $customer = $model->getDebtBy();
    require_once($path.'view.inc.php');
    

}else if ($_POST['action'] == 'delete'){
    $customer = $model->deleteDebtByID($_POST['id']);
    
    $debt = $model->getDebtBy($customer_id);
    $sale = $model_sale->getSaleBy();
    // echo "<script>console.log(".count($debt).");</script>";
    
    require_once($path.'view.inc.php');

}else if ($_POST['action'] == 'add'){
    

        $data = [];
        $data['customer_id'] = $_POST['customer_id'];
        $data['debt_cate_id'] = $_POST['debt_cate_id'];
        $data['sale_id'] = $_POST['sale_id'];
        $data['debt_check_number'] = $_POST['debt_check_number'];
        $data['debt_invoice_number'] = $_POST['debt_invoice_number'];
        $data['debt_value'] = $_POST['debt_value'];
        $data['debt_balance'] = $_POST['debt_value'];
        $data['debt_interest'] = 0;
        $data['debt_date'] = $_POST['debt_date'];
        $data['debt_remark'] = $_POST['debt_remark'];
        $data['updateby'] = $user[0][0];
        $data['lastupdate'] = 'NOW()';
        // echo "<script>alert('');</script>";
        $debt = $model->insertDebt($data);

        if($debt){
            $debt = $model->getDebtBy($customer_id);
            $sale = $model_sale->getSaleBy();
            // echo "<script>console.log(".count($debt).");</script>";
            
            require_once($path.'view.inc.php');
        }else{
            echo '0';
        }
    
    
}else if ($_POST['action'] == 'edit'){
    
    $data = [];
    $data['debt_cate_id'] = $_POST['debt_cate_id'];
    $data['sale_id'] = $_POST['sale_id'];
    $data['debt_check_number'] = $_POST['debt_check_number'];
    $data['debt_invoice_number'] = $_POST['debt_invoice_number'];
    $data['debt_value'] = $_POST['debt_value'];
    $data['debt_balance'] = $_POST['debt_value'];
    $data['debt_interest'] = 0;
    $data['debt_date'] = $_POST['debt_date'];
    $data['debt_remark'] = $_POST['debt_remark'];
    $data['updateby'] = $user[0][0];
    $data['lastupdate'] = 'NOW()';
    
    $debt = $model->updateDebtByID($_POST['customer_id'],$_POST['debt_id'],$data);

    if($debt){
        // echo "<script>alert('".$_POST['action']."');</script>";
        $debt = $model->getDebtBy($customer_id);
        $sale = $model_sale->getSaleBy();
        // echo "<script>console.log(".count($debt).");</script>";
        
        require_once($path.'view.inc.php');
    }else{

        ?>
        <?php
    }
        
    

}
else{
    // echo "<script>alert('".$_POST['action']."');</script>";
    $debt = $model->getDebtBy($customer_id);
    $sale = $model_sale->getSaleBy();
    // echo "<script>console.log(".count($debt).");</script>";
    
    require_once($path.'view.inc.php');
}
?>