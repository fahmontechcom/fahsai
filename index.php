<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login Form</title>

<script>
function refresh(){
    window.location = "admin/index.php?content=user"
}   

function error(){
    alert("Can not login. Please check your username and password.");
    document.getElementById("error").innerHTML = "username and password.";
}

function check(){
    var user = document.getElementById("username").value;
    var pass = document.getElementById("password").value;
    if(user == ""){
        alert("Please input username.");
        document.getElementById("error").innerHTML = "Please input username.";
        return false;
    }else if (pass == ''){
        alert("Please input password.");
        document.getElementById("error").innerHTML = "Please input password.";
        return false;
    }
    return true;
}
</script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div style=" position:fixed;
                top: 50%;
                left: 50%;
                margin-top: -150px; 
                margin-left: -135px; 
                border: 1px solid #ccc;
                background-color: #f3f3f3; background-color:#FFffff; 
                border-radius:3px; padding:15px; width:300px; height:270px; 
                overflow:hidden; -webkit-box-shadow: 7px 7px 16px 0px rgba(50, 50, 50, 0.67);
                -moz-box-shadow:    7px 7px 16px 0px rgba(50, 50, 50, 0.67);
                box-shadow:         7px 7px 16px 0px rgba(50, 50, 50, 0.67);" align="center">
                <div style="padding:5px; font-size:45px; color:#CCC; padding-bottom:20px;">
                    ADMIN PANEL
                </div>
                <iframe id="checklogin" name="checklogin" src="" style="width:0px;height:0px;border:0"></iframe>
                <form action="check_login.php" method="post" onSubmit="return check();" target="checklogin">
                    <div>
                        <input name="username" id="username" type="text" placeholder="Username" autofocus>
                    </div>
                    <div style="margin-top:10px;">
                        <input name="password" id="password" type="password" placeholder="Password">
                    </div>
                    <div style="padding-top:15px; padding-left:15px; padding-right:15px;" align="center">
                        <button type="submit" >Login</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
            
</body>
</html>