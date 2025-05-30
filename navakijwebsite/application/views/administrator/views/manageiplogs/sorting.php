<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4>
				<i class="icon-cogs"></i> ค้นหา
				<?php echo ($this->input->get('sort_keyword')!='')?'ด้วย "'.$this->input->get('sort_keyword').'"':''; ?>
				<?php echo ($this->input->get('sort_start_date')!='')?'ช่วงวันที่ '.$this->input->get('sort_start_date').' ถึงวันที่ '.$this->input->get('sort_end_date'):''; ?>
			</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<form method="get" action="<?php echo admin_url('manageiplogs/index'); ?>" enctype="multipart/form-data" id="sortform" class="form-horizontal form-inline">

				<div class="control-group">
					<label class="control-label" for="sort_keyword">คีย์เวิร์ด : </label>
					<div class="controls">
						<input type="text" class="span10" name="sort_keyword" id="sort_keyword" placeholder="ค้นหาจาก IP, HASH" value="<?php echo set_value('sort_keyword', $this->input->get('sort_keyword')); ?>" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="sort_start_date">ค้นหาจากช่วงวันที่ : </label>
					<div class="controls">
						<div class="input-append date date-picker" data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
							<input class="input-small date-picker" id="sort_start_date" name="sort_start_date" size="16" type="text" value="<?php echo set_value('sort_start_date', $this->input->get('sort_start_date')); ?>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						ถึงวันที่
						<div class="input-append date date-picker" data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
							<input class="input-small date-picker" id="sort_end_date" name="sort_end_date" size="16" type="text" value="<?php echo set_value('sort_end_date', $this->input->get('sort_end_date')); ?>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>
				</div>

                <div class="control-group">
                    <label class="control-label" for="sort_onlythai">เลือกดูเฉพาะประเทศไทย : </label>
                    <div class="controls">
                        <input type="checkbox" name="sort_onlythai" value="1" <?php echo set_checkbox('sort_onlythai', 1, $aSort['sort_onlythai'] == 1); ?> />
                    </div>
                </div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-primary" id="btn-submit"><i class="icon-search"></i> ค้นหา</button>
				 	<a class="btn" href="<?php echo admin_url("manageiplogs/index/"); ?>"><i class="icon-list"></i> ดูทั้งหมด</a>
				 	<button type="button" class="btn btn-success" id="btn-export"><i class="icon-download"></i> ส่งออกไปยัง Excels</button>
				</div>
				
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#btn-export').click(function(){
		$('#sortform').attr('action', '<?php echo admin_url('manageiplogs/exportiplogs/'); ?>');
		$('#sortform').submit();
		$('#sortform').removeAttr('action');
	});
});
</script>