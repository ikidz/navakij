<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4>
				<i class="icon-cogs"></i> ค้นหา
				<?php echo ($this->input->post('sort_keyword')!='')?'ด้วย "'.$this->input->post('sort_keyword').'"':''; ?>
				<?php echo ($this->input->post('sort_start_date')!='')?'ช่วงวันที่ '.$this->input->post('sort_start_date').' ถึงวันที่ '.$this->input->post('sort_end_date'):''; ?>
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
			<form method="get" enctype="multipart/form-data" id="sortform" class="form-horizontal form-inline" action="<?php echo admin_url('applicantsreport/index'); ?>">

				<div class="control-group">
					<label class="control-label" for="sort_keywords">คีย์เวิร์ด : </label>
					<div class="controls">
						<input type="text" class="span10" name="sort_keywords" id="sort_keywords" placeholder="ค้นหาจาก ชื่อ​ นามสกุล อีเมล เบอร์โทรศัพท์" value="<?php echo set_value('sort_keywords', $this->input->get('sort_keywords')); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="sort_location_id">สถานที่ปฏิบัติงาน : </label>
					<div class="controls">
						<select name="sort_location_id" id="sort_location_id">
							<option value="" <?php echo set_select('sort_location_id','', true); ?>>-- ดูทั้งหมด --</option>
							<?php if( isset( $locations ) && count( $locations ) > 0 ): ?>
								<?php foreach( $locations as $location ): ?>
									<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('sort_location_id', $location['location_id'], $this->input->get('sort_location_id') == $location['location_id']); ?>><?php echo $location['location_title_th']; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="sort_job_id">ตำแหน่งงาน : </label>
					<div class="controls">
						<select name="sort_job_id" id="sort_job_id">
							<option value="" <?php echo set_select('sort_job_id','', true); ?>>-- ดูทั้งหมด --</option>
							<?php if( isset( $jobs ) && count( $jobs ) > 0 ): ?>
								<?php foreach( $jobs as $job ): ?>
									<option value="<?php echo $job['job_id']; ?>" <?php echo set_select('sort_job_id', $job['job_id'], $this->input->get('sort_job_id') == $job['job_id']); ?>><?php echo $job['job_title_th']; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
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
				
				<div class="form-actions">
					<button type="submit" class="btn btn-primary" id="btn-submit"><i class="icon-search"></i> ค้นหา</button>
				 	<a class="btn" href="<?php echo admin_url("applicantsreport/index/"); ?>"><i class="icon-list"></i> ดูทั้งหมด</a>
				 	<button type="button" class="btn btn-success" id="btn-export"><i class="icon-download"></i> ส่งออกไปยัง Excels</button>
				</div>
				
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#btn-export').click(function(){
		$('#sortform').attr('action', '<?php echo site_url('administrator/applicantsreport/export', false); ?>');
		$('#sortform').submit();
		$('#sortform').removeAttr('action');
	});
});
</script>