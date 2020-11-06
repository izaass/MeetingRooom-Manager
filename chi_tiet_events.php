<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="./js/jquery.min.js"></script>  
    <link rel="stylesheet" href="./css/bootstrap.min.css" />  
    <script src="./js/bootstrap.min.js"></script> 
    <script src="./js/bootbox.min.js"></script>
    <title>Chi tiết sự kiện</title>
</head>
<body>
<?php
session_start();
$ma_nhan_vien = $_SESSION['ma_nv'];
$today = date('Y-m-d'); // ngay thang nam hien tai Y-m-d
// chi tiết sự kiện theo id
if(isset($_POST["ev_id"]))
{
 $output = '';
 include 'config.php';
 $connect->set_charset("utf8");
 $query = "SELECT * FROM `su_kien` WHERE id = '".$_POST["ev_id"]."'";
 $result = mysqli_query($connect, $query);
 $lang = $_SESSION['kw_lang'];
	if($lang == 'vi')
	{
		$title_noidung = 'Nội dung';
		$title_tenphong = 'Tên Phòng';
		$title_tgbd = 'Thời Gian Bắt đầu';
		$title_ngthem = 'Người thêm';
		$title_thaotac ='Thao tác';
		$title_xoacd = 'Xóa lịch cố định';
	}else if($lang == 'en')
	{
		$title_noidung = 'Content';
		$title_tenphong = 'Room';
		$title_tgbd = 'Start time';
		$title_ngthem = 'Author';
		$title_thaotac ='Action';
		$title_xoacd = 'Delete fixed schedule';
	}
	else{
		$title_noidung = '含量';
		$title_tenphong = '房间';
		$title_tgbd = '开始时间';
		$title_ngthem = '作者';
		$title_thaotac ='行动';
		$title_xoacd = '删除固定时间表';
	}
 $output .= ' 
      <div class="table-responsive">  
           <table class="table table-bordered">';
    while($row = mysqli_fetch_array($result))
    {
     $output .= '
     <tr>  
            <td width="30%"><label>'.$title_noidung.'</label></td>  
            <td width="70%">'.$row["noi_dung"].'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>'.$title_tenphong.'</label></td>  
            <td width="70%">'.$row["ten_phong"].'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>'.$title_tgbd.'</label></td>  
            <td width="70%">'.date('d/m',strtotime($row["start_date"])). ' - ('. $row["start_time"] .'-'. $row["end_time"] .')</td>  
        </tr>

        <tr>  
            <td width="30%"><label>'.$title_ngthem.'</label></td>  
            <td width="70%">'.$row["ten_thuong_goi"].'</td>  
        </tr>';
				if($ma_nhan_vien == $row["ma_nhan_vien"] || $ma_nhan_vien =="7980")
				{
					if($today <= $row['start_date'])
					{
						$output .='<tr>  
						<td width="30%"><label>'.$title_thaotac.'</label></td>  
						<td width="35%">
						<button name="edit" id="'.$row['id'].'" class="btn btn-info btn-xs edit_data"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
						<button id=del_'.$row['id'].' class="delete btn btn-danger" data-id='.$row['id'].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						</td>


						</tr>';
						if($row['trang_thai'] != 0)
						{
						$output .='<tr>  
						<td width="40%"><label>'.$title_xoacd.'</label></td>  
						<td width=60%">
						<button id=del_'.$row['id'].' class="deletegroup btn btn-danger" data-id='.$row['ngay_them'].'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						</td>
						</tr>';
						}
					}
				}

    }
    $output .= '</table></div>';
    echo $output;
}
	if($lang =='vi')
	{
		$mess = 'Bạn có thực sự muốn xóa sự kiện này?';
		$fail = 'Xóa của người ta chi vậy má!!';
	}
	else if($lang =='en')
	{
		$mess = 'Are you sure?';
		$fail = 'Delete fail';
	}
	else{
		$mess = '你确定吗';
		$fail = '删除失败';
	}
?>
<script>  
    $(document).ready(function(){
     //xoa su kien
        $('.delete').click(function(){
            var el = this;
            // Delete id
            var deleteid = $(this).data('id');
            // Confirm box
            bootbox.confirm("<?=$mess?>", function(result) {
               if(result){
                // AJAX Request
                $.ajax({
                   url: 'xoa_ev.php',
                   type: 'POST',
                   data: { id:deleteid },
                   success: function(response){
                        // Removing row from HTML Table
                        if(response == 1){
							location.reload();
                        }
                        else{
							bootbox.alert('<?=$fail?>');
						}}
                });
            }});
        });
			// xoa co dinh
			$('.deletegroup').click(function(){
            var el = this;
            // Delete id
            var deleteid = $(this).data('id');
            // Confirm box
            bootbox.confirm("<?=$mess?>", function(result) {
               if(result){
                // AJAX Request
                $.ajax({
                   url: 'xoa_gr_ev.php',
                   type: 'POST',
                   data: { id:deleteid},
                   success: function(response){
                        // Removing row from HTML Table
                        if(response == 1){
                            location.reload();
                        }
                        else{
                            bootbox.alert('<?=$fail?>');
                        }}
                });
            }});
        });
    });  
     </script>
</body>
</html>
