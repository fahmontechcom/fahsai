<script>
    function charge_add(){
            
        
        var debt_payment_charge_id = document.getElementById("debt_payment_charge_id_<?php echo $debt_id; ?>").value;
        var debt_payment_charge_detail = document.getElementById("debt_payment_charge_detail_<?php echo $debt_id; ?>").value; 
        var debt_payment_charge_amount = document.getElementById("debt_payment_charge_amount_<?php echo $debt_id; ?>").value; 
        var debt_payment_charge_date = document.getElementById("debt_payment_charge_date_<?php echo $debt_id; ?>").value; 
        
        debt_payment_charge_detail = $.trim(debt_payment_charge_detail); 
        debt_payment_charge_amount = $.trim(debt_payment_charge_amount); 
        debt_payment_charge_date = $.trim(debt_payment_charge_date); 
        

        if(debt_payment_charge_detail.length == 0){
            alert("Please input detail");
            document.getElementById("debt_payment_charge_detail_<?php echo $debt_id; ?>").focus();
            return false;
        }else if(debt_payment_charge_amount.length == 0){
            alert("Please input amount");
            document.getElementById("debt_payment_charge_amount_<?php echo $debt_id; ?>").focus();
            return false;    
        }else if(debt_payment_charge_date.length == 0){
            alert("Please input date");
            document.getElementById("debt_payment_charge_date_<?php echo $debt_id; ?>").focus();
            return false;    
        }else if(debt_payment_charge_id.length== 0){
            
            // window.history.replaceState("", "", "index.php?content=customer&customer_id="+customer_id+"");
            $.post( "modules/charge/views/index.inc.php",
                    {
                        customer_id:<?php echo $customer_id; ?>,
                        debt_id:'<?php echo $debt_id; ?>',
                        debt_payment_charge_detail:debt_payment_charge_detail,
                        debt_payment_charge_amount:debt_payment_charge_amount,
                        debt_payment_charge_date:debt_payment_charge_date,
                        action:'add'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else if(data=='1'){
                    alert('กรุณาเลือกวันให้มากกว่าข้อมูลล่าสุด');
                }else{
                    $("#modal_data_<?php echo $debt_id; ?>").html(data);
                }
                // getInvoiceNumber(customer_id);

            });
        }else{
            // alert();
            // window.history.replaceState("", "", "index.php?content=customer&customer_id="+customer_id+"");
            $.post( "modules/charge/views/index.inc.php",
                    {
                        id:debt_payment_charge_id,
                        customer_id:<?php echo $customer_id; ?>,
                        debt_id:'<?php echo $debt_id; ?>',
                        debt_payment_charge_detail:debt_payment_charge_detail,
                        debt_payment_charge_amount:debt_payment_charge_amount,
                        debt_payment_charge_date:debt_payment_charge_date,
                        action:'edit'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถบันทึกข้อมูลได้');
                }else if(data=='1'){
                    alert('กรุณาเลือกวันให้มากกว่าข้อมูลล่าสุด');
                }else if(data=='2'){
                    alert('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากข้อมูลนี้ได้ถูกใช้งานในรายการจ่ายเงินไปแล้ว');
                }else{
                    $("#modal_data_<?php echo $debt_id; ?>").html(data);
                }
                // getInvoiceNumber(customer_id);
            });
        }
            
    }
    function charge_delete(debt_payment_charge_id){
        if(confirm('You want to delete this charge ?')){
            $.post( "modules/charge/views/index.inc.php",
                    {
                        customer_id:<?php echo $customer_id; ?>,
                        debt_id:'<?php echo $debt_id; ?>',
                        id:debt_payment_charge_id,
                        action:'delete'
                    }
                , function( data ) {
                if(data=='0'){
                    alert('ไม่สามารถลบข้อมูลได้');
                }else if(data=='2'){
                    alert('ไม่สามารถลบข้อมูลได้ เนื่องจากข้อมูลนี้ได้ถูกใช้งานในรายการจ่ายเงินไปแล้ว');
                }else{
                    $("#modal_data_<?php echo $debt_id; ?>").html(data);
                } 
            });
        }
        
    }
    function charge_update(debt_payment_charge_id,debt_payment_charge_detail,debt_payment_charge_amount,debt_payment_charge_date){
            
        document.getElementById("debt_payment_charge_id_<?php echo $debt_id; ?>").value = debt_payment_charge_id;
        document.getElementById("debt_payment_charge_detail_<?php echo $debt_id; ?>").value = debt_payment_charge_detail;
        document.getElementById("debt_payment_charge_amount_<?php echo $debt_id; ?>").value = debt_payment_charge_amount; 
        document.getElementById("debt_payment_charge_date_<?php echo $debt_id; ?>").value = debt_payment_charge_date; 
    }
    function charge_view(customer_id){
        $.post( "modules/charge/views/index.inc.php",
            {
                customer_id:<?php echo $customer_id; ?>,
                debt_id:'<?php echo $debt_id; ?>',
                action:'view'
            }, 
            function( data ) {
                $("#modal_data_<?php echo $debt_id; ?>").html(data);

        });
        
    }

    $(function(){
        $(".debt_date").datepicker({
            dateFormat: 'yy-mm-dd',
            // numberOfMonths: 2,
        });

    });
