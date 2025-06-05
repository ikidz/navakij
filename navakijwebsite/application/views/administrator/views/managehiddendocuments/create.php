<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มรายการเอกสารซ่อน</h4>
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
					<label class="control-label" for="document_file">ไฟล์ (ไทย) :</label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="document_file" id="document_file" />
						<label class="help-inline">* รองรับไฟล์นามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และไฟล์ต้องมีขนาดความจุ (Size) ไม่เกิน 100 เมกะไบต์ (Mb)</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_file_en">ไฟล์ (En) :</label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="document_file_en" id="document_file_en" />
						<label class="help-inline">* รองรับไฟล์นามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และไฟล์ต้องมีขนาดความจุ (Size) ไม่เกิน 100 เมกะไบต์ (Mb)</label>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="document_title_th">ชื่อเรื่อง (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="document_title_th" id="document_title_th" value="<?php echo set_value('document_title_th'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_title_en">ชื่อเรื่อง (En) : *</label>
					<div class="controls">
						<input type="text" name="document_title_en" id="document_title_en" value="<?php echo set_value('document_title_en'); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="document_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="document_status" id="document_status">
							<option value="approved" <?php echo set_select('document_status','approved', true); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('document_status','pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managehiddendocuments/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	var category_meta_title = '<?php echo $category['category_meta_url']; ?>';
	
	/* Auto Generate Meta Tag Title (en) - Start */
	$('body').on('keyup','#document_title_en', function(){
		if($(this).val()!=''){
			var url = ToSeoUrl( $(this).val() );
			$('#document_meta_url').val( category_meta_title+'/'+url );
		}else{
			$('#document_meta_url').val('');
		}
	});
	/* Auto Generate Meta Tag Title (en) - End */

	/* #document_type handler - Start */
	$('body').on('change','#document_type', function(){
		if( $(this).val() == 'multi' ){
			$('#single-files').slideUp('fast');
		}else{
			$('#single-files').slideDown('fast');
		}
	});
	/* #document_type handler - End */
});
</script>