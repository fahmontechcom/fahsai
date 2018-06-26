<script>
    function check_debt_schedule(){
  

            var debt_schedule_id = document.getElementById("debt_schedule_id").value;
            var debt_id = document.getElementById("debt_id").value;
            var debt_schedule_status_id = document.getElementById("debt_schedule_status_id").value;
            var debt_schedule_detail = document.getElementById("debt_schedule_detail").value;
            var debt_schedule_remark = document.getElementById("debt_schedule_remark").value;
            // var debt_schedule_date = document.getElementById("debt_schedule_date").value;
            
            debt_schedule_id = $.trim(debt_schedule_id);
            debt_id = $.trim(debt_id);
            debt_schedule_status_id = $.trim(debt_schedule_status_id);
            debt_schedule_detail = $.trim(debt_schedule_detail);
            debt_schedule_remark = $.trim(debt_schedule_remark);
            // debt_schedule_date = $.trim(debt_schedule_date);
            
             if(debt_schedule_status_id.length == 0){
                alert("Please input status");
                document.getElementById("debt_schedule_status_id").focus();
                return false;
            }else if(debt_schedule_detail.length == 0){
                alert("Please input detail");
                document.getElementById("debt_schedule_detail").focus();
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
                <form role="form" method="post" onsubmit="return check_debt_schedule();" <?php if($debt_schedule_id == ''){ ?>action="index.php?content=schedule&action=add"<?php }else{?> action="index.php?content=schedule&action=edit" <?php }?> enctype="multipart/form-data">
                    <input type="hidden"  id="debt_schedule_id" name="debt_schedule_id" value="<?php echo $debt_schedule_id; ?>" />
                    <input type="hidden"  id="debt_id" name="debt_id" value="<?php echo $debt_id; ?>" />
                    <input type="hidden"  id="custmer_id" name="custmer_id" value="<?php echo $custmer_id; ?>" />
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <!-- /.row (nested) -->

                            <div class="row">
                                
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>สถานะ </label>                                                                           
                                        <select id="debt_schedule_status_id" name="debt_schedule_status_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php 
                                            for($i =  0 ; $i < count($debt_schedule_status) ; $i++){
                                                ?>
                                                <option value="<?php echo $debt_schedule_status[$i]['debt_schedule_status_id'] ?>"><?php echo $debt_schedule_status[$i]['debt_schedule_status_name'] ?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
  
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>คำอธิบาย <font color="#F00"><b>*</b></font></label>
                                        <input id="debt_schedule_detail" name="debt_schedule_detail" class="form-control" value="<?php echo $debt_schedule['debt_schedule_detail']?>">
                                        <p class="help-block">Example : เจรจาผ่อนจ่าย</p>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>หมายเหตุ <font color="#F00"><b>*</b></font></label>
                                        <input id="debt_schedule_remark" name="debt_schedule_remark" class="form-control" value="<?php echo $debt_schedule['debt_schedule_remark']?>">
                                        <p class="help-block">Example : ผ่อนจ่ายทุกๆ วันที่ 5 ของเดือน</p>
                                        
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

        <div id="calendar_div" class="row mouse-today"></div>
        <script src="../template/calendar/function.js"></script>
               
          
          <!-- /.panel-body -->
      
      <!-- /.panel -->
    </div>
  
  </div>
</div>
<script type="text/javascript">

var d = new Date();

var date_event = [{
    date:{
        day:d.getDate(),
        month:d.getMonth()+1,
        year:d.getFullYear()
    }, 
    type:0,
    class:'badge-today color-today', 
    detail:'ปัจจุบัน'
},{
    date:{
        day:25,
        month:1,
        year:2018
    }, 
    type:1,
    class:'badge-event color-event', 
    detail:'วันหยุด'
},{
    date:{
        day:24,
        month:1,
        year:2018
    }, 
    type:3,
    class:'badge-invoice color-invoice', 
    detail:'รับ Invoice วันสุดท้าย'
},{
    date:{
        day:1,
        month:2,
        year:2018
    }, 
    type:2,
    class:'badge-bill color-bill', 
    detail:'วันวางบิล'
},{
    date:{
        day:2,
        month:2,
        year:2018
    }, 
    type:2,
    class:'badge-bill color-bill', 
    detail:'วันวางบิล'
},{
    date:{
        day:3,
        month:2,
        year:2018
    }, 
    type:2,
    class:'badge-bill color-bill', 
    detail:'วันวางบิล'
},{
    date:{
        day:4,
        month:2,
        year:2018
    }, 
    type:2,
    class:'badge-bill color-bill', 
    detail:'วันวางบิล'
}];



    //load initCalendar 
    window.onload =function() {
        initCalendar();
    };
    
</script>

