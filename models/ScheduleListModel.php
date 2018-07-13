<?php

require_once("BaseModel.php");
class ScheduleListModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    function getScheduleListBy($debt_schedule_id){
        $sql = " SELECT *
        FROM tb_debt_schedule_list  
        WHERE debt_schedule_id = '$debt_schedule_id' 
        ORDER BY debt_schedule_list_id 
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


    function insertScheduleList($data = []){
        $sql = " INSERT INTO tb_debt_schedule_list(
            debt_schedule_id, 
            debt_schedule_list_detail, 
            debt_schedule_list_date
            ) VALUES ('".
            $data['debt_schedule_id']."','".
            $data['debt_schedule_list_detail']."','". 
            $data['debt_schedule_list_date']."');";

        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
            $id = mysqli_insert_id($this->db); 
            return $id; 
        }else {
            return 0;
        }

    }

    

    function updateScheduleListById($data,$id){

        $sql = " UPDATE tb_debt_schedule_list 
            SET debt_schedule_id = '".$data['debt_schedule_id']."', 
            debt_schedule_list_detail = '".$data['debt_schedule_list_detail']."', 
            debt_schedule_list_date = '".$data['debt_schedule_list_date']."'
            WHERE debt_schedule_list_id = '$id'
        ";
     

        if($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) { 
            return true;
        }else {
            return false;
        }
    }




    function deleteScheduleListByID($id){
        $sql = "DELETE FROM tb_debt_schedule_list WHERE debt_schedule_list_id = '$id' ";
        $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 
    }

    function deleteScheduleListByScheduleID($id){

        $sql = "DELETE FROM tb_debt_schedule_list WHERE debt_schedule_id = '$id' ";
        $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 

    }

    function deleteScheduleListByScheduleIDNotIN($id,$data){
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


        $sql = "DELETE FROM tb_debt_schedule_list WHERE debt_schedule_id = '$id' AND debt_schedule_list_id NOT IN ($str) ";

        $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 

    }
}
?>