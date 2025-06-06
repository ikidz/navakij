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
    <div class="col-4 col-md-2 col-lg-1 py-3 mx-auto text-center">
        <a href="<?php echo site_url(''); ?>">
            <img src="<?php echo assets_url('img/logo.png'); ?>" alt="" class="img-fullwidth" />
        </a>
    </div>
    <div class="bg-navy p-3 py-lg-2 d-flex flex-wrap">
        <h5 class="white mb-3 mb-lg-0 mx-auto ml-lg-0">เครือข่ายบริการสินไหมฯ : <?php echo $category['category_title_'.$this->_language]; ?></h5>
        <h5 class="white mx-auto mr-lg-0">The Navakij Insurance Public Company Limited</h5>
    </div>
    <div class="table-responsive p-3">
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
    </div>

</div>
<?php /* #container - End */ ?>

</body>
</html>