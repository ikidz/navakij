<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>ข้อมูลการติดต่อ</title>

</head>

<body>

<div id="container">

    <h3>ผลิตภัณฑ์ <?php echo $product['insurance_title_th']; ?> ได้รับความสนใจจากคุณ <?php echo $info['insurance_contact_name'].' '.$info['insurance_contact_lastname']; ?> ผ่านทางเว็บไซต์ <?php echo $company_title['setting_value']; ?></h3>
    <p>อีเมล : <?php echo $info['insurance_contact_email']; ?></p>
    <p>เบอร์โทรศัพท์ : <?php echo $info['insurance_contact_mobile']; ?></p>
    <?php $province = $this->product_model->get_provinceinfo_byid( $info['province_id'] ); ?>
    <p>จังหวัด : <?php echo $province['province_name_th']; ?></p>
    <p>เพศ​ : <?php echo ( $info['insurance_contact_gender'] == 'male' ? 'ชาย' : 'หญิง' ); ?></p>
    <p>มีการลงทะเบียนเข้าเมื่อเวลา : <?php echo thai_convert_fulldate( date('Y-m-d') ); ?> <?php echo date('H:i'); ?>น.</p>

</div>


</body>
</html>