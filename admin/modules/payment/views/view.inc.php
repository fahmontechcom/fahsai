<script>

$(function(){
    $(".date_pick").datetimepicker({
        dateFormat: 'yy-mm-dd',
        // numberOfMonths: 2,
    });

});

    
    // $("#show_sum").html('xx,xxx');
    // $("#show_pay").html('xx,xxx');
    // $("#show_balance").html('xx,xxx');
    function payment_add(){
           
        var debt_payment_id = document.getElementById("debt_payment_id").value; 
        var debt_payment_date = document.getElementById("debt_payment_date").value; 
        var debt_payment_pay = document.getElementById("debt_payment_pay").value;
        var debt_payment_gateway_id = document.getElementById("debt_payment_gateway_id").value; 
        var debt_payment_remark = document.getElementById("debt_payment_remark").value; 
        var debt_payment_discount = document.getElementById("debt_payment_discount").value; 
        
        debt_payment_date = $.trim(debt_payment_date);
        debt_payment_pay = $.trim(debt_payment_pay);
        debt_payment_gateway_id = $.trim(debt_payment_gateway_id); 
        debt_payment_remark = $.trim(debt_payment_remark); 
 

        if(debt_payment_pay.length == 0){
            alert("Please input amount");
            document.getElementById("debt_payment_pay").focus();
            return false;
        }else if(debt_payment_date.length == 0){
            alert("Please input date");
            document.getElementById("debt_payment_date").focus();
            return false;       
        }else if(debt_payment_gateway_id.length == 0){
            alert("Please input gateway");
            document.getElementById("debt_payment_gateway_id").focus();
            return false;       
        }else if(debt_payment_id.length== 0){ 
            $.post( "modules/payment/views/index.inc.php",
                    {  
                        debt_id:'<?php echo $debt_id;?>',
                        debt_payment_gateway_id:debt_payment_gateway_id, 
                        debt_payment_date:debt_payment_date,  
                        debt_payment_pay:debt_payment_pay,  
                        debt_payment_remark:debt_payment_remark,
                        debt_payment_discount:debt_payment_discount,
                        action:'add'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else{
                    $("#collapse_debt_td_<?php echo $debt_id;?>").html(data);
                }
                

            });
        }else{ 
            $.post( "modules/payment/views/index.inc.php",
                    { 
                        debt_id:'<?php echo $debt_id;?>',
                        id:debt_payment_id,
                        debt_payment_gateway_id:debt_payment_gateway_id, 
                        debt_payment_date:debt_payment_date, 
                        debt_payment_pay:debt_payment_pay, 
                        debt_payment_remark:debt_payment_remark,
                        debt_payment_discount:debt_payment_discount,
                        action:'edit'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else{
                    $("#collapse_debt_td_<?php echo $debt_id;?>").html(data);
                }
                
            });
        }
        
    }

    function payment_delete(debt_payment_id){
        if(confirm('You want to delete this payment ?')){
            $.post( "modules/payment/views/index.inc.php",
                    {
                        debt_id:'<?php echo $debt_id;?>',
                        id:debt_payment_id,
                        action:'delete'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถลบข้อมูลได้');
                }else{
                    $("#collapse_debt_td_<?php echo $debt_id;?>").html(data);
                }

                
                
 
            });
        }
       
    }
    
    function payment_update(debt_payment_id,debt_payment_gateway_id,debt_payment_date,debt_payment_pay ,debt_payment_remark,debt_payment_discount){
         
        document.getElementById("debt_payment_id").value = debt_payment_id;  
        document.getElementById("debt_payment_gateway_id").value = debt_payment_gateway_id; 
        document.getElementById("debt_payment_date").value = debt_payment_date; 
        document.getElementById("debt_payment_pay").value = debt_payment_pay; 
        document.getElementById("debt_payment_remark").value = debt_payment_remark; 
        document.getElementById("debt_payment_discount").value = debt_payment_discount; 
         
    }
    function payment_view(){
        $.post( "modules/payment/views/index.inc.php",
            {
                debt_id:'<?php echo $debt_id;?>',
                action:'view'
            }, 
            function( data ) {
            $("#collapse_debt_td_<?php echo $debt_id;?>").html(data);

        });
        
    }
  
