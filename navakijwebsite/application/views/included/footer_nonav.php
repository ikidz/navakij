<?php /* Javascripts - Start */ ?>
<script type="text/javascript">
    var base_url = '<?php echo base_url(''); ?>';
    var language = '<?php echo $this->_language; ?>';
</script>
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=60348e9f317d2200110fb4ee&product=sop' async='async'></script>
<script type="text/javascript" src="<?php echo assets_url('js/jquery-3.4.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('js/jquery-migrate-1.4.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('lazyload/jquery.lazyload.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('select2/js/select2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('slick/slick/slick.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('fancybox/jquery.fancybox.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('isotope/isotope.pkgd.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('isotope/imagesloaded.pkgd.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('lazyload/jquery.lazyload.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('sweetalert2/sweetalert2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('js/function.js?v=1'); ?>"></script>
<script type="text/javascript">

    $(document).ready(function(){
        <?php $introPopup = $this->mainmodel->get_intro(); ?>
        <?php if( isset( $introPopup ) && count( $introPopup ) > 0 ): ?>
            /* #introPopup trigger - Start */
            $('#introPopup').trigger('click');
            /* #introPopup trigger - End */
        <?php endif; ?>

        $('body').on('click','#btnAcceptPolicy', function(){
            var target = $(this);
            var targetParent = target.parents('#cookies');
            $.get( '<?php echo base_url($this->_language . '/api/acceptCookies'); ?>', function(response){
                var res = JSON.parse( response );
                console.log( response );
                if( res.status == 200 ){
                    targetParent.fadeOut('fast');
                }
            });
        });
        $('body').on('click','#cookies .btnClose, #cookies #btnDeclinePolicy', function(){
            var target = $(this);
            var targetParent = target.parents('#cookies');
            targetParent.fadeOut('fast');
        });
    });

    <?php $success = $this->session->flashdata("message-success"); ?>
    <?php if($success): ?>
        swalMessage('message-success', '<?php echo ( $this->_language == 'th' ? 'สำเร็จ!' : 'Success!' ); ?>', '<?php echo $success; ?>' );
    <?php endif; ?>
    
    <?php $info = $this->session->flashdata("message-info"); ?>
    <?php if($info): ?>
        swalMessage('message-info', '<?php echo ( $this->_language == 'th' ? 'กรุณาอ่าน' : 'Please, noted.' ); ?>', '<?php echo $info; ?>' );
    <?php endif; ?>
    
    <?php $error = $this->session->flashdata("message-error"); ?>
    <?php if($error): ?>
        swalMessage('message-error', '<?php echo ( $this->_language == 'th' ? 'เกิดข้อผิดพลาด!' : 'Something wrong!' ); ?>', '<?php echo $error; ?>' );
    <?php endif; ?>

    <?php $warning = $this->session->flashdata("message-warning"); ?>
    <?php if($warning): ?>
        swalMessage('message-warning', '<?php echo ( $this->_language == 'th' ? 'คำเตือน!' : 'Warning!' ); ?>', '<?php echo $warning; ?>' );
    <?php endif; ?>
    
</script>
<?php /* Javascripts - End */ ?>

<?php /* Facebook chat plugin - Start */ ?>
<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0'
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/th_TH/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>

      <!-- Your Chat plugin code -->
      <div class="fb-customerchat"
        attribution="page_inbox"
        page_id="187249974717764">
      </div>
<?php /* Facebook chat plugin - Start */ ?>

</body>
</html>