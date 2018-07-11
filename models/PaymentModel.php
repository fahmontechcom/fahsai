<?php

require_once("BaseModel.php");
class PaymentModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    } 
function getPaymentBy($debt = ''){
    $sql = "SELECT tb_debt_payment.* ,tb_debt_payment_gateway.debt_payment_gateway_name
    FROM tb_debt_payment INNER JOIN tb_debt_payment_gateway ON tb_debt_payment.debt_payment_gateway_id = tb_debt_payment_gateway.debt_payment_gateway_id 
    WHERE debt_id='$debt' 
    ORDER BY  str_to_date( tb_debt_payment.debt_payment_date,'%m/%d/%Y %h:%i:%s' ) 
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

function getSumPaymentBy($debt_id){
    $sql = " SELECT SUM(debt_payment_pay) as debt_payment_pay 
    FROM tb_debt_payment 
    WHERE debt_id = '$debt_id' 
    ORDER BY debt_payment_id 
    ";
    // echo $sql;
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $result->close();
        return $data;
    }

}
function getLastPaymentBy($debt_id){
    $sql = "SELECT * FROM tb_debt_payment WHERE debt_id = '$debt_id' AND debt_payment_date IN (SELECT MAX(debt_payment_date) FROM tb_debt_payment WHERE debt_id = '$debt_id' ) ORDER BY debt_payment_id DESC
    ";
    // echo $sql;
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $result->close();
        return $data;
    }

}


function getCountPaymentByID($id){
    $sql = " SELECT COUNT(debt_payment_id) AS count_payment 
    FROM tb_debt_payment 
    WHERE debt_id = '$id' 
    ";
    // echo $sql;
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $result->close();
        return $data;
    }
}

function getCountPaymentByChargeID($id){
    $sql = " SELECT COUNT(debt_payment_id) AS count_payment 
    FROM tb_debt_payment 
    WHERE debt_payment_charge_amount_new_id >= '$id' 
    ";
    // echo $sql;
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $result->close();
        return $data;
    }
}
function getBeforePaymentByID($id,$debt_id){
    $sql = " SELECT * FROM tb_debt_payment WHERE debt_id = '$debt_id' AND debt_payment_date < (SELECT debt_payment_date
    FROM tb_debt_payment 
    WHERE debt_payment_id = '$id') ORDER BY debt_payment_date DESC
    ";
    // echo $sql;
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $result->close();
        return $data;
    }
}
function getPaymentByID($id){
    $sql = " SELECT *
    FROM tb_debt_payment 
    WHERE debt_payment_id = '$id' 
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



function updatePaymentByID($id,$data = []){
    
    $sql = " UPDATE tb_debt_payment SET 
    debt_payment_gateway_id = '".$data['debt_payment_gateway_id']."', 
    debt_payment_pay = '".$data['debt_payment_pay']."', 
    debt_payment_remark = '".$data['debt_payment_remark']."', 
    debt_payment_date = '".$data['debt_payment_date']."', 
    debt_payment_date_amount = '".$data['debt_payment_date_amount']."', 
    debt_payment_interest_cal = '".$data['debt_payment_interest_cal']."', 
    debt_payment_interest = '".$data['debt_payment_interest']."', 
    debt_payment_discount = '".$data['debt_payment_discount']."', 
    debt_payment_charge_amount = '".$data['debt_payment_charge_amount']."', 
    debt_payment_value = '".$data['debt_payment_value']."', 
    debt_payment_interest_balance = '".$data['debt_payment_interest_balance']."', 
    debt_payment_charge_amount_balance = '".$data['debt_payment_charge_amount_balance']."', 
    debt_payment_value_balance = '".$data['debt_payment_value_balance']."', 
    debt_payment_interest_pay = '".$data['debt_payment_interest_pay']."', 
    debt_payment_charge_amount_pay = '".$data['debt_payment_charge_amount_pay']."', 
    debt_payment_value_pay = '".$data['debt_payment_value_pay']."', 
    debt_payment_charge_amount_new = '".$data['debt_payment_charge_amount_new']."', 
    debt_payment_charge_amount_new_date = '".$data['debt_payment_charge_amount_new_date']."', 
    debt_payment_charge_amount_new_id = '".$data['debt_payment_charge_amount_new_id']."' 
    WHERE debt_payment_id = $id  ";
    // echo $sql;
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){
        return true;
    }else {
        return false;
    }
}
 
function insertPayment($data=[]){
    $sql = " INSERT INTO tb_debt_payment(
        debt_id, 
        debt_payment_gateway_id, 
        debt_payment_pay, 
        debt_payment_remark, 
        debt_payment_date, 
        debt_payment_date_amount, 
        debt_payment_interest_cal, 
        debt_payment_interest, 
        debt_payment_discount, 
        debt_payment_charge_amount, 
        debt_payment_value, 
        debt_payment_interest_balance, 
        debt_payment_charge_amount_balance, 
        debt_payment_value_balance, 
        debt_payment_interest_pay,
        debt_payment_charge_amount_pay,
        debt_payment_value_pay, 
        debt_payment_charge_amount_new, 
        debt_payment_charge_amount_new_date, 
        debt_payment_charge_amount_new_id 
        ) VALUES ('".
        $data['debt_id']."','".
        $data['debt_payment_gateway_id']."','".
        $data['debt_payment_pay']."','".
        $data['debt_payment_remark']."','".
        $data['debt_payment_date']."','".
        $data['debt_payment_date_amount']."','".
        $data['debt_payment_interest_cal']."','".
        $data['debt_payment_interest']."','".
        $data['debt_payment_discount']."','".
        $data['debt_payment_charge_amount']."','".
        $data['debt_payment_value']."','".
        $data['debt_payment_interest_balance']."','".
        $data['debt_payment_charge_amount_balance']."','".
        $data['debt_payment_value_balance']."','".
        $data['debt_payment_interest_pay']."','".
        $data['debt_payment_charge_amount_pay']."','".
        $data['debt_payment_value_pay']."','".
        $data['debt_payment_charge_amount_new']."','".
        $data['debt_payment_charge_amount_new_date']."','".
        $data['debt_payment_charge_amount_new_id']."')";
        //  echo $sql;
        if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
            // $img_path="../img_upload/sale/".$data['sale_image'];
            // $ict=move_uploaded_file($data['sale_image_upload'],$img_path);
            return true;
        }else {
            return false;
        }
}

function deletePaymentByID($id){
    $sql = " DELETE FROM tb_debt_payment WHERE debt_payment_id = '$id' ";
    mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);
}
}
?>