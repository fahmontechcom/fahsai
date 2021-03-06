<?php

require_once("BaseModel.php");
class InvoiceModel extends BaseModel{

    function __construct(){
        if(!static::$db){
            static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        }
    }

    

function getInvoiceByCustomerID($customer_id,$deleted=0,$invoice_number = ''){
    $sql = "SELECT tb_invoice.*,SUM(tb_invoice_list.invoice_list_sum) AS list_sum 
    FROM tb_invoice INNER JOIN tb_invoice_list ON tb_invoice.invoice_id = tb_invoice_list.invoice_id 
    WHERE 
    customer_id = '$customer_id' AND 
    invoice_number LIKE ('%$invoice_number%') AND 
    tb_invoice.deleted = $deleted 
    GROUP BY tb_invoice.invoice_id 
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
function getInvoiceBy($deleted=0,$invoice_number = ''){
    $sql = "SELECT * 
    FROM tb_invoice INNER JOIN tb_customer ON tb_invoice.customer_id = tb_customer.customer_id 
    WHERE  
    tb_invoice.invoice_number LIKE ('%$invoice_number%') AND 
    tb_invoice.deleted = $deleted 
    GROUP BY tb_invoice.invoice_id 
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
function getSumInvoiceBy($invoice_number = ''){
    $sql = "SELECT COUNT(invoice_id) AS invoice_count 
    FROM tb_invoice   
    WHERE  
    invoice_number LIKE ('%$invoice_number%')   
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

function getInvoiceByID($id){
    $sql = "SELECT * 
    FROM tb_invoice 
    WHERE invoice_id = '$id' 
    ";
// echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data;
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data = $row;
        }
        $result->close();
        return $data;
    }
}
 
function updateInvoiceByID($id,$data = []){
    $sql = " UPDATE tb_invoice SET 
    invoice_remark = '".$data['invoice_remark']."' 
    WHERE invoice_id = $id ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertInvoice($data=[]){
    $sql = " INSERT INTO tb_invoice(
        customer_id,
        invoice_number,
        invoice_remark,
        invoice_create_date 
        ) VALUES ('".
        $data['customer_id']."','".
        $data['invoice_number']."','".
        $data['invoice_remark']."',".
        "NOW()".
        ")";
        // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) { 
        $id = mysqli_insert_id($this->db); 
        return $id;
    }else {
        return false;
    }
}

function deleteInvoiceByID($id){
    $sql = " DELETE FROM tb_invoice WHERE invoice_id = '$id' ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
    // echo $sql;
}
function deletedInvoiceByID($id,$user_id){
    $sql = " UPDATE tb_invoice SET 
    deleted = 1,
    delete_by = '".$user_id."', 
    delete_date = NOW()  
    WHERE invoice_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function recoverInvoiceByID($id){
    $sql = " UPDATE tb_invoice SET 
    deleted = 0,
    delete_by = '', 
    delete_date = ''  
    WHERE invoice_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
}
?>