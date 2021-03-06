<?php

require_once("BaseModel.php");
class CustomerModel extends BaseModel{

    function __construct(){
        if(!static::$db){
            static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        }
    } 

function getCustomerBy($deleted=0,$name = '', $email = '', $mobile  = ''){
    $sql = "SELECT 
    customer_id,
    customer_name as name , 
    customer_telephone, 
    customer_email,
    IFNULL(( 
        SELECT COUNT(*) 
        FROM tb_debt 
        WHERE debt_cate_id ='0' 
        AND customer_id = tb_cust.customer_id 
        GROUP BY customer_id 
    ),0) AS invoice_number, 
    IFNULL((
        SELECT COUNT(*) 
        FROM tb_debt 
        WHERE debt_cate_id ='1' 
        AND customer_id = tb_cust.customer_id 
        GROUP BY customer_id 
    ),0) AS check_number , 
    FORMAT(IFNULL(( 
        SELECT SUM(debt_value) 
        FROM tb_debt 
        WHERE debt_cate_id ='0' 
        AND customer_id = tb_cust.customer_id  
        GROUP BY customer_id 
    ),0),2) AS invoice_value ,   
    FORMAT(IFNULL((
        SELECT SUM(debt_value)  
        FROM tb_debt  
        WHERE debt_cate_id ='1' 
        AND customer_id = tb_cust.customer_id 
        GROUP BY customer_id 
    ),0),2) AS check_value  
    FROM tb_customer AS tb_cust 
    WHERE deleted = $deleted 
    ORDER BY tb_cust.customer_name
    ";
    // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        $result->close();
        return $data;
    }
}

function getInvoiceNumberByCustomerID($customer_id){
    $sql = "SELECT 
     IFNULL(( 
        SELECT COUNT(*) 
        FROM tb_debt 
        WHERE debt_cate_id ='0' 
        AND customer_id = tb_cust.customer_id 
        GROUP BY customer_id 
    ),0) AS invoice_number, 
    IFNULL((
        SELECT COUNT(*) 
        FROM tb_debt 
        WHERE debt_cate_id ='1' 
        AND customer_id = tb_cust.customer_id 
        GROUP BY customer_id 
    ),0) AS check_number , 
    FORMAT(IFNULL(( 
        SELECT SUM(debt_value) 
        FROM tb_debt 
        WHERE debt_cate_id ='0' 
        AND customer_id = tb_cust.customer_id  
        GROUP BY customer_id 
    ),0),2) AS invoice_value ,   
    FORMAT(IFNULL((
        SELECT SUM(debt_value)  
        FROM tb_debt  
        WHERE debt_cate_id ='1' 
        AND customer_id = tb_cust.customer_id 
        GROUP BY customer_id 
    ),0),2) AS check_value   
    FROM tb_customer AS tb_cust  
    WHERE customer_id = '$customer_id' AND deleted = 0 
    ";

    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data;
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data = $row;
        }
        $result->close();
        return $data;
    }
}

function getCustomerByID($id){
    $sql = " SELECT * 
    FROM tb_customer 
    WHERE customer_id = '$id' 
    ";

    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data;
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data = $row;
        }
        $result->close();
        return $data;
    }
}

function updateCustomerByID($id,$data = []){
    $sql = " UPDATE tb_customer SET 
    customer_name = '".$data['customer_name']."',
    customer_telephone = '".$data['customer_telephone']."', 
    customer_email = '".$data['customer_email']."', 
    customer_address = '".$data['customer_address']."' 
    WHERE customer_id = $id ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertCustomer($data=[]){
    $sql = " INSERT INTO tb_customer(
        customer_name,
        customer_telephone, 
        customer_email, 
        customer_address
        ) VALUES ('".
        $data['customer_name']."','".
        $data['customer_telephone']."','".
        $data['customer_email']."','".
        $data['customer_address']."')";
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        // $img_path="../img_upload/sale/".$data['customer_image'];
        // $ict=move_uploaded_file($data['customer_image_upload'],$img_path); 
        return true;
    }else {
        return false;
    }
}

function deleteCustomerByID($id){
    $sql = " DELETE FROM tb_customer WHERE customer_id = '$id' ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function deletedCustomerByID($id,$user_id){
    $sql = " UPDATE tb_customer SET 
    deleted = 1,
    delete_by = '".$user_id."', 
    delete_date = NOW()  
    WHERE customer_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function recoverCustomerByID($id){
    $sql = " UPDATE tb_customer SET 
    deleted = 0,
    delete_by = '', 
    delete_date = ''  
    WHERE customer_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
}
?>