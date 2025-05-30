		
			<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
			<div class="navbar-inverse">
				<form class="navbar-search visible-phone">
					<input type="text" class="search-query" placeholder="Search" />
				</form>
			</div>
			<!-- END RESPONSIVE QUICK SEARCH FORM -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul>
            	<?php foreach($menu_entry as $rs){ ?>
                <?php if( isset( $rs ) && count( $rs ) > 0 ){ ?>
					<li class="has-sub <?php echo $rs['active']; ?>">
						<a href="javascript:;" class="<?php echo $rs['active']; ?>">
							<i class="<?php echo $rs['icon']; ?>"></i> <?php echo $rs['label']; ?>
							<span class="arrow"></span>
						</a>
						<?php if( isset( $rs['submenu_entry'] ) ): ?>
							<ul class="sub">
								<?php foreach($rs['submenu_entry'] as $submenu){ ?>
									<?php if( @$submenu['link'] != '' ): ?>
										<li class="<?php echo $submenu['active']; ?>">
											<a href="<?php echo $submenu['link']; ?>">
												<i class="<?php echo $submenu['icon']; ?>"></i> 
												<?php echo $submenu['label']; ?>
											</a>
										</li>
									<?php endif; ?>
								<?php } ?>
							</ul>
						<?php endif; ?>
					</li>
                <?php }else{ ?>
				<li class="<?php echo $rs['active']; ?>">
					<a href="<?php echo $rs['link']; ?>">
					<i class="<?php echo $rs['icon']; ?>"></i> <?php echo $rs['label']; ?>
					</a>					
				</li>
             	<?php } ?>
				<?php } ?>
                
			</ul>
			<!-- END SIDEBAR MENU -->