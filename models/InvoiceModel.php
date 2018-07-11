<?php

require_once("BaseModel.php");
class InvoiceModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    

function getInvoiceBy($invoice_number = ''){
    $sql = "SELECT tb_invoice.*,SUM(tb_invoice_list.invoice_list_sum) AS list_sum 
    FROM tb_invoice INNER JOIN tb_invoice_list ON tb_invoice.invoice_id = tb_invoice_list.invoice_id 
    WHERE  
    invoice_number LIKE ('%$invoice_number%') GROUP BY tb_invoice.invoice_id 
    ";
    // echo $sql;
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
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
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
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
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
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
    
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){
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
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) { 
        return mysqli_insert_id($this->db);
    }else {
        return false;
    }
}

function deleteInvoiceByID($id){
    $sql = " DELETE FROM tb_invoice WHERE invoice_id = '$id' ";
    mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);
    // echo $sql;
}
}
?>