<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<?php /* Stylesheets - Start */ ?>
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('bootstrap/css/bootstrap.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('bootstrap/css/bootstrap-reboot.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('fontawesome/css/all.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('select2/css/select2.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('slick/slick/slick.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('slick/slick/slick-theme.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('fancybox/jquery.fancybox.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('sweetalert2/sweetalert2.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('icomoon/style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('mk-trc/mk-toggle-radio-check.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('bootstrap-datepicker/css/datepicker.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/animate.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/stylesheet.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/style.css?v=1.6'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/responsive.css?v=1.6'); ?>" />
<?php /* Stylesheets - End */ ?>

<?php /* Meta for SEO - Start */ ?>
<meta name="title" content="">
<meta name="description" content="">
<meta name="keyword" content="">
<?php /* Meta for SEO - Start */ ?>

<title>Print</title>

</head>

<body>

<?php /* #container - Start */ ?>
<div id="container" class="container">

    <?php /* #job-information - Start */ ?>
    <section id="job-information" class="py-3">
        <h2 class="underline mb-3">รายละเอียดตำแหน่งที่สมัครงาน</h2>
        <table cellpadding="1" cellspacing="1" class="table table-striped">
            <tbody>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:20%;">
                        <p class="bold mb-1">สถานที่ปฏิบัติงาน</p>
                        <p>Area Expected</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:40%;">
                        <?php $location = $this->applicantsreportmodel->get_locationinfo_byid( $info['location_id'] ); ?>
                        <?php if( isset( $location ) && count( $location ) > 0 ): ?>
                            <p class="bold"><?php echo $location['location_title_th']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:20%;">
                        <p class="bold mb-1">เงินเดือนที่คาดหวัง</p>
                        <p>Expected Salary</p>
                    </td>
                    <td class="border-navy border-1px" style="width:20%;">
                        <p><?php echo $info['applicant_salary']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ตำแหน่ง</p>
                        <p>Position Applied</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" colspan="3">
                        <?php $job = $this->applicantsreportmodel->get_jobinfo_byid( $info['job_id'] ); ?>
                        <?php if( isset( $job ) && count( $job ) > 0 ): ?>
                            <p><?php echo $job['job_title_th']; ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php /* #job-information - End */ ?>

    <?php /* #personal-information - Start */ ?>
    <section id="personal-information" class="py-3">
        <h2 class="underline mb-3">ประวัติส่วนตัว (Personal Information)</h2>
        <table cellpadding="1" cellspacing="1" class="table table-striped">
            <tbody>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        <p class="bold mb-1">ชื่อ-นามสกุล</p>
                        <p>Name - Surname</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        <?php if( $info['prefix_id'] == 999 ): ?>
                            <?php $title = $info['prefix_other']; ?>
                        <?php else: ?>
                            <?php $prefix = $this->applicantsreportmodel->get_prefixinfo_byid( $info['prefix_id'] ); ?>
                            <?php $title = ( isset( $prefix ) && count( $prefix ) > 0 ? $prefix['prefix_title_th'] : '' ); ?>
                        <?php endif; ?>
                        <p><?php echo $title.' '.$info['applicant_fname_th'].' '.$info['applicant_lname_th']; ?></p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        <p class="bold mb-1">วัน / เดือน / ปี เกิด</p>
                        <p>Date of birth</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        <?php if( $info['applicant_birthdate'] != '' || $info['applicant_birthdate'] != null ): ?>
                            <p><?php echo date("d/m/Y", strtotime( $info['applicant_birthdate'] ) ); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        <p class="bold mb-1">บัตรประจำตัวประชาชน</p>
                        <p>Identity Card No.</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        <p><?php echo $info['applicant_idcard']; ?></p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        <p class="bold mb-1">วันที่บัตรหมดอายุ</p>
                        <p>Date of Expiry</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        <?php if( $info['applicant_idcard_expired'] != '' || $info['applicant_idcard_expired'] != null ): ?>
                            <p><?php echo date('d/m/Y', strtotime( $info['applicant_idcard_expired'] )); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        <p class="bold mb-1">ส่วนสูง</p>
                        <p>Height</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        <?php if( $info['applicant_height'] > 0 ): ?>
                            <p><?php echo $info['applicant_height']; ?> ซม. (cm.)</p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        <p class="bold mb-1">น้ำหนัก</p>
                        <p>Weight</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        <?php if( $info['applicant_weight'] > 0 ): ?>
                            <p><?php echo $info['applicant_weight']; ?> กก. (kg.)</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        <p class="bold mb-1">สถานะภาพทางทหาร</p>
                        <p>Military Status</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        <?php
                            if( $info['applicant_military_status'] != '' || $info['applicant_military_status'] != null ){
                                switch( $info['applicant_military_status'] ){
                                    case 'serving' : echo 'อยู่ระหว่างรับราชการทหาร / ทหารเกณฑ์'; break;
                                    case 'completed' : echo 'ผ่านการเกณฑ์ทหาร'; break;
                                    default : echo 'ได้รับการยกเว้น';
                                }
                            }
                        ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:15%;">
                        &nbsp;
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:35%;">
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php /* #personal-information - End */ ?>

    <?php /* #addresses - Start */ ?>
    <section id="addresses">
        <?php $addresses = $this->applicantsreportmodel->get_addresss( $info['applicant_id'] ); ?>
        <?php if( isset( $addresses ) && count( $addresses ) > 0 ): ?>
            <?php foreach( $addresses as $address ): ?>
                <?php if( $address['address_type'] == 'current' ): ?>
                    <h2 class="underline mb-3">ที่อยู่ปัจจุบัน (Present Address)</h2>
                <?php else: ?>
                    <h2 class="underline mb-3">ที่อยู่ตามสำเนาทะเบียนบ้าน (Address as in housing register)</h2>
                <?php endif; ?>
                <table cellpadding="1" cellspacing="1" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">เลขที่</p>
                                <p>Address No.</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $address['address_no']; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">หมู่บ้าน/อาคาร</p>
                                <p>Village/Bldg.</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $address['address_building']; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">ตรอก/ซอย</p>
                                <p>Soi</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $address['address_avenue']; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">ถนน</p>
                                <p>Road</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $address['address_street']; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">แขวง/ตำบล</p>
                                <p>Sub District</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <?php $subdistrict = $this->applicantsreportmodel->get_subdistrictinfo_byid( $address['subdistrict_id'] ); ?>
                                <?php if( isset( $subdistrict ) && count( $subdistrict ) > 0 ): ?>
                                    <p><?php echo $subdistrict['name']; ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">เขต/อำเภอ</p>
                                <p>District</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <?php $district = $this->applicantsreportmodel->get_districtinfo_byid( $address['district_id'] ); ?>
                                <?php if( isset( $district ) && count( $district ) > 0 ): ?>
                                    <p><?php echo $district['name']; ?></p>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">จังหวัด</p>
                                <p>Province</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <?php $province = $this->applicantsreportmodel->get_provinceinfo_byid( $address['province_id'] ); ?>
                                <?php if( isset( $province ) && count( $province ) > 0 ): ?>
                                    <p><?php echo $province['name']; ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">เขต/อำเภอ</p>
                                <p>District</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <?php $postcode = $this->applicantsreportmodel->get_postcodeinfo_byid( $address['postcode_id'] ); ?>
                                <?php if( isset( $postcode ) && count( $postcode ) > 0 ): ?>
                                    <p><?php echo $postcode['postcode']; ?></p>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">โทรศัพท์</p>
                                <p>Telephone</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $address['address_tel']; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">โทรศัพท์มือถือ</p>
                                <p>Telephone</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $address['address_mobile']; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">อีเมล</p>
                                <p>Email</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $address['address_email']; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                &nbsp;
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
    <?php /* #addresses - End */ ?>

    <?php /* #information - Start */ ?>
    <section id="information" class="py-3">
        <table cellpadding="1" cellspacing="1" class="table table-striped">
            <tbody>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:100%;">
                        <p class="bold mb-1">ทราบการรับสมัครงานของ บมจ. นวกิจประกันภัย จากที่ใด</p>
                        <p>You know to apply to the Company from?</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:100%;">
                        <?php $source = $this->applicantsreportmodel->get_news_sourceinfo_byid( $info['applicant_news_source_id'] ); ?>
                        <?php if( isset( $source ) && count( $source ) > 0 ): ?>
                            <p><?php echo $source['source_title_th']; ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:100%;">
                        <p class="bold mb-1">เคยสมัครงานกับ บมจ.​นวกิจประกันภัย มาก่อนหรือไม่?</p>
                        <p>Have you to applied for employment with us before?</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:100%;">
                        <p><?php echo ( $info['applicant_applied_status'] == 1 ? 'เคย' : 'ไม่เคย' ); ?></p>
                        <?php if( $info['applicant_applied_status'] == 1 && $info['applicant_applied_year'] != '' ): ?>
                            <p>เมื่อปี : <?php echo $info['applicant_applied_year']; ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:100%;">
                        <p class="bold mb-1">ท่านเคยประสบอุบัติเหตุถึงขั้นเข้าโรงพยาบาลหรือไม่?</p>
                        <p>Have you ever had an accident or illness to step into the hospital?</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:100%;">
                        <p><?php echo ( $info['applicant_applied_status'] == 1 ? 'เคย' : 'ไม่เคย' ); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php /* #information - End */ ?>

    <?php /* #education - Start */ ?>
    <section id="education">
        <h2 class="underline mb-3">ประวัติการศึกษา (Education Information)</h2>
        <table cellpadding="1" cellspacing="1" class="table table-striped">
            <tbody>
                <tr>
                    <td class="border-right border-navy border-1px px-3" colspan="2">
                        <p class="bold mb-1">ขณะนี้ท่านอยู่ระหว่างการศึกษาหรือไม่?</p>
                        <p>Are you currently studying?</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" colspan="4">
                        <p><?php echo ( $info['applicant_studying_status'] == 1 ? 'ใช่' : 'ไม่ใช่' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3" style="width:20%;">
                        <p class="text-center bold mb-0">ระดับการศึกษา</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:25%;">
                        <p class="text-center bold mb-0">สถานบัน</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="text-center bold mb-0">จังหวัด</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="text-center bold mb-0">ปีที่จบ</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="text-center bold mb-0">วิชาเอก</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3" style="width:10%;">
                        <p class="text-center bold mb-0">เกรดเฉลี่ย</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">มัธยมศึกษา</p>
                        <p>High school</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_highschool_name']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3">
                        <?php if( $info['applicant_education_highschool_province_id'] > 0 ): ?>
                            <?php $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_highschool_province_id'] ); ?>
                            <p><?php echo $province['name']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_highschool_year']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_highschool_major']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_highschool_gpa']; ?></p></td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ปวช.</p>
                        <p>Vocational</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_vocational_name']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3">
                        <?php if( $info['applicant_education_vocational_province_id'] > 0 ): ?>
                            <?php $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_vocational_province_id'] ); ?>
                            <p><?php echo $province['name']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_vocational_year']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_vocational_major']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_vocational_gpa']; ?></p></td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ปวท./ปวส.</p>
                        <p>Diploma</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_diploma_name']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3">
                        <?php if( $info['applicant_education_diploma_province_id'] > 0 ): ?>
                            <?php $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_diploma_province_id'] ); ?>
                            <p><?php echo $province['name']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_diploma_year']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_diploma_major']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_diploma_gpa']; ?></p></td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ปริญญาตรี</p>
                        <p>Bachelor's degree</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_bachelor_name']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3">
                        <?php if( $info['applicant_education_bachelor_province_id'] > 0 ): ?>
                            <?php $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_bachelor_province_id'] ); ?>
                            <p><?php echo $province['name']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_bachelor_year']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_bachelor_major']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_bachelor_gpa']; ?></p></td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ปริญญาโท</p>
                        <p>Master's degree</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_master_name']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3">
                        <?php if( $info['applicant_education_master_province_id'] > 0 ): ?>
                            <?php $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_master_province_id'] ); ?>
                            <p><?php echo $province['name']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_master_year']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_master_major']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_master_gpa']; ?></p></td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">อื่นๆ</p>
                        <p>Other</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_other_name']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3">
                        <?php if( $info['applicant_education_other_province_id'] > 0 ): ?>
                            <?php $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_other_province_id'] ); ?>
                            <p><?php echo $province['name']; ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_other_year']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_other_major']; ?></p></td>
                    <td class="border-right border-navy border-1px px-3"><p><?php echo $info['applicant_education_other_gpa']; ?></p></td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php /* #education - End */ ?>

    <?php /* #skills - Start */ ?>
    <section id="skills">
        <h2 class="underline mb-3">ความสามารถอื่นๆ (Knowledge/Skills)</h2>
        <table cellpadding="1" cellspacing="1" class="table table-striped">
            <tbody>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ความรู้/ความสามารถเกี่ยวกับคอมพิวเตอร์?</p>
                        <p>Computer Skill</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p><?php echo $info['applicant_skill_computer']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">อัตราพิมพ์ดีด ภาษาไทย</p>
                        <p>Typing rate in Thai</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p><?php echo $info['applicant_skill_typing_thai']; ?> คำ/นาที (words / minute)</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">อัตราพิมพ์ดีด ภาษาอังกฤษ</p>
                        <p>Typing rate in English</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p><?php echo $info['applicant_skill_typing_english']; ?> คำ/นาที (words / minute)</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">สามารถใช้เครื่องใช้สำนักงานอะไรได้บ้าง</p>
                        <p>What office equipment can be used to do?</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p><?php echo $info['applicant_skill_office_tools']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ความรู้/ความสามารถพิเศษ</p>
                        <p>Knowledge/Skills</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p><?php echo $info['applicant_skill_specials']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">กิจกรรมระหว่างการศึกษา</p>
                        <p>Activities during the study</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <p><?php echo $info['applicant_skill_activities']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="border-right border-navy border-1px px-3">
                        <p class="bold mb-1">ความสามารถในการขับขี่ยานพาหนะ</p>
                        <p>Vehicel driving skill</p>
                    </td>
                    <td class="border-right border-navy border-1px px-3">
                        <?php if( $info['applicant_skill_driving_status'] == 1 ): ?>
                            <p>รถยนต์ : <?php echo ( $info['applicant_skill_driving_status'] == 1 ? 'ได้' : 'ไม่ได้' ); ?></p>
                            <p>หมายเลขใบขับขี่ : <?php echo $info['applicant_skill_driving_license']; ?></p>
                        <?php endif; ?>
                        <?php if( $info['applicant_skill_driving_status'] == 1 ): ?>
                            <p>รถจักรยานยนต์ : <?php echo ( $info['applicant_skill_riding_status'] == 1 ? 'ได้' : 'ไม่ได้' ); ?></p>
                            <p>หมายเลขใบขับขี่ : <?php echo $info['applicant_skill_riding_license']; ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php /* #skills - End */ ?>

    <?php /* #skill-languages - Start */ ?>
    <section id="skill-languages">
        <h2 class="underline mb-3">ความรู้ด้านภาษา (Language abilities)</h2>
        <?php $languages = $this->applicantsreportmodel->get_languages( $info['applicant_id'] ); ?>
        <?php if( isset( $languages ) && count( $languages ) > 0 ): ?>
            <table cellpadding="1" cellspacing="1" class="table table-striped">
                <tbody>
                    <tr>
                        <td class="border-right border-navy border-1px px-3">
                            <p class="bold mb-1">ภาษา</p>
                            <p>Language</p>
                        </td>
                        <td class="border-right border-navy border-1px px-3">
                            <p class="bold mb-1">ฟัง</p>
                            <p>Listening</p>
                        </td>
                        <td class="border-right border-navy border-1px px-3">
                            <p class="bold mb-1">พูด</p>
                            <p>Speaking</p>
                        </td>
                        <td class="border-right border-navy border-1px px-3">
                            <p class="bold mb-1">อ่าน</p>
                            <p>Reading</p>
                        </td>
                        <td class="border-right border-navy border-1px px-3">
                            <p class="bold mb-1">เขียน</p>
                            <p>Writing</p>
                        </td>
                    </tr>
                    <?php foreach( $languages as $language ): ?>
                        <tr>
                            <td class="border-right border-navy border-1px px-3"><p><?php echo $language['language_name']; ?></p></td>
                            <td class="border-right border-navy border-1px px-3">
                                <?php
                                    switch( $language['language_listen'] ){
                                        case 'great' : $status = 'ดีมาก'; break;
                                        case 'good' : $status = 'ดี'; break;
                                        case 'moderate' : $status = 'พอใช้'; break;
                                        default : $status = '-';
                                    }
                                ?>
                                <p><?php echo $status; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3">
                                <?php
                                    switch( $language['language_speaking'] ){
                                        case 'great' : $status = 'ดีมาก'; break;
                                        case 'good' : $status = 'ดี'; break;
                                        case 'moderate' : $status = 'พอใช้'; break;
                                        default : $status = '-';
                                    }
                                ?>
                                <p><?php echo $status; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3">
                                <?php
                                    switch( $language['language_reading'] ){
                                        case 'great' : $status = 'ดีมาก'; break;
                                        case 'good' : $status = 'ดี'; break;
                                        case 'moderate' : $status = 'พอใช้'; break;
                                        default : $status = '-';
                                    }
                                ?>
                                <p><?php echo $status; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3">
                                <?php
                                    switch( $language['language_writing'] ){
                                        case 'great' : $status = 'ดีมาก'; break;
                                        case 'good' : $status = 'ดี'; break;
                                        case 'moderate' : $status = 'พอใช้'; break;
                                        default : $status = '-';
                                    }
                                ?>
                                <p><?php echo $status; ?></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
    <?php /* #skill-languages - End */ ?>

    <?php /* #experiences - Start */ ?>
    <section id="experiences">
        <h2 class="underline mb-3">ประวัติการทำงาน (Working Experience In Chronological)</h2>
        <?php $experiences = $this->applicantsreportmodel->get_experiences( $info['applicant_id'] ); ?>
        <?php if( isset( $experiences ) && count( $experiences ) > 0 ): ?>
            <table cellpadding="1" cellspacing="1" class="table table-striped">
                <tbody>
                    <?php foreach( $experiences as $experience ): ?>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">ชื่อบริษัท</p>
                                <p>Company Name</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $experience['experience_company_name']; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">ที่อยู่</p>
                                <p>Address</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $experience['experience_company_address']; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">โทรศัพท์</p>
                                <p>Telephone</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $experience['experience_company_tel']; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">ตั้งแต่</p>
                                <p>Since - until</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <?php if( $experience['experience_start'] != '' ): ?>
                                    <p>
                                        <?php echo thai_convert_shortdate( $experience['experience_start'] ); ?>
                                         - 
                                        <?php echo ( $experience['experience_end'] != '' ? thai_convert_shortdate( $experience['experience_end'] ) : 'ปัจจุบัน' ); ?>
                                    </p>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">ชื่อผู้บังคับบัญชา/ตำแหน่ง</p>
                                <p>Name of superior/position.</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $experience['experience_superior']; ?></p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3">
                                <p class="bold mb-1">หน้าที่ความรับผิดชอบ</p>
                                <p>Responsibilities</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" colspan="3">
                                <p><?php echo $experience['experience_job_description']; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">เงินเดือน</p>
                                <p>Salary</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo number_format( $experience['experience_salary'] ); ?> บาท</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">ค่าครองชีพ</p>
                                <p>Cost of living</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo number_format( $experience['experience_cost_of_living'] ); ?> บาท</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">โบนัส/เดือน</p>
                                <p>Bonus/month</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo number_format( $experience['experience_bonus'] ); ?> บาท</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">รายได้อื่นๆ</p>
                                <p>Other</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo number_format( $experience['experience_other'] ); ?> บาท</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">รวม</p>
                                <p>Total</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo number_format( $experience['experience_total'] ); ?> บาท</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:15%;">
                                <p class="bold mb-1">เหตุผลในการลาออก</p>
                                <p>Reason for resignation</p>
                            </td>
                            <td class="border-right border-navy border-1px px-3" style="width:35%;">
                                <p><?php echo $experience['experience_reason']; ?></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
    <?php /* #experiences - End */ ?>

    <?php /* #introduction - Start */ ?>
    <section id="introduction">
        <h2 class="underline mb-3">แนะนำตนเอง (Introduction)</h2>
        <table cellpadding="1" cellspacing="1" class="table table-striped">
            <tbody>
                <tr>
                    <td>
                        <p class="bold mb-1">กรุณาแนะนำตัวท่านเองเพื่อให้บริษัทรู้จักตัวท่านดีขึ้น</p>
                        <p>Please provide any further information about yourself which will allow our company to know you better.</p>
                    </td>
                </tr>
                <tr>
                    <td><p><?php echo $info['applicant_introduction']; ?></p></td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php /* #introduction - End */ ?>

</div>
<?php /* #container - End */ ?>

<script type="text/javascript">
    window.print();
</script>
</body>
</html>