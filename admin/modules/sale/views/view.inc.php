<div class="row">
  <div class="col-lg-12">
    <div>
     <h1>ระบบจัดการพนักงานขาย</h1>
     <h2>เพิ่ม ลบ เเก้ไข พนักงานขาย</h2>
     <div align=right>
      <a href="?content=sale&action=insert">
        <input class="button" type="submit" value="เพิ่มพนักงานขาย">
      </a>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>ชื่อ - นามสกุล</th>  
        <th>เบอร์โทรศัพท์</th>
        <th>อีเมล</th>
        
        <th>จัดการ</th>
        
      </tr>
    </thead>
    <tbody>
      <?php 
      for($i=0; $i < count($sale); $i++){
        ?>
        <tr>
          <td><?php echo $i+1; ?></td>
          <td><?php echo $sale[$i]['name']; ?></td>
          <td><?php echo $sale[$i]['sale_telephone']; ?></td>
          <td><?php echo $sale[$i]['sale_email']; ?></td>
          
          <td>
            <a href="?content=sale&action=update&id=<?php echo $sale[$i]['sale_id'];?>" style="font-size: 20px;">
              <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
            </a> 
            <a href="?content=sale&action=delete&id=<?php echo $sale[$i]['sale_id'];?>" onclick="return confirm('You want to delete sale : <?php echo $sale[$i]['name']; ?>');" style="color:red; font-size: 20px;">
              <i class="fa fa-times" aria-hidden="true"></i>
            </a>
          </td>
          
        </tr>
        
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

