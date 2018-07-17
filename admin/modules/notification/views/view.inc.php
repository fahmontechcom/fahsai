<div class="row">
    <div class="col-lg-12">
        <div>
            <h1>Notifications</h1>
     
        </div>
        <div class="list-group">
            <?php 
            for($i=0 ; $i < count($notifications) ;$i++){ 
                $today=date('Y-m-d');
                $debt_schedule_list_date=$notifications[$i]['debt_schedule_list_date'];
                $today_arr = explode("-",$debt_schedule_list_date);
                        $day = intval($today_arr[2]);
                        $month= intval($today_arr[1]);
                        $year= intval($today_arr[0]);
                $debt_schedule_list_date = $day.'-'.$month.'-'.$year;   
            ?>
            <a class="dropdown-item <?php if($notifications[$i]['notification_log_id'] == "0"){ echo "notify-active"; }else{  echo "notify";  } ?>" style="font-size:12px" href="index.php?content=schedule&action=update&customer_id=<?=$notifications[$i]['customer_id']?>&debt_id=<?=$notifications[$i]['debt_id']?>&id=<?=$notifications[$i]['debt_schedule_id']?>&modal_id=<?=$debt_schedule_list_date?>&notification_id=<?=$notifications[$i]['debt_schedule_list_id']?>">
                <div>
                    <i class="fa fa-comment fa-fw"></i><?php echo $notifications[$i]['debt_schedule_status_name'];?><br>InvNo.&nbsp;<?php echo $notifications[$i]['debt_invoice_number'];?><span class="pull-right text-muted small"><?php echo $notifications[$i]['debt_schedule_list_date'];?></span>
                </div>
            </a>
            <div class="dropdown-divider"></div>
            <?php
            }
            ?>
            
        </div>
    </div>
</div>

