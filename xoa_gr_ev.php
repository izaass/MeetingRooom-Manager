<?php
session_start();
$ma_nhan_vien = $_SESSION[ 'ma_nv' ];
include "config.php";
if ( isset( $_POST[ 'id' ] ) ) {
		$id = $_POST[ 'id' ];
		$sql = "DELETE FROM `su_kien` where ngay_them = '" . $id . "'";
		mysqli_query($connect,$sql);
   echo 1;
   exit;
}

echo 0;
exit;
?>