<?php

require_once("BaseModel.php");
class ChargeModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    function getChargeBy($debt_id){
        $sql = " SELECT *
        FROM tb_debt_payment_charge  
        WHERE debt_id = '$debt_id' 
        ORDER BY debt_payment_charge_id 
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
    function getSumChargeBy($debt_id,$debt_payment_date){
        $sql = " SELECT MAX(debt_payment_charge_id) AS debt_payment_charge_id ,MAX(debt_payment_charge_date) AS debt_payment_charge_date , SUM(debt_payment_charge_amount) as debt_payment_charge_amount 
        FROM tb_debt_payment_charge  
        WHERE debt_id = '$debt_id' AND debt_payment_charge_date <= '$debt_payment_date'  
        ";
        // echo $sql;
        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
            $data = [];
            $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
            
            $result->close();
            return $data;
        }

    }

    function getSumNewChargeBy($debt_id,$debt_payment_charge_id,$charge_amount_new_date,$debt_payment_date){
        $sql = " SELECT  MAX(debt_payment_charge_id) AS debt_payment_charge_id ,MAX(debt_payment_charge_date) AS debt_payment_charge_date , SUM(debt_payment_charge_amount) as debt_payment_charge_amount 
        FROM tb_debt_payment_charge  
        WHERE debt_id = '$debt_id' AND  debt_payment_charge_id > '$debt_payment_charge_id' AND debt_payment_charge_date > '$charge_amount_new_date' AND debt_payment_charge_date <= '$debt_payment_date' 
        ORDER BY debt_payment_charge_id 
        ";
        // echo $sql;
        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
            $data = [];
            $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
            
            $result->close();
            return $data;
        }

    }

    function getLastChargeBy($debt_id){
        $sql = "SELECT * FROM tb_debt_payment_charge WHERE debt_id = '$debt_id' AND debt_payment_charge_date IN (SELECT MAX(debt_payment_charge_date) FROM tb_debt_payment_charge WHERE debt_id = '$debt_id' ) ORDER BY debt_payment_charge_id DESC
        ";
        // echo $sql;
        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
            $data = [];
            $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
            
            $result->close();
            return $data;
        }
    
    }


    function insertCharge($data = []){
        $sql = " INSERT INTO tb_debt_payment_charge(
            debt_id, 
            debt_payment_charge_detail, 
            debt_payment_charge_amount,
            debt_payment_charge_date
            ) VALUES ('".
            $data['debt_id']."','".
            $data['debt_payment_charge_detail']."','". 
            $data['debt_payment_charge_amount']."','". 
            $data['debt_payment_charge_date']."');";
            // echo $sql;
        if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) { 
            return true;
        }else {
            return false;
        }

    }

    

    function updateChargeByID($id,$data){

        $sql = " UPDATE tb_debt_payment_charge 
            SET debt_id = '".$data['debt_id']."', 
            debt_payment_charge_detail = '".$data['debt_payment_charge_detail']."', 
            debt_payment_charge_amount = '".$data['debt_payment_charge_amount']."', 
            debt_payment_charge_date = '".$data['debt_payment_charge_date']."'
            WHERE debt_payment_charge_id = '$id'
        ";
    
        if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
           return true;
        }else {
            return false;
        }
    }




    function deleteChargeByID($id){
        $sql = "DELETE FROM tb_debt_payment_charge WHERE debt_payment_charge_id = '$id' ";
        // echo $sql;
        mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);
    }

    function deleteChargeByScheduleID($id){

        $sql = "DELETE FROM tb_debt_payment_charge WHERE debt_id = '$id' ";
        mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);

    }

    function deleteChargeByScheduleIDNotIN($id,$data){
        $str ='';
        if(is_array($data)){ 
            for($i=0; $i < count($data) ;$i++){
                $str .= $data[$i];
                if($i + 1 < count($data)){
                    $str .= ',';
                }
            }
        }else if ($data != ''){
            $str = $data;
        }else{
            $str='0';
        }


        $sql = "DELETE FROM tb_debt_payment_charge WHERE debt_id = '$id' AND debt_payment_charge_id NOT IN ($str) ";

        mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);

        

    }
}
?>