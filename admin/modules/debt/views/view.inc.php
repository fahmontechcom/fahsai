<script>
    function check(){
        var debt_check_number = document.getElementById("debt_check_number").value; 
        var debt_invoice_number = document.getElementById("debt_invoice_number").value;
        var debt_value = document.getElementById("debt_value").value;
        var debt_date = document.getElementById("debt_date").value;
        var debt_remark = document.getElementById("debt_remark").value;

        debt_check_number = $.trim(debt_check_number); 
        debt_invoice_number = $.trim(debt_invoice_number);
        debt_value = $.trim(debt_value);
        debt_date = $.trim(debt_date);
        debt_remark = $.trim(debt_remark);
        
        if(debt_check_number.length == 0){
            alert("Please input customer firstname");
            document.getElementById("debt_check_number").focus();
            return false;
        }else if(debt_invoice_number.length == 0){
            alert("Please input customer telephone");
            document.getElementById("debt_invoice_number").focus();
            return false;
        }else if(debt_value.length == 0){
            alert("Please input customer email");
            document.getElementById("debt_value").focus();
            return false;
        }else if(debt_date.length == 0){
            alert("Please input customer address");
            document.getElementById("debt_date").focus();
            return false;
        }else if(debt_remark.length == 0){
            alert("Please input customer address");
            document.getElementById("debt_remark").focus();
            return false;
        }else{
            return true;
        }
    }


</script>
<div class="row " style="margin:5px;background-color:#e4f2fe;">
  <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form role="form" method="post" onsubmit="return check();" <?php if($customer_id == ''){ ?>action="index.php?content=debt&action=add"<?php }else{?> action="index.php?content=debt&action=edit" <?php }?> enctype="multipart/form-data">
                    <input type="hidden"  id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" />
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>เลขที่เช็ค </label>
                                <input id="debt_check_number" name="debt_check_number" class="form-control" value="<?php echo $customers['debt_check_number']?>">
                                <p class="help-block">Example : 1234567</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>เลขที่อินวอย </font></label>
                                <input id="debt_invoice_number" name="debt_invoice_number" class="form-control" value="<?php echo $customers['debt_invoice_number']?>">
                                <p class="help-block">Example : INV1805004</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>มูลค่า <font color="#F00"><b>*</b></font></label>
                                <input id="debt_value" name="debt_value" class="form-control" value="<?php echo $customers['debt_value']?>">
                                <p class="help-block">Example : 15,000.00</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>วันที่ <font color="#F00"><b>*</b></font> </label>
                                <input type="text" id="debt_date" name="debt_date" class="form-control" value="<?php echo $customers['debt_date']?>">
                                <p class="help-block">Example : 09-09-2018 </p>
                                
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>หมายเหตุ</label>
                                <input type="text" id="debt_remark" name="debt_remark" class="form-control" value="<?php echo $customers['debt_remark']?>">
                                <p class="help-block">Example : Check failed </p>
                                
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->

                    
                    <!-- /.row (nested) -->

                    
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
            <th>ลำดับ.</th>
            <th>เลขที่เช็ค</th>  
            <th>เลขที่อินวอย</th>
            <th>มูลค่า</th>
            <th>คงเหลือ</th>
            <th>สถานะ</th>
            <th>จัดการ</th>
            
        </tr>
    </thead>
        <tbody>
        <?php 
        for($i=0; $i < count($debt); $i++){
            ?>
            <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $debt[$i]['debt_check_number']; ?></td>
            <td><?php echo $debt[$i]['debt_invoice_number']; ?></td>
            <td><?php echo $debt[$i]['debt_value']; ?></td>
            <td><?php echo $debt[$i]['debt_balance']; ?></td>
            <td><?php echo '#ดึงสถานะจากตารางกำหนดการ#'; ?></td>
            
            <td>
                <a href="?content=sale&action=update&id=<?php echo $debt[$i]['sale_id'];?>" style="font-size: 20px;">
                <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                </a> 
                <a href="?content=sale&action=delete&id=<?php echo $debt[$i]['sale_id'];?>" onclick="return confirm('You want to delete sale : <?php echo $debt[$i]['name']; ?>');" style="color:red; font-size: 20px;">
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

