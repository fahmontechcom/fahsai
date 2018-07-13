<script> 
    
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
        <input class="button" type="submit" style="font-size:14px" value="เพิ่ม">
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

