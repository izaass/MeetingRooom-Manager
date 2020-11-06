<?php
date_default_timezone_set( 'Asia/Ho_Chi_Minh' );
session_start();
include 'config.php';
$ma_nhan_vien = $_SESSION[ 'ma_nv' ];
$ngay_hien_tai = date('Y-m-d-h:i:s');
$today = date('Y-m-d');
$ketqua_kt = mysqli_query($kw_link, sprintf("SELECT * FROM `nhan_vien` WHERE `ma_nhan_vien` = '".$ma_nhan_vien."'"));
$kw        = mysqli_fetch_assoc($ketqua_kt);
$ten       = $kw['ten_thuong_goi'];
$lang = $_SESSION['kw_lang'];
if($lang == 'vi')
{
	$mess_them_tc = 'Thêm thành công!';
	$mess_them_tb = 'Thêm thất bại, phòng này đã có người đặt!';
	$mess_cn_tc = 'Cập Nhật Thành Công!';
	$mess_cn_tb = 'Cập Nhật Thất Bại!';
}else if($lang == 'en'){
	$mess_them_tc = 'Add success!';
	$mess_them_tb = 'Fail, this room has already been booked !!';
	$mess_cn_tc = 'Update Success!';
	$mess_cn_tb = 'Update fail!';
}
else{
	$mess_them_tc = '新增成功！';
	$mess_them_tb = '新增失敗，此會議室已有預訂!';
	$mess_cn_tc = '更新成功！';
	$mess_cn_tb = '更新失敗！';
}

