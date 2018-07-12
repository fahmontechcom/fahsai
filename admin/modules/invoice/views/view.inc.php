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
        $(id).closest('tr').children('td').children('input[name="debt_balance[]"]').val( (parseFloat(data[0]['debt_balance']).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
        $(id).closest('tr').children('td').children('input[name="invoice_list_to_date[]"]').val('');
        $(id).closest('tr').children('td').children('input[name="debt_charge_amount[]"]').val('');
        $(id).closest('tr').children('td').children('input[name="interest_balance[]"]').val('');
        $(id).closest('tr').children('td').children('input[name="sum[]"]').val('');
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
                        invoice_list_to_date:invoice_list_to_date,
                        action:'edit' 
                    }
                , function( data ) {
                    // console.log(data.debt_payment_interest);
                    var interest = data.debt_payment_interest;
                    var charge_amount =  data.debt_payment_charge_amount; 
                    var check = data.check;
                    // alert(interest);
                    if(check=='1'){ 
                    console.log(data.debt_payment_interest);
                    $(id).closest('tr').children('td').children('input[name="interest_balance[]"]').val( (parseFloat(interest).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
                    $(id).closest('tr').children('td').children('input[name="debt_charge_amount[]"]').val( (parseFloat(charge_amount).toFixed(2) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
                    $(id).closest('tr').children('td').children('input[name="sum[]"]').val((parseFloat(debt_balance.replace(/,/g , "")) + parseFloat(interest)+ parseFloat(charge_amount)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                    // alert(date.debt_payment_interest)  
                
            });
        }else{
        alert('กรุณาเลือกอินวอย');
        $(id).closest('tr').children('td').children('select[name="debt[]"]').focus();
        }
    }
  function invoice_list(customer_id,invoice_id){ 
    $.post( "modules/invoice_list/views/index.inc.php",
            {
                customer_id:customer_id, 
                invoice_id:invoice_id, 
                action:'update'
            }, 
            function( data ) {
            $("#modal_invoice_data_"+invoice_id).html(data); 
        });
  }
  function invoice_add(customer_id){
    $.post( "modules/invoice_list/views/index.inc.php",
            {
                customer_id:customer_id,  
                action:''
            }, 
            function( data ) {
            $("#modal_invoice_data").html(data); 
        });
  }
</script>
<div class="row">
  <div class="col-lg-12">
    <div>
     <h1 style="color:black;">รายการใบแจ้งหนี้ของลูกค้า <?=$customer['customer_name']?></h1> 
     <div align="right">
      <a href="javascript:;" onclick="invoice_add('<?PHP echo $customer_id;?>');" data-toggle="modal" data-target="#modal_invoice"  style="font-size: 20px;color:green;">
        <input class="button" type="submit" value="เพิ่ม">
      </a> 
      <div class="modal fade" id="modal_invoice" tabindex="-1" role="dialog" aria-labelledby="modal_invoiceTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-big" role="document">
              <div id="modal_invoice_data" class="modal-content">
                
              </div>
          </div>
      </div>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>เลขที่ใบแจ้งหนี้</th> 
        <th>วันที่ออก</th>
        <th>ยอดหนี้</th>
        <th>หมายเหตุ</th> 
        <th style="max-width:60px;">จัดการ</th>
        
      </tr>
    </thead>
    <tbody>
      <?php 
      for($i=0; $i < count($invoice); $i++){
        ?>
        <tr class="nth-child">
          <td><?php echo $i+1; ?></td>
          <td><?php echo $invoice[$i]['invoice_number'];?></td> 
          <td><?PHP echo date_format(date_create($invoice[$i]['invoice_create_date']),"d-m-Y") ; ?></td>
          <td class="align-money"><?php echo number_format($invoice[$i]['list_sum'], 2, '.', ',');?></td>
          <td><?php echo $invoice[$i]['invoice_remark'];?></td>
          <td> 
            <a href="javascript:;" onclick="invoice_list('<?php 
              echo $customer_id;?>','<?php 
              echo $invoice[$i]['invoice_id'];?>');" data-toggle="modal" data-target="#modal_invoice_<?php echo $invoice[$i]['invoice_id']; ?>"  style="font-size: 20px;color:green;">
                <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
            </a>
            <div class="modal fade" id="modal_invoice_<?php echo $invoice[$i]['invoice_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal_invoice_<?php echo $invoice[$i]['invoice_id']; ?>Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-big" role="document">
                    <div id="modal_invoice_data_<?php echo $invoice[$i]['invoice_id']; ?>" class="modal-content">
                        
                    </div>
                </div>
            </div>
            <a href="?content=invoice&customer_id=<?=$customer_id?>&action=delete&id=<?php echo $invoice[$i]['invoice_id'];?>" onclick="return confirm('You want to delete invoice : <?php echo $invoice[$i]['invoice_number']; ?>');" style="color:red; font-size: 20px;">
              <i class="fa fa-times" aria-hidden="true"></i>
            </a>
          </td>
          
        </tr>
        <?php } ?>
    </tbody>
  </table>
  </div>
</div>

