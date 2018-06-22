<script>
    function check(){
        var sale_firstname = document.getElementById("sale_firstname").value;
        var sale_lastname = document.getElementById("sale_lastname").value;
        var sale_telephone = document.getElementById("sale_telephone").value;
        var sale_email = document.getElementById("sale_email").value;
        var sale_address = document.getElementById("sale_address").value;

        sale_firstname = $.trim(sale_firstname);
        sale_lastname = $.trim(sale_lastname);
        sale_telephone = $.trim(sale_telephone);
        sale_email = $.trim(sale_email);
        sale_address = $.trim(sale_address);
        
        if(sale_firstname.length == 0){
            alert("Please input sale firstname");
            document.getElementById("sale_firstname").focus();
            return false;
        }else if(sale_lastname.length == 0){
            alert("Please input sale lastname");
            document.getElementById("sale_lastname").focus();
            return false;
        }else if(sale_telephone.length == 0){
            alert("Please input sale telephone");
            document.getElementById("sale_telephone").focus();
            return false;
        }else if(sale_email.length == 0){
            alert("Please input sale email");
            document.getElementById("sale_email").focus();
            return false;
        }else if(sale_address.length == 0){
            alert("Please input sale address");
            document.getElementById("sale_address").focus();
            return false;
        }else{
            return true;
        }
    }

    

</script>

<div class="row">
    <div class="col-lg-6">
        <h1>เเก้ไขข้อมูลผู้ใช้งาน</h1>
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
                <form role="form" method="post" onsubmit="return check();" action="index.php?content=sale&action=edit" enctype="multipart/form-data">
                    <input type="hidden"  id="sale_id" name="sale_id" value="<?php echo $sale_id ?>" />
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <!-- /.row (nested) -->

                            <div class="row">
                                
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>ชื่อ <font color="#F00"><b>*</b></font></label>
                                        <input id="sale_firstname" name="sale_firstname" class="form-control" value="<?php echo $sale['sale_firstname']?>">
                                        <p class="help-block">Example : John </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>นามสกุล <font color="#F00"><b>*</b></font></label>
                                        <input id="sale_lastname" name="sale_lastname" class="form-control" value="<?php echo $sale['sale_lastname']?>">
                                        <p class="help-block">Example : Smith </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์ </label>
                                        <input id="sale_telephone" name="sale_telephone" class="form-control" value="<?php echo $sale['sale_telephone']?>">
                                        <p class="help-block">Example : 099-999-9999 </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>ที่อยู่อีเมล </label>
                                        <input id="sale_email" name="sale_email" class="form-control" value="<?php echo $sale['sale_email']?>">
                                        <p class="help-block">Example : user@info.com </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>ที่อยู่ <font color="#F00"><b>*</b></font> </label>
                                        <input type="text" id="sale_address" name="sale_address" class="form-control" value="<?php echo $sale['sale_address']?>">
                                        <p class="help-block">Example : 1242/2 Mittraphab Road </p>
                                    </div>
                                </div>
                            </div>
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