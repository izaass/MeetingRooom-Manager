<?php
session_start();
$ma_nhan_vien = $_SESSION[ 'ma_nv' ];
include 'config.php';
$query = "SELECT * FROM phong_hop ORDER BY id DESC";
$result = mysqli_query( $connect, $query );
$sql = "SELECT * FROM `user_deps`,`nhan_vien` where `user_deps`.`ma_nhan_vien` = `nhan_vien`.`ma_nhan_vien` and `nhan_vien`.`ma_nhan_vien`='$ma_nhan_vien' and `user_deps`.`ma_he_thong` ='qlph'";
$kq_tv = mysqli_query($kw_link, $sql);
$role = mysqli_fetch_array( $kq_tv );
$lang = $_SESSION['kw_lang'];
if($lang == 'vi')
	{
		$tieu_de = 'Phòng Họp';
		$title_detail = 'Chi tiết phòng';
		$title_tieude = 'Thêm Phòng mới';
		$title_h1 = 'Quản Lý Phòng Họp';
		$title_action = 'Thao tác';
		$title_mota = 'Mô tả';
		$title_tenphong = 'Tên Phòng';
		$title_trangthai = 'Trạng Thái';
		$title_chonstt = 'Chọn trạng thái';
		$title_chonstt1 = 'Đang hoạt động';
		$title_chonstt2 = 'Ngưng hoạt động';
		$title_btnthem = 'Thêm';
		$title_btnupdate = 'Cập nhật';
		$title_xoa = 'Bạn có thực sự muốn xóa phòng này?';
		$fail = 'Xóa của người ta chi vậy má!!';
	}else if($lang == 'en')
	{
		$tieu_de = 'Rooms';
		$title_h1 = 'Meeting Room Manager';
		$title_detail = 'Room details';
		$title_tieude = 'Add new room';
		$title_action = 'Action';
		$title_mota = 'Description';
		$title_tenphong = 'Room';
		$title_trangthai = 'Status';
		$title_chonstt = 'Choose a status';
		$title_chonstt1 = 'Active';
		$title_chonstt2 = 'Disable';
		$title_btnthem = 'Add';
		$title_btnupdate = 'Update';
		$title_xoa = 'Are you sure?';
		$fail = 'Delete fail';
	}
	else{
		$title_detail = '會議室明細';
		$tieu_de = '會議室';
		$title_tieude = '新增會議室';
		$title_h1 = '會議室管理';
		$title_mota = '描述';
		$title_action = '行動';
		$title_tenphong = '會議室名稱';
		$title_trangthai = '狀態';
		$title_chonstt = '選擇狀態';
		$title_chonstt1 = '啟用';
		$title_chonstt2 = '禁用';
		$title_btnthem = '新增';
		$title_btnupdate = '更新';
		$title_xoa = '是否確定？';
		$fail = '無法刪除';
	}?>

<!DOCTYPE html>
<html>
<head>
<title><?=$tieu_de?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./css/menubar.css" />
<link rel="stylesheet" href="./css/font-awesome.min.css">
<script src="./js/jquery.min.js"></script>
<link rel="stylesheet" href="./css/bootstrap.min.css" />
<script src="./js/bootstrap.min.js"></script> 
<script src="./js/bootbox.min.js"></script>

</head>
<body>
<header class="header">
	<?php include 'menubar.php';?>
</header>
<div class="container">
		<h3 align="center"><?=$title_h1?></h3>
		<div class="table-wrapper">
				<div class="table-title">
						<div class="row">
								<div class="col-sm-6">
									<?php if($role['ma_deps'] == '8' and $role['chuc_vu'] == 'TP' and $role['ma_he_thong'] == 'qlph')
										{?>
										<button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning"><i class="fa fa-plus" aria-hidden="true"></i> <?=$title_tieude?></button>
									<?php }?>
								</div>
						</div>
				</div>
				<br />
				<div id="employee_table">
						<table class="table table-striped table-hover">
						<thead class="thead-dark">
								<tr>
										<th><?=$title_tenphong?></th>
										<th><?=$title_trangthai?></th>
										<th><?=$title_action?></th>
								</tr>
								</thead>
								<?php
								while ( $row = mysqli_fetch_array( $result ) ) {
										?>
								<tr>
										<td>
											<button type="button" id="<?php echo $row["id"]; ?>" class="view_data btn btn-link"><?php echo $row["ten_phong"]; ?></button>
										</td>
										<?php if($row["trang_thai"] == 'active')
										{	
											$trang_thai = $title_chonstt1;
											echo '<td>'.$trang_thai.'</td>';
										}
											else {
												$trang_thai = $title_chonstt2;
												echo '<td style="color:red">'.$trang_thai.'</td>';
											} 
										?>
									<td>
											<button type="button" id="<?php echo $row["id"]; ?>" class="view_data btn btn-primary "><i class="fa fa-eye" aria-hidden="true"></i></button>
										
									<?php if($role['ma_deps'] == '8' and $role['chuc_vu'] == 'TP' and $role['ma_he_thong'] == 'qlph')
										{
										echo '
											<button name="edit" id="'.$row["id"].'" class="btn btn-info btn-xs edit_data"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>';
											if($row["trang_thai"] == 'active')
										{
											echo ' <button id=del_'.$row['id'].' class="delete btn btn-danger" data-id='.$row['id'].'> <i class="fa fa-trash" aria-hidden="true"></i> </button>';}
											
									}?>
										</td>
								</tr>
								<?php
								}
								?>
						</table>
				</div>
		</div>
