<?php

require_once("BaseModel.php");
class ScheduleModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    

function getScheduleBy(){
    $sql = "SELECT * 
    FROM tb_debt_schedule
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

function getInvoiceNumberByScheduleID($customer_id){
    $sql = "SELECT 
    IFNULL(( 
        SELECT COUNT(*) 
        FROM tb_debt 
        WHERE customer_id = tb_cust.customer_id 
        AND debt_invoice_number !='' 
        GROUP BY customer_id 
    ),0) AS invoice_number, 
    IFNULL((
        SELECT COUNT(*) 
        FROM tb_debt 
        WHERE customer_id = tb_cust.customer_id 
        AND debt_check_number !='' 
        GROUP BY customer_id 
    ),0) AS check_number, 
    FORMAT(IFNULL(( 
        SELECT SUM(debt_value) 
        FROM tb_debt 
        WHERE customer_id = tb_cust.customer_id 
        AND debt_invoice_number !='' 
        GROUP BY customer_id 
    ),0),2) AS invoice_value  , 
    FORMAT(IFNULL((
        SELECT SUM(debt_value)  
        FROM tb_debt  
        WHERE customer_id = tb_cust.customer_id 
        AND debt_check_number !='' 
        GROUP BY customer_id 
    ),0),2) AS check_value   
    FROM tb_debt_schedule AS tb_cust  
    WHERE customer_id = '$customer_id'
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

function getScheduleByID($id){
    $sql = " SELECT * 
    FROM tb_debt_schedule 
    WHERE debt_schedule_id = '$id' 
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

function updateScheduleByID($id,$data = []){
    $sql = " UPDATE tb_debt_schedule SET 
    debt_id = '".$data['debt_id']."', 
    debt_schedule_status_id = '".$data['debt_schedule_status_id']."',  
    debt_schedule_detail = '".$data['debt_schedule_detail']."', 
    debt_schedule_remark = '".$data['debt_schedule_remark']."' 
    WHERE debt_schedule_id = $id "; 
    
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertSchedule($data=[]){
    $sql = " INSERT INTO tb_debt_schedule(
        debt_id,
        debt_schedule_status_id, 
        debt_schedule_detail, 
        debt_schedule_remark
        ) VALUES ('".
        $data['debt_id']."','".
        $data['debt_schedule_status_id']."','".
        $data['debt_schedule_detail']."','".
        $data['debt_schedule_remark']."')";
    if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        $id = mysqli_insert_id($this->db); 
        return $id;
    }else {
        return false;
    }
}

function deleteScheduleByID($id){
    $sql = " DELETE FROM tb_debt_schedule WHERE debt_schedule_id = '$id' ";
    $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 
}
}
?>