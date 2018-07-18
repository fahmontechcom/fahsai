<?PHP
date_default_timezone_set('Asia/Bangkok');
require_once('../../models/NotificationModel.php');
$model = new NotificationModel;
 
$user_id = $_POST['user_id'];
$debt_schedule_list_id = $_POST['debt_schedule_list_id'];
// echo '<pre>';
// print_r($user);
// echo '</pre>';
//หารายการ schedule_list วันนี้ customer_id=$schedule_list['customer_id'] ,debt_id=$schedule_list['debt_id'], debt_schedule_id = $schedule_list['debt_schedule_id'], modal_id = $display_today
$check_result = '';
$notification_log = $model->getNotificationByID($user_id,$debt_schedule_list_id);
if(count($notification_log)==0){
    $data=[];
    $data['user_id'] = $user_id; 
    $data['debt_schedule_list_id'] = $debt_schedule_list_id; 
    $check_result = $model->insertNotification($data); 
}   
$notifications = $model->getNotificationByUserID($user_id,date('Y-m-d')); 
$notifications_new = $model->getNewNotificationByUserID($user_id,date('Y-m-d'));
$str =  '<a href="#" class="nav-link dropdown-toggle text-center" id="navDropDownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-bell" style="font-size:18px;color:#337ab7;">';
                    if(count($notifications_new) > 0){
                        $str .= '<span class="alert">'.count($notifications_new).'</span>';
                    }
                    $str .= '</i></a>
                <div class="dropdown-menu  dropdown-menu-right" style="width: 310px; min-width: 0;" aria-labelledby="navDropDownLink">
                    <div style="max-height: 310px;overflow:auto;">';
                          
                        for($i=0 ; $i < count($notifications) ;$i++){ 
                            $today=date('Y-m-d');
                            $debt_schedule_list_date=$notifications[$i]['debt_schedule_list_date'];
                            $today_arr = explode("-",$debt_schedule_list_date);
                                    $day = intval($today_arr[2]);
                                    $month= intval($today_arr[1]);
                                    $year= intval($today_arr[0]);
                            $debt_schedule_list_date = $day.'-'.$month.'-'.$year;   
                        
                            $str .='<a class="dropdown-item '; 
                            if($notifications[$i]['notification_log_id'] == "0"){
                                $str .= "notify-active"; 
                            }else{  
                                $str .= "notify";  
                            } 
                            $str .='" style="font-size:12px" href="index.php?content=schedule&action=update&customer_id='.$notifications[$i]['customer_id'].'&debt_id='.$notifications[$i]['debt_id'].'&id='.$notifications[$i]['debt_schedule_id'].'&list_id='.$notifications[$i]['debt_schedule_list_id'].'&modal_id='.$debt_schedule_list_date.'&notification_id='.$notifications[$i]['debt_schedule_list_id'].'">
                            <div>
                                <i class="fa fa-comment fa-fw"></i>'.$notifications[$i]['debt_schedule_status_name'].'<br>InvNo.&nbsp;'.$notifications[$i]['debt_invoice_number'].'<span class="pull-right text-muted small">'.$notifications[$i]['debt_schedule_list_date'].'</span>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>';
                         
                            if($i == 10){
                                break;
                            }
                        } 
                     
                        $str .='</div>  
                    <a class="dropdown-item  text-center" href="index.php?content=notification" style="color:black;font-size: 12px;">Show All</a>
                </div>';

echo $str;
?>