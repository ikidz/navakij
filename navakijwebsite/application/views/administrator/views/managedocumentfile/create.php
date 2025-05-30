<div class="span12" style="margin:0! important;">
	<div class="widget">
		<div class="widget-title">
			<h4>
				<i class="icon-plus"></i> เพิ่มไฟล์
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
            <form method="post" enctype="multipart/form-data" id="uploadForm" action="<?php echo admin_url('managedocumentfile/uploadFiles/'.$document['document_id']); ?>" class="form-horizontal form-inline">
            
                <div class="control-group">
					<label class="control-label" for="document_file_th">ไฟล์ (ไทย) : </label>
					<div class="controls">
                        <input type="file" id="document_file_th" name="document_file_th">
						<label class="help-inline">* รองรับไฟล์นามสกุล pdf|doc|docx|xlsx|xls|zip เท่านั้น และไฟล์ต้องมีขนาดความจุ (Size) ไม่เกิน 100 เมกะไบต์ (Mb)</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="document_file_en">ไฟล์ (En) : </label>
					<div class="controls">
                        <input type="file" id="document_file_en" name="document_file_en">
						<label class="help-inline">* รองรับไฟล์นามสกุล pdf|doc|docx|xlsx|xls|zip เท่านั้น และไฟล์ต้องมีขนาดความจุ (Size) ไม่เกิน 100 เมกะไบต์ (Mb)</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="document_file_title_th">ชื่อเรื่อง (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="document_file_title_th" id="document_file_title_th" value="<?php echo set_value('document_file_title_th'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_file_title_en">ชื่อเรื่อง (En) : *</label>
					<div class="controls">
						<input type="text" name="document_file_title_en" id="document_file_title_en" value="<?php echo set_value('document_file_title_en'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_file_desc_th">หมายเหตุ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="document_file_desc_th" id="document_file_desc_th" value="<?php echo set_value('document_file_desc_th'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_file_desc_en">หมายเหตุ (En) : </label>
					<div class="controls">
						<input type="text" name="document_file_desc_en" id="document_file_desc_en" value="<?php echo set_value('document_file_desc_en'); ?>" class="span6" />
					</div>
				</div>
                
                <div class="form-actions" style="text-align:center;">
					<button type="submit" class="btn btn-success" id="btn-submit"><i class="icon-upload"></i> บันทึก</button>
				 	<a class="btn btn-danger" href="<?php echo admin_url("managedocumentfile/index/".$document['document_id']); ?>"><i class="icon-times"></i> ยกเลิก</a>
				 	<a class="btn btn-primary" href="<?php echo admin_url("managedocuments/index/".$document['category_id']); ?>"><i class="icon-undo"></i> กลับไปยังรายการเอกสาร</a>
				</div>
				
			</form>
		</div>
	</div>
</div>