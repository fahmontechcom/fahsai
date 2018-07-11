<?php

require_once("BaseModel.php");
class DebtModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    } 
function getDebtBy($customer_id = '',$debt_check_number = '', $debt_invoice_number = '',$point=2){
    $sql = "SELECT *
    FROM tb_debt 
    WHERE customer_id='$customer_id' AND debt_check_number LIKE ('%$debt_check_number%') 
    AND debt_invoice_number LIKE ('%$debt_invoice_number%')
    ";
    
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
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
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data;
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data = $row;
        }
        $result->close();
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
    debt_remark = '".$data['debt_remark']."', 
    updateby = '".$data['updateby']."', 
    lastupdate = ".$data['lastupdate']." 
    WHERE debt_id = $id ";
    
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){
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
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){
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
        $data['debt_remark']."','".
        $data['updateby']."',".
        $data['lastupdate'].")";
        
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        // $img_path="../img_upload/sale/".$data['sale_image'];
        // $ict=move_uploaded_file($data['sale_image_upload'],$img_path);
        return true;
    }else {
        return false;
    }
}

    function deleteDebtByID($id){
        $sql = " DELETE FROM tb_debt WHERE debt_id = '$id' ";
        mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);
    }
    
}
?>