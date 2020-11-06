<?php
include '../kw/login.php'; //get login from db kw
$lang = $_SESSION['kw_lang'];
if($lang == 'vi'){$title = 'Quản lý phòng họp';}else if($lang =='en'){$title = 'Meeting Room Manager';	}else{$title = '会议室经理';;}?>
<!DOCTYPE html>  
<html>  
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$title?></title>
<link rel = "stylesheet" href = "./css/menubar.css">
<link rel = "stylesheet" href = "./css/reset.css">
<link rel="stylesheet" href="./css/font-awesome.min.css">
<link rel="stylesheet" href="./css/bootstrap.min.css" />
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script> 
<script src="./js/bootbox.min.js"></script>
<style>
.view_data:hover {
	background-color: #7f94a9;
}
.btn {
	margin: 10px;
	padding: 5px;
	border: 1px solid #eae6e6;
}
.nut{
	width: 140px;
	margin: 8px;
	display: inline-block;
	font-weight: 400;
	color: #212529;
	text-align: center;
	vertical-align: middle;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	border: 1px solid #eae6e6;
	font-size: 1rem;
	line-height: 1.5;
	border-radius: .25rem;
}
.grnut {
	display: inline-block;
	font-weight: 400;
	text-align: center;
	vertical-align: middle;
	padding: .375rem .75rem;
	font-size: 1rem;
	line-height: 1.5;
	border: 1px solid #eae6e6;
	border-radius: .25rem;
	margin: 5px;
}
.hscroll {
  overflow-x: auto; /* Horizontal */
}
.header{margin: -1.5rem 0rem 0rem 0rem;}
#ngay_ket_thuc{
    display: none;
}
#lbl_ngay_ket_thuc{
	display: none;
}
</style>
</head>	
<body>

<header class="header">
	<?php include 'menubar.php';?>
</header>
<?php
include 'config.php'; //get db from db qlph
//echo $dien_thoai; điện thoại
$_SESSION['ma_nv'] = $ma_nhan_vien;
$ngay_hien_tai = date('Y-m-d');
$gio_hien_tai = date('H:i');
$gio_du_kien_ket_thuc = date('H:i', strtotime('+1 hour'));
$trang_thai = "";
$year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
$week = (isset($_GET['week'])) ? $_GET['week'] : date('W');
if ($week > 52)
{
    $year++;
    $week = 1;
}
elseif ($week < 1)
{
    $year--;
    $week = 52;
}
	
?>
<div class="btn-group" role="group" aria-label="btngroup">
<a class="grnut btn-primary" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week == 1 ? 52 : $week - 1) . '&year=' . ($week == 1 ? $year - 1 : $year); ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i><?php if($lang == 'vi'){echo ' Trước';}else if($lang =='en'){echo ' Next';}else{echo' 下一頁';}?></a> <!--Next week--> 
<a class="grnut btn-success" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . (date('W')) . '&year=' . (date('Y')); ?>"><?php if($lang == 'vi'){echo 'Hôm nay';}else if($lang =='en'){echo 'Today';}else{echo'今天';}?></a> <!--This Week--> 
<a class="grnut btn-primary" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week == 52 ? 1 : 1 + $week) . '&year=' . ($week == 52 ? 1 + $year : $year); ?>"><?php if($lang == 'vi'){echo 'Sau ';}else if($lang =='en'){echo 'Prev ';}else{echo '上一頁 ';}?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a> <!--Previous week--> 
	<!-- thêm mới -->
<a name="age" id="age" data-toggle="modal" data-target="#add_data_Modal" class="grnut btn-warning"><i class="fa fa-plus" aria-hidden="true"></i><?php if($lang == 'vi'){echo ' Thêm';}else if($lang =='en'){echo ' Add';}else{echo' 新增';}?></a>
</div>
<div class="hscroll">
	<div id="employee_table">
			<table class="table table-striped table-hover">
			<thead class="thead-dark">
					<tr>
							<th ><?php if($lang == 'vi'){echo 'Phòng';}else if($lang =='en'){echo 'Room';}else{echo'房間';}?></th>
							<?php
