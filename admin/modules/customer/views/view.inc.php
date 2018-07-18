<script>
    function customer_view(){
        window.location="index.php?content=customer";
    }

    function check(){
        

            var customer_name = document.getElementById("customer_name").value;
            var customer_telephone = document.getElementById("customer_telephone").value;
            // var customer_email = document.getElementById("customer_email").value;
            // var customer_address = document.getElementById("customer_address").value;

            customer_name = $.trim(customer_name);
            customer_telephone = $.trim(customer_telephone);
            // customer_email = $.trim(customer_email);
            // customer_address = $.trim(customer_address);
            
            if(customer_name.length == 0){
                alert("Please input customer customer name");
                document.getElementById("customer_name").focus();
                return false;
            }else if(customer_telephone.length == 0){
                alert("Please input customer telephone");
                document.getElementById("customer_telephone").focus();
                return false;
            // }else if(customer_email.length == 0){
            //     alert("Please input customer email");
            //     document.getElementById("customer_email").focus();
            //     return false;
            // }else if(customer_address.length == 0){
            //     alert("Please input customer address");
            //     document.getElementById("customer_address").focus();
            //     return false;
            }else{
                return true;
            }
        

    }
    

    function show_debt (display_id,display_td_id,customer_id) {
        
        
        if(!$(display_id).is(':visible')){
            window.history.replaceState("", "", "index.php?content=customer&customer_id="+customer_id+"");
            $.post( "modules/debt/views/index.inc.php",{customer_id:customer_id}, function( data ) {
                $('.dd_td').html("");
	            $('.dd_tr').hide();
                $(display_td_id).html(data);
                $(display_id).toggle();
                <?PHP
                if(isset($_GET['debt_id'])){
                    ?>
                    show_payment('#collapse_debt_<?PHP echo $_GET['debt_id'];?>','#collapse_debt_td_<?PHP echo $_GET['debt_id'];?>','<?PHP echo $_GET['customer_id'];?>','<?PHP echo $_GET['debt_id'];?>');
                    <?PHP
                }  
                ?>
            });

        }else{
            window.history.replaceState("", "", "index.php?content=customer");
            $(display_td_id).html('');
            $(display_id).toggle();
        }
    }

    

    
    <?PHP 
    if(isset($_GET['customer_id'])){
        ?>
        show_debt ('#collapse_<?PHP echo $_GET['customer_id'];?>','#collapse_td_<?PHP echo $_GET['customer_id'];?>','<?PHP echo $_GET['customer_id'];?>');
        <?PHP 
        
    }
    ?>
    
    function show_payment(display_id,display_td_id,customer_id,debt_id) {        
        
        if(!$(display_id).is(':visible')){
            window.history.replaceState("", "", "index.php?content=customer&customer_id="+customer_id+"&debt_id="+debt_id+"");
            $.post( "modules/payment/views/index.inc.php",{debt_id:debt_id}, function( data ) {
                $('.payment_td').html("");
                $('.payment_tr').hide();
                $(display_td_id).html(data);
                $(display_id).toggle();
            });
    
        }else{
            window.history.replaceState("", "", "index.php?content=customer&customer_id="+customer_id+"");
            $(display_td_id).html('');
            $(display_id).toggle();
        }
    }
    
    

