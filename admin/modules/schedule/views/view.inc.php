<script>
    
    function check_debt_schedule(){  
            
            var debt_schedule_status_id = document.getElementById("debt_schedule_status_id").value;
            var debt_schedule_detail = document.getElementById("debt_schedule_detail").value; 
            
            debt_schedule_status_id = $.trim(debt_schedule_status_id);
            debt_schedule_detail = $.trim(debt_schedule_detail); 
            
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
    function schedule_delete(customer_id,debt_schedule_id){
        if(confirm('You want to delete this status ?')){
            window.location="index.php?content=schedule&customer_id="+customer_id+"&id="+debt_schedule_id+"&action=delete";

        }       
    }
    function schedule_back(customer_id){
        window.location="index.php?content=customer&customer_id="+customer_id+"&action=view";
    }
</script>
<div class="row">
  <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
            <form role="form" method="post" onsubmit="return check_debt_schedule(<?PHP echo $customer_id; ?>);" <?php if($debt_schedule_id == ''){ ?>action="index.php?content=schedule&action=add&customer_id=<?PHP echo $customer_id; ?>"<?php }else{?> action="index.php?content=schedule&action=edit&customer_id=<?PHP echo $customer_id; ?>&id=<?php echo $debt_schedule_id;?>" <?php }?> enctype="multipart/form-data">
                    
                    <input type="hidden"  id="debt_id" name="debt_id" value="<?php echo $debt_id; ?>" />   
                    

                    <div class="row">
                        <div class="col-lg-12">
                            
                            <div class="row">
                                
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>สถานะ <font color="#F00"><b>*</b></font></label> 
                                        <select id="debt_schedule_status_id" name="debt_schedule_status_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php 
                                            for($i =  0 ; $i < count($debt_schedule_status) ; $i++){
                                                ?>
                                                <option value="<?php echo $debt_schedule_status[$i]['debt_schedule_status_id'] ?>" <?php 
                                                if($debt_schedule_status[$i]['debt_schedule_status_id']==$debt_schedule['debt_schedule_status_id']){
                                                    echo " selected='selected' ";
                                                }
                                                 ?>><?php echo $debt_schedule_status[$i]['debt_schedule_status_name'] ?></option>
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
                                        <label>หมายเหตุ </label>
                                        <input id="debt_schedule_remark" name="debt_schedule_remark" class="form-control" value="<?php echo $debt_schedule['debt_schedule_remark']?>">
                                        <p class="help-block">Example : ผ่อนจ่ายทุกๆ วันที่ 5 ของเดือน</p>
                                        
                                    </div>
                                </div>
                                
                            </div>
                           
                        </div>
                        
                    </div>
                  
                    <div align="right">
                        <button type="button"  onclick="schedule_back(<?php 
                                echo $customer_id; ?>);" class="btn btn-outline-dark">ย้อนกลับ</button>
                        <button type="reset" class="btn btn-primary">ล้างข้อมูล</button>
                        <button name="submit" type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                        <?php if($debt_schedule_id != ''){ ?>
                            <button type="button" onclick="schedule_delete(<?php 
                                echo $customer_id; ?>,<?php 
                                echo $debt_schedule_id; ?>);" class="btn btn-danger">ลบ</button>
                        <?php }?>
                    </div>
                    <!-- /.row (nested) -->
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
            
            <!-- /.panel-heading -->
            
        <hr />       
        <link rel="stylesheet" media="all" type="text/css" href="../template/calendar/css/font-awesome.css" />
        <link rel="stylesheet" media="all" type="text/css" href="../template/calendar/css/styles.css" />
        <?php if($debt_schedule_id != ''){ ?>
            <div id="calendar_div" class="row mouse-today"></div>
        <?php }?>
        
        <script src="../template/calendar/function.js"></script>
               
          
          <!-- /.panel-body -->
      
      <!-- /.panel -->
    </div>
  
  </div>
</div>
<script type="text/javascript">


// var debt_shedule_list_detail23_11_2018 = document.getElementById("debt_shedule_list_detail23-11-2018").value;
// if(debt_shedule_list_detail23_11_2018.length != 0){
//     $("#23-11-2018").modal("show");
// }

var modal_id ='<?php echo $_GET['modal_id'];?>';
if(modal_id!=''){ 
    $.post( "controllers/setNotificationLog.php",
                    {
                        user_id:'<?php echo $user[0][0];?>',
                        debt_schedule_list_id:'<?php echo $_GET['list_id'];?>' 
                    }
                , function( data ) {
                    console.log(data); 
                    $('#display_notification').html(data);   
            });
}
var d = new Date();

var date_event = [
<?php 
if(count($schedule_list)>0){

    for($i=0;$i<count($schedule_list);$i++){
        $schedule_list_date = explode("-",$schedule_list[$i]['debt_schedule_list_date']);
        $day = $schedule_list_date[2];
        $month= $schedule_list_date[1];
        $year= $schedule_list_date[0];
        
?>
    {
        date:{
            day:<?PHP echo intval($day);?>,
            month:<?PHP echo intval($month);?>,
            year:<?PHP echo $year;?>
        }, 
        type:0,
        class:'badge-today color-today', 
        detail:'<?PHP echo $schedule_list[$i]['debt_schedule_list_detail'];?>',
        id:'<?PHP echo $schedule_list[$i]['debt_schedule_list_id'];?>'

    },
<?php 
    }
}
?>

];
var customer_name =  '<?PHP echo $customer['customer_name'];?>';
var status_name =  '<?PHP echo $debt_schedule['debt_schedule_status_name'];?>';
function schedule_list_add(){

        $.post( "controllers/getScheduleList.php",
            {
                debt_schedule_id:"<?php echo $debt_schedule_id;?>",
                date_event: JSON.stringify(date_event)
                
            }
        , function( data ) {
            location.reload();
        });
    }

    //load initCalendar 
    window.onload =function() {
        initCalendar();
         
    };

    
    
</script>