if ($week < 10)
{
    $week = '0' . $week;
}
$today = date('m-d'); // highlight today
// hiển thị thứ - tháng - ngày
for ($day = 1;$day <= 6;$day++)
{
    $d = strtotime($year . "W" . $week . $day);
    $so_sanh = date('m-d', $d);
    if ($today == date('m-d', $d))
    {	
        echo "<th style='color:#ff4c94'>" . date( 'l', $d ) . "<br>" . date( 'd-m', $d ) . "</th>";
    }
    else echo "<th>" . date( 'l', $d ) . "<br>" . date( 'd-m', $d ) . "</th>";
}
$query = mysqli_query($connect, "SELECT * FROM `phong_hop` where trang_thai = 'active' ORDER BY `phong_hop`.`ten_phong` DESC");
while ($phong = mysqli_fetch_assoc($query))
{
    $lien = $phong['ten_phong'];
    echo '<tbody><tr><td>' . $lien . '</td>';
    for ($day = 1;$day <= 6;$day++)
    {
		
        $d = strtotime($year . "W" . $week . $day);
        $so_sanh = date('m-d', $d);
        $vnb = "SELECT * FROM `su_kien` where `start_date` like '%" . $so_sanh . "%' and `ten_phong` = '" . $lien . "' ORDER BY `start_time` ASC ";
        $ketqua_kt = mysqli_query($connect, $vnb);
		if ($today == date('m-d', $d))
    	{
        echo '<td width="200px" style="background:#fbeed1;" >';
		}
		else{echo '<td width="200px">';}
        if (mysqli_num_rows($ketqua_kt) != 0)
        {
            while ($row = mysqli_fetch_assoc($ketqua_kt))
            {	
				
                // kiểm tra trạng thái nếu bằng 1 thì là lịch cố định á
                if ($row['trang_thai'] == 1)
                {
                    $trang_thai = " (Cố định)";
                    echo '<button name="view" id=' . $row['id'] . ' class="nut btn-warning view_data"> (' . $row['start_time'] . '-' . $row['end_time'] . ')<br>' . $row['ten_thuong_goi'] . '' . $trang_thai . '</button><br/>';
                }
                else
                {
                    echo '<button name="view" style="background-color:#e3e3e3;" id=' . $row['id'] . ' class="nut view_data">(' . $row['start_time'] . '-' . $row['end_time'] . ')<br>' . $row['ten_thuong_goi'] . '</button><br>';
                }
				
            }
			echo'<button name="age" data-phong="' . $lien . '" data-ngaybd="' . date('Y-m-d', $d) . '" class="grnut btn-link them_lich"><i class="fa fa-plus" aria-hidden="true"></i></button>';
        }
        else echo '<button name="age" data-phong="' . $lien . '" data-ngaybd="' . date('Y-m-d', $d) . '" class="grnut btn-link them_lich"><i class="fa fa-plus" aria-hidden="true"></i></button>';
        echo '</td>';
    }
    echo '</tr></tbody>';
}
?>
			</table>
	</div>