</div>
</div>
</body>
</html>
<div id="dataModal" class="modal fade">
		<div class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
								<h4 class="modal-title"><?=$title_detail?></h4>
						</div>
						<div class="modal-body" id="chi_tiet_phong"></div>
						<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="color: red;" aria-hidden="true"></i></button>
						</div>
				</div>
		</div>
</div>
<div id="add_data_Modal" class="modal fade">
		<div class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
								<h4 class="modal-title"><?=$title_tieude?></h4>
						</div>
						<div class="modal-body">
								<form method="post" id="insert_form">
										<label><?=$title_tenphong?></label>
										<input type="text" name="ten_phong" id="ten_phong" class="form-control" required />
										<br />
										<label><?=$title_mota?></label>
										<input type="text" name="mo_ta" id="mo_ta" class="form-control" required />
										<br />
										<label><?=$title_trangthai?></label>
										<select name="trang_thai" id="trang_thai" class="form-control" required>
												<option value=""><?=$title_chonstt?></option>
												<option value="active"><?=$title_chonstt1?></option>
												<option value="disable"><?=$title_chonstt2?></option>
										</select>
										<br>
										<input type="hidden" name="room_id" id="room_id" />
										<input type="submit" name="insert" id="insert" value="<?=$title_btnthem?>" class="btn btn-success" />
								</form>
						</div>
						<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="color: red;" aria-hidden="true"></i></button>
						</div>
				</div>
		</div>
</div>
<script>  
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("<?=$title_btnthem?>");  
           $('#insert_form')[0].reset();  
      });  
      $(document).on('click', '.edit_data', function(){  
           var room_id = $(this).attr("id");  
           $.ajax({  
               url:"cap_nhat_phong.php",  
               method:"POST",  
               data:{room_id:room_id},  
               dataType:"json",  
               success:function(data){  
                    $('#ten_phong').val(data.ten_phong);  
                    $('#mo_ta').val(data.mo_ta);  
                    $('#trang_thai').val(data.trang_thai);
                    $('#room_id').val(data.id);  
                    $('#insert').val("<?=$title_btnupdate?>");  
                    $('#add_data_Modal').modal('show');  
                }     
           });  
      });  
      $('#insert_form').on("submit", function(event){  
           event.preventDefault();   
               $.ajax({  
                    url:"them_phong.php",  
                    method:"POST",  
                    data:$('#insert_form').serialize(),  
                    beforeSend:function()
                    {  
                         $('#insert').val("Đang Thêm...");  
                    },  
                    success:function(data)
                    {  
                         $('#insert_form')[0].reset();  
                         $('#add_data_Modal').modal('hide');  
                         $('#employee_table').html(data);  
                    }  
               });  

      });  
			//xoa phong hop
	$('.delete').click(function(){
		var el = this;
		// Delete id
		var deleteid = $(this).data('id');
		// Confirm box
		bootbox.confirm("<?=$title_xoa?>", function(result) {
		   if(result){
			// AJAX Request
			$.ajax({
			   url: 'xoa_phong.php',
			   type: 'POST',
			   data: { id:deleteid },
			   success: function(response){
					// Removing row from HTML Table
					if(response == 1){
						$(el).closest('tr').css('background','tomato');
						$(el).closest('tr').fadeOut(800,function(){
						   $(this).remove();
						});
					}
					else{
						bootbox.alert('<?=$fail?>');
					}}
			});
		}});
	});
      //xem chi tiết phòng họp
    $(document).on('click', '.view_data', function() {
        //$('#dataModal').modal();
        var room_id = $(this).attr("id");
        $.ajax({
            url: "chi_tiet_phong.php",
            method: "POST",
            data: {
                room_id: room_id
            },
            success: function(data) {
                $('#chi_tiet_phong').html(data);
                $('#dataModal').modal('show');
            }
        });
    });  
});  
</script>
<script>
     $(document).ready(function()
     {
          setTimeout(function()
          {
               $('#message').hide();
          },3000);
     });
</script>