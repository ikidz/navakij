<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome Email</title>
</head>

<body style="font-size:12px;font-family:'Lucida Grande', 'Lucida Sans Unicode', Tahoma, Helvetica, Arial, Verdana, sans-serif;width:700px;">
	<p>
		<img src="<?php echo base_url("public/panel/assets/img/logo.png"); ?>" />
	</p>
	<p>สวัสดี <?php echo $user_fullname; ?></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เราของแจ้งให้ทราบว่าคุณถูกยกเลิกการใช้งานระบบจัดการข้อมูลของ <strong><?php echo $company; ?></strong> โดยผู้ดูและระบบ ซึ่งมีผลโดยทันทีที่ได้รับอีเมมล์ฉบับนี้</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p style="text-align:right;">ขอบคุณที่มาเป็นส่วนหนึ่งของเรา </p>
	<p style="text-align:right;"><strong><?php echo $company; ?></strong></p>
</body>
</html>
