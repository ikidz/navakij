	
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<?php
					$info = $this->admin_model->get_companyinfo();
					if( $info['company_logo']!='' && is_file( UPLOAD_PATH.'/system_company_logo/'.$info['company_logo'] ) ):
						?>
						<a class="brand" href="<?php echo admin_url(); ?>">
							<img src="<?php echo site_url( 'public/core/uploaded/system_company_logo/'.$info['company_logo'] ); ?>" alt="logo" class="center" /> 
						</a>
						<?php
					endif;
				?>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="arrow"></span>
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->				
				<div class="top-nav">
					<!-- BEGIN QUICK SEARCH FORM -->
					<?php /*?><form class="navbar-search hidden-phone">
						<div class="search-input-icon">
							<input type="text" class="search-query dropdown-toggle" id="quick_search" placeholder="Search" data-toggle="dropdown" />
							<i class="icon-search"></i>
							<!-- BEGIN QUICK SEARCH RESULT PREVIEW -->
							<ul class="dropdown-menu extended">								
								<li>
									<span class="arrow"></span>
									<p>Found <span class="result_count">0</span> results</p>
								</li>
							</ul>
							<!-- END QUICK SEARCH RESULT PREVIEW -->
						</div>
					</form><?php */?>
					<!-- END QUICK SEARCH FORM -->
					<!-- BEGIN TOP NAVIGATION MENU -->					
					<ul class="nav pull-right" id="top_menu">
                    	<!-- BEGIN NOTIFICATION DROPDOWN -->	
						<!--<li class="dropdown" id="header_notification_inbox">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-envelope"></i>
							<span class="label label-info notif_badge">0</span> 
							</a>
							<ul class="dropdown-menu extended notification">
								<li>
									<p>You have <span class="notification_count">0</span> new notifications</p>
								</li>
							</ul>
						</li>-->
						<!-- BEGIN NOTIFICATION DROPDOWN -->	
						<?php /*?><li class="dropdown" id="header_notification_feed">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-globe"></i>
							<span class="label label-info notif_badge">0</span>
							</a>
							<ul class="dropdown-menu extended notification">
								<li>
									<p>You have <span class="notification_count">0</span> new notifications</p>
								</li>
							</ul>
						</li><?php */?>
						<!-- END NOTIFICATION DROPDOWN -->
						<!-- BEGIN INBOX DROPDOWN -->
						<?php /*?><li class="dropdown" id="header_notification_comment">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-comment"></i>
							<span class="label label-success notif_badge">0</span>
							</a>
							<ul class="dropdown-menu extended inbox">
								<li>
									<p>You have <span class="notification_count">0</span> new comments</p>
								</li>
							</ul>
						</li><?php */?>
						<?php /*?><!-- END INBOX DROPDOWN -->
						<li class="divider-vertical hidden-phone hidden-tablet"></li>
						<!-- BEGIN USER LOGIN DROPDOWN -->
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-wrench"></i>
							<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="javascript:;"><i class="icon-cogs"></i> System Settings</a></li>
								<li><a href="javascript:;"><i class="icon-pushpin"></i> Shortcuts</a></li>
								<li><a href="javascript:;"><i class="icon-trash"></i> Trash</a></li>								
							</ul>
						</li>
						<!-- END USER LOGIN DROPDOWN --><?php */?>
						<li class="divider-vertical hidden-phone hidden-tablet"></li>
						<!-- BEGIN USER LOGIN DROPDOWN -->
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<?php if($user_info['user_avatar'] != ""){ ?>
					    	<img src="<?php echo site_url("src/15x15/user_admin/".$user_info['user_avatar']); ?>" />
					    	<?php }else{ ?>
						    <i class="icon-user"></i>
						    <?php } ?>
							<?php echo $user_info['user_fullname']; ?>
							<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo admin_url("user_profile"); ?>"><i class="icon-github-square"></i> ข้อมูลส่วนตัว</a></li>
								<li><a href="<?php echo site_url(); ?>" target="_blank"><i class=" icon-home"></i> ไปยังหน้าแรกเว็บไซต์</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo admin_url("logout"); ?>" class="force_redirect"><i class="icon-sign-out"></i> ออกจากระบบ</a></li>
							</ul>
						</li>
						<!-- END USER LOGIN DROPDOWN -->
					</ul>
					<!-- END TOP NAVIGATION MENU -->	
				</div>
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	