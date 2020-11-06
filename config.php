<?php
//db quản lý phòng họp
$connect = new mysqli("localhost","root","7980@abc","qlph");
// set utf8 cho db
$connect->set_charset("utf8");
// Check connection
if ($connect -> connect_errno) {
  echo "Kết nối thất bại: " . $connect -> connect_error;
  exit();
}

//db kw dung ở them_lich.php fix thẻ input của mr.Báo
$kw_link = mysqli_connect("localhost", "root", "7980@abc", "kw");
// set utf8 cho db
$kw_link->set_charset("utf8");
// Check connection
if ($kw_link -> connect_errno) {
  echo "Kết nối thất bại: " . $kw_link -> connect_error;
  exit();
}

//START Lang
if(isset($_GET["lang"])) 
	$lang = $_GET["lang"];
else
{
	if(isset($_SESSION["kw_lang"])) 
		$lang = $_SESSION["kw_lang"];
	else
		$lang='vi';
}

if($lang !='vi' and $lang !='en' and $lang !='tw')
	$lang='vi';

$_SESSION["kw_lang"] = $lang;
//END Lang
?>