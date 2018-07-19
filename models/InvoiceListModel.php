<?php

require_once("BaseModel.php");
class InvoiceListModel extends BaseModel{

    function __construct(){
        if(!static::$db){
            static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        }
    }

    

function getInvoiceListBy($invoice_number = ''){
    $sql = "SELECT *
    FROM tb_invoice_list 
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

function getInvoiceListByInvoiceID($id){
    $sql = "SELECT tb_invoice_list.*,tb_debt.debt_invoice_number
    FROM tb_invoice_list INNER JOIN tb_debt ON tb_invoice_list.debt_id = tb_debt.debt_id 
    WHERE invoice_id = '$id' 
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
function getSumInvoiceListByInvoiceID($id){
    $sql = "SELECT SUM(invoice_list_debt_balance) AS invoice_list_debt_balance,SUM(invoice_list_debt_charge_amount) AS invoice_list_debt_charge_amount,SUM(invoice_list_interest_balance) AS invoice_list_interest_balance,SUM(invoice_list_sum) AS invoice_list_sum
    FROM tb_invoice_list  
    WHERE invoice_id = '$id' GROUP BY invoice_id
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



function updateInvoiceListByID($data = [],$id){
    $sql = " UPDATE tb_invoice_list SET 
    invoice_id = '".$data['invoice_id']."', 
    invoice_list_debt_date = '".$data['invoice_list_debt_date']."', 
    debt_id = '".$data['debt_id']."', 
    invoice_list_debt_balance = '".$data['invoice_list_debt_balance']."', 
    invoice_list_to_date = '".$data['invoice_list_to_date']."', 
    invoice_list_debt_charge_amount = '".$data['invoice_list_debt_charge_amount']."', 
    invoice_list_interest_balance = '".$data['invoice_list_interest_balance']."', 
    invoice_list_sum = '".$data['invoice_list_sum']."' 
    WHERE invoice_list_id = $id ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertInvoiceList($data=[]){
    $sql = " INSERT INTO tb_invoice_list(
        invoice_id,
        invoice_list_debt_date,
        debt_id, 
        invoice_list_debt_balance, 
        invoice_list_to_date, 
        invoice_list_debt_charge_amount, 
        invoice_list_interest_balance, 
        invoice_list_sum 
        ) VALUES ('".
        $data['invoice_id']."','".
        $data['invoice_list_debt_date']."','".
        $data['debt_id']."','".
        $data['invoice_list_debt_balance']."','".
        $data['invoice_list_to_date']."','".
        $data['invoice_list_debt_charge_amount']."','".
        $data['invoice_list_interest_balance']."','".
        $data['invoice_list_sum']."'".
        ")";
        // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) { 
        return true;
    }else {
        return false;
    }
}

function deleteInvoiceListByID($id){
    $sql = " DELETE FROM tb_invoice_list WHERE invoice_id = '$id' ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}

function deleteInvoiceListByInvoiceIDNotIN($id,$data){
    $str ='';
    if(is_array($data)){ 
        for($i=0; $i < count($data) ;$i++){
            if($data[$i] != ""){
                $str .= $data[$i];
                if($i + 1 < count($data)){
                    $str .= ',';
                }
            }
        }
    }else if ($data != ''){
        $str = $data;
    }else{
        $str='0';
    }

    if( $str==''){
        $str='0';
    }

    $sql = "DELETE FROM tb_invoice_list WHERE invoice_id = '$id' AND invoice_list_id NOT IN ($str) ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 

}

}
?>