</script>             

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">จัดการเช็ค</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">          
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>อินวอย </label>
                    <input readonly id="debt_invoice_number" name="debt_invoice_number" class="form-control" value="<?php echo $debts['debt_invoice_number'];?>">
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>เช็ค </label>
                    <input readonly id="debt_check_number" name="debt_check_number" class="form-control" value="<?php echo $debts['debt_check_number'];?>">
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label>มูลค่า </label>
                    <input readonly id="debt_value" name="debt_value" class="form-control" value="<?php echo number_format($debts['debt_value'], 2, '.', ',');?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>หมายเหตุ </label>
                    <input readonly id="debt_remark" name="debt_remark" class="form-control" value="<?php echo $debts['debt_remark'];?>">
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="hidden" id="debt_payment_charge_id_<?php echo $debt_id; ?>" name="debt_payment_charge_id_<?php echo $debt_id; ?>" class="form-control" value="">
                    <label>รายละเอียดค่าใช้จ่าย <font color="#F00"><b>*</b></font></label>
                    <input  id="debt_payment_charge_detail_<?php echo $debt_id; ?>" name="debt_payment_charge_detail_<?php echo $debt_id; ?>" class="form-control" value=""> 
                    <p class="help-block">Example : ค่าเดินทาง</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>จำนวน <font color="#F00"><b>*</b></font></label>
                    <input  type="number"  step="any" id="debt_payment_charge_amount_<?php echo $debt_id; ?>" name="debt_payment_charge_amount_<?php echo $debt_id; ?>" class="form-control" value=""> 
                    <p class="help-block">Example : 5000</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>วันที่ <font color="#F00"><b>*</b></font> </label>
                    <input readonly type="text" id="debt_payment_charge_date_<?php echo $debt_id; ?>" name="debt_payment_charge_date_<?php echo $debt_id; ?>" class="form-control debt_date" value="">
                    <p class="help-block">Example : 2018-12-31 09:00</p>
                    
                </div>
            </div>
            
        </div>
        
        <div align="right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ย้อนกลับ</button>
            <button type="button" onclick="charge_view('<?php echo $debt_id; ?>');" class="btn btn-primary">ล้างข้อมูล</button>
            <button name="button" onclick="charge_add();"  class="btn btn-success">บันทึกข้อมูล</button>  
        </div>
        <hr />   
        
        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>รายละเอียดค่าใช้จ่าย</th> 
                        <th>จำนวน</th> 
                        <th style="max-width:60px;">จัดการ</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php 
                for($i=0; $i < count($charge); $i++){
                    ?>
                    <tr class="nth-child">
                        <td><?php echo $charge[$i]['debt_payment_charge_date']; ?></td>
                        <td><?php echo $charge[$i]['debt_payment_charge_detail']; ?></td>
                        <td class="align-money" ><?php echo number_format($charge[$i]['debt_payment_charge_amount'], 2, '.', ','); ?></td>
                        <td>
                        <?PHP 
                            if($i == count($charge)-1){
                                ?>
                            <a href="javascript:;" onclick="charge_update('<?php 
                                echo $charge[$i]['debt_payment_charge_id']; ?>','<?php 
                                echo $charge[$i]['debt_payment_charge_detail'];?>','<?php 
                                echo $charge[$i]['debt_payment_charge_amount'];?>','<?php 
                                echo $charge[$i]['debt_payment_charge_date'];?>');" style="font-size: 20px;">
                                <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                            </a> 
                            
                            <a href="javascript:;" onclick="charge_delete('<?php 
                                echo $charge[$i]['debt_payment_charge_id']; ?>');" style="color:red; font-size: 20px;">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                            <?PHP
                            }
                        ?>
                        </td>
                    
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>                                             
    </div>
</div>
               
           
     

               
            



