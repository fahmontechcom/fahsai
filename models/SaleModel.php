<?php

require_once("BaseModel.php");
class SaleModel extends BaseModel{

    function __construct(){
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    

function getSaleBy($name = '', $email = '', $mobile  = ''){
    $sql = "SELECT 
    sale_id,
    CONCAT(tb_sale.sale_firstname,' ',tb_sale.sale_lastname) as name , 
    sale_telephone, 
    sale_email   
    FROM tb_sale 
    WHERE CONCAT(tb_sale.sale_firstname,' ',tb_sale.sale_lastname) LIKE ('%$name%') 
    AND sale_email LIKE ('%$email%') 
    AND sale_telephone LIKE ('%$mobile%') 
    ORDER BY CONCAT(tb_sale.sale_firstname,' ',tb_sale.sale_lastname) 
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

function getSaleByID($id){
    $sql = " SELECT * 
    FROM tb_sale 
    WHERE sale_id = '$id' 
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

function updateSaleByID($id,$data = []){
    $sql = " UPDATE tb_sale SET 
    sale_firstname = '".$data['sale_firstname']."', 
    sale_lastname = '".$data['sale_lastname']."', 
    sale_telephone = '".$data['sale_telephone']."', 
    sale_email = '".$data['sale_email']."', 
    sale_address = '".$data['sale_address']."' 
    WHERE sale_id = $id ";
    
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)){
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
    if (mysqli_query($this->db,$sql, MYSQLI_USE_RESULT)) {
        // $img_path="../img_upload/sale/".$data['sale_image'];
        // $ict=move_uploaded_file($data['sale_image_upload'],$img_path);
        return true;
    }else {
        return false;
    }
}

function deleteSaleByID($id){
    $sql = " DELETE FROM tb_sale WHERE sale_id = '$id' ";
    mysqli_query($this->db,$sql, MYSQLI_USE_RESULT);
}
}
?>