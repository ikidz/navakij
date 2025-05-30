<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4>
				<i class="icon-cogs"></i> ค้นหา
				<?php echo ($this->input->get('sort_keyword')!='')?'ด้วย "'.$this->input->get('sort_keyword').'"':''; ?>
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
			<form method="get" action="<?php echo admin_url('manageboardmembers/index'); ?>" enctype="multipart/form-data" id="sortform" class="form-horizontal form-inline">

				<div class="control-group">
					<label class="control-label" for="sort_keyword">คีย์เวิร์ด : </label>
					<div class="controls">
						<input type="text" class="span10" name="sort_keyword" id="sort_keyword" placeholder="ชื่อ - นามสกุล, ชื่อตำแหน่ง" value="<?php echo set_value('sort_keyword', $this->input->get('sort_keyword')); ?>" />
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-primary" id="btn-submit"><i class="icon-search"></i> ค้นหา</button>
				 	<a class="btn" href="<?php echo admin_url("manageiplogs/index/"); ?>"><i class="icon-list"></i> ดูทั้งหมด</a>
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