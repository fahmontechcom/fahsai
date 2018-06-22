<?php
require_once('../../../../models/CustomerModel.php');


$path = "";

$model = new CustomerModel;
$customer_id=$_POST['customer_id'];
if(!isset($_POST['action'])){
    $customer = $model->getCustomerBy();
    // echo "<script>console.log(".count($customer).");</script>";
    
    require_once($path.'view.inc.php');

}
else if ($_POST['action'] == 'insert'){
    ?>
    <script>window.location="index.php?content=customer"</script>
    <?php

}else if ($_POST['action'] == 'update'){
    $customer_id = $_POST['id'];
    $customers = $model->getCustomerByID($customer_id);
    $customer = $model->getCustomerBy();
    require_once($path.'view.inc.php');
    

}else if ($_POST['action'] == 'delete'){
    $customer = $model->deleteCustomerByID($_POST['id']);
    ?>
    <script>window.location="index.php?content=customer";</script>
    <?php

}else if ($_POST['action'] == 'add'){
    

        $data = [];
        $data['customer_name'] = $_POST['customer_name'];
        $data['customer_telephone'] = $_POST['customer_telephone'];
        $data['customer_email'] = $_POST['customer_email'];
        $data['customer_address'] = $_POST['customer_address'];
        // echo "<script>console.log(".count($data).");</script>";
        $customer = $model->insertCustomer($data);

        if($customer){
            ?>
            <script>window.location="index.php?content=customer"</script>
            <?php
        }else{
            ?>
            <?php
        }
    
    
}else if ($_POST['action'] == 'edit'){
    
        $data = [];
        $data['customer_name'] = $_POST['customer_name'];
        $data['customer_telephone'] = $_POST['customer_telephone'];
        $data['customer_email'] = $_POST['customer_email'];
        $data['customer_address'] = $_POST['customer_address'];
        
        $customer = $model->updateCustomerByID($_POST['customer_id'],$data);

        if($customer){
            ?>
            <script>window.location="index.php?content=customer"</script>
            <?php
        }else{

            ?>
            <?php
        }
        
    

}
else{

    $customer = $model->getCustomerBy();
    // echo "<script>console.log(".count($customer).");</script>";
    
    require_once($path.'view.inc.php');

}
?>