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

<?php /* Favicons - Start */ ?>
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo assets_url('favicons/apple-icon-57x57.png'); ?>">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo assets_url('favicons/apple-icon-60x60.png'); ?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo assets_url('favicons/apple-icon-72x72.png'); ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo assets_url('favicons/apple-icon-76x76.png'); ?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo assets_url('favicons/apple-icon-114x114.png'); ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo assets_url('favicons/apple-icon-120x120.png'); ?>">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo assets_url('favicons/apple-icon-144x144.png'); ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo assets_url('favicons/apple-icon-152x152.png'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo assets_url('favicons/apple-icon-180x180.png'); ?>">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo assets_url('favicons/android-icon-192x192.png'); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo assets_url('favicons/favicon-32x32.png'); ?>">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo assets_url('favicons/favicon-96x96.png'); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo assets_url('favicons/favicon-16x16.png'); ?>">
<link rel="manifest" href="<?php echo assets_url('favicons/manifest.json'); ?>">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo assets_url('favicons/ms-icon-144x144.png'); ?>">
<meta name="theme-color" content="#ffffff">
<?php /* Favicons - End */ ?>

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
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/style.css?v=2.0'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/responsive.css?v=1.8'); ?>" />
<?php /* Stylesheets - End */ ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<?php $analytics = $this->mainmodel->get_web_setting( 'marketing_tags' ); ?>
<?php if( isset( $analytics ) && count( $analytics ) > 0 ): ?>
    <?php echo $analytics['setting_value']; ?>
<?php endif; ?>

<?php /* #container - Start */ ?>
<div id="container" class="container-fluid px-0">