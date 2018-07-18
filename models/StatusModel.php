<?php

require_once("BaseModel.php");
class StatusModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    

function getStatusBy($deleted=0,$name = ''){
    $sql = "SELECT *
    FROM tb_debt_schedule_status 
    WHERE  
    debt_schedule_status_name LIKE ('%$name%') 
    AND deleted = $deleted 
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

function getStatusByID($id){
    $sql = "SELECT * 
    FROM tb_debt_schedule_status 
    WHERE debt_schedule_status_id = '$id' 
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
function getStatusByDebtID($id,$deleted=0){
    $sql = "SELECT DISTINCT tb_schedule.debt_schedule_id , tb_status.* 
    FROM tb_debt_schedule_status AS tb_status INNER JOIN tb_debt_schedule AS tb_schedule ON tb_status.debt_schedule_status_id = tb_schedule.debt_schedule_status_id
    WHERE tb_schedule.debt_id = '$id' AND tb_schedule.deleted = $deleted
    ";
    // echo $sql;
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $result->close();
        return $data;
    }
}

function updateStatusByID($id,$data = []){
    $sql = " UPDATE tb_debt_schedule_status SET 
    debt_schedule_status_name = '".$data['debt_schedule_status_name']."' 
    WHERE debt_schedule_status_id = $id ";
    
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertStatus($data=[]){
    $sql = " INSERT INTO tb_debt_schedule_status(
        debt_schedule_status_name
        ) VALUES ('".
        $data['debt_schedule_status_name']."')";
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) { 
        return true;
    }else {
        return false;
    }
}

function deleteStatusByID($id){
    $sql = " DELETE FROM tb_debt_schedule_status WHERE debt_schedule_status_id = '$id' ";
    $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 
}
function deletedStatusByID($id,$user_id){
    $sql = " UPDATE tb_debt_schedule_status SET 
    deleted = 1,
    delete_by = '".$user_id."', 
    delete_date = NOW()  
    WHERE debt_schedule_status_id = $id ";
    echo $sql;
    $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 
}
function recoverStatusByID($id){
    $sql = " UPDATE tb_debt_schedule_status SET 
    deleted = 0,
    delete_by = '', 
    delete_date = ''  
    WHERE debt_schedule_status_id = $id ";
    $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 
}
}
?>