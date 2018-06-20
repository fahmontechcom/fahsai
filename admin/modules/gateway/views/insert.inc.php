<script>
    function check(){
        
        var debt_schedule_status_name = document.getElementById("debt_schedule_status_name").value;
        
        
        debt_schedule_status_name = $.trim(debt_schedule_status_name);
        
        
        if(debt_schedule_status_name.length == 0){
            alert("Please input status name");
            document.getElementById("debt_schedule_status_name").focus();
            return false;
        }else{
            return true;
        }
    }

    

</script>

<div class="row">
    <!-- <div class="col-lg-2">
                                    
    </div> -->
    <div class="col-lg-6">
        <h1>เพิ่มสถานะหนี้</h1>
    </div>
    <div class="col-lg-6" align="right">

    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form role="form" method="post" onsubmit="return check();" action="index.php?content=status&action=add" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <!-- <div class="col-lg-2">
                                    
                                </div> -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>ชื่อสถานะหนี้ <font color="#F00"><b>*</b></font></label>
                                        <input id="debt_schedule_status_name" name="debt_schedule_status_name" class="form-control">
                                    </div>
                                </div>
                                                              
                            </div>
                            <!-- /.row (nested) -->

                            
                            <!-- /.row (nested) -->

                           
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
                        <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                    </div>
                    <!-- /.row (nested) -->
                </form>
                       
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>