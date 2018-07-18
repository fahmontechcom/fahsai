<?php

require_once("BaseModel.php");
class NotificationModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    function getNotificationByUserID($user_id,$date,$str =''){ 
        $sql = " SELECT tb_debt_schedule_status.*,tb_debt.debt_invoice_number,tb_debt.customer_id,tb_debt_schedule.*,tb_debt_schedule_list.*,
                        IFNULL(( 
                            SELECT notification_log_id 
                            FROM tb_notification_log 
                            WHERE debt_schedule_list_id = tb_debt_schedule_list.debt_schedule_list_id AND user_id = '$user_id'
                        ),0) AS notification_log_id 
                        FROM tb_debt_schedule_list INNER JOIN tb_debt_schedule ON tb_debt_schedule_list.debt_schedule_id = tb_debt_schedule.debt_schedule_id INNER JOIN tb_debt_schedule_status ON tb_debt_schedule.debt_schedule_status_id = tb_debt_schedule_status.debt_schedule_status_id INNER JOIN tb_debt ON tb_debt_schedule.debt_id = tb_debt.debt_id 
                        WHERE tb_debt_schedule_list.debt_schedule_list_date <= '$date' 
                        ORDER BY tb_debt_schedule_list.debt_schedule_list_date DESC ;
                ";
         //ORDER BY STR_TO_DATE(notification_date,'%Y-%m-%d') DESC ;
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
    function getNewNotificationByUserID($user_id,$date,$str =''){ 
        $sql = " SELECT * 
                FROM tb_debt_schedule_list  
                WHERE tb_debt_schedule_list.debt_schedule_list_date <= '$date' AND debt_schedule_list_id NOT IN (SELECT debt_schedule_list_id FROM tb_notification_log WHERE  user_id = '$user_id') 
                ORDER BY tb_debt_schedule_list.debt_schedule_list_date DESC ;
                ";
         //ORDER BY STR_TO_DATE(notification_date,'%Y-%m-%d') DESC ;
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
    function getNotificationBy($user_id,$str =''){
        if($str != ""){
            $str = "AND notification_seen_date ='' ";
        }
        $sql = " SELECT * 
        FROM tb_notification 
        WHERE user_id = '$user_id' 
        $str
        ORDER BY  notification_date  DESC ;
         ";
         //ORDER BY STR_TO_DATE(notification_date,'%Y-%m-%d') DESC ;
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


    function getNotificationByType($user_id,$type,$str =''){
        if($str != ""){
            $str = "AND notification_seen_date ='' ";
        }
        $sql = " SELECT * 
        FROM tb_notification 
        WHERE user_id = '$user_id' 
        AND notification_type = '$type' 
        $str
        ORDER BY STR_TO_DATE(notification_date,'%Y-%m-%d %H:%i:%s') DESC 
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


    function getNotificationByID($user_id,$debt_schedule_list_id){
        $sql = " SELECT * 
        FROM tb_notification_log 
        WHERE user_id = '$user_id' AND debt_schedule_list_id = '$debt_schedule_list_id' 
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
    function insertNotification($data=[]){
        $sql = " INSERT INTO tb_notification_log(
            user_id,
            debt_schedule_list_id,
            notification_log_date
            ) VALUES ('".
            $data['user_id']."','".
            $data['debt_schedule_list_id']."',".
            "NOW()".
            ")";
            // echo $sql;
        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) { 
            return true;
        }else {
            return false;
        }
    }

    function setNotification($type="",$detail="",$url="",$page="",$status=""){
        $sql = "
            SELECT user_id FROM tb_user LEFT JOIN tb_license ON tb_user.license_id = tb_license.license_id 
            WHERE tb_license.$page IN ($status) 
        ";

        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
            $str=array();
            while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $str[] ="INSERT INTO tb_notification 
                ( user_id, notification_type, notification_seen, notification_date,notification_seen_date,notification_detail,notification_url) 
                VALUES ('".$row['user_id']."','$type','0',NOW(),'','$detail','$url')";

                

            }
            $result->close();

            for($i=0; $i < count($str); $i++){
                $result = mysqli_query($this->db,$str[$i], MYSQLI_USE_RESULT); 
            }
        }

    }

    function setNotificationSeenByID($id){
        $sql = " UPDATE tb_notification SET 
        notification_seen_date = NOW() , 
        notification_seen = '1'  
        WHERE notification_id = $id 
        ";


        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) { 
           return true;
        }else {
            return false;
        }


    }

    function setNotificationSeenByURL($url){
        $sql = " UPDATE tb_notification SET 
        notification_seen_date = NOW() , 
        notification_seen = '1'  
        WHERE notification_url LIKE ('%$url%') 
        ";

        if ($result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) { 
           return true;
        }else {
            return false;
        }


    }


    function deleteNotificationByID($id){
        $sql = " DELETE FROM tb_notification WHERE notification_id = '$id' ";
        $result = mysqli_query($this->db,$sql, MYSQLI_USE_RESULT); 

    }
}
?>