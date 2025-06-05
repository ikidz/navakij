				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid"> 
					<div class="span12">	
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->		
						<h3 class="page-title">
                        	{if $navi_icon != NULL}<i class="{$navi_icon}"></i>{/if} 
							{if $navi_title != NULL}{$navi_title}{/if}
                            {if isset($page_detail)}
							<small>{$page_detail}</small>
                            {/if}
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="<?php echo admin_url(); ?>"><?php echo $this->admin_library->getCompanyName(); ?></a> 
							</li>
                            
                           <?php foreach($this->admin_library->breadcrumb() as $breadcrumb){ ?>
							<li>
                            	<span class="divider">/</span>
                                <i class="<?php echo $breadcrumb['menu_icon']; ?>"></i>
                                <a href="<?php echo $breadcrumb['menu_link']; ?>"><?php echo $breadcrumb['menu_label']; ?></a>
                            </li>
							<?php } ?>
                            {if count($toolbar) != 0}
                            	{foreach $toolbar as $seq=>$tool}
                                <li class="pull-right">
                                {$tool}
                                </li>
                                {/foreach}
                            {/if}
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->