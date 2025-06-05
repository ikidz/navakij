
    	<!-- BEGIN SIDEBAR -->
		<div id="sidebar" class="nav-collapse collapse">
    	<?php echo $left_menu; ?>
        </div>
		<!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
		<div id="body">
        	<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
            <?php echo $navi_entry; ?>
            	<!-- BEGIN PAGE CONTENT-->
				<div id="body_entry" class="dashboard">
				<?php echo $body_entry; ?>
                </div>
                <!-- END PAGE CONTENT-->
            </div>
			<!-- END PAGE CONTAINER-->	
        </div>
        <!-- END PAGE -->
<script>
		jQuery(document).ready(function() {		
			// initiate layout and plugins
			$.AdminInit();
			
			$(".mobilephone").mask("0899999999");
			window.document.title="<?php echo $title; ?>";
			if(typeof(window.history.pushState)=="function"){
				window.history.pushState({},null,"<?php echo $current_url; ?>");
			}
		});
	</script>	