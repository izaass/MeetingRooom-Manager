<?php
session_start();
include 'config.php';
$ma_nhan_vien = $_SESSION[ 'ma_nv' ];
$lang = $_SESSION['kw_lang'];
if($lang == 'vi')
{
	$mess_them_tc = 'Thêm thành công!';
	$mess_cn_tc = 'Cập Nhật Thành Công!';
}else if($lang == 'en'){
	$mess_them_tc = 'Add success!';
	$mess_cn_tc = 'Update Success!';
}
else{
	$mess_them_tc = '新增成功！';
	$mess_cn_tc = '新增成功！';
}
if(!empty($_POST))
{
    $output = '';
    if(isset($_POST["ten_phong"])) {
        $name =  strip_tags(Addslashes($_POST["ten_phong"]));
    }
    if(isset($_POST["mo_ta"])) {
        $des =  strip_tags(Addslashes($_POST["mo_ta"]));
    }
    if(isset($_POST["trang_thai"])) {
        $status = strip_tags($_POST["trang_thai"]);
    }
      if($_POST["room_id"] != '')  
      {  
          $query = "  
          UPDATE phong_hop   
          SET ten_phong       ='$name',   
          mo_ta        ='$des',   
          trang_thai         ='$status'
          WHERE id='".$_POST["room_id"]."'";  
          $message       = $mess_cn_tc;  
      }  
      else  
      {  	
          $query = "INSERT INTO phong_hop(ten_phong, mo_ta, trang_thai,nguoi_tao)  
     			VALUES('$name', '$des', '$status','$ma_nhan_vien')";
          $message = $mess_them_tc;  
      }  
     if(mysqli_query($connect, $query))  
     {  
           $output .= '<label class="text-success">' . $message . '</label><meta http-equiv="refresh" content="1">';
	 $select_query = "SELECT * FROM phong_hop where trang_thai = 'active'";
	 $result = mysqli_query($connect, $select_query);
    }
    echo $output;
}
//Đóng database
$connect->close();
?>