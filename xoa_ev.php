<?php
include "config.php";
if(isset($_POST['id'])){
   $id=  $_POST['id'];
   $sql = "DELETE FROM `su_kien` WHERE id='".$id."'";
   mysqli_query($connect,$sql);
   echo 1;
   exit;
}

echo 0;
exit;
?>