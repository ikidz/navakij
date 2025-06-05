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
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เราของแจ้งให้ทราบว่าข้อมูลส่วนตัวของคุณได้รับการปรับปรุงแก้ไขเมื่อ <?php echo $user_updatedate; ?> โดยคุณสามารถใช้ข้อมูลการเข้าสู่ระบบต่อไปนี้ในการเข้าใช้งานที่ <a href="<?php echo admin_url(); ?>"><?php echo admin_url(); ?></a></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><u>ข้อมูลการเข้าสู่ระบบ</u></strong></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Username :</strong> <?php echo $username; ?></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Password :</strong> <?php echo ($password=="")?"(รหัสผ่านเดิม ไม่เปลี่ยนแปลง)":$password; ?></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>ระดับสิทธิ์ :</strong> <?php echo $this->admin_library->getGroupName($user_group); ?></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><u>ข้อมูลส่วนตัวของคุณ</u></strong></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>ชื่อ-สกุล :</strong> <?php echo $user_fullname; ?></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>อีเมลล์ :</strong> <?php echo $user_email; ?></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>โทรศัพท์มือถือ :</strong> <?php echo $user_mobileno; ?></p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เราหวังเป็นอย่างยิ่งว่าข้อมูลนี้จะเป็นความลับที่สุดของคุณ เพราะทุกการประทำในระบบจะถูกบันทึกไว้ คุณจะเป็นผู้รับชอบในความเสียหาย หากให้ผู้อื่นใช้งานรหัสส่วนตัวของท่านจนเกิดความเสียหายต่อข้อมูลต่าง ๆ ในระบบ</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพื่อความปลอดภัย เราขอแนะนำให้ท่านเปลี่ยนรหัสผ่านใหม่ในครั้งแรกที่คุณเข้างาน และควรเปลี่ยนทุก ๆ 3 เดือน โดยควรตั้งรหัสเป็นตัวอักษรใหญ่-เล็กผสมตัวเลขและอักขระพิเศษ ให้คาดเดาได้ยากที่สุด เพื่อความปลอดภัยกับตัวคุณเอง</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p style="text-align:right;">ขอบคุณที่มาเป็นส่วนหนึ่งของเรา </p>
	<p style="text-align:right;"><strong><?php echo $this->admin_library->getCompanyName(); ?></strong></p>
</body>
</html>
