<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มรายการเอกสาร</h4>
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
                    <label class="control-label" for="document_thumbnail">รูปภาพ :</label>
                    <div class="controls">
                        <div class="preview"></div>
                        <input type="file" name="document_thumbnail" id="document_thumbnail" class="readfile" />
                        <label class="help-inline">* รองรับไฟล์นามสกุล .jpg, .png, .gif เท่านั้น และไฟล์ต้องมีขนาดความจุ (Size) ไม่เกิน 2 เมกะไบต์ (Mb)</label>
                    </div>
                </div>

				<div class="control-group">
					<label class="control-label" for="document_type">ประเภทของไฟล์ : *</label>
					<div class="controls">
						<select id="document_type" name="document_type">
							<option value="single" <?php echo set_select('document_type','single', true); ?>>ไฟล์เดี่ยว</option>
							<option value="multi" <?php echo set_select('document_type','multi'); ?>>หลายไฟล์</option>
							<option value="link" <?php echo set_select('document_type','link'); ?>>ลิงก์ URL</option>
						</select>
					</div>
				</div>

				<div id="single-files" style="margin-bottom:1rem;">
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
				</div>

				<div id="link" style="display:none; margin-bottom:1rem;">
					<div class="control-group">
						<label class="control-label" for="document_url_th">URL (ไทย) : *</label>
						<div class="controls">
							<input type="text" name="document_url_th" id="document_url_th" value="<?php echo set_value('document_url_th'); ?>" class="span12" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="document_url_en">URL (En) : *</label>
						<div class="controls">
							<input type="text" name="document_url_en" id="document_url_en" value="<?php echo set_value('document_url_en'); ?>" class="span12" />
						</div>
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
					<label class="control-label" for="document_desc_th">หมายเหตุ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="document_desc_th" id="document_desc_th" value="<?php echo set_value('document_desc_th'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_desc_en">หมายเหตุ (En) : </label>
					<div class="controls">
						<input type="text" name="document_desc_en" id="document_desc_en" value="<?php echo set_value('document_desc_en'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="document_publish_date">วันที่โพสต์ : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="document_publish_date" id="document_publish_date" value="<?php echo set_value('document_publish_date', date("d-m-Y")); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('document_publish_date'); ?>
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="document_meta_title">Title สำหรับ SEO :</label>
					<div class="controls">
						<input type="text" name="document_meta_title" id="document_meta_title" value="<?php echo set_value('document_meta_title'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_meta_description">Description สำหรับ SEO : </label>
					<div class="controls">
						<textarea name="document_meta_description" id="document_meta_description" rows="5" class="span6" style="resize:none;"><?php echo set_value('document_meta_description'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_meta_keywords">Keyword สำหรับ SEO :</label>
					<div class="controls">
						<input type="text" name="document_meta_keywords" id="document_meta_keywords" value="<?php echo set_value('document_meta_keywords'); ?>" class="span6" />
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
                    <input type="hidden" name="category_id" id="category_id" value="<?php echo $category['category_id']; ?>" />
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managedocuments/index/".$category['category_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
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
			$('#link').slideUp('fast');
		}else if( $(this).val() == 'link' ){
			$('#single-files').slideUp('fast');
			$('#link').slideDown('fast');
		}else{
			$('#single-files').slideDown('fast');
			$('#link').slideUp('fast');
		}
	});
	/* #document_type handler - End */
});
</script>