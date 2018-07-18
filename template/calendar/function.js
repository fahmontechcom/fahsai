var initCalendar = function(){
    var div         = document.getElementById('calendar_div'),
        tr_td       ='',
        main_table  ='',
        table,
        index,
        arr_month   = ['January','February','March','April','May','June','July','August','September','October','November','December'],
        yr          = new Date().getFullYear(),arr;
        // console.log(date_event);
        for (var i = 0; i <12; i++) {
            arr=calendarDate(yr,i);
            index = 0;
            table='<div id="zabuto_calendar_68z" class="col-sm-6 col-md-4 col-lg-3" style="margin-top:10px;">'+
                        '<div class="zabuto_calendar">'+
                            '<table class="table">'+
                                '<tbody>'+
                                    '<tr class="calendar-month-header">'+
                            
                            '<td colspan="7">'+
                                '<span>'+arr_month[i]+' '+yr+'</span>'+
                            '</td>'+
                            
                        '</tr>'+
                        '<tr class="calendar-dow-header">'+
                            '<th>Mon</th>'+
                            '<th>Tue</th>'+
                            '<th>Wed</th>'+
                            '<th>Thu</th>'+
                            '<th>Fri</th>'+
                            '<th>Sat</th>'+
                            '<th>Sun</th>'+
                        '</tr>';
                       
            
            for (var j = 0; j <5; j++) {
                tr_td+='<tr class="calendar-dow">';
                for (var k = 0; k <7; k++) {
                    var val = date_event.filter(item => (item['date']['day'] === arr[index] && item['date']['month'] === i+1 && item['date']['year'] === yr));
                    
                    var btn_del ='';
                    var txt_detail ='';
                    var day_display;
                    var month_display;
                    var year_display;
                    if(val.length > 0 ){                       
                        txt_detail = val[0]['detail'];
                        
                        tr_td +='<td>'+
                                    '<div class="day">';
                        
                        btn_del ='<button type="button" onclick="set_date('+arr[index]+','+(i+1)+','+yr+',1)" class="btn btn-danger"  data-dismiss="modal">ลบ</button>';
                        val.forEach(element => {
                            tr_td += '<span class="event '+element['class']+'" title="'+element['detail']+'"></span>';
                        });

                                    
                        
                    }else{
                        tr_td+='<td>'+
                                    '<div class="day">';
                        btn_del ='';
                    }
                    // if(arr[index-1]>0){
                    //     day_display = parseInt(arr[index-1]);
                    //     month_display= parseInt(i+1);
                    //     year_display = parseInt(yr);
                    //     if((day_display.toString()).length==1){
                    //         day_display = '0'+day_display.toString()
                    //     }
                    //     if((month_display.toString()).length==1){
                    //         month_display = '0'+month_display.toString()
                    //     }
                        
                    // }
                    // console.log(day_display+'-'+month_display+'-'+year_display);
                    tr_td += '<a  data-toggle="modal" data-target="#'+arr[index]+'-'+(i+1)+'-'+yr+'">'+arr[index++]+'</a>'+
                                    '<div class="modal fade" id="'+arr[index-1]+'-'+(i+1)+'-'+yr+'" tabindex="-1" role="dialog" aria-labelledby="'+arr[index-1]+'-'+(i+1)+'-'+yr+'Title" aria-hidden="true">'+
                                        '<div class="modal-dialog modal-dialog-centered" role="document">'+
                                            '<div class="modal-content">'+
                                                '<div class="modal-header">'+
                                                    '<h5 class="modal-title" id="exampleModalLongTitle" align="left">เพิ่มกำหนดการ<br> ลูกค้า : '+customer_name+' สถานะ : '+status_name+'</h5>'+
                                                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                                    '<span aria-hidden="true">&times;</span>'+
                                                    '</button>'+
                                                '</div>'+
                                                '<div class="modal-body">'+
                                                    '<div class="col-lg-12">'+
                                                        '<div class="form-group col-lg-4">'+
                                                            '<label>วันที่ </label>'+
                                                            '<input readonly id="debt_shedule_list_date" name="debt_shedule_list_date" class="form-control" value="'+arr[index-1]+'-'+(i+1)+'-'+yr+'">'+
                                                        '</div>'+
                                                        '<div class="form-group col-lg-12">'+
                                                            '<label>รายละเอียด </label>'+
                                                            '<textarea class="form-control" rows="5"  id="debt_shedule_list_detail'+arr[index-1]+'-'+(i+1)+'-'+yr+'" name="debt_shedule_list_detail'+arr[index-1]+'-'+(i+1)+'-'+yr+'" >'+txt_detail+'</textarea>'+
                                                        '</div>'+
                                                    '</div>'+                                                
                                                '</div>'+
                                                '<div class="modal-footer">'+
                                                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>'+
                                                    '<button type="button" onclick="set_date('+arr[index-1]+','+(i+1)+','+yr+')" class="btn btn-success"  data-dismiss="modal">บันทึก</button>'+
                                                    btn_del+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</td>';
                    
                }
                tr_td+='</tr>';
            }
        table += tr_td + '</table>' + 
        '</div>' +
        '</div>';
        main_table+=table;
        tr_td='';
        table='';
        
    }
    
    div.innerHTML=''+main_table+
    '<div class="ml-auto" style="margin:15px;">'+
        '<button onclick="schedule_list_add();" class="btn btn-success">บันทึกข้อมูล</button>'+
    '</div>'+
    '<div class="clear"></div>';
    if(modal_id!=''){

        $("#"+modal_id).modal("show");
    }
    
} //close initCalendar()

