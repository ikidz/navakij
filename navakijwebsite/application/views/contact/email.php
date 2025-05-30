<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>ข้อมูลการติดต่อ</title>

</head>

<body>

<div id="container">

    <h3>คุณได้รับการติดต่อจาก <?php echo $info['contact_name']; ?> ผ่านทางเว็บไซต์ <?php echo $company_title['setting_value']; ?></h3>
    <p>อีเมล : <?php echo $info['contact_email']; ?></p>
    <p>เบอร์โทรศัพท์ : <?php echo $info['contact_mobile']; ?></p>
    <p>ข้อความ</p>
    <p><?php echo $info['contact_message']; ?></p>
    <p>ติดต่อเข้ามาเมื่อเวลา : <?php echo thai_convert_fulldate( date('Y-m-d') ); ?> <?php echo date('H:i'); ?>น.</p>

</div>


</body>
</html>