<?php  
session_start();
include 'config.php';
if(isset($_POST["room_id"]))
{
 $output = '';
 $connect->set_charset("utf8");
 $query = "SELECT * FROM phong_hop WHERE id = '".$_POST["room_id"]."'";
 $result = mysqli_query($connect, $query);
	$lang = $_SESSION['kw_lang'];
	if($lang == 'vi')
	{
		$title_tenphong = 'Tên Phòng';
		$title_mota = 'Mô tả';
		$title_stt = 'Trạng Thái';
		$title_stt1 ='Đang hoạt động';
		$title_stt2 = 'Ngưng hoạt động';
	}else if($lang == 'en')
	{
		$title_tenphong = 'Room';
		$title_mota = 'Description';
		$title_stt = 'Status';
		$title_stt1 ='Enable';
		$title_stt2 = 'Disable';
	}
	else{
		$title_tenphong = '會議室';
		$title_mota = '描述';
		$title_stt = '狀態';
		$title_stt1 ='啟用';
		$title_stt2 = '禁用';
	}
 $output .= '
      <div class="table-responsive">  
           <table class="table table-bordered">';
    while($row = mysqli_fetch_array($result))
    {
	if($row["trang_thai"] == 'active')
	{
		$trangthai =$title_stt1;
	}
	else {$trangthai =$title_stt2;}
     $output .= '
     <tr>  
            <td width="30%"><label>'.$title_tenphong.'</label></td>  
            <td width="70%">'.$row["ten_phong"].'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>'.$title_mota.'</label></td>  
            <td width="70%">'.$row["mo_ta"].'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>'.$title_stt.'</label></td>  
            <td width="70%">'.$trangthai.'</td>  
        </tr>
     ';
    }
    $output .= '</table></div>';
    echo $output;
}
?>