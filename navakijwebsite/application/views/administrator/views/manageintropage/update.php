<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไข Popup Special Day ใหม่</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="control-group">
					<label class="control-label" for="intro_type">ประเภทของมีเดีย * : </label>
					<div class="controls">
						<select class="span6 chosen" id="intro_type" name="intro_type" tabindex="1">
							<option value="image" <?php echo set_select('intro_type', 'image', $info['intro_type'] == 'image'); ?>>Image</option>
							<option value="youtube" <?php echo set_select('intro_type', 'youtube', $info['intro_type'] == 'youtube'); ?>>YouTube</option>
						</select>
					</div>
				</div>

				<div id="type-image" class="control-group" <?php echo ( $info['intro_type'] == 'image' || $this->input->post('intro_type') == 'image' ? '' : 'style="display:none;"' ); ?>>
					<label class="control-label" for="intro_value">รูปภาพ * : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['intro_value'] != '' && is_file( realpath('public/core/uploaded/intro/'.$info['intro_value']) ) === true ): ?>
								<a href="<?php echo base_url('public/core/uploaded/intro/'.$info['intro_value']); ?>" class="fancybox-button">
									<img src="<?php echo base_url('public/core/uploaded/intro/'.$info['intro_value']); ?>" alt="" style="width:250px;" />
								</a>
							<?php endif; ?>
						</div>
						<input type="file" name="intro_value" id="intro_value" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb)</span>
					</div>
				</div>

				<div id="type-youtube" class="control-group" <?php echo ( $info['intro_type'] == 'youtube' || $this->input->post('intro_type') == 'youtube' ? '' : 'style="display:none;"' ); ?>>
					<label class="control-label" for="intro_value">YouTube ID * : </label>
					<div class="controls">
						https://www.youtube.com/watch?v=<input type="text" class="span2" name="intro_value" id="intro_value" placeholder="Youtube ID *" value="<?php echo set_value('intro_value', $info['intro_value']); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="intro_url">URL : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-link"></i></span>
							<input type="text" class="input-large" name="intro_url" id="intro_url" placeholder="URL" value="<?php echo set_value('intro_url', $info['intro_url']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="intro_title">ชื่อ Popup * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="intro_title" id="intro_title" placeholder="ชื่อ Popup" value="<?php echo set_value('intro_title', $info['intro_title']); ?>" />
						</div>
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="intro_start_date">วันที่เริ่ม : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="intro_start_date" id="intro_start_date" value="<?php echo set_value('intro_start_date', date( "d-m-Y", strtotime( $info['intro_start_date'] ) )); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('intro_start_date'); ?>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="intro_end_date">วันที่สิ้นสุด : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="intro_end_date" id="intro_end_date" value="<?php echo set_value('intro_end_date', date( "d-m-Y", strtotime( ( $info['intro_end_date'] != null ? $info['intro_end_date'] : '+1 year' ) ) )); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
							<a href="javascript:void(0);" id="btnClearDate" class="btn btn-inverse">ล้างข้อมูลวันทีสิ้นสุด</a>
                        </div>
                        <?php echo form_error('intro_end_date'); ?>
                    </div>
                </div>
				
				<div class="control-group">
					<label class="control-label" for="intro_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="intro_status" id="intro_status">
							<option value="approved" <?php echo set_select('intro_status','approved', $info['intro_status'] == 'approved'); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('intro_status','pending', $info['intro_status'] == 'pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageintropage/index"); ?>"><i class="icon-save"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('body').on('change','#intro_type', function(){
		var type = $(this).val();
		if( type == 'youtube' ){
			$('#type-youtube').slideDown('fast');
			$('#type-image').slideUp('fast');
		}else{
			$('#type-youtube').slideUp('fast');
			$('#type-image').slideDown('fast');
		}
	});
});
</script>