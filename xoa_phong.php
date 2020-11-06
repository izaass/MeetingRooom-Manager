<?php 
include "config.php";
session_start();
$ma_nhan_vien = $_SESSION['ma_nv'];
if(isset($_POST['id'])){
   $id=  $_POST['id'];
   $sql = "UPDATE `phong_hop` SET `trang_thai`='disable', `nguoi_tao`=". $ma_nhan_vien ." WHERE id=".$id;
   mysqli_query($connect,$sql);
   echo 1;
   exit;
}

echo 0;
exit;
?>