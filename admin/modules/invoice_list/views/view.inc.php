<script>
    var debt_data = [
    <?php for($i = 0 ; $i < count($debt) ; $i++ ){?>
        {
            debt_id:'<?php echo $debt[$i]['debt_id'];?>',
            debt_date:'<?php echo $debt[$i]['debt_date'];?>', 
            debt_invoice_number:'<?php echo $debt[$i]['debt_invoice_number'];?>', 
            debt_balance:'<?php echo $debt[$i]['debt_balance'];?>', 
            debt_charge_amount:'<?php echo $debt[$i]['debt_charge_amount'];?>',
            debt_interest:'<?php echo $debt[$i]['debt_interest'];?>'
        },
    <?php }?>
    ];
    function delete_row(id){
        $(id).closest('tr').remove();
    }
    function add_row(id){
        var index = 0;
        if(isNaN($(id).closest('table').children('tbody').children('tr').length)){
            index = 1;
        }else{
            index = $(id).closest('table').children('tbody').children('tr').length + 1;
        }
        $(id).closest('table').children('tbody').append(
            '<tr class="odd gradeX">'+
                '<td><input type="text" class="form-control" name="debt_date[]" readonly style="width:110px;" /></td>'+
                '<td>'+ 
                    '<input type="hidden" name="invoice_id[]" value="0" />'+
                    '<input type="hidden" name="invoice_list_id[]" value="0" />'+     
                    '<select class="form-control select" type="text" name="debt_id[]" onchange="show_data(this);" data-live-search="true"  style="width:140px;" ></select>'+
                '</td>'+ 
                '<td><input type="text" class="form-control align-money" id="debt_balance_'+index+'" name="debt_balance[]" readonly /></td>'+
                '<td><input type="date" class="form-control" id="invoice_list_to_date_'+index+'" name="invoice_list_to_date[]" onchange="cal(this);" /></td>'+
                '<td><input type="text" class="form-control align-money" id="debt_charge_amount_'+index+'" name="debt_charge_amount[]" readonly /></td>'+
                '<td><input type="text" class="form-control align-money" id="interest_balance_'+index+'" name="interest_balance[]" readonly /></td>'+
                '<td><input type="text" class="form-control align-money" id="sum_'+index+'"  name="sum[]" readonly /></td>'+ 
                '<td>'+
                    '<a href="javascript:;" onclick="delete_row(this);" style="color:red;">'+
                        '<i class="fa fa-times" aria-hidden="true"></i>'+
                    '</a>'+
                '</td>'+
            '</tr>'
        );

        $(id).closest('table').children('tbody').children('tr:last').children('td').children('select').empty();
        var str = "<option value=''>Select</option>";
        $.each(debt_data, function (index, value) {
            str += "<option value='" + value['debt_id'] + "'>"+value['debt_invoice_number']+"</option>";
        });
        $(id).closest('table').children('tbody').children('tr:last').children('td').children('select').html(str);

        $(id).closest('table').children('tbody').children('tr:last').children('td').children('select').selectpicker();
    }
    function show_data(id){
        // console.log('***'+id);
        var debt_date = "";
        var data = debt_data.filter(val => val['debt_id'] == $(id).val());
        if(data.length > 0){
            $(id).closest('tr').children('td').children('select[name="debt_id[]"]').val( data[0]['debt_id'] );
            $(id).closest('tr').children('td').children('input[name="debt_date[]"]').val( data[0]['debt_date'] );
            $(id).closest('tr').children('td').children('input[name="debt_balance[]"]').val( data[0]['debt_balance'] );
            // $(id).closest('tr').children('td').children('input[name="debt_charge_amount[]"]').val( data[0]['debt_charge_amount'] );
            // $.post( "controllers/getSumCharge.php",
            //         {  
            //             debt_id:data[0]['debt_id'],
            //             invoice_list_to_date:invoice_list_to_date, 
            //             debt_payment_date:debt_payment_date,  
            //             debt_payment_pay:debt_payment_pay
            //         }
            //     , function( data ) {
            //     if(data=='0'){
            //         alert('ไม่สามารถบันทึกข้อมูลได้');
            //     }else if(data=='1'){
            //         alert('กรุณาเลือกวันให้มากกว่าข้อมูลล่าสุด');
            //     }else{
            //         $("#collapse_debt_td_<?PHP echo $debt_id;?>").html(data); 
            //     } 

            // });
        }
        
    }
    function cal(id){  
        var debt_balance = $(id).closest('tr').children('td').children('input[name="debt_balance[]"]').val();
        var invoice_list_to_date = $(id).closest('tr').children('td').children('input[name="invoice_list_to_date[]"]').val();
        var debt_id = $(id).closest('tr').children('td').children('select[name="debt_id[]"]').val();
        // console.log('***'+$(id).closest('tr').children('td').children('input[name="debt_balance[]"]').val()+'*');
        
        if(debt_id!=''&&debt_id!=0){

        $.post( "controllers/getSumCharge.php",
                    {  
                        debt_id:debt_id,
                        invoice_list_to_date:invoice_list_to_date 
                    }
                , function( data ) {
                    // console.log(data.debt_payment_interest);
                    var interest = data.debt_payment_interest;
                    var charge_amount =  data.debt_payment_charge_amount; 
                    var check = data.check;
                    // alert(interest);
                    if(check=='1'){ 
                    console.log(data.debt_payment_interest);
                    $(id).closest('tr').children('td').children('input[name="interest_balance[]"]').val( interest );
                    $(id).closest('tr').children('td').children('input[name="debt_charge_amount[]"]').val( charge_amount );
                    $(id).closest('tr').children('td').children('input[name="sum[]"]').val( (parseFloat(debt_balance) + parseFloat(interest)+ parseFloat(charge_amount)).toFixed(2) );
                    }
                    // alert(date.debt_payment_interest)  
                
            });
        }else{
        alert('กรุณาเลือกอินวอย');
        $(id).closest('tr').children('td').children('select[name="debt[]"]').focus();
        }
    }
    
    
