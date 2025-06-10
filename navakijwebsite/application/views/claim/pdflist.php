<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<title>รายชื่อเครือข่าย <?php echo $category['category_title_'.$this->_language]; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('bootstrap/css/bootstrap.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo vendors_url('bootstrap/css/bootstrap-reboot.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/style.css?v=1.6'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/responsive.css?v=1.6'); ?>" />
<style type="text/css">
.table tr td:first-child{
    border-left:none;
}
.table tr td:last-child{
    border-right:none;
}
.table tr td{
    background:initial;
}
</style>
</head>

<body>

<?php /* #container - Start */ ?>
<div id="container">
    <div class="d-flex flex-wrap">
        <div class="col-6 col-md-4 col-lg-2 py-3 px-5 mx-auto mx-lg-0 text-left">
            <a href="<?php echo site_url(''); ?>">
                <img src="<?php echo assets_url('img/logo.png'); ?>" alt="" class="img-fullwidth" />
            </a>
        </div>
        <?php /*
        <?php if( in_array( $category['category_id'], [4,5,6] ) === true ): ?>
            <div class="col-12 col-md-12 col-lg-8 ml-auto mb-3 my-lg-auto">
                <?php if( $this->_language == 'th' ): ?>
                    <p class="small text-right navy mr-2">* หมายเหตุ : บัตร H = บัตรประกันสุขภาพ, บัตร HP = บัตรประกันสุขภาพพิเศษ, บัตร HPT = บัตรประกันสุขภาพพิเศษสำหรับผู้สูงอายุ</p>
                    <p class="small text-right navy mr-2">** หมายเหตุ : I = ผู้ป่วยใน (IPD / In-Patient Department), O = ผู้ป่วยนอก (OPD / Out-Patient Department)</p>
                <?php else: ?>
                    <p class="small text-right navy mr-2">* Note : H Card = Health Insurance Card, HP Card = Health Insurance Card (Special), HPT Card = Health Insurance Card (Special for Elderly)</p>
                    <p class="small text-right navy mr-2">** Note : I = Inpatient (IPD / In-Patient Department), O = Outpatient (OPD / Out-Patient Department)</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        */ ?>
    </div>
    <div class="p-3 py-lg-2 d-flex flex-wrap">
        <h5 class="navy bold mb-3 mb-lg-0 mx-auto ml-lg-0">เครือข่ายบริการสินไหมทดแทน : <?php echo $category['category_title_'.$this->_language]; ?></h5>
        <?php /*
        <h5 class="white mx-auto mr-lg-0">The Navakij Insurance Public Company Limited</h5>
        */ ?>
    </div>
    <div class="table-responsive p-3">

        <?php if( in_array( $category['category_id'], [4,5,6] ) === true ): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">ชื่อ<?php echo $category['category_title_'.$this->_language]; ?></p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">ที่อยู่</p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">เขต/อำเภอ</p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">บัตร*</p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">IPD/OPD**</p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">เบอร์โทรศัพท์</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if( isset( $branches ) && count( $branches ) > 0 ): ?>
                        <?php foreach( $branches as $branch ): ?>
                            <tr>
                                <td colspan="6" class="p-0">
                                    <p class="white py-2 px-3 bg-navy"><?php echo $branch['province_name']; ?></p>
                                </td>
                            </tr>
                            <?php if( isset( $branch['branches'] ) && count( $branch['branches'] ) > 0 ): ?>
                                <?php foreach( $branch['branches'] as $list ): ?>
                                    <tr>
                                        <td><p><?php echo $list['branch_title_'.$this->_language]; ?></p></td>
                                        <td><p><?php echo $list['branch_address']; ?></p></td>
                                        <td><p class="text-center"><?php echo ( $this->_language == 'th' ? $list['name'] : $list['name_alt'] ); ?></p></td>
                                        <td><p class="text-center"><?php echo $list['card']; ?></p></td>
                                        <td><p class="text-center"><?php echo $list['patient_department']; ?></p></td>
                                        <td><p class="text-center"><?php echo $list['branch_tel']; ?></p></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4"><p class="text-center">-- ไม่มีข้อมูล --</p></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">ชื่อ<?php echo $category['category_title_'.$this->_language]; ?></p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">ที่อยู่</p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">เขต/อำเภอ</p>
                        </th>
                        <th class="bg-lightgrey">
                            <p class="bold text-center">เบอร์โทรศัพท์</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if( isset( $branches ) && count( $branches ) > 0 ): ?>
                        <?php foreach( $branches as $branch ): ?>
                            <tr>
                                <td colspan="4" class="p-0">
                                    <p class="white py-2 px-3 bg-navy"><?php echo $branch['province_name']; ?></p>
                                </td>
                            </tr>
                            <?php if( isset( $branch['branches'] ) && count( $branch['branches'] ) > 0 ): ?>
                                <?php foreach( $branch['branches'] as $list ): ?>
                                    <tr>
                                        <td><p><?php echo $list['branch_title_'.$this->_language]; ?></p></td>
                                        <td><p><?php echo $list['branch_address']; ?></p></td>
                                        <td><p class="text-center"><?php echo ( $this->_language == 'th' ? $list['name'] : $list['name_alt'] ); ?></p></td>
                                        <td><p class="text-center"><?php echo $list['branch_tel']; ?></p></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4"><p class="text-center">-- ไม่มีข้อมูล --</p></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php if( in_array( $category['category_id'], [4,5,6] ) === true ): ?>
        <div class="d-flex flex-wrap mb-3">
            <?php if( $this->_language == 'th' ): ?>
                <p class="col-12 small text-right navy mr-3">* หมายเหตุ : H = บัตร NKI HEALTH INSURANCE, P = บัตร NKI PA CARD</p>
                <p class="col-12 small text-right navy mr-3">** หมายเหตุ : I = ผู้ป่วยใน (IPD / In-Patient Department), O = ผู้ป่วยนอก (OPD / Out-Patient Department)</p>
            <?php else: ?>
                <p class="col-12 small text-right navy mr-3">* Note : H = NKI HEALTH INSURANCE CARD, P = NKI PA CARD</p>
                <p class="col-12 small text-right navy ml-3">** Note : I = Inpatient (IPD / In-Patient Department), O = Outpatient (OPD / Out-Patient Department)</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>
<?php /* #container - End */ ?>

</body>
</html>