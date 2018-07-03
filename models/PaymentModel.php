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
    ORDER BY tb_debt_payment.debt_payment_id 
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
    debt_payment_remark = '".$data['debt_payment_remark']."' 
    WHERE debt_payment_id = $id ";
    
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
        debt_payment_date 
        ) VALUES ('".
        $data['debt_id']."','".
        $data['debt_payment_gateway_id']."','".
        $data['debt_payment_pay']."','".
        $data['debt_payment_remark']."',".
        $data['debt_payment_date'].")";
        
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