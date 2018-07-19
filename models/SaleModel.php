<?php

require_once("BaseModel.php");
class SaleModel extends BaseModel{

    function __construct(){
        if(!static::$db){
            static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        }
    }

    

function getSaleBy($deleted=0,$name = '', $email = '', $mobile  = ''){
    $sql = "SELECT 
    sale_id,
    CONCAT(tb_sale.sale_firstname,' ',tb_sale.sale_lastname) as name , 
    sale_telephone, 
    sale_email   
    FROM tb_sale 
    WHERE CONCAT(tb_sale.sale_firstname,' ',tb_sale.sale_lastname) LIKE ('%$name%') 
    AND sale_email LIKE ('%$email%') 
    AND sale_telephone LIKE ('%$mobile%') 
    AND deleted = $deleted 
    ";
    // ORDER BY CONCAT(tb_sale.sale_firstname,' ',tb_sale.sale_lastname) 
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        $data = [];
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $data[] = $row;
        }
        $result->close();
        // echo "<script>alert('');</script>";
        // echo $sql;
        return $data;
    }
}

function getSaleByID($id){
    $sql = " SELECT * 
    FROM tb_sale 
    WHERE sale_id = '$id' 
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

function updateSaleByID($id,$data = []){
    $sql = " UPDATE tb_sale SET 
    sale_firstname = '".$data['sale_firstname']."', 
    sale_lastname = '".$data['sale_lastname']."', 
    sale_telephone = '".$data['sale_telephone']."', 
    sale_email = '".$data['sale_email']."', 
    sale_address = '".$data['sale_address']."' 
    WHERE sale_id = $id ";
    
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)){ 
        return true;
    }else {
        return false;
    }
}

function insertSale($data=[]){
    $sql = " INSERT INTO tb_sale(
        sale_firstname, 
        sale_lastname, 
        sale_telephone, 
        sale_email, 
        sale_address
        ) VALUES ('".
        $data['sale_firstname']."','".
        $data['sale_lastname']."','".
        $data['sale_telephone']."','".
        $data['sale_email']."','".
        $data['sale_address']."')";
    if ($result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT)) {
        // $img_path="../img_upload/sale/".$data['sale_image'];
        // $ict=move_uploaded_file($data['sale_image_upload'],$img_path); 
        return true;
    }else {
        return false;
    }
}

function deleteSaleByID($id){
    $sql = " DELETE FROM tb_sale WHERE sale_id = '$id' ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function deletedSaleByID($id,$user_id){
    $sql = " UPDATE tb_sale SET 
    deleted = 1,
    delete_by = '".$user_id."', 
    delete_date = NOW()  
    WHERE sale_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
function recoverSaleByID($id){
    $sql = " UPDATE tb_sale SET 
    deleted = 0,
    delete_by = '', 
    delete_date = ''  
    WHERE sale_id = $id ";
    $result = mysqli_query(static::$db,$sql, MYSQLI_USE_RESULT); 
}
}
?>