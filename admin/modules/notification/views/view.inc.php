<div class="row">
    <div class="col-lg-12">
        <div>
            <h1>Notifications</h1>
     
        </div>
        <div class="list-group">
            <?php for($i=0 ; $i < count($notifications) ;$i++){ ?>
                <a style="font-size:14px;"  href="<?php echo $notifications[$i]['notification_url'];?>" class="list-group-item <?php if($notifications[$i]['notification_seen_date'] != ""){ ?>notify<? }else{ ?> notify-active <?php } ?>">

                    <i class="fa fa-comment fa-fw"></i>
                    <?php echo $notifications[$i]['notification_detail'];?> 
                    <span class="pull-right text-muted small"><em><?php echo $notifications[$i]['notification_date'];?></em>
                    </span>
                </a>
            <?}?>
            <a style="font-size:14px;" href="index.php?app=purchase_request&amp;action=detail&amp;id=13" class="list-group-item notify">

                <i class="fa fa-comment fa-fw"></i>
                เจรจา <br>INV. INV1806001  
                <span class="pull-right text-muted small"><em>2018-06-06 17:03:08</em>
                </span>
            </a>
            <a style="font-size:14px;" href="index.php?app=purchase_request&amp;action=detail&amp;id=13" class="list-group-item notify">

                <i class="fa fa-comment fa-fw"></i>
                เจรจา <br>INV. INV1806001  
                <span class="pull-right text-muted small"><em>2018-06-06 17:03:08</em>
                </span>
            </a>
            <a style="font-size:14px;" href="index.php?app=purchase_request&amp;action=detail&amp;id=13" class="list-group-item notify">

                <i class="fa fa-comment fa-fw"></i>
                เจรจา <br>INV. INV1806001  
                <span class="pull-right text-muted small"><em>2018-06-06 17:03:08</em>
                </span>
            </a>
            <a style="font-size:14px;" href="index.php?app=purchase_request&amp;action=detail&amp;id=13" class="list-group-item notify">

                <i class="fa fa-comment fa-fw"></i>
                เจรจา <br>INV. INV1806001  
                <span class="pull-right text-muted small"><em>2018-06-06 17:03:08</em>
                </span>
            </a>
            <a style="font-size:14px;" href="index.php?app=purchase_request&amp;action=detail&amp;id=13" class="list-group-item notify">

                <i class="fa fa-comment fa-fw"></i>
                เจรจา <br>INV. INV1806001  
                <span class="pull-right text-muted small"><em>2018-06-06 17:03:08</em>
                </span>
            </a>
        </div>
    </div>
</div>

