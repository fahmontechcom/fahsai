<script>
     function checkAll(id)
    {
        var checkbox = document.getElementsByName("check_all");

        if (checkbox[0].checked == true ){
            $('input[name="check_all"]').prop('checked', true);
            $(id).closest('table').children('tbody').children('tr').children('td').children('input[type="checkbox"]').prop('checked', true);
        }else{
            $('input[name="check_all"]').prop('checked', false);
            $(id).closest('table').children('tbody').children('tr').children('td').children('input[type="checkbox"]').prop('checked', false);
        }
    }
    function recover(){
        var checkbox = document.getElementsByName("summit_sale_id[]");
        var data = []; 
        if (confirm("คุณต้องการกู้คืนข้อมูล ?") == true) {
            
            
            for(i = 0 ;i<checkbox.length;i++){
                if(checkbox[i].checked){
                    data.push(checkbox[i].value); 
                }
            }
            $.post( "recover/sale/views/index.inc.php", { 
                sale_id:JSON.stringify(data),
                action:'recover'
            }) 
                    .done(function( data ) { 
                        console.log(data);
                        $('#display_recover').html(data);   
            }); 
        }   
    }
    function del(){
        var checkbox = document.getElementsByName("summit_sale_id[]");
        var data = [];  
        if (confirm("คุณต้องการลบข้อมูล ?") == true) {
            
            for(i = 0 ;i<checkbox.length;i++){
                if(checkbox[i].checked){
                    data.push(checkbox[i].value); 
                }
            }
            $.post( "recover/sale/views/index.inc.php", { 
                sale_id:JSON.stringify(data),
                action:'delete'
            }) 
                    .done(function( data ) { 
                        console.log(data);
                        $('#display_recover').html(data);   
            }); 
        } 
    } 
</script>

<div class="col-lg-12"> 
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อลูกค้า</th> 
                <th>เบอร์โทรศัพท์</th>  
            </tr>
        </thead>
        <tbody>
            <?php 
            for($i=0; $i < count($sale); $i++){
            ?>
                <tr class="nth-child">
                    <td><input type="checkbox" name="summit_sale_id[]" value="<?php echo $sale[$i]['sale_id'];?>" /></td>
                    <td><?php echo $sale[$i]['name'];?></td>
                    <td><?php echo $sale[$i]['sale_telephone'];?></td> 
                </tr>
            <?php 
            } 
            ?>
        </tbody>
        <tfoot> 
        <?PHP if(count($sale)>0){?>
            <tr>
                <td >
                    <input type="checkbox" value="all" name="check_all" onclick="checkAll(this)" /> 
                </td>
                <td colspan="2" style="text-align:left">
                    <button type="summit" onclick="del();" class="btn btn-danger" style="margin:2px;">ลบ</button>
                    <button type="summit" onclick="recover();"  class="btn btn-success" style="margin:2px;">กู้คืน</button>
                </td>
            </tr>
        <?PHP }?>
        </tfoot>
    </table>
</div> 
