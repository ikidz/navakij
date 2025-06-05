<!DOCTYPE HTML>
<html class="<?php echo ($this->router->fetch_class()=='')?'home':$this->router->fetch_class(); ?>_<?php echo ($this->router->fetch_method()=='')?'index':$this->router->fetch_method(); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php echo $meta_title; ?></title>

<?php /* Meta Tags - Start */ ?>
<meta name="title" content="<?php echo $meta_title; ?>">
<meta name="description" content="<?php echo $meta_description; ?>">
<meta name="keywords" content="<?php echo $meta_keyword; ?>">
<?php /* Meta Tags - End */ ?>

<?php /* OG Meta Tags - Start */ ?>
<meta property="og:type"               content="website" />
<meta property="og:url"                content="<?php echo current_url(); ?>" />
<meta property="og:title"              content="<?php echo $meta_title; ?>" />
<meta property="og:description"        content="<?php echo $meta_description; ?>" />
<meta property="og:image"              content="<?php echo $meta_image; ?>" />
<meta property="og:image:width"        content="<?php echo $meta_image_width; ?>" />
<meta property="og:image:height"       content="<?php echo $meta_image_height; ?>" />

<?php /* OG Meta Tags - End */ ?>

<?php /* Twitter Meta Tags - Start */ ?>
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo current_url(); ?>">
<meta property="twitter:title" content="navakij.co.th - <?php echo ( $meta_title != '' ? ' - '.$meta_title : '' ); ?>">
<meta property="twitter:description" content="<?php echo mb_substr( $meta_description, 0, 140, 'UTF-8' ); ?>">
<meta property="twitter:image" content="<?php echo $meta_image; ?>">
<?php /* Twitter Meta Tags - End */ ?>

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
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/animate.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/stylesheet.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/style.css?v=1.6'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/responsive.css?v=1.6'); ?>" />
<?php /* Stylesheets - End */ ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<?php $analytics = $this->mainmodel->get_web_setting( 'marketing_tags' ); ?>
<?php if( isset( $analytics ) && count( $analytics ) > 0 ): ?>
    <?php echo $analytics['setting_value']; ?>
<?php endif; ?>

<?php /* #container - Start */ ?>
<div id="container" class="container-fluid px-3 px-lg-0 bg-lightgrey">
    <div class="d-flex flex-wrap vh-100">
        <div class="col-12 col-lg-6 mx-auto align-self-center p-3 p-lg-5">
            <?php if( $info['response_image'] != '' && is_file( realpath('public/core/uploaded/responses/'.$info['response_image'])) === true ): ?>
                <p class="col-6 col-lg-2 px-3 mx-auto text-center mb-5"><img src="<?php echo base_url('public/core/uploaded/responses/'.$info['response_image']); ?>" alt="" class="img-fullwidth" /></p>
            <?php endif; ?>
            <h1 class="navy bold text-center mb-3"><?php echo $info['response_title_'.$this->_language]; ?></h1>
            <div class="caption text-center mb-5">
                <?php echo $info['response_caption_'.$this->_language]; ?>
            </div>
            <?php if( $info['response_button_1_url'] != '' || $info['response_button_2_url'] != '' ): ?>
                <p class="text-center mb-5">
                    <?php if( $info['response_button_1_url'] != '' ): ?>
                        <a href="<?php echo $info['response_button_1_url']; ?>" class="btn btn-navy mb-3 mb-lg-0"><?php echo $info['response_button_1_label_'.$this->_language]; ?></a>
                    <?php endif; ?>
                    <?php if( $info['response_button_2_url'] != '' ): ?>
                        <a href="<?php echo $info['response_button_2_url']; ?>" class="btn btn-navy mx-3"><?php echo $info['response_button_2_label_'.$this->_language]; ?></a>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
            <p class="col-6 col-lg-2 mx-auto text-center"><img src="<?php echo assets_url('img/logo.png'); ?>" alt="" class="img-fullwidth" /></p>
        </div>
    </div>
</div>
<?php /* #container - End */ ?>

</body>
</html>