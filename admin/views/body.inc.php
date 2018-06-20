<?php
    if($page=="user"){ 
        require_once("modules/user/views/index.inc.php"); 
    }
    if($page=="status"){ 
        require_once("modules/status/views/index.inc.php"); 
    }
    if($page=="gateway"){ 
        require_once("modules/gateway/views/index.inc.php"); 
    }
    
?>