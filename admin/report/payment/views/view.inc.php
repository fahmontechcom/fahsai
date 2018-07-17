
<div class="row">
     
    <div class="col-lg-2">
        <div class="form-group">
            <label>วันที่เริ่มต้น <font color="#F00"><b>*</b></font> </label>
            <input  type="date" id="start_date" name="start_date" class="form-control date_pick" value="<?PHP echo $start_date;?>">
            <p class="help-block">Example : 31-11-2018 </p> 
        </div> 
    </div> 
    <div class="col-lg-2">
        <div class="form-group">
            <label>วันที่สิ้นสุด <font color="#F00"><b>*</b></font> </label>
            <input  type="date" id="end_date" name="end_date" class="form-control date_pick" value="<?PHP echo $end_date;?>">
            <p class="help-block">Example : 31-12-2018 </p> 
        </div> 
    </div>
    <div class="col-lg-2"  style='text-align:center;font-size:14px;margin-top:40px;'>
        <input type="checkbox" class="form-check-input" id="debt_payment_remark" <?PHP if($debt_payment_remark=='true'){echo 'checked';}?> style="">
        <label class="form-check-label" for="debt_payment_remark">แสดงหมายเหตุ</label>
    </div> 
    <div class="col-lg-2">
        <div class="form-group">
            <button name="button" onclick="search();"  class="btn btn-custom-blue" style="margin-top: 27px;">ค้นหา</button> 
        </div> 
    </div> 
    
     
    
</div>  
<div class="form-group" style="text-align:right">
    <button name="button" onclick="rp_print();"  class="btn btn-custom-blue" style="margin-top: 27px;">ออกรายงาน</button> 
    <button name="button" onclick="rp_excel();"  class="btn btn-custom-blue" style="margin-top: 27px;">Excel</button> 
    <button name="button" onclick="rp_pdf();"  class="btn btn-custom-blue" style="margin-top: 27px;">PDF</button>
</div>  
<div class="col-lg-12">
    <div style="font-size:32px;" align="center"><strong>รายงานการชำระเงิน</strong></div> 
    <br>
    <table width="90%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">
        <thead>
            <tr>  
                <td class="" style="text-align:center;">ลูกค้า</td>
                <td class="" style="text-align:center;">อินวอย</td>
                <td class="" style="text-align:center;">เงินต้น</td>
                <td class="" style="text-align:center;">ดอกเบี้ย</td>
                <td class="" style="text-align:center;">ช่องทางการชำระเงิน</td>
                <td class="" style="text-align:center;">วันที่</td> 
                <td class="" style="text-align:center;">ค่าใช้จ่าย</td> 
                <?PHP if($debt_payment_remark!='false'){?>
                <td class="" style="text-align:center;">หมายเหตุ</td> 
                <?PHP }?>
                <td class="" style="text-align:center;">ชำระ</td> 
            </tr>        
        </thead>
        <tbody>
            <?php 
            for($i=0; $i < count($payment); $i++){
            ?> 
                <tr name="debt_payment_id" data-id="<?PHP echo $debt[$i]['debt_payment_id'];?>"> 
                    <td class="" style="text-align:center;"><?php echo $payment[$i]['customer_name'];?></td>
                    <td class="" style="text-align:center;width:140px;"><?php echo $payment[$i]['debt_invoice_number'];?></td>
                    <td class="" style="text-align:right;width:140px;"><?php echo number_format($payment[$i]['debt_payment_value_pay'], 2, '.', ',');?></td>
                    <td class="" style="text-align:right;width:140px;"><?php echo number_format($payment[$i]['debt_payment_interest_pay'], 2, '.', ',');?></td>
                    <td class="" style="text-align:center;width:140px;"><?php echo $payment[$i]['debt_payment_gateway_name'];?></td>
                    <td class="" style="text-align:center;"><?php echo date_format(date_create($payment[$i]['debt_payment_date']),"d-m-Y");?></td> 
                    <td class="" style="text-align:right;"><?php echo number_format($payment[$i]['debt_payment_charge_amount_pay'], 2, '.', ',');?></td> 
                    <?PHP if($debt_payment_remark!='false'){?>
                    <td class="" style="text-align:center;"><?php echo $payment[$i]['debt_payment_remark'];?></td> 
                    <?PHP }?>
                    <td class="" style="text-align:right;"><?php echo number_format($payment[$i]['debt_payment_pay'], 2, '.', ',');?></td> 
                </tr> 
            <?php 
            }
            ?>  
        </tbody>
        <tfoot>
        
        </tfoot>
    </table>
</div>
<script>
    
    function search(){
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        var debt_payment_remark = document.getElementById('debt_payment_remark').checked;
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }
        $.post( "report/payment/views/index.inc.php",
                    { 
                        start_date:start_date,
                        end_date:end_date,
                        debt_payment_remark:debt_payment_remark,
                        action:'search'
                    }
                , function( data ) { 
                    $("#display_report").html(data);
                });
    }
    function rp_excel(){
        
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        var debt_payment_remark = document.getElementById('debt_payment_remark').checked;
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }

        window.open('print/payment.php?start_date='+start_date+'&end_date='+end_date+'&export_type=excel', '_blank'); 
    }
    function rp_pdf(){
        
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        var debt_payment_remark = document.getElementById('debt_payment_remark').checked;
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }

        window.open('print/payment.php?start_date='+start_date+'&end_date='+end_date+'&export_type=pdf', '_blank'); 
    }
    function rp_print(){
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        var debt_payment_remark = document.getElementById('debt_payment_remark').checked;
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }

        window.open('print/payment.php?start_date='+start_date+'&end_date='+end_date+'&export_type=print', '_blank'); 
    }
    
</script>

