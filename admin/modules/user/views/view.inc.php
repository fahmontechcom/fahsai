<div class="row">
  <div class="col-lg-12">
    <div>
     <h1>ระบบจัดการผู้ใช้งาน</h1>
     <h2>เพิ่ม ลบ เเก้ไข ผู้ใช้งาน</h2>
     <div align=right>
      <a href="?content=user&action=insert">
        <input class="button" type="submit" value="เพิ่มผู้ใช้งาน">
      </a>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>ชื่อ - นามสกุล</th>  
        <th>เบอร์โทรศัพท์</th>
        <th>ชื่อผู้ใช้งาน</th>
        
        <th>จัดการ</th>
        
      </tr>
    </thead>
    <tbody>
      <?php 
      for($i=0; $i < count($user); $i++){
        ?>
        <tr>
          <td><?php echo $i+1; ?></td>
          <td><?php echo $user[$i]['name']; ?></td>
          <td><?php echo $user[$i]['user_telephone']; ?></td>
          <td><?php echo $user[$i]['user_username']; ?></td>
          
          <td>
            <a href="?content=user&action=update&id=<?php echo $user[$i]['user_id'];?>" style="font-size: 20px;">
              <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
            </a> 
            <a href="?content=user&action=delete&id=<?php echo $user[$i]['user_id'];?>" onclick="return confirm('You want to delete user : <?php echo $user[$i]['name']; ?>');" style="color:red; font-size: 20px;">
              <i class="fa fa-times" aria-hidden="true"></i>
            </a>
          </td>
          
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