function getAllDaysInAMonth($year, $month, $day) {
    $dateString = 'first '.$day.' of '.$year.'-'.$month;

    if (!strtotime($dateString)) {
        throw new \Exception('"'.$dateString.'" is not a valid strtotime');
    }

    $startDay = new \DateTime($dateString);

    /*if ($startDay->format('j') > $daysError) {
        $startDay->modify('- 7 days');
    }*/

    $days = array();

    while ($startDay->format('Y-m') <= $year.'-'.str_pad($month, 2, 0, STR_PAD_LEFT)) {
        $days[] = clone($startDay);
        $startDay->modify('+ 7 days');
    }

    return $days;
}
if(!empty($_POST))
{
    if(isset($_POST["noi_dung"])) {
    $noi_dung = strip_tags(Addslashes($_POST['noi_dung']));
  }

  if(isset($_POST["phong_hop"])) {
    $phong_hop = $_POST['phong_hop'];
  }
  if(isset($_POST["ngay_bat_dau"])) {
    $ngay_bat_dau = $_POST['ngay_bat_dau'];
  }
  if(isset($_POST["ngay_ket_thuc"])) {
    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
  }
  if(isset($_POST["gio_bat_dau"])) {
    $gio_bat_dau = $_POST['gio_bat_dau'];
  }

  if(isset($_POST["gio_ket_thuc"])) {
    $gio_ket_thuc = $_POST['gio_ket_thuc'];
  }
	if(isset($_POST["co_dinh"])) {
    $co_dinh = strip_tags($_POST['co_dinh']);
  }
      if($_POST["ev_id"] != '')  
      {  		
		  
		  		//xử lí trùng lịch
		  		$ev_id = $_POST["ev_id"];
				$query = mysqli_query($connect, "SELECT * FROM `su_kien` where `ten_phong` = '$phong_hop' and start_date = '$ngay_bat_dau' and (('$gio_bat_dau' <= start_time) and ('$gio_ket_thuc' >= end_time) or (('$gio_bat_dau' BETWEEN start_time and end_time) or ('$gio_ket_thuc' BETWEEN start_time and end_time))) and id != '$ev_id'");
				$dump  = mysqli_num_rows($query);
				// nếu lịch trùng thì thêm thất bại
				if($dump >0) {
					echo $mess_them_tb;
				}
				//nếu không trùng thì thêm thành công
				else {
					if($co_dinh == 0)
					{
						$sql = "UPDATE `su_kien` SET `noi_dung`= '$noi_dung', `ten_phong`= '$phong_hop', `start_date`= '$ngay_bat_dau', `start_time`= '$gio_bat_dau', `end_time`= '$gio_ket_thuc', `ngay_them`='update-$ngay_hien_tai' WHERE `id`='".$_POST["ev_id"]."'";
						if ($connect->query($sql)===TRUE) {
								echo $mess_cn_tc; 
							}
						else{
							//echo 'Tính phá j đó homies';
							echo $sql;
							echo "Error: ". $sql . "<br>". $connect->error;
							echo $mess_cn_tb;
						}
					}
					else{
						$kq_truyvan = mysqli_query($connect,"SELECT * FROM `su_kien` WHERE `id`='".$_POST["ev_id"]."'");
						$row = mysqli_fetch_assoc($kq_truyvan);
						$sql = "UPDATE `su_kien` SET `noi_dung`= '$noi_dung', `ten_phong`= '$phong_hop', `start_time`= '$gio_bat_dau', `end_time`= '$gio_ket_thuc', `ngay_them`='update-$ngay_hien_tai' WHERE `ngay_them`='".$row['ngay_them']."'";
						if ($connect->query($sql)===TRUE) {
								echo $mess_cn_tc; 
							}
						else{
							//echo 'Tính phá j đó homies';
							echo $sql;
							echo "Error: ". $sql . "<br>". $connect->error;
							echo $mess_cn_tb;
						}
						
					}  
	  }}
      else  
      {  	
        //xử lí trùng lịch
				$query = mysqli_query($connect, "SELECT * FROM `su_kien` where `ten_phong` = '$phong_hop' and start_date = '$ngay_bat_dau' and (('$gio_bat_dau' <= start_time) and ('$gio_ket_thuc' >= end_time) or (('$gio_bat_dau' BETWEEN start_time and end_time) or ('$gio_ket_thuc' BETWEEN start_time and end_time)))");
				$dump  = mysqli_num_rows($query);
				// nếu lịch trùng thì thêm thất bại
				if($dump > 0) {
					echo $mess_them_tb;
				}
				//nếu không trùng thì thêm thành công
				else {
					//Code xử lý, insert dữ liệu vào table
					// nếu cố định = 0 thì insert sql
					$xoa = "DELETE FROM `su_kien` WHERE `ten_phong` = '' OR `ten_phong` IS NULL";
					$sql = "INSERT INTO `su_kien`(`noi_dung`, `ten_phong`, `start_date`, `start_time`, `end_time`, `trang_thai`, `ma_nhan_vien`, `ten_thuong_goi`,`ngay_them`) VALUES ('$noi_dung', '$phong_hop', '$ngay_bat_dau', '$gio_bat_dau', '$gio_ket_thuc', '$co_dinh','$ma_nhan_vien','$ten','$ngay_hien_tai')";
					// nếu cố định =1 thì insert codinh
					$y = date('Y',strtotime($ngay_bat_dau));
					$m = date('m',strtotime($ngay_bat_dau));
					$d = date('l',strtotime($ngay_bat_dau));
					$days = getAllDaysInAMonth($y ,$m, $d); 
					if($co_dinh == 0)
					{
						$ymdhi_today = date('Y-m-dH:i');
						$sosanh = $ngay_bat_dau.$gio_bat_dau;
						if($sosanh < $ymdhi_today)
						{
							echo "Giờ trong quá khứ sao họp ba";
						} 
						else{
							if ($connect->query($sql)===TRUE) {
								mysqli_query( $connect, $xoa );
								echo $mess_them_tc;
							}
							else {
								//echo 'Tính phá j đó homies';
								echo "Error: ". $sql . "<br>". $connect->error;
							}
						}
					}else if($co_dinh == 2)
					{
						$ymdhi_today = date('Y-m-dH:i');
						$sosanh = $ngay_bat_dau.$gio_bat_dau;
						if($sosanh < $ymdhi_today)
						{
							echo "Giờ trong quá khứ sao họp ba";
						}
						else{
							$begin = new DateTime( ".$ngay_bat_dau." );
							$end   = new DateTime( ".$ngay_ket_thuc." );
							for($i = $begin; $i <= $end; $i->modify('+1 day')){
								$ngay_bd = $i->format('Y-m-d');
								//xử lí trùng lịch
								$query = mysqli_query($connect, "SELECT * FROM `su_kien` where `ten_phong` = '$phong_hop' and start_date = '$ngay_bd' and (('$gio_bat_dau' <= start_time) and ('$gio_ket_thuc' >= end_time) or (('$gio_bat_dau' BETWEEN start_time and end_time) or ('$gio_ket_thuc' BETWEEN start_time and end_time)))");
								$dump  = mysqli_num_rows($query);
								// nếu lịch trùng thì thêm thất bại
								if($dump <= 0) {
									$codinh_ngay = "INSERT INTO `su_kien`(`noi_dung`, `ten_phong`, `start_date`, `start_time`, `end_time`, `trang_thai`, `ma_nhan_vien`, `ten_thuong_goi`,`ngay_them`) VALUES ('$noi_dung', '$phong_hop', '$ngay_bd', '$gio_bat_dau', '$gio_ket_thuc', '$co_dinh','$ma_nhan_vien','$ten','$ngay_hien_tai')";
									$result = mysqli_query( $connect, $codinh_ngay );
									$xoa_fail = "DELETE FROM `su_kien` where `ngay_them` = '".$ngay_hien_tai."' and trang_thai=2";
								}
								else{
									echo "Phòng này đã có người đặt tại ngày ". $ngay_bd;
									mysqli_query( $connect, $xoa_fail );
									exit();
								}
							}
							if ($result) {
								echo $mess_them_tc; 
							}
							else {
								echo $mess_them_tb. "Error: ". $codinh_ngay . "<br>". $connect->error;
								//echo "Tính phá j đó homies";
							}
						}
					}
					else{
						$ymdhi_today = date('Y-m-dH:i');
						$sosanh = $ngay_bat_dau.$gio_bat_dau;
						if($sosanh < $ymdhi_today)
						{
							echo "Giờ trong quá khứ sao họp ba";
						} 
						else{
							foreach ($days as $day) {
							if($day->format('Y-m-d') >= $today)
							{
								$ngay_bd = $day->format('Y-m-d');
								//xử lí trùng lịch
								$query = mysqli_query($connect, "SELECT * FROM `su_kien` where `ten_phong` = '$phong_hop' and start_date = '$ngay_bd' and (('$gio_bat_dau' <= start_time) and ('$gio_ket_thuc' >= end_time) or (('$gio_bat_dau' BETWEEN start_time and end_time) or ('$gio_ket_thuc' BETWEEN start_time and end_time)))");
								$dump  = mysqli_num_rows($query);
								// nếu lịch trùng thì thêm thất bại
								if($dump <= 0) {
									$codinh = "INSERT INTO `su_kien`(`noi_dung`, `ten_phong`, `start_date`, `start_time`, `end_time`, `trang_thai`, `ma_nhan_vien`, `ten_thuong_goi`,`ngay_them`) VALUES ('$noi_dung', '$phong_hop', '$ngay_bd', '$gio_bat_dau', '$gio_ket_thuc', '$co_dinh','$ma_nhan_vien','$ten','$ngay_hien_tai')";
									$result = mysqli_query( $connect, $codinh );
									$xoa_fail = "DELETE FROM `su_kien` where `ngay_them` = '".$ngay_hien_tai."' and trang_thai=1";
								}
								else{
									echo "Phòng này đã có người đặt tại ngày ". $ngay_bd;
									mysqli_query( $connect, $xoa_fail );
									exit();
								}
							}
						}
						if ($result) {
							echo $mess_them_tc; 
						}
						else {
							echo $mess_them_tb. "Error: ". $codinh . "<br>". $connect->error;
							//echo "Tính phá j đó homies";
						}
						}
						
					}
				}
          
      }
}
//Đóng database
$connect->close();
?>