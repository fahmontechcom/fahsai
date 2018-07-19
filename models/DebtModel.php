<?php

require_once("BaseModel.php");
class DebtModel extends BaseModel{

function __construct(){
    if(!static::$db){
        static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }
}
function getDebtAllBy($deleted=0,$point=2){
    $sql = "SELECT *  
    FROM tb_debt INNER JOIN tb_customer ON tb_debt.customer_id = tb_customer.customer_id 
    WHERE   tb_debt.debt_check_number LIKE ('%$debt_check_number%') 
    AND tb_debt.debt_invoice_number LIKE ('%$debt_invoice_number%') 
    AND tb_debt.deleted = $deleted 
    ";
    // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        $result->close();
        // echo "<script>alert(".count($data).");</script>";
        // echo $sql;        
        return $data;
    }
}
function getDebtBy($customer_id = '',$debt_check_number = '', $debt_invoice_number = '',$deleted=0,$point=2){
    $sql = "SELECT *
    FROM tb_debt INNER JOIN tb_customer ON tb_debt.customer_id = tb_customer.customer_id 
    WHERE tb_debt.customer_id='$customer_id' 
    AND tb_debt.debt_check_number LIKE ('%$debt_check_number%') 
    AND tb_debt.debt_invoice_number LIKE ('%$debt_invoice_number%') 
    AND tb_debt.deleted = $deleted 
    ";
    // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        $result->close();
        // echo "<script>alert(".count($data).");</script>";
        // echo $sql;        
        return $data;
    }
}

function getDebtByID($id){
    $sql = " SELECT * 
    FROM tb_debt 
    WHERE debt_id = '$id' 
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
function getDebtAndCustomerBy(){
    $sql = " SELECT * 
    FROM tb_debt INNER JOIN tb_customer ON tb_debt.customer_id = tb_customer.customer_id 
    ORDER BY  tb_customer.customer_id
    ";
    // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        $result->close();
        // echo "<script>alert(".count($data).");</script>";
        // echo $sql;        
        return $data;
    }
}
function getDebtAndCustomerByDate($start_date,$end_date){
    $sql = " SELECT * 
    FROM tb_debt INNER JOIN tb_customer ON tb_debt.customer_id = tb_customer.customer_id 
    WHERE debt_date >= '$start_date' AND debt_date <= '$end_date'   
    ORDER BY  tb_customer.customer_id
    ";
    // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        $result->close();
        // echo "<script>alert(".count($data).");</script>";
        // echo $sql;        
        return $data;
    }
}

function updateDebtByID($customer_id,$id,$data = []){
    
    $sql = " UPDATE tb_debt SET 
    debt_cate_id = '".$data['debt_cate_id']."', 
    sale_id = '".$data['sale_id']."', 
    debt_check_number = '".$data['debt_check_number']."', 
    debt_invoice_number = '".$data['debt_invoice_number']."', 
    debt_value = '".$data['debt_value']."', 
    debt_balance = '".$data['debt_balance']."', 
    debt_interest = '".$data['debt_interest']."', 
    debt_date = '".$data['debt_date']."', 
    debt_bill_date = '".$data['debt_bill_date']."', 
    debt_remark = '".$data['debt_remark']."', 
    updateby = '".$data['updateby']."', 
    lastupdate = ".$data['lastupdate']." 
    WHERE debt_id = $id ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}
function updateDebtBalanceByID($data = []){
    
    $sql = " UPDATE tb_debt SET  
    debt_balance = '".$data['debt_payment_value_balance']."', 
    debt_charge_amount = '".$data['debt_payment_charge_amount_balance']."', 
    debt_charge_amount_new_id = '".$data['debt_payment_charge_amount_new_id']."', 
    debt_interest = '".$data['debt_payment_interest_balance']."' 
    WHERE debt_id = '".$data['debt_id']."' ";
    // echo $sql;
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertDebt($data=[]){
    $sql = " INSERT INTO tb_debt(
        customer_id, 
        debt_cate_id, 
        sale_id, 
        debt_check_number, 
        debt_invoice_number, 
        debt_value,
        debt_balance,
        debt_interest,
        debt_date,
        debt_bill_date,
        debt_remark,
        updateby,
        lastupdate
        ) VALUES ('".
        $data['customer_id']."','".
        $data['debt_cate_id']."','".
        $data['sale_id']."','".
        $data['debt_check_number']."','".
        $data['debt_invoice_number']."','".
        $data['debt_value']."','".
        $data['debt_balance']."','".
        $data['debt_interest']."','".
        $data['debt_date']."','".
        $data['debt_bill_date']."','".
        $data['debt_remark']."','".
        $data['updateby']."',".
        $data['lastupdate'].")";
        
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        // $img_path="../img_upload/sale/".$data['sale_image'];
        // $ict=move_uploaded_file($data['sale_image_upload'],$img_path); 
        return true;
    }else {
        return false;
    }
}

    function deleteDebtByID($id){
        $sql = " DELETE FROM tb_debt WHERE debt_id = '$id' ";
        $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
    }
    function deletedDebtByID($id,$user_id){
        $sql = " UPDATE tb_debt SET 
        deleted = 1,
        delete_by = '".$user_id."', 
        delete_date = NOW()  
        WHERE debt_id = $id ";
        $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
    }
    function recoverDebtByID($id){
        $sql = " UPDATE tb_debt SET 
        deleted = 0,
        delete_by = '', 
        delete_date = ''  
        WHERE debt_id = $id ";
        $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
    }
    
}
?>