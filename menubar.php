<?php
include('iz.php');
include('config.php');
$sql = "SELECT * FROM `user_deps`,`nhan_vien` where `user_deps`.`ma_nhan_vien` = `nhan_vien`.`ma_nhan_vien` and `nhan_vien`.`ma_nhan_vien`='$ma_nhan_vien' and `user_deps`.`ma_he_thong` ='qlph'";
$kq_tv = mysqli_query($kw_link, $sql);
$role = mysqli_fetch_array( $kq_tv );
?>
<!-- menu bar -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top"> 
<a class="navbar-brand">
<?php 
	if(isset($_SESSION[ 'ma_nv' ])){
		$ma_nhan_vien = $_SESSION[ 'ma_nv' ];
		echo '<i class="fa fa-user" aria-hidden="true"></i> ' .$role['ten_thuong_goi'].'('.$ma_nhan_vien.')' ;
	}
	else{
		echo '<i class="fa fa-user" aria-hidden="true"></i> ' .$role['ten_thuong_goi'].'('.$ma_nhan_vien.')' ;
	}
?>
</a>
	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse"> <span class="navbar-toggler-icon"></span> </button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
			<div class="navbar-nav"> 
				<a href="index.php" class="nav-item nav-link">
					<?php 
					if($_SESSION['kw_lang'] =='vi') 
					{echo 'Trang Chủ';}
					else if($_SESSION['kw_lang'] == 'en'){echo 'Home';}
					else {echo '主頁';}
					?>
				</a>
				<a href="phong.php" class="nav-item nav-link">
					<?php 
					if($_SESSION['kw_lang'] =='vi') 
					{echo 'Phòng';}
					else if($_SESSION['kw_lang'] == 'en'){echo 'Rooms';}
					else {echo '房間';}
					?>
				</a>
				<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php 
					if($_SESSION['kw_lang'] =='vi') 
					{echo 'Ngôn Ngữ';}
					else if($_SESSION['kw_lang'] == 'en'){echo 'Language';}
					else {echo '語言';}
					?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="?lang=vi">Vietnamese</a>
          <a class="dropdown-item" href="?lang=en">English</a>
		  <a class="dropdown-item" href="?lang=tw">Taiwan</a>
        </div>
      </li>
			</div>
			<div class="navbar-nav ml-auto"> 
				<a href="../KW/logout.php" class="nav-item nav-link">
					<?php 
					if($_SESSION['kw_lang'] =='vi') 
					{echo 'Đăng xuất';}
					else if($_SESSION['kw_lang'] == 'en'){echo 'Logout';}
					else {echo '登出';}
					?>
				</a> 
			</div>
	</div>
</nav>
<!-- end menubar  -->

