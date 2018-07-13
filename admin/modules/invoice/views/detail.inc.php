<script> 
    window.print(); 
</script>
<div>
    <div style="font-size:32px;" align="center"><strong>ใบแจ้งหนี้</strong></div>
    <div> 
        <p style="font-size: 14px;"><strong>รหัสใบแจ้งหนี้ </strong> <?=$customer['customer_name']?></p>
        <span style="font-size: 14px;"><strong>ชื่อลูกค้า </strong> <?=$customer['customer_name']?></span><br>
        <span style="font-size: 14px;"><strong>ที่อยู่ </strong> <?=$customer['customer_address']?></span><br>
        <span style="font-size: 14px;"><strong>อีเมล </strong> <?=$customer['customer_email']?></span><br>
        <span style="font-size: 14px;"><strong>หมายเหตุ </strong> <?php echo $invoice['invoice_remark'];?></span> 
    </div>
     <br>
    <table width="90%" cellspacing="0" cellpadding="0" style="border:1px solid #000;margin:20px auto;">
        <thead>
            <tr>  
                <td class="border-report" style="text-align:center;">วันที่</td>
                <td class="border-report" style="text-align:center;">อินวอย</td>
                <td class="border-report" style="text-align:center;">ยอด</td>
                <td class="border-report" style="text-align:center;">ถึงวันที่</td>
                <td class="border-report" style="text-align:center;">ค่าใช้จ่าย</td>
                <td class="border-report" style="text-align:center;">ดอกเบี้ย</td>
                <td class="border-report" style="text-align:center;">รวม</td> 
            </tr>        
        </thead>
        <tbody>
            <?php 
            for($i=0; $i < count($invoice_list); $i++){
            ?>
            <tr> 
                <td class="border-report" style="width:110px;border:1px solid #000;"><?PHP echo date_format(date_create($invoice_list[$i]['invoice_list_debt_date']),"d-m-Y") ;  ?></td>
                <td class="border-report" style="width:140px;border:1px solid #000;"><?php echo $invoice_list[$i]['debt_invoice_number'];?></td>
                <td class="align-money border-report" style="border:1px solid #000;"><?php echo number_format($invoice_list[$i]['invoice_list_debt_balance'], 2, '.', ','); ?></td>
                <td style="border:1px solid #000;"><?php echo date_format(date_create($invoice_list[$i]['invoice_list_to_date']),"d-m-Y") ; ?></td>
                <td class="align-money border-report" style="border:1px solid #000;"><?php echo number_format($invoice_list[$i]['invoice_list_debt_charge_amount'], 2, '.', ','); ?></td>
                <td class="align-money border-report" style="border:1px solid #000;"><?php echo number_format($invoice_list[$i]['invoice_list_interest_balance'], 2, '.', ','); ?></td>
                <td class="align-money border-report" style="border:1px solid #000;"><?php echo number_format($invoice_list[$i]['invoice_list_sum'], 2, '.', ','); ?></td> 
            </tr> 
            <?php 
            }
            ?>  
        </tbody>
        <tfoot>
        <tr> 
            <td class="border-report" style="text-align:right;" colspan="2">รวม</td> 
            <td class="border-report" style="text-align:right;"><?php echo number_format($invoice_list_sum[0]['invoice_list_debt_balance'], 2, '.', ','); ?></td>
            <td class="border-report" style="text-align:right;"></td>
            <td class="border-report" style="text-align:right;"><?php echo number_format($invoice_list_sum[0]['invoice_list_debt_charge_amount'], 2, '.', ','); ?></td>
            <td class="border-report" style="text-align:right;"><?php echo number_format($invoice_list_sum[0]['invoice_list_interest_balance'], 2, '.', ','); ?></td>
            <td class="border-report" style="text-align:right;"><?php echo number_format($invoice_list_sum[0]['invoice_list_sum'], 2, '.', ','); ?></td> 
        </tr> 
        </tfoot>
    </table>
</div>
