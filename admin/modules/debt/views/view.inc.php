<script>
    
    function debt_add(customer_id){
           
        var debt_cate_id = document.getElementById("debt_cate_id").value; 
        var debt_id = document.getElementById("debt_id").value; 
        var debt_check_number = document.getElementById("debt_check_number").value; 
        var debt_invoice_number = document.getElementById("debt_invoice_number").value;
        var debt_value = document.getElementById("debt_value").value;
        var debt_date = document.getElementById("debt_date").value;
        var debt_remark = document.getElementById("debt_remark").value;
        var sale_id = document.getElementById("sale_id").value;
        

        debt_cate_id = $.trim(debt_cate_id); 
        debt_check_number = $.trim(debt_check_number); 
        debt_invoice_number = $.trim(debt_invoice_number);
        debt_value = $.trim(debt_value);
        debt_date = $.trim(debt_date);
        debt_remark = $.trim(debt_remark);
        sale_id = $.trim(sale_id);
 

        if(debt_cate_id.length == 0){
            alert("Please input debt_cate_id");
            document.getElementById("debt_cate_id").focus();
            return false;
        }else if(debt_check_number.length == 0 && debt_invoice_number.length == 0){
            alert("Please input check number or invoice number");
            document.getElementById("debt_date").focus();
            return false;
        }else if(debt_value.length == 0){
            alert("Please input value");
            document.getElementById("debt_value").focus();
            return false;
        }else if(debt_date.length == 0){
            alert("Please input date");
            document.getElementById("debt_date").focus();
            return false;
        }else if(sale_id.length == 0){
            alert("Please input sale name");
            document.getElementById("sale_id").focus();
            return false;
        }else if(debt_id.length== 0){

            window.history.replaceState("", "", "index.php?content=customer&customer_id="+customer_id+"");
            $.post( "modules/debt/views/index.inc.php",
                    {
                        customer_id:customer_id,
                        debt_cate_id:debt_cate_id,
                        debt_check_number:debt_check_number,
                        debt_invoice_number:debt_invoice_number,
                        debt_value:debt_value,
                        debt_date:debt_date,
                        sale_id:sale_id,
                        debt_remark:debt_remark,
                        action:'add'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else{
                    $("#collapse_td_"+customer_id).html(data);
                }
                getInvoiceNumber(customer_id);

            });
        }else{
            window.history.replaceState("", "", "index.php?content=customer&customer_id="+customer_id+"");
            $.post( "modules/debt/views/index.inc.php",
                    {
                        customer_id:customer_id,
                        debt_cate_id:debt_cate_id,
                        debt_id:debt_id,
                        debt_check_number:debt_check_number,
                        debt_invoice_number:debt_invoice_number,
                        debt_value:debt_value,
                        debt_date:debt_date,
                        sale_id:sale_id,
                        debt_remark:debt_remark,
                        action:'edit'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else{
                    $("#collapse_td_"+customer_id).html(data);
                }
                getInvoiceNumber(customer_id);
            });
        }
        
    }

    function debt_delete(customer_id,debt_id){
        if(confirm('You want to delete this invoice ?')){
            $.post( "modules/debt/views/index.inc.php",
                    {
                        customer_id:customer_id,
                        id:debt_id,
                        action:'delete'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else{
                    $("#collapse_td_"+customer_id).html(data);
                }

                getInvoiceNumber(customer_id);
                

            });
        }
       
    }
    function schedule_view(customer_id,debt_id){
        // alert(debt_id);
        window.location="index.php?content=schedule&customer_id="+customer_id+"&debt_id="+debt_id;
       
    }
    function schedule_update(customer_id,debt_id,debt_schedule_id){
        // alert(debt_id);
        window.location="index.php?content=schedule&customer_id="+customer_id+"&debt_id="+debt_id+"&id="+debt_schedule_id+"&action=update";
       
    }

   
    
    function debt_update(customer_id,debt_cate_id,debt_id,debt_check_number,debt_invoice_number,debt_value,debt_date,sale_id,debt_remark){
        
        document.getElementById("customer_id").value = customer_id;
        document.getElementById("debt_cate_id").value = debt_cate_id; 
        document.getElementById("debt_id").value = debt_id; 
        document.getElementById("debt_check_number").value = debt_check_number; 
        document.getElementById("debt_invoice_number").value = debt_invoice_number; 
        document.getElementById("debt_value").value = debt_value; 
        document.getElementById("debt_date").value = debt_date; 
        document.getElementById("sale_id").value = sale_id; 
        document.getElementById("debt_remark").value = debt_remark; 
        
        
    }

   function debt_view(customer_id){
        $.post( "modules/debt/views/index.inc.php",
            {
                customer_id:customer_id,
                action:'view'
            }, 
            function( data ) {
            $("#collapse_td_"+customer_id).html(data);

        });
       
    }



$(function(){
    $(".debt_date").datetimepicker({
        dateFormat: 'yy-mm-dd',
        // numberOfMonths: 2,
    });

});