</script>
<div class="row row-payment" style="">
  <div class="col-lg-12">
        <div class="panel panel-default">
            
            <div class="panel-body">
                
                <div class="col-lg-12 text-left" style="margin-top:5px;">
                    <p class="p-bold">จำนวนหนี้&nbsp;:&nbsp;<span class="span-nomal"  id="show_debt_value"><?php echo number_format($debt['debt_value'], 2, '.', ','); ?></span>&nbsp;&nbsp;ดอกเบี้ย&nbsp;:&nbsp;<span class="span-nomal" id="show_debt_interest" ><?php echo number_format($debt['debt_interest'], 2, '.', ','); ?></span>&nbsp;&nbsp;ค่าใช้จ่าย&nbsp;:&nbsp;<span class="span-nomal" id="show_charge_amount" ><?php echo number_format($charge['debt_payment_charge_amount'], 2, '.', ','); ?></span>&nbsp;&nbsp;รวม&nbsp;:&nbsp;<span class="span-nomal" id="show_sum"><?php echo number_format($sum, 2, '.', ','); ?></span>&nbsp;&nbsp;ชำระแล้ว&nbsp;:&nbsp;<span class="span-nomal" id="show_pay"><?php echo number_format($sum_payment['debt_payment_pay'], 2, '.', ','); ?></span>&nbsp;&nbsp;คงเหลือ&nbsp;:&nbsp;<span class="span-nomal"  id="show_balance"><?php echo number_format($balance, 2, '.', ','); ?></span></p>  
                </div>
                <div class="row justify-content-md-center">
                    
                    <div class="col-md-12 col-lg-11">
                    <table style="">
                        <thead>
                            <tr>
                                <th class="th-debt-payment">วันที่</th>
                                <th class="th-debt-payment">ยอดจ่ายเงิน</th>
                                <th class="th-debt-payment">จ่ายเงินต้น</th>  
                                <th class="th-debt-payment">จ่ายค่าใช้จ่าย</th>  
                                <th class="th-debt-payment">จ่ายดอกเบี้ย</th>  
                                <th class="th-debt-payment">ส่วนลด</th>  
                                <th class="th-debt-payment">ช่องทางชำระ</th>
                                <th class="th-debt-payment">จัดการ</th>
                                
                            </tr>
                        </thead>
                        <tbody id="tbody_debt">
                            <?php 
                            for($i=0; $i < count($payment); $i++){
                                ?>
                                <tr class="nth-child">
                                    <td><?php echo $payment[$i]['debt_payment_date']; ?></td>
                                    <td class="align-money" ><?php echo number_format($payment[$i]['debt_payment_pay'], 2, '.', ','); ?></td>
                                    <td><?php echo number_format($payment[$i]['debt_payment_value_pay'], 2, '.', ','); ?></td>
                                    <td><?php echo number_format($payment[$i]['debt_payment_charge_amount_pay'], 2, '.', ','); ?></td>
                                    <td><?php echo number_format(($payment[$i]['debt_payment_interest_pay']-$payment[$i]['debt_payment_discount']), 2, '.', ','); ?></td>
                                    <td><?php echo number_format($payment[$i]['debt_payment_discount'], 2, '.', ','); ?></td>
                                    <td><?php echo $payment[$i]['debt_payment_gateway_name']; ?></td>
                                    
                                
                                    <td>
                                        
                                        <a href="javascript:;" onclick="payment_update('<?php  
                                            echo $payment[$i]['debt_payment_id'];?>','<?php  
                                            echo $payment[$i]['debt_payment_gateway_id'];?>','<?php 
                                            echo $payment[$i]['debt_payment_date'];?>','<?php 
                                            echo $payment[$i]['debt_payment_pay'];?>','<?php 
                                            echo $payment[$i]['debt_payment_remark'];?>','<?php 
                                            echo $payment[$i]['debt_payment_discount'];?>');" style="font-size: 20px;">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                                        </a> 
                                        <a href="javascript:;" onclick="payment_delete('<?php  
                                            echo $payment[$i]['debt_payment_id'];?>');" style="color:red; font-size: 20px;">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                
                                </tr>
                                
                                <?php } ?>
                        </tbody>
                    </table>
                    </div>
                    
                </div>
                <hr />  
                    <input type="hidden"  id="debt_payment_id" name="debt_payment_id" value="" />
                    <div class="row" style="margin-left:10px;margin-right:10px;"> 
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>วันที่ <font color="#F00"><b>*</b></font> </label>
                                <input readonly type="text" id="debt_payment_date" name="debt_payment_date" class="form-control date_pick">
                                <p class="help-block">Example : 2018-12-31 09:00</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ชำระเงิน <font color="#F00"><b>*</b></font></label>
                                <input type="number"  step="any" id="debt_payment_pay" name="debt_payment_pay" class="form-control" value="">
                                <p class="help-block">Example : 15000</p>
                                
                            </div>
                        </div> 
                        <div class="col-lg-2">
                            
                            <div class="form-group">
                                <label>ช่องทางชำระ <font color="#F00"><b>*</b></font></label>
                                <select id="debt_payment_gateway_id" name="debt_payment_gateway_id" class="form-control">
                                    <option value="">Select</option>
                                    <?php 
                                    for($i =  0 ; $i < count($gateway) ; $i++){
                                        ?>
                                        <option value="<?php echo $gateway[$i]['debt_payment_gateway_id'] ?>"><?php echo $gateway[$i]['debt_payment_gateway_name'] ?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ส่วนลด</label>
                                <input type="number" id="debt_payment_discount" name="debt_payment_discount" class="form-control" value="">
                                <p class="help-block">Example : 25</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>หมายเหตุ</label>
                                <input type="text" id="debt_payment_remark" name="debt_payment_remark" class="form-control" value="">
                                <p class="help-block">Example : ธ. กรุงเทพ บช. 999-999</p>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                    <div align="right" style="margin-right:25px">
                      <button type="button" onclick="payment_view()" class="btn btn-primary">ล้างข้อมูล</button>
                      <button name="button" onclick="payment_add()"  class="btn btn-success">บันทึกข้อมูล</button>
                    </div>

                   
                
            </div>
            
        </div>
            
        
            
             

        
               
          
          
    </div>
  
  </div>
</div>


