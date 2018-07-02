<div class="row">
  <div class="col-lg-12">
    <div>
     <h1>ระบบจัดการช่องทางการชำระเงิน</h1>
     <h2>เพิ่ม ลบ เเก้ไข ช่องทางการชำระเงิน</h2>
     <div align=right>
      <a href="?content=gateway&action=insert">
        <input class="button" type="submit" value="เพิ่มช่องทางการชำระเงิน">
      </a>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>ช่องทางการชำระเงิน</th> 
        <th style="max-width:60px;">จัดการ</th>
        
      </tr>
    </thead>
    <tbody>
      <?php 
      for($i=0; $i < count($debt_payment_geteway); $i++){
        ?>
        <tr class="nth-child">
          <td><?php echo $i+1; ?></td>
          <td><?php echo $debt_payment_geteway[$i]['debt_payment_geteway_name']; ?></td>
          <td>
            <a href="?content=gateway&action=update&id=<?php echo $debt_payment_geteway[$i]['debt_payment_geteway_id'];?>" style="font-size: 20px;">
              <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
            </a> 
            <a href="?content=gateway&action=delete&id=<?php echo $debt_payment_geteway[$i]['debt_payment_geteway_id'];?>" onclick="return confirm('You want to delete gateway : <?php echo $debt_payment_geteway[$i]['debt_payment_geteway_name']; ?>');" style="color:red; font-size: 20px;">
              <i class="fa fa-times" aria-hidden="true"></i>
            </a>
          </td>
          
        </tr>
        <?php } ?>
    </tbody>
  </table>
  </div>
</div>

