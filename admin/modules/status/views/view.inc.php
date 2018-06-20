<div class="row">
  <div class="col-lg-12">
    <div>
     <h1>ระบบจัดการสถานะหนี้</h1>
     <h2>เพิ่ม ลบ เเก้ไข สถานะหนี้</h2>
     <div align=right>
      <a href="?content=status&action=insert">
        <input class="button" type="submit" value="เพิ่มสถานะหนี้">
      </a>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>ชื่อสถานะ</th>  
        
        
        <th style="max-width:60px;">เเก้ไข</th>
        <th style="max-width:60px;">ลบ</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      for($i=0; $i < count($debt_schedule_status); $i++){
        ?>
        <tr>
          <td><?php echo $i+1; ?></td>
          <td><?php echo $debt_schedule_status[$i]['debt_schedule_status_name']; ?></td>
          <td>
            <a href="?content=status&action=update&id=<?php echo $debt_schedule_status[$i]['debt_schedule_status_id'];?>" style="font-size: 20px;">
              <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
            </a> 
          </td>
          <td>
            <a href="?content=status&action=delete&id=<?php echo $debt_schedule_status[$i]['debt_schedule_status_id'];?>" onclick="return confirm('You want to delete status : <?php echo $debt_schedule_status[$i]['debt_schedule_status_name']; ?>');" style="color:red; font-size: 20px;">
              <i class="fa fa-times" aria-hidden="true"></i>
            </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

