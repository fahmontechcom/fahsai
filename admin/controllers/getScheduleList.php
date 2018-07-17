<?PHP
require_once('../../models/ScheduleListModel.php');
$model_schedule_list = new ScheduleListModel;

$data_date = [];
$data_date = json_decode(stripslashes($_POST['date_event']), true);
$debt_schedule_id = $_POST['debt_schedule_id'];
$id=[];
for($i=0; $i<count($data_date);$i++){
    $day = $data_date[$i]['date']['day'];
    $month = $data_date[$i]['date']['month'];
    $year = $data_date[$i]['date']['year'];
    if(strlen($day)==1){
        $day =  '0'.$day;
    }
    if(strlen($month)==1){
        $month =  '0'.$month;
    }
    $data_sub = [];
    $data_sub['debt_schedule_id'] = $debt_schedule_id;
    $data_sub['debt_schedule_list_detail'] = $data_date[$i]['detail'];
    $data_sub['debt_schedule_list_date'] = $year.'-'.$month.'-'.$day;

    if($data_date[$i]['id']!= "0"){
         $model_schedule_list->updateScheduleListById($data_sub,$data_date[$i]['id']);
         $id[]=$data_date[$i]['id'];
    }else{
        $id[] = $model_schedule_list->insertScheduleList($data_sub);
    }
    
}

$model_schedule_list->deleteScheduleListByScheduleIDNotIN($debt_schedule_id,$id);
//echo $_POST['date_event'].", count ".count($data_date);
?>