</script>             

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">ออกใบแจ้งหนี้</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">          
    <div class="container-fluid">
    <form role="form" method="post" onsubmit="return check();" action="index.php?content=invoice&action=add&customer_id=<?=$customer_id?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>ชื่อลูกค้า </label>
                    <input readonly id="customer_name" name="customer_name" class="form-control" value="<?=$customer['customer_name']?>"> 
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <label>ที่อยู่ </label>
                    <input readonly id="customer_address" name="customer_address" class="form-control" value="<?=$customer['customer_address']?>">
                </div>
            </div> 
            <div class="col-md-3">
                <div class="form-group">
                    <label>อีเมล </label>
                    <input readonly id="customer_email" name="customer_email" class="form-control" value="<?=$customer['customer_email']?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>หมายเหตุ </label>
                    <input  id="invoice_remark" name="invoice_remark" class="form-control" value="<?php echo $invoice['invoice_remark'];?>"> 
                </div>
            </div> 
        </div>
        <table width="100%" class="table table-striped table-bordered table-hover" >
            <thead>
                <tr>
                    <th style="text-align:center;">วันที่</th>
                    <th style="text-align:center;">อินวอย</th>
                    <th style="text-align:center;">ยอด</th>
                    <th style="text-align:center;">ถึงวันที่</th>
                    <th style="text-align:center;">ค่าใช้จ่าย</th>
                    <th style="text-align:center;">ดอกเบี้ย</th>
                    <th style="text-align:center;">รวม</th>
                    <th style="width: 10px;"></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            <tfoot>
                <tr class="odd gradeX">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="javascript:;" onclick="add_row(this);" style="color:red;">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div align="right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ย้อนกลับ</button>
            <button type="button" onclick="" class="btn btn-primary">ล้างข้อมูล</button>
            <button type="submit" name="button" onclick=""  class="btn btn-success">บันทึกข้อมูล</button>  
        </div>
    </form>  
    </div>
</div>
               
           
     

               
            



