<?php

require_once("BaseModel.php");
class UserModel extends BaseModel{

    function __construct(){
        if(!static::$db){
            static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        }
    }

    function getLogin($username, $password){
        $sql="SELECT 
        user_id, 
        user_firstname
        
        FROM tb_user 
        WHERE user_username = '$username' 
        AND user_password = '$password'";

        if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
            $data = [];
            while ($row = mysqli_fetch_array($result,MYSQLI_NUM)){
                $data[] = $row;
            }
            $result->close();
            return $data;
        }
    }

function getUserBy($deleted=0,$name = '', $email = '', $mobile  = ''){
    $sql = "SELECT 
    user_id,
    user_username,
    CONCAT(tb_user.user_firstname,' ',tb_user.user_lastname) as name , 
    user_telephone, 
    user_email   
    FROM tb_user 
    WHERE CONCAT(tb_user.user_firstname,' ',tb_user.user_lastname) LIKE ('%$name%') 
    AND user_email LIKE ('%$email%') 
    AND user_telephone LIKE ('%$mobile%')  
    AND deleted = $deleted  
    ORDER BY CONCAT(tb_user.user_firstname,' ',tb_user.user_lastname) 
    ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        $result->close();
        return $data;
    }
}

function getUserByID($id){
    $sql = " SELECT * 
    FROM tb_user 
    WHERE user_id = '$id' 
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

function updateUserByID($id,$data = []){
    $sql = " UPDATE tb_user SET 
    user_username = '".$data['user_username']."', 
    user_password = '".$data['user_password']."', 
    user_firstname = '".$data['user_firstname']."', 
    user_lastname = '".$data['user_lastname']."', 
    user_telephone = '".$data['user_telephone']."', 
    user_email = '".$data['user_email']."', 
    user_address = '".$data['user_address']."' 
    WHERE user_id = $id ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertUser($data=[]){
    $sql = " INSERT INTO tb_user(
        user_username, 
        user_password, 
        user_firstname, 
        user_lastname, 
        user_telephone, 
        user_email, 
        user_address
        ) VALUES ('".
        $data['user_username']."','".
        $data['user_password']."','".
        $data['user_firstname']."','".
        $data['user_lastname']."','".
        $data['user_telephone']."','".
        $data['user_email']."','".
        $data['user_address']."')";
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        // $img_path="../img_upload/user/".$data['user_image'];
        // $ict=move_uploaded_file($data['user_image_upload'],$img_path); 
        return true;
    }else {
        return false;
    }
}

function deleteUserByID($id){
    $sql = " DELETE FROM tb_user WHERE user_id = '$id' ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function deletedUserByID($id,$user_id){
    $sql = " UPDATE tb_user SET 
    deleted = 1,
    delete_by = '".$user_id."', 
    delete_date = NOW()  
    WHERE user_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function recoverUserByID($id){
    $sql = " UPDATE tb_user SET 
    deleted = 0,
    delete_by = '', 
    delete_date = ''  
    WHERE user_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
}
?>