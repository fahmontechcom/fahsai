<script>  
    $(document).ready(function(){
        show_report('1');
    }); 
    function show_report(id){ 
        var overview = document.getElementById("overview");
        var payment = document.getElementById("payment");
        var schedule = document.getElementById("schedule");
        // alert();
        if(id==1){
            overview.classList.add("button-report-menu-active");  
            payment.classList.remove("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active"); 
            $.post( "report/overview/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_report").html(data);
                });
        }else if(id==2){
            overview.classList.remove("button-report-menu-active");  
            payment.classList.add("button-report-menu-active"); 
            schedule.classList.remove("button-report-menu-active"); 
            $.post( "report/payment/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_report").html(data);
                });
        }else if(id==3){
            overview.classList.remove("button-report-menu-active");  
            payment.classList.remove("button-report-menu-active"); 
            schedule.classList.add("button-report-menu-active"); 
            $.post( "report/schedule/views/index.inc.php",
                    { 
                        action:'view'
                    }
                , function( data ) { 
                    $("#display_report").html(data);
                });
        }
    }
</script>
<div class="row">
  <div class="col-lg-12">
    <div>
    <a id="overview" href="javasctipt:;" onclick="show_report('1');" class='button-report button-report-menu button-report-menu-active' >
        <i class="fa fa-user header-i-size " ></i>
        <span >รายงานภาพรวม</span>
    </a>
    <a id="payment"  href="javasctipt:;" onclick="show_report('2');" class='button-report button-report-menu' >
        <i class="fa fa-user header-i-size " ></i>
        <span >รายงานการชำระเงิน</span>
    </a>
    <a id="schedule" href="javasctipt:;" onclick="show_report('3');" class='button-report button-report-menu' >
        <i class="fa fa-user header-i-size " ></i>
        <span >รายงานกำหนดการรวม</span>
    </a> 
  </div>

  <hr/>
  <div id="display_report"></div>
  </div>
</div>

