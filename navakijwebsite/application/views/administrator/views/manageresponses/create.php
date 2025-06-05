<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มรายการ Call out</h4>
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
					<label class="control-label" for="response_image">รูปภาพ * : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="response_image" id="response_image" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb)</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="response_title_th">หัวข้อ (ไทย) * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="response_title_th" id="response_title_th" value="<?php echo set_value('response_title_th'); ?>" />
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="response_title_en">หัวข้อ (En) : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="response_title_en" id="response_title_en" value="<?php echo set_value('response_title_en'); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="response_caption_th">แคปชัน (ไทย) : </label>
					<div class="controls">
						<textarea name="response_caption_th" id="response_caption_th" rows="5" class="span6 ckeditor"><?php echo set_value('response_caption_th'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="response_caption_en">แคปชัน (En) : </label>
					<div class="controls">
						<textarea name="response_caption_en" id="response_caption_en" rows="5" class="span6 ckeditor"><?php echo set_value('response_caption_en'); ?></textarea>
					</div>
				</div>

                <div class="control-group">    
                    <label class="control-label">ปุ่มที่ 1 : </label>
                    <div class="controls">
                        <input type="text" name="response_button_1_url" id="response_button_1_url" value="<?php echo set_value('response_button_1_url'); ?>" class="span4" placeholder="URL" /><br />
                        <br />
                        <input type="text" name="response_button_1_label_th" id="response_button_1_label_th" value="<?php echo set_value('response_button_1_label_th'); ?>" placeholder="ข้อความบนปุ่มภาษาไทย" class="span2" maxlength="30" />
                        <input type="text" name="response_button_1_label_en" id="response_button_1_label_en" value="<?php echo set_value('response_button_1_label_en'); ?>" placeholder="ข้อความบนปุ่มภาษาอังกฤษ" class="span2" maxlength="30" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="response_button_2_url">ปุ่มที่ 2 : </label>
                    <div class="controls">
                        <input type="text" name="response_button_2_url" id="response_button_2_url" value="<?php echo set_value('response_button_2_url'); ?>" class="span4" placeholder="URL" /><br />
                        <br />
                        <input type="text" name="response_button_2_label_th" id="response_button_2_label_th" value="<?php echo set_value('response_button_2_label_th'); ?>" placeholder="ข้อความบนปุ่มภาษาไทย" class="span2" maxlength="30" />
                        <input type="text" name="response_button_2_label_en" id="response_button_2_label_en" value="<?php echo set_value('response_button_2_label_en'); ?>" placeholder="ข้อความบนปุ่มภาษาอังกฤษ" class="span2" maxlength="30" />
                    </div>
                </div>
				
				<div class="control-group">
					<label class="control-label" for="response_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="response_status" id="response_status">
							<option value="approved" <?php echo set_select('response_status','approved', TRUE); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('response_status','pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageresponses/index"); ?>"><i class="icon-save"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('body').on('change','#article_id', function(){
		var id = $(this).val();
		if( id == 9999 ){
			$('#url_other').slideDown('fast');
		}else{
			$('#url_other').find('input[name="response_url"]').val('');
			$('#url_other').slideUp('fast');
		}
	});
});
</script>