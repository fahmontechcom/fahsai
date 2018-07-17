<?PHP
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
echo $check_result;
?>