</script>
<div class="row">
  <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form role="form" method="post" onsubmit="return check();" <?php if($customer_id == ''){ ?>action="index.php?content=customer&action=add"<?php }else{?> action="index.php?content=customer&action=edit" <?php }?> enctype="multipart/form-data">
                    <input type="hidden"  id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" />
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <!-- /.row (nested) -->

                            <div class="row">
                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>ชื่อ <font color="#F00"><b>*</b></font></label>
                                        <input id="customer_name" name="customer_name" class="form-control" value="<?php echo $customers['customer_name']?>">
                                        <p class="help-block">Example : ABC Co.,Ltd</p>
                                        
                                    </div>
                                </div>
  
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์ <font color="#F00"><b>*</b></font></label>
                                        <input id="customer_telephone" name="customer_telephone" class="form-control" value="<?php echo $customers['customer_telephone']?>">
                                        <p class="help-block">Example : 099-999-9999</p>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>ที่อยู่อีเมล </label>
                                        <input id="customer_email" name="customer_email" class="form-control" value="<?php echo $customers['customer_email']?>">
                                        <p class="help-block">Example : user@info.com</p>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>ที่อยู่ </label>
                                        <input type="text" id="customer_address" name="customer_address" class="form-control" value="<?php echo $customers['customer_address']?>">
                                        <p class="help-block">Example : 1242/2 Mittraphab Road </p>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.col-lg-9 (nested) -->

                        
                        <!-- /.col-lg-3 (nested) -->
                    </div>
                    <!-- /.row (nested) -->

                    
                    <!-- /.row (nested) -->

                   
                    <!-- /.row (nested) -->

                    
                    <!-- /.row (nested) -->

                    
                    <!-- /.row (nested) -->

                    <div align="right">
                      <button type="button" onclick="customer_view();" class="btn btn-primary">ล้างข้อมูล</button>
                      <button name="submit" type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                    </div>
                    <!-- /.row (nested) -->
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
            
            <!-- /.panel-heading -->
            
        <hr />       

        <table>
            <thead>
                <tr>
                  <th>ลำดับ.</th>
                  <th>ชื่อลูกค้า</th>  
                  <th>เบอร์โทรศัพท์</th>
                  <!-- <th>อีเมล</th> -->
                  <th>จำนวนอินวอย</th>
                  <th>จำนวนเช็ค</th>
                  <th>มูลค่าอินวอย</th>
                  <th>มูลค่าเช็ค</th>
                  <th>จัดการ</th>
                  
                </tr>
            </thead>
            <tbody>
                <?php 
                for($i=0; $i < count($customer); $i++){
                ?>
                    <tr class="nth-child-customer">
                        <td><?php echo $i+1; ?><a href="javascript:;" onclick="show_debt('#collapse_<?=$customer[$i]['customer_id']?>','#collapse_td_<?=$customer[$i]['customer_id']?>','<?=$customer[$i]['customer_id']?>')"  style="font-size: 12px;">&nbsp;[+]</a></td>
                        <td><?php echo $customer[$i]['name']; ?></td>
                        <td><?php echo $customer[$i]['customer_telephone']; ?></td>
                        <!-- <td><?php echo $customer[$i]['customer_email']; ?></td> -->
                        <td id="display_inv_num_<?=$customer[$i]['customer_id']?>"><?php echo $customer[$i]['invoice_number']; ?></td>
                        <td id="display_chk_num_<?=$customer[$i]['customer_id']?>"><?php echo $customer[$i]['check_number']; ?></td>
                        <td class="align-money" id="display_inv_val_<?=$customer[$i]['customer_id']?>"><?php echo $customer[$i]['invoice_value']; ?></td>
                        <td class="align-money" id="display_chk_val_<?=$customer[$i]['customer_id']?>"><?php echo $customer[$i]['check_value']; ?></td>
                        <td>
                            <a href="?content=customer&action=update&id=<?php echo $customer[$i]['customer_id'];?>" style="font-size: 20px;">
                                <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                            </a> 
                            
                            <a href="?content=customer&action=delete&id=<?php echo $customer[$i]['customer_id'];?>" onclick="return confirm('You want to delete customer : <?php echo $customer[$i]['name']; ?>');" style="color:red; font-size: 20px;">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </td>
                        
                    </tr>
                    <tr class="dd_tr" style="display:none;" id="collapse_<?=$customer[$i]['customer_id']?>">
                        <td colspan="9" class="dd_td padding-0 margin-0" id="collapse_td_<?=$customer[$i]['customer_id']?>"></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
               
          
          <!-- /.panel-body -->
      
      <!-- /.panel -->
    </div>
  
  </div>
</div>

