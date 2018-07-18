<?php
require_once('../models/CustomerModel.php');


$path = "modules/customer/views/";

$model = new CustomerModel;

if(!isset($_GET['action'])){
    $customer = $model->getCustomerBy();
    // echo "<script>console.log(".count($customer).");</script>";
    require_once($path.'view.inc.php');

}
else if ($_GET['action'] == 'insert'){
    ?>
    <script>window.location="index.php?content=customer"</script>
    <?php

}else if ($_GET['action'] == 'update'){
    $customer_id = $_GET['id'];
    $customers = $model->getCustomerByID($customer_id);
    $customer = $model->getCustomerBy();
    require_once($path.'view.inc.php');
    

}else if ($_GET['action'] == 'delete'){
    // $customer = $model->deleteCustomerByID($_GET['id']);
    ?>
    <!-- <script>window.location="index.php?content=customer";</script> -->
    <?php
    $customer = $model->deletedCustomerByID($_GET['id'],$user[0][0]);
    ?>
    <script>window.location="index.php?content=customer";</script>
    <?php

}else if ($_GET['action'] == 'add'){
    

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
    
    
}else if ($_GET['action'] == 'edit'){
    
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

    $customer = $model->getCustomerBy($_GET['name'],$_GET['position'],$_GET['email']);
    require_once($path.'view.inc.php');

}
?>