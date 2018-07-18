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
    <div style="font-size:18px;" align="center"><strong>รายงานภาพรวม</strong></div> 
    <div style="font-size:14px;" align="right">ระหว่างวันที่ <?=date_format(date_create($start_date),"d-m-Y")?> ถึง <?=date_format(date_create($end_date),"d-m-Y")?> </div> 
    <table width="90%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">
        <thead>
            <tr>  
                <td class="border-report" style="text-align:center;"><strong>ลูกค้า</strong></td>
                <td class="border-report" style="text-align:center;"><strong>เงินต้นคงเหลือ</strong></td>
                <td class="border-report" style="text-align:center;"><strong>ดอกเบี้ย</strong></td>
                <td class="border-report" style="text-align:center;"><strong>วันที่รับดอกเบี้ยล่าสุด</strong></td>
                <td class="border-report" style="text-align:center;"><strong>ค่าใช้จ่าย</strong></td>
                <td class="border-report" style="text-align:center;"><strong>ยอดทั้งหมด</strong></td> 
            </tr>        
        </thead>
        <tbody>
            <?php 
            for($i=0; $i < count($debt); $i++){
                
            ?> 
            <tr name="debt_id" data-id="<?PHP echo $debt[$i]['debt_id'];?>"> 
                <td class="border-report" style="text-align:center;border:1px solid #000;"><?php echo $debt[$i]['customer_name'];?></td>
                <td name="rp_value_balance" class="border-report" style="width:140px;border:1px solid #000;"></td>
                <td name="rp_interest" class="border-report" style="width:140px;"></td>
                <td name="rp_interest_date" class="border-report" style="text-align:center;width:140px;"></td>
                <td name="rp_charge" class="border-report" style="width:140px;"></td>
                <td name="rp_sum" class="border-report" style=""></td> 
            </tr> 
            <?php 
            }
            ?>  
        </tbody>
        <tfoot>
            <tr>  
                <td colspan='5' style="text-align:right;border:1px solid #000;"><strong>รวม</strong></td> 
                <td style="text-align:right;border:1px solid #000;"><strong><span id="rp_sum_all"></span></strong></td> 
            </tr>
        </tfoot>
    </table>
</div>
<script>
    $(document).ready(function(){
        calReportByRow();
    }); 
    function calReportByRow(){ 
        var debt_id = document.getElementsByName('debt_id'); 
        var rp_value_balance = document.getElementsByName('rp_value_balance'); 
        var rp_interest_date = document.getElementsByName('rp_interest_date'); 
        var rp_interest = document.getElementsByName('rp_interest'); 
        var rp_charge = document.getElementsByName('rp_charge'); 
        var rp_sum = document.getElementsByName('rp_sum'); 
        var rp_sum_all = document.getElementById('rp_sum_all'); 
        var sum_all = 0;
        var debt_data = [];
        for(var i = 0 ; i < (debt_id.length); i++){ 
            debt_data.push({
                debt_id:debt_id[i].dataset.id
            });
        } 

        $.post( "controllers/getSumReport.php", { debt_data:JSON.stringify(debt_data)}) 
                .done(function( data ) { 
                    console.log(data);
                    
                    for(var i = 0 ; i < (data.length); i++){ 
                        rp_value_balance[i].innerText= (parseFloat(data[i].debt_payment_value_balance).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
                        rp_interest_date[i].innerText=data[i].debt_payment_interest_last_date; 
                        rp_interest[i].innerText= (parseFloat(data[i].debt_payment_interest).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        rp_charge[i].innerText= (parseFloat(data[i].debt_payment_charge_amount).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        rp_sum[i].innerText=(parseFloat(data[i].debt_payment_value_balance+data[i].debt_payment_interest+data[i].debt_payment_charge_amount).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        sum_all +=data[i].debt_payment_value_balance+data[i].debt_payment_interest+data[i].debt_payment_charge_amount;
                    }
                    rp_sum_all.innerText = (parseFloat(sum_all).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });


    }
    function search(){
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }
        $.post( "report/overview/views/index.inc.php",
                    { 
                        start_date:start_date,
                        end_date:end_date,
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

        window.open('print/overview.php?start_date='+start_date+'&end_date='+end_date+'&export_type=excel', '_blank'); 
    }
    function rp_pdf(){
        
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value; 
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }

        window.open('print/overview.php?start_date='+start_date+'&end_date='+end_date+'&export_type=pdf', '_blank'); 
    }
    function rp_print(){
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value; 
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }

        window.open('print/overview.php?start_date='+start_date+'&end_date='+end_date+'&export_type=print', '_blank'); 
    }
</script>
