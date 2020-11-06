<?php
function blockip() {
	echo '
<html>
<head>
<meta charset="UTF-8"/>
<title>Hệ Thống Giám Sát An Toàn Website</title>
</head>
<body>
<div style="text-align: center; width: 60%; margin: 50px auto; border: 1px solid #ccc; border-radius: 5px; min-height: 200px; padding: 20px">
	<div style="font-weight: bold; margin-bottom: 10px; text-transform: uppercase">Hệ Thống Giám Sát An Toàn Website</div>
	<img src="https://media.giphy.com/media/jY28p9JxDNViU/giphy.gif" height="200"><br>

	<div style="margin-top: 10px">
	<meta http-equiv="refresh" content="3;URL='.$_SERVER['PHP_SELF'].'"><strong>Tình trạng: Chặn truy cập </strong><div>Hệ thống sẽ tự động trở về trang chủ ...</div>
</body>
</html>
	';
	exit();
}
$sqli = explode("|", "%|*|(|)|+|<|>|0x|/|\|,|;|'|\"|[|]|{|}| ");
foreach ($_GET as $key => $value) {
	foreach ($sqli as $key1 => $value1) {
		$_GET[$key] = str_replace($value1, "", $_GET[$key]);
		if ($_GET[$key]!=$value) {
			blockip();
			break;
		}
	}
}
foreach ($_POST as $key => $value) {
	foreach ($sqli as $key1 => $value1) {
		$_POST[$key] = str_replace($value1, "", $_POST[$key]);
		if ($_POST[$key]!=$value) {
			blockip();
			break;
		}
	}
}
?>