<?php
if($lang == 'vi')
	{
		$title_noidung = 'Nội dung';
		$title_tenphong = 'Tên Phòng';
		$title_ngaybd = 'Ngày bắt đầu';
		$title_ngaykt = 'Ngày kết thúc';
		$title_giobd = 'Giờ bắt đầu';
		$title_giokt = 'Giờ kết thúc';
		$title_thaotac = 'Thao tác';
		$title_xoacd = 'Xóa lịch cố định';
		$title_chonphong= 'Chọn phòng';
		$title_trangthai = 'Cố định';
		$title_chonstt1 = 'Mặc định';
		$title_chonstt2 = 'Cố định theo tháng';
		$title_chonstt3 = 'Cố định theo ngày';
		$title_btnthem = 'Thêm';
		$title_btnupdate = 'Cập nhật';
		$title_themcap='Thao tác sự kiện';
		$title_time_mess = 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu!';
		$title_date_mess = 'Ngày bắt đầu không hợp lệ!';
	}else if($lang == 'en')
	{
		$title_noidung = 'Content';
		$title_tenphong = 'Room';
		$title_ngaybd = 'Start date';
		$title_ngaykt = 'End date';
		$title_giobd = 'Start time';
		$title_giokt = 'End time';
		$title_thaotac = 'Action';
		$title_xoacd = 'Delete fixed schedule';
		$title_chonphong = 'Choose a room';
		$title_trangthai = 'Status';
		$title_chonstt1 = 'Default';
		$title_chonstt2 = 'Fixed by month';
		$title_chonstt3 = 'Fixed by date';
		$title_btnthem = 'Insert';
		$title_btnupdate = 'Update';
		$title_themcap = 'Action';
		$title_time_mess = 'The end time must be greater than the starting time !!';
		$title_date_mess = 'Invalid start date!';
	}
	else{
		$title_noidung = '內容';
		$title_tenphong = '會議室名稱';
		$title_ngaybd = '開始日期';
		$title_ngaykt = '結束日期';
		$title_giobd = '開始時間';
		$title_giokt = '結束時間';
		$title_thaotac = '操作';
		$title_xoacd = '刪除固定排程';
		$title_chonphong = '選擇會議室';
		$title_trangthai = '狀態';
		$title_chonstt1 = '默认';
		$title_chonstt2 = '固定时间依月';
		$title_chonstt3 = '依日固定';
		$title_btnthem = '新增';
		$title_btnupdate = '更新';
		$title_themcap = '活動';
		$title_time_mess = '結束時間必須大於開始時間！';
		$title_date_mess = '無效的開始日期！';
	}?>
	</div>
 <div id="dataModal" class="modal fade">
		<div class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
								<h4 class="modal-title"><?php if($lang == 'vi'){echo 'Chi tiết sự kiện';}else if($lang =='en'){echo 'Event Detail';}else{echo'會議內容';}?></h4>
						</div>
						<div class="modal-body" id="chi_tiet_ev"></div>
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
								<h4 class="modal-title"><?=$title_themcap?></h4>
						</div>
						<div class="modal-body">
								<form method="post" id="insert_form">
										<label><?=$title_noidung?></label>
										<textarea name="noi_dung" id="noi_dung" rows="2" class="form-control" required></textarea>
										<br />
										<label><?=$title_tenphong?></label>
										<select name="phong_hop" id="phong_hop" class="form-control" required>
												<option value=""><?=$title_chonphong?></option>
												<?php
												$kq = mysqli_query($connect, "SELECT * FROM `phong_hop` where trang_thai='active' ORDER BY `phong_hop`.`ten_phong` DESC");
												while ($row = mysqli_fetch_assoc($kq))
												{
													echo '<option value="' . $row['ten_phong'] . '">' . $row['ten_phong'] . '</option>';
												}
												?>
										</select>
										<br>
										<label><?=$title_trangthai?></label>
										<select name="co_dinh" id="co_dinh" class="form-control" required onchange="showNgayKT('lbl_ngay_ket_thuc','ngay_ket_thuc', this)">
												<option value="0" selected><?=$title_chonstt1?></option>
												<option value="1"><?=$title_chonstt2?></option>
												<option value="2"><?=$title_chonstt3?></option>
										</select>
										<br>
										<div class="form-row">
												<div class="form-group col-md-6">
														<label><?=$title_ngaybd?></label>
														<input type="date" value="<?=$ngay_hien_tai?>" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control" required />
												</div>
												<div class="form-group col-md-6">
														<label id="lbl_ngay_ket_thuc"><?=$title_ngaykt?></label>
														<input type="date" value="<?=$ngay_hien_tai?>" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control" required />
												</div>
										</div>
										<div class="form-row">
												<div class="form-group col-md-6">
														<label><?=$title_giobd?></label>
														<input type="time"  value="<?=$gio_hien_tai?>" name="gio_bat_dau" id="gio_bat_dau" class="form-control" required/>
												</div>
												<div class="form-group col-md-6">
														<label><?=$title_giokt?></label>
														<input type="time" value="<?=$gio_du_kien_ket_thuc?>" name="gio_ket_thuc" id="gio_ket_thuc" class="form-control" required/>
												</div>
										</div>
										<input type="hidden" name="ev_id" id="ev_id" />
										<input type="submit" name="insert" id="insert" value="<?=$title_btnthem?>" class="btn btn-success" />
								</form>
						</div>
						<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss"><i class="fa fa-times" style="color: red;" aria-hidden="true"></i></button>
						</div>
				</div>
		</div>
