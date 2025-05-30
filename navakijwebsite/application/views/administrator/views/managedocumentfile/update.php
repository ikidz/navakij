<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขไฟล์</h4>
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
                    <label class="control-label" for="document_file_th">ไฟล์ (ไทย) :</label>
                    <div class="controls">
                        <div class="preview">
							<?php if( $info['document_file_th'] != '' && is_file( realpath('public/core/uploaded/documents/files/'.$info['document_id'].'/'.$info['document_file_th']) ) === true ): ?>
								<a href="<?php echo base_url('public/core/uploaded/documents/files/'.$info['document_id'].'/'.$info['document_file_th']); ?>" target="_blank"><i class="icon-download"></i> ดาวน์โหลดไฟล์</a>
							<?php endif; ?>
						</div>
                        <input type="file" name="document_file_th" id="document_file_th" />
                        <label class="help-inline">* รองรับไฟล์นามสกุล pdf|doc|docx|xlsx|xls|zip เท่านั้น และไฟล์ต้องมีขนาดความจุ (Size) ไม่เกิน 100 เมกะไบต์ (Mb)</label>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="document_file_en">ไฟล์ (En) :</label>
                    <div class="controls">
                        <div class="preview">
							<?php if( $info['document_file_en'] != '' && is_file( realpath('public/core/uploaded/documents/files/'.$info['document_id'].'/'.$info['document_file_en']) ) === true ): ?>
								<a href="<?php echo base_url('public/core/uploaded/documents/files/'.$info['document_id'].'/'.$info['document_file_en']); ?>" target="_blank"><i class="icon-download"></i> ดาวน์โหลดไฟล์</a>
							<?php endif; ?>
						</div>
                        <input type="file" name="document_file_en" id="document_file_en" />
                        <label class="help-inline">* รองรับไฟล์นามสกุล pdf|doc|docx|xlsx|xls|zip เท่านั้น และไฟล์ต้องมีขนาดความจุ (Size) ไม่เกิน 100 เมกะไบต์ (Mb)</label>
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="document_file_title_th">ชื่อเรื่อง (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="document_file_title_th" id="document_file_title_th" value="<?php echo set_value('document_file_title_th', $info['document_file_title_th']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_file_title_en">ชื่อเรื่อง (En) : *</label>
					<div class="controls">
						<input type="text" name="document_file_title_en" id="document_file_title_en" value="<?php echo set_value('document_file_title_en', $info['document_file_title_en']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_file_desc_th">หมายเหตุ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="document_file_desc_th" id="document_file_desc_th" value="<?php echo set_value('document_file_desc_th', $info['document_file_desc_th']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="document_file_desc_en">หมายเหตุ (En) : </label>
					<div class="controls">
						<input type="text" name="document_file_desc_en" id="document_file_desc_en" value="<?php echo set_value('document_file_desc_en', $info['document_file_desc_en']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="document_file_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="document_file_status" id="document_file_status">
							<option value="approved" <?php echo set_select('document_file_status','approved', $info['document_file_status'] == 'approved' ); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('document_file_status','pending', $info['document_file_status'] == 'pending' ); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
                    <input type="hidden" name="document_file_id" id="document_file_id" value="<?php echo $info['document_file_id']; ?>" />
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managedocumentfile/index/".$info['document_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>