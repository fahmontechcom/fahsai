<?php

require_once("BaseModel.php");
class GatewayModel extends BaseModel{

    function __construct(){
        if(!static::$db){
            static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        }
    } 

function getGatewayBy($deleted=0,$name = ''){
    $sql = "SELECT *
    FROM tb_debt_payment_gateway 
    WHERE  
    debt_payment_gateway_name LIKE ('%$name%') 
    AND deleted = $deleted
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

function getGatewayByID($id){
    $sql = "SELECT * 
    FROM tb_debt_payment_gateway 
    WHERE debt_payment_gateway_id = '$id' 
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

function updateGatewayByID($id,$data = []){
    $sql = " UPDATE tb_debt_payment_gateway SET 
    debt_payment_gateway_name = '".$data['debt_payment_gateway_name']."' 
    WHERE debt_payment_gateway_id = $id ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertGateway($data=[]){
    $sql = " INSERT INTO tb_debt_payment_gateway(
        debt_payment_gateway_name
        ) VALUES ('".
        $data['debt_payment_gateway_name']."')";
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) { 
        return true;
    }else {
        return false;
    }
}

function deleteGatewayByID($id){
    $sql = " DELETE FROM tb_debt_payment_gateway WHERE debt_payment_gateway_id = '$id' ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function deletedGatewayByID($id,$user_id){
    $sql = " UPDATE tb_debt_payment_gateway SET 
    deleted = 1,
    delete_by = '".$user_id."', 
    delete_date = NOW()  
    WHERE debt_payment_gateway_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function recoverGatewayByID($id){
    $sql = " UPDATE tb_debt_payment_gateway SET 
    deleted = 0,
    delete_by = '', 
    delete_date = ''  
    WHERE debt_payment_gateway_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
}
?>