<script>
    function check(){
        
        var debt_payment_geteway_name = document.getElementById("debt_payment_geteway_name").value;
        
        
        debt_payment_geteway_name = $.trim(debt_payment_geteway_name);
        
        
        if(debt_payment_geteway_name.length == 0){
            alert("Please input gateway name");
            document.getElementById("debt_payment_geteway_name").focus();
            return false;
        }else{
            return true;
        }
    }

    

</script>

<div class="row">
    <div class="col-lg-6">
        <h1>เเก้ไขข้อมูลช่องทางการชำระเงิน</h1>
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
                <form role="form" method="post" onsubmit="return check();" action="index.php?content=gateway&action=edit" enctype="multipart/form-data">
                    <input type="hidden"  id="debt_payment_geteway_id" name="debt_payment_geteway_id" value="<?php echo $debt_payment_geteway_id ?>" />
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>ช่องทางการชำระเงิน <font color="#F00"><b>*</b></font></label>
                                        <input id="debt_payment_geteway_name" name="debt_payment_geteway_name" class="form-control" value="<?php echo $debt_payment_geteway['debt_payment_geteway_name']?>">
                                        <p class="help-block">Example : Cash </p>
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
                        <button name="submit" type="submit" class="btn btn-success">บันทึกข้อมูล</button>
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