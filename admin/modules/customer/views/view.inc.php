<script>
    function check(){
        var customer_name = document.getElementById("customer_name").value;
        
        var customer_telephone = document.getElementById("customer_telephone").value;
        var customer_email = document.getElementById("customer_email").value;
        var customer_address = document.getElementById("customer_address").value;

        customer_name = $.trim(customer_name);
        
        customer_telephone = $.trim(customer_telephone);
        customer_email = $.trim(customer_email);
        customer_address = $.trim(customer_address);
        
        if(customer_name.length == 0){
            alert("Please input customer firstname");
            document.getElementById("customer_name").focus();
            return false;
        }else if(customer_telephone.length == 0){
            alert("Please input customer telephone");
            document.getElementById("customer_telephone").focus();
            return false;
        }else if(customer_email.length == 0){
            alert("Please input customer email");
            document.getElementById("customer_email").focus();
            return false;
        }else if(customer_address.length == 0){
            alert("Please input customer address");
            document.getElementById("customer_address").focus();
            return false;
        }else{
            return true;
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
                        <div class="col-lg-9">
                            
                            <!-- /.row (nested) -->

                            <div class="row">
                                
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>ชื่อ <font color="#F00"><b>*</b></font></label>
                                        <input id="customer_name" name="customer_name" class="form-control" value="<?php echo $customers['customer_name']?>">
                                    </div>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์ <font color="#F00"><b>*</b></font></label>
                                        <input id="customer_telephone" name="customer_telephone" class="form-control" value="<?php echo $customers['customer_telephone']?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>ที่อยู่อีเมล <font color="#F00"><b>*</b></font></label>
                                        <input id="customer_email" name="customer_email" class="form-control" value="<?php echo $customers['customer_email']?>">
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>ที่อยู่ <font color="#F00"><b>*</b></font> </label>
                                <input type="text" id="customer_address" name="customer_address" class="form-control" value="<?php echo $customers['customer_address']?>">
                                <p class="help-block">Example : 1242/2 Mittraphab Road Tambon Naimuang Amphoe Muang Province Nakhonratchasima 30000</p>
                                 
                            </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->

                    
                    <!-- /.row (nested) -->

                    
                    <!-- /.row (nested) -->

                    <div align="right">
                      <button type="reset" class="btn btn-primary">ล้างข้อมูล</button>
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
                  <th>#</th>
                  <th>ชื่อลูกค้า</th>  
                  <th>เบอร์โทรศัพท์</th>
                  <th>อีเมล</th>
                  <th>จำนวนเช็ค</th>
                  <th>จำนวนอินวอย</th>
                  <th>มูลค่าเช็ค</th>
                  <th>มูลค่าอินวอย</th>
                  <th>เเก้ไข</th>
                  <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                for($i=0; $i < count($customer); $i++){
                  ?>
                  <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo $customer[$i]['name']; ?></td>
                    <td><?php echo $customer[$i]['customer_telephone']; ?></td>
                    <td><?php echo $customer[$i]['customer_email']; ?></td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>
                      <a href="?content=customer&action=update&id=<?php echo $customer[$i]['customer_id'];?>" style="font-size: 20px;">
                        <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                      </a> 
                    </td>
                    <td>
                      <a href="?content=customer&action=delete&id=<?php echo $customer[$i]['customer_id'];?>" onclick="return confirm('You want to delete customer : <?php echo $customer[$i]['name']; ?>');" style="color:red; font-size: 20px;">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                  <?php } ?>
            </tbody>
        </table>
               
          
          <!-- /.panel-body -->
      
      <!-- /.panel -->
    </div>
  
  </div>
</div>