</div>
 <script>  
 $(document).ready(function(){
	 //đặt lại form rỗng
	 $("#add_data_Modal").on('hide.bs.modal', function(){
		 $('#insert').val("<?=$title_btnthem?>");
    	 $('#insert_form')[0].reset();
		 document.getElementById("ngay_ket_thuc").style.display = 'none';
		 document.getElementById("lbl_ngay_ket_thuc").style.display = 'none';
  	});
	 $('#dismiss').click(function(){
		 $('#insert').val("<?=$title_btnthem?>");
         $('#insert_form')[0].reset();
		 document.getElementById("ngay_ket_thuc").style.display = 'none';
		 document.getElementById("lbl_ngay_ket_thuc").style.display = 'none';
      });
      $('#add').click(function(){
		  
           $('#insert').val("<?=$title_btnthem?>");  
           $('#insert_form')[0].reset();  
      });
	  // chỉnh sửa
      $(document).on('click', '.edit_data', function(){  
		   var ev_id = $(this).attr("id");
           $.ajax({  
               url:"cap_nhat_ev.php",  
               method:"POST",  
               data:{ev_id:ev_id},  
               dataType:"json",  
               success:function(data){ 
                    $('#noi_dung').val(data.noi_dung);  
                    $('#phong_hop').val(data.ten_phong);  
                    $('#ngay_bat_dau').val(data.start_date);  
                    $('#gio_bat_dau').val(data.start_time);  
                    $('#gio_ket_thuc').val(data.end_time);
					$('#co_dinh').val(data.trang_thai);
					$('#ev_id').val(data.id); 
					$('#insert').val("<?=$title_btnupdate?>");
                    $('#add_data_Modal').modal('show');
                }  
           });  
      });   
$('#insert_form').on("submit", function(event){  
    event.preventDefault();
	var ngay_hien_tai = new Date().toJSON().slice(0,10).replace(/-/g,'-');
	var now = new Date(Date.now());
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var curTime = hours+ ":" +minutes;
	var getUTC = now.getTime();
	if($('#noi_dung').val() == "")  
  {  
   bootbox.alert("Xóa required chi z ba!!");  
  }  
  else if($('#phong_hop').val() == '')  
  {  
   bootbox.alert("Xóa required chi z ba!!");  
  } else if($('#gio_bat_dau').val() > $('#gio_ket_thuc').val())
	{
	bootbox.alert("<?=$title_time_mess?>");
	}
	else if($('#ngay_bat_dau').val() < ngay_hien_tai)
	{
	bootbox.alert("<?=$title_date_mess?>");
	}
	else
	{
	   $.ajax({
			url:"them_lich.php",
			method:"POST",
			data:$('#insert_form').serialize(),
			success:function(data)
			{
				 if(data == "Thêm thành công!" || data == "Cập Nhật Thành Công!" || data =="Add success!" || data =="Update Success!" || data =="新增成功！" || data =="更新成功！")
					 {
						 alert(data);
						 $('#insert_form')[0].reset();
						 $('#add_data_Modal').modal('hide');
						 $('#employee_table').html(data);
						 location.reload();
					 }
				else
				{
					alert(data);
				}
				 
			}
	   });
	}
      });
       //xem chi tiết phòng họp
    $(document).on('click', '.view_data', function() {
        //$('#dataModal').modal();
        var ev_id = $(this).attr("id");
        $.ajax({
            url: "chi_tiet_events.php",
            method: "POST",
            data: {
                ev_id: ev_id
            },
            success: function(data) {
                $('#chi_tiet_ev').html(data);
                $('#dataModal').modal('show');
            }
        });
    });
	 	 // them mới trong table
      $(document).on('click', '.them_lich', function(){
		  var ngaybd = $(this).attr("data-ngaybd"); // trả về ngày bắt đầu
		  var phong = $(this).attr("data-phong"); // trả về phong
		  // Disable #phong_hop
		  //$( "#phong_hop" ).attr('disabled','true');
		  // Disable #ngay_bat_dau
		  //$( "#ngay_bat_dau" ).attr('readonly','true');
		  $('#add_data_Modal').modal('show');
		  $('#phong_hop').val(phong);
		  $('#ngay_bat_dau').val(ngaybd);
				$.ajax({
				   url:"them_lich.php",
				   method:"POST",
				   data:{ngay_bat_dau:ngaybd,ngay_ket_thuc:ngaybd,phong:phong},
				   success:function(data){
						$('#phong_hop').val(phong);
						$('#ngay_bat_dau').val(ngaybd);
					    $('#ngay_ket_thuc').val(ngaybd);
						$('#ev_id').val(data.id);
					}
			   });
	  });
});
function showNgayKT(lbl_ngay_ket_thuc,ngay_ket_thuc, element)
{
    document.getElementById(ngay_ket_thuc).style.display = element.value == 2 ? 'block' : 'none';
	document.getElementById(lbl_ngay_ket_thuc).style.display = element.value == 2 ? 'block' : 'none';
}
</script>
