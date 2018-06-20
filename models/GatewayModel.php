<?php

require_once("BaseModel.php");
class GatewayModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    

function getGatewayBy($name = ''){
    $sql = "SELECT *
    FROM tb_debt_payment_geteway 
    WHERE  
    tb_debt_payment_geteway_name LIKE ('%$name%')
    ";
    
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
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
    FROM tb_debt_payment_geteway 
    WHERE tb_debt_payment_geteway_id = '$id' 
    ";

    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data;
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data = $row;
        }
        $result->close();
        return $data;
    }
}

function updateGatewayByID($id,$data = []){
    $sql = " UPDATE tb_debt_payment_geteway SET 
    tb_debt_payment_geteway_name = '".$data['tb_debt_payment_geteway_name']."' 
    WHERE tb_debt_payment_geteway_id = $id ";
    
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){
        return true;
    }else {
        return false;
    }
}

function insertGateway($data=[]){
    $sql = " INSERT INTO tb_debt_payment_geteway(
        tb_debt_payment_geteway_name
        ) VALUES ('".
        $data['tb_debt_payment_geteway_name']."')";
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        
        return true;
    }else {
        return false;
    }
}

function deleteGatewayByID($id){
    $sql = " DELETE FROM tb_debt_payment_geteway WHERE tb_debt_payment_geteway_id = '$id' ";
    mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);
}
}
?>