function calendarDate(yr,i){
    var months      = (i==0) ? 1 : (i+1),
        days        = (i==0) ? 0 : i,
        get_date    = new Date(yr,months,0).getDate(),//total number of month days
        get_day     = new Date(yr,days,1).getDay(),//month start day ...sun,mon.....
        arrDay      = [], 
        extra_arr   = [30,31], 
        extra_day   = get_date-29, 
        num_day     = 0,temp_day;

    for (var i = 0; i<35; i++) {
        if((get_day>5 || get_day>6) && (get_date>29) && i<extra_day)  {
            temp_day=extra_arr[i];
        } else if(i<get_day ) {
            temp_day='';
        } else {
            if(num_day<get_date){
                num_day++
                temp_day=num_day;
            } else {
                temp_day='&nbsp;';
            }
        }
        arrDay.push(temp_day);
    }
    return arrDay;
} // close calendarDate

var select_type = 0;
function select_date_type(type){
    select_type = type;
    // console.log("Date type: "+select_type);
    //document.body.style.cursor = "wait";
    document.getElementById('calendar_div').classList.remove('mouse-today');
    document.getElementById('calendar_div').classList.remove('mouse-event');
    document.getElementById('calendar_div').classList.remove('mouse-bill');
    document.getElementById('calendar_div').classList.remove('mouse-invoice');

    switch(select_type){
        case 0 :document.getElementById('calendar_div').classList.add('mouse-today');
        break;
        case 1 :document.getElementById('calendar_div').classList.add('mouse-event');
        break;
        case 2 :document.getElementById('calendar_div').classList.add('mouse-bill');
        break;
        case 3 :document.getElementById('calendar_div').classList.add('mouse-invoice');
        break;
    }
}


function set_date(day, month, year,del=''){
    
    var debt_shedule_list_detail = document.getElementById("debt_shedule_list_detail"+day+"-"+month+"-"+year).value;
    
    var val = date_event.filter(item => (item['date']['day'] === day && item['date']['month'] === month && item['date']['year'] === year && item['type'] === select_type));
    if(del !=''){
        date_event = date_event.filter(item => (item['date']['day'] !== day || item['date']['month'] !== month || item['date']['year'] !== year || item['type'] !== select_type));
    }else if(val.length > 0){
        date_event.filter(item => {if(item['date']['day'] === day && item['date']['month'] === month && item['date']['year'] === year){
            item['detail'] = debt_shedule_list_detail;
        }});
    }else{
        var _class = "";
        var _detail = debt_shedule_list_detail;
        switch(select_type){
            case 0 :_class = "badge-today color-today";
            break;
            case 1 :_class = "badge-event color-event";
            break;
            case 2 :_class = "badge-bill color-bill";
            break;
            case 3 :_class = "badge-invoice color-invoice";
            break;
        }



        date_event.push({
            date:{
                day:day,
                month:month,
                year:year
            }, 
            type:select_type,
            class:_class, 
            detail:_detail,
            id:'0'

        });

        
        
    }
    
    initCalendar();
}
function close_date(){
    
    initCalendar();
}

function toggle_select(){
   if( document.getElementById('fixed_body').classList.contains('active')){
        document.getElementById('fixed_body').classList.remove('active');
        document.getElementById('fixed_header').innerHTML= "<i class='fa fa-cog' aria-hidden='true'></i>";
   }else{
        document.getElementById('fixed_header').innerHTML= "<i class='fa fa-window-close' aria-hidden='true'></i>";
        document.getElementById('fixed_body').classList.add('active');
   }
}