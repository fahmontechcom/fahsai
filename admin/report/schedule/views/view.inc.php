<script>
     
</script>
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
    <div style="font-size:32px;" align="center"><strong>รายงานกำหนดการรวม</strong></div> 
    <br>
    <table width="90%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">
        <thead>
            <tr>  
                <td class="border-report" style="text-align:center;">วันที่</td>
                <td class="border-report" style="text-align:center;">รายละเอียด</td>
                <td class="border-report" style="text-align:center;">ลูกค้า</td>
                <td class="border-report" style="text-align:center;">อินวอย</td>  
            </tr>        
        </thead>
        <tbody>
            <?php 
            for($i=0; $i < count($schedule_list); $i++){
            ?>
             <tr> 
                    <td class="border-report" style="width:140px;text-align:center;border:1px solid #000;"><?php echo date_format(date_create($schedule_list[$i]['debt_schedule_list_date']),"d-m-Y");?></td>
                    <td name=" " class="border-report" style="text-align:center;border:1px solid #000;"><?php echo $schedule_list[$i]['debt_schedule_list_detail'];?></td>
                    <td name=" " class="border-report" style="text-align:center;"><?php echo $schedule_list[$i]['customer_name'];?></td>
                    <td name=" " class="border-report" style="text-align:center;width:140px;"><?php echo $schedule_list[$i]['debt_invoice_number'];?></td>
                     
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
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }
        $.post( "report/schedule/views/index.inc.php",
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
        if(start_date.length == 0){
            alert("Please input start date");
            document.getElementById("start_date").focus();
            return false;
        }else if(end_date.length == 0){
            alert("Please input end date");
            document.getElementById("end_date").focus();
            return false;
        }

        window.open('print/schedule.php?start_date='+start_date+'&end_date='+end_date+'&export_type=excel', '_blank'); 
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

        window.open('print/schedule.php?start_date='+start_date+'&end_date='+end_date+'&export_type=pdf', '_blank'); 
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

        window.open('print/schedule.php?start_date='+start_date+'&end_date='+end_date+'&export_type=print', '_blank'); 
    }
</script>