function getInvoiceNumber(customer_id){

    $.post( "controllers/getInvoiceNumber.php",
                    {
                        customer_id:customer_id
                    }
                , function( data ) {
                    console.log(data);
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else{
                    $("#display_inv_num_"+customer_id).html(data.invoice_number);
                    $("#display_chk_num_"+customer_id).html(data.check_number);
                    $("#display_inv_val_"+customer_id).html(data.invoice_value);
                    $("#display_chk_val_"+customer_id).html(data.check_value);
                }
                

            });
}


</script>
<div class="row " style="margin:0px;padding-top:10px;padding-bottom:15px;background-color:#e4f2fe;">
  <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
               
                    <input type="hidden"  id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" />
                    <input type="hidden"  id="debt_id" name="debt_id" value="<?php echo $customers['debt_id']?>" />
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ประเภท </label>
                                <select id="debt_cate_id" name="debt_cate_id" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">เลขที่เช็ค</option>
                                    <option value="1">เลขที่อินวอย</option>
                                </select>
                            </div>
                        </div>
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
                                <input type="number"  step="any" id="debt_value" name="debt_value" class="form-control" value="<?php echo $customers['debt_value']?>">
                                <p class="help-block">Example : 15000</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>วันที่ <font color="#F00"><b>*</b></font> </label>
                                <input readonly type="text" id="debt_date" name="debt_date" class="form-control debt_date" value="<?php echo $customers['debt_date']?>">
                                <p class="help-block">Example : 2018-12-31 09:00</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>พนักงานขาย <font color="#F00"><b>*</b></font></label>
                                <select id="sale_id" name="sale_id" class="form-control">
                                    <option value="">Select</option>
                                    <?php 
                                    for($i =  0 ; $i < count($sale) ; $i++){
                                        ?>
                                        <option value="<?php echo $sale[$i]['sale_id'] ?>"><?php echo $sale[$i]['name'] ?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
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
                      <button type="button" onclick="debt_view('<?php echo $customer_id; ?>')" class="btn btn-primary">ล้างข้อมูล</button>
                      <button name="button" onclick="debt_add('<?php echo $customer_id; ?>')"  class="btn btn-success">บันทึกข้อมูล</button>
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
            <th class="th-debt">ลำดับ.</th>
            <th class="th-debt">เลขที่เช็ค</th>  
            <th class="th-debt">เลขที่อินวอย</th>
            <th class="th-debt">มูลค่า</th>
            <th class="th-debt">คงเหลือ</th>
            <th class="th-debt">สถานะ</th>
            <th class="th-debt">จัดการ</th>
            
        </tr>
    </thead>
        <tbody id="tbody_debt">
        <?php 
        for($i=0; $i < count($debt); $i++){
            ?>
            <tr class="nth-child">
                <td><?php echo $i+1; ?></td>
                <td><?php echo $debt[$i]['debt_check_number']; ?></td>
                <td><?php echo $debt[$i]['debt_invoice_number']; ?></td>
                <td><?php echo number_format($debt[$i]['debt_value'], 2, '.', ','); ?></td>
                <td><?php echo $debt[$i]['debt_balance']; ?></td>
                <td style="text-align:left;">
                    <?PHP for($i_status=0; $i_status < count($debt_status[$debt[$i]['debt_id']]); $i_status++){?>
                        <button name="button" onclick="schedule_update(<?PHP 
                            echo $customer_id; ?>,<?php 
                            echo $debt[$i]['debt_id'];?>,<?php 
                            echo $debt_status[$debt[$i]['debt_id']][$i_status]['debt_schedule_id'];?>);"  class="btn btn-custom-black" style="">
                        <?php echo $debt_status[$debt[$i]['debt_id']][$i_status]['debt_schedule_status_name'];?>
                        </button>
                    <?PHP }?>
                    <button name="button" onclick="schedule_view(<?PHP 
                            echo $customer_id; ?>,<?php 
                            echo $debt[$i]['debt_id'];?>);"  class="btn btn-custom-green" style=""><i class="fa fa-plus" style=""></i>
                    </button>
                </td>
            
                <td>
                    <a href="javascript:;" onclick="debt_update('<?php 
                        echo $customer_id; ?>','<?php 
                        echo $debt[$i]['debt_cate_id'];?>','<?php 
                        echo $debt[$i]['debt_id'];?>','<?php 
                        echo $debt[$i]['debt_check_number'];?>','<?php 
                        echo $debt[$i]['debt_invoice_number'];?>','<?php 
                        echo $debt[$i]['debt_value'];?>','<?php 
                        echo $debt[$i]['debt_date'];?>','<?php 
                        echo $debt[$i]['sale_id'];?>','<?php 
                        echo $debt[$i]['debt_remark'];?>');" style="font-size: 20px;">
                        <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                    </a> 
                    <a href="javascript:;" onclick="debt_delete('<?php 
                        echo $customer_id; ?>','<?php 
                        echo $debt[$i]['debt_id'];?>');" style="color:red; font-size: 20px;">
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


