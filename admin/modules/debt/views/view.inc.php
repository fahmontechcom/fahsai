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
        }else if(debt_invoice_number.length == 0){
            alert("Please input invoice number");
            document.getElementById("debt_invoice_number").focus();
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
                }else if(data=='1'){
                    alert('ไม่สามารถแก้ไขข้อมูลได้ กรุณาลบรายการชำระเงินก่อน');
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
    function debt_charge(customer_id,debt_id,debt_invoice_number,debt_check_number,debt_value,debt_remark){
        // alert(debt_id);
        $.post( "modules/charge/views/index.inc.php",
            {
                customer_id:customer_id,
                debt_id:debt_id,
                debt_invoice_number:debt_invoice_number,
                debt_check_number:debt_check_number,
                debt_value:debt_value,
                debt_remark:debt_remark,
                action:'view'
            }, 
            function( data ) {
            $("#modal_data_"+debt_id).html(data);
            $('.payment_tr').hide();
        });
        
        
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
   function debt_invoice(customer_id){
        window.location="index.php?content=invoice&customer_id="+customer_id;
       
    }



$(function(){
    $(".debt_date").datepicker({
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
<div class="row row-debt" style="">
  <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
               
                    <input type="hidden"  id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" />
                    <input type="hidden"  id="debt_id" name="debt_id" value="<?php echo $debts['debt_id']?>" />
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ประเภท <font color="#F00"><b>*</b></font></label>
                                <select id="debt_cate_id" name="debt_cate_id" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">อินวอย</option>
                                    <option value="1">เช็ค</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>อินวอย <font color="#F00"><b>*</b></font></label>
                                <input id="debt_invoice_number" name="debt_invoice_number" class="form-control" value="<?php echo $debts['debt_invoice_number']?>">
                                <p class="help-block">Example : INV1805004</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>เช็ค </label>
                                <input id="debt_check_number" name="debt_check_number" class="form-control" value="<?php echo $debts['debt_check_number']?>">
                                <p class="help-block">Example : 1234567</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>มูลค่า <font color="#F00"><b>*</b></font></label>
                                <input type="number"  step="any" id="debt_value" name="debt_value" class="form-control" value="<?php echo $debts['debt_value']?>">
                                <p class="help-block">Example : 15000</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>วันที่ <font color="#F00"><b>*</b></font> </label>
                                <input readonly type="text" id="debt_date" name="debt_date" class="form-control debt_date" value="<?php echo $debts['debt_date']?>">
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
                                <input type="text" id="debt_remark" name="debt_remark" class="form-control" value="<?php echo $debts['debt_remark']?>">
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
                      <button name="button" onclick="debt_invoice('<?php echo $customer_id; ?>')"  class="btn btn-custom-blue">ออกใบแจ้งหนี้</button>
                      
                    </div>
                    <!-- /.row (nested) -->
                
            </div>
            <!-- /.panel-body -->
        </div>
            
            <!-- /.panel-heading -->
            
        <hr />       

        <table>
    <thead>
        <tr>
            <th class="th-debt">ลำดับ.</th>
            <th class="th-debt">อินวอย</th>
            <th class="th-debt">เช็ค</th>  
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
                <td><?php echo $i+1; ?><a href="javascript:;" onclick="show_payment('#collapse_debt_<?=$debt[$i]['debt_id']?>','#collapse_debt_td_<?=$debt[$i]['debt_id']?>','<?=$customer_id?>','<?=$debt[$i]['debt_id']?>')"  style="font-size: 12px;">&nbsp;[+]</a></td>
                <td><?php echo $debt[$i]['debt_invoice_number']; ?></td>
                <td><?php echo $debt[$i]['debt_check_number']; ?></td>
                <td class="align-money"><?php echo number_format($debt[$i]['debt_value'], 2, '.', ','); ?></td>
                <td class="align-money" id="display_value_balance_<?=$debt[$i]['debt_id']?>"><?php 
                if($value_balance[$debt[$i]['debt_id']]['debt_payment_value_balance']!=''){
                    echo number_format($value_balance[$debt[$i]['debt_id']]['debt_payment_value_balance'], 2, '.', ',');
                }else{
                    echo number_format($debt[$i]['debt_value'], 2, '.', ','); 
                } 
                 ?></td>
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
                    <a href="javascript:;" onclick="debt_charge('<?php 
                    echo $customer_id;?>','<?php 
                    echo $debt[$i]['debt_id'];?>','<?php 
                    echo $debt[$i]['debt_invoice_number'];?>','<?php 
                    echo $debt[$i]['debt_check_number'];?>','<?php 
                    echo number_format($debt[$i]['debt_value'], 2, '.', ',');?>','<?php 
                    echo $debt[$i]['debt_remark'];?>');" data-toggle="modal" data-target="#modal_<?php echo $debt[$i]['debt_id']; ?>"  style="font-size: 20px;color:green;">
                        <i class="fa fa-money" aria-hidden="true" ></i>
                    </a>
                    <div class="modal fade" id="modal_<?php echo $debt[$i]['debt_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal_<?php echo $debt[$i]['debt_id']; ?>Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div id="modal_data_<?php echo $debt[$i]['debt_id']; ?>" class="modal-content">
                                
                            </div>
                        </div>
                    </div>
                    <a id="debt_update_<?php 
                        echo $debt[$i]['debt_id'];?>" href="javascript:;" onclick="debt_update('<?php 
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
            <tr class="payment_tr" style="display:none;" id="collapse_debt_<?=$debt[$i]['debt_id']?>">
                <td colspan="9" class="payment_td padding-0 margin-0" id="collapse_debt_td_<?=$debt[$i]['debt_id']?>"></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
               
          
          <!-- /.panel-body -->
      
      <!-- /.panel -->
    </div>
  
  </div>
</div>


