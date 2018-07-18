<script>  
    $(document).ready(function(){
        btn_hover('customer');
    }); 
    function btn_hover(id){ 
        var customer = document.getElementById("customer");
        var user = document.getElementById("user");
        var status = document.getElementById("status");
        var gateway = document.getElementById("gateway");
        var sale = document.getElementById("sale");
        var schedule = document.getElementById("schedule");
        var invoice = document.getElementById("invoice");
        var debt = document.getElementById("debt");
        // alert();
        if(id=='customer'){
            customer.classList.add("button-report-menu-active");  
            user.classList.remove("button-report-menu-active"); 
            status.classList.remove("button-report-menu-active"); 
            gateway.classList.remove("button-report-menu-active"); 
            sale.classList.remove("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active");  
            invoice.classList.remove("button-report-menu-active");  
            debt.classList.remove("button-report-menu-active");  
            $.post( "recover/customer/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });
        }else if(id=="user"){
            customer.classList.remove("button-report-menu-active");
            user.classList.add("button-report-menu-active");   
            status.classList.remove("button-report-menu-active"); 
            gateway.classList.remove("button-report-menu-active"); 
            sale.classList.remove("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active"); 
            invoice.classList.remove("button-report-menu-active");  
            debt.classList.remove("button-report-menu-active");   
            $.post( "recover/user/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });
        }else if(id=="status"){
            customer.classList.remove("button-report-menu-active");  
            user.classList.remove("button-report-menu-active"); 
            status.classList.add("button-report-menu-active"); 
            gateway.classList.remove("button-report-menu-active"); 
            sale.classList.remove("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active");  
            invoice.classList.remove("button-report-menu-active");  
            debt.classList.remove("button-report-menu-active");   
            $.post( "recover/status/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });
        }else if(id=="gateway"){
            customer.classList.remove("button-report-menu-active");  
            user.classList.remove("button-report-menu-active"); 
            status.classList.remove("button-report-menu-active"); 
            gateway.classList.add("button-report-menu-active"); 
            sale.classList.remove("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active");  
            invoice.classList.remove("button-report-menu-active");  
            debt.classList.remove("button-report-menu-active");   
            $.post( "recover/gateway/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });
        }else if(id=="sale"){
            customer.classList.remove("button-report-menu-active");  
            user.classList.remove("button-report-menu-active"); 
            status.classList.remove("button-report-menu-active"); 
            gateway.classList.remove("button-report-menu-active"); 
            sale.classList.add("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active");
            invoice.classList.remove("button-report-menu-active");  
            debt.classList.remove("button-report-menu-active");   
            $.post( "recover/sale/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });  
        }else if(id=="schedule"){
            customer.classList.remove("button-report-menu-active");  
            user.classList.remove("button-report-menu-active"); 
            status.classList.remove("button-report-menu-active"); 
            gateway.classList.remove("button-report-menu-active"); 
            sale.classList.remove("button-report-menu-active"); 
            schedule.classList.add("button-report-menu-active");
            invoice.classList.remove("button-report-menu-active");  
            debt.classList.remove("button-report-menu-active");   
            $.post( "recover/schedule/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });   
        }else if(id=="invoice"){
            customer.classList.remove("button-report-menu-active");  
            user.classList.remove("button-report-menu-active"); 
            status.classList.remove("button-report-menu-active"); 
            gateway.classList.remove("button-report-menu-active"); 
            sale.classList.remove("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active");
            invoice.classList.add("button-report-menu-active");  
            debt.classList.remove("button-report-menu-active");   
            $.post( "recover/invoice/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });   
        }else if(id=="debt"){
            customer.classList.remove("button-report-menu-active");  
            user.classList.remove("button-report-menu-active"); 
            status.classList.remove("button-report-menu-active"); 
            gateway.classList.remove("button-report-menu-active"); 
            sale.classList.remove("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active");
            invoice.classList.remove("button-report-menu-active");  
            debt.classList.add("button-report-menu-active");   
            $.post( "recover/debt/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_recover").html(data);
                });   
        }
    }
</script>
<div class="row">
    <div class="col-lg-12">
    <div>
     <h1>ระบบจัดการกู้คืนข้อมูล</h1>
     <h2>ลบ กู้คืน รายการข้อมูล</h2>
      
  </div>
        <div>
            <a id="customer" href="javasctipt:;" onclick="btn_hover('customer');" class='button-report button-report-menu button-report-menu-active' >
                <i class="fa fa-user header-i-size " ></i>
                <span >ลูกค้า</span>
            </a>
            <a id="user"  href="javasctipt:;" onclick="btn_hover('user');" class='button-report button-report-menu' >
                <i class="fa fa-group header-i-size " ></i>
                <span >ผู้ใช้งาน</span>
            </a>
            <a id="status" href="javasctipt:;" onclick="btn_hover('status');" class='button-report button-report-menu' >
                <i class="fa fa-tasks header-i-size " ></i>
                <span >สถานะหนี้</span>
            </a> 
            <a id="gateway" href="javasctipt:;" onclick="btn_hover('gateway');" class='button-report button-report-menu' >
                <i class="fa fa-money header-i-size " ></i>
                <span >ช่องทางชำระ</span>
            </a> 
            <a id="sale" href="javasctipt:;" onclick="btn_hover('sale');" class='button-report button-report-menu' >
                <i class="fa fa-male header-i-size " ></i>
                <span >พนักงานขาย</span>
            </a> 
            <a id="schedule" href="javasctipt:;" onclick="btn_hover('schedule');" class='button-report button-report-menu' >
                <i class="fa fa-calendar header-i-size " ></i>
                <span >กำหนดการ</span>
            </a> 
            <a id="invoice" href="javasctipt:;" onclick="btn_hover('invoice');" class='button-report button-report-menu' >
                <i class="fa fa-calendar header-i-size " ></i>
                <span >ออกใบแจ้งหนี้</span>
            </a> 
            <a id="debt" href="javasctipt:;" onclick="btn_hover('debt');" class='button-report button-report-menu' >
                <i class="fa fa-calendar header-i-size " ></i>
                <span >หนี้</span>
            </a> 
        </div>

    <hr/>
    <div id="display_recover"></div>
    </div>
</div>

