<?php
$ngay_bat_dau = "2020-10-22";
$ngay_ket_thuc = "2020-10-30";
$begin = new DateTime( $ngay_bat_dau );
$end   = new DateTime( $ngay_ket_thuc );
for($i = $begin; $i <= $end; $i->modify('+1 day')){
    echo $i->format("Y-m-d")."<br>";
}
?>