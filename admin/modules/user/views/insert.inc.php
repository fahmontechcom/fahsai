<script>
    function check(){
        
        var user_username = document.getElementById("user_username").value;
        var user_password = document.getElementById("user_password").value;
        var user_firstname = document.getElementById("user_firstname").value;
        var user_lastname = document.getElementById("user_lastname").value;
        var user_telephone = document.getElementById("user_telephone").value;
        var user_email = document.getElementById("user_email").value;
        var user_address = document.getElementById("user_address").value;
        
        user_username = $.trim(user_username);
        user_password = $.trim(user_password);
        user_firstname = $.trim(user_firstname);
        user_lastname = $.trim(user_lastname);
        user_telephone = $.trim(user_telephone);
        user_email = $.trim(user_email);
        user_address = $.trim(user_address);
        
        if(user_username.length == 0){
            alert("Please input user username");
            document.getElementById("user_username").focus();
            return false;
        }else if(user_password.length == 0){
            alert("Please input user password");
            document.getElementById("user_password").focus();
            return false;
        }else if(user_firstname.length == 0){
            alert("Please input user firstname");
            document.getElementById("user_firstname").focus();
            return false;
        }else if(user_lastname.length == 0){
            alert("Please input user lastname");
            document.getElementById("user_lastname").focus();
            return false;
        }else if(user_telephone.length == 0){
            alert("Please input user telephone");
            document.getElementById("user_telephone").focus();
            return false;
        }else if(user_email.length == 0){
            alert("Please input user email");
            document.getElementById("user_email").focus();
            return false;
        }else if(user_address.length == 0){
            alert("Please input user address");
            document.getElementById("user_address").focus();
            return false;
        }else{
            return true;
        }
    }

    

</script>

<div class="row">
    <div class="col-lg-6">
        <h1>เพิ่มผู้ดูเเลระบบ</h1>
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
                <form role="form" method="post" onsubmit="return check();" action="index.php?content=user&action=add" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>username <font color="#F00"><b>*</b></font></label>
                                        <input id="user_username" name="user_username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>password <font color="#F00"><b>*</b></font></label>
                                        <input id="user_password" name="user_password" class="form-control">
                                    </div>
                                </div>                                
                            </div>
                            <!-- /.row (nested) -->

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>ชื่อ <font color="#F00"><b>*</b></font></label>
                                        <input id="user_firstname" name="user_firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>นามสกุล <font color="#F00"><b>*</b></font></label>
                                        <input id="user_lastname" name="user_lastname" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row (nested) -->

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์ </label>
                                        <input id="user_telephone" name="user_telephone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>ที่อยู่อีเมล <font color="#F00"><b>*</b></font></label>
                                        <input id="user_email" name="user_email" class="form-control">
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>ที่อยู่ <font color="#F00"><b>*</b></font> </label>
                                <input type="text" id="user_address" name="user_address" class="form-control">
                                <p class="help-block">Example : 1242/2 Mittraphab Road Tambon Naimuang Amphoe Muang Province Nakhonratchasima 30000</p>
                            </div>
                        </div>
                    </div>
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