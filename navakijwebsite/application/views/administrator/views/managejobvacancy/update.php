<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขข้อมูลตำแหน่งงาน</h4>
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
					<label class="control-label" for="job_title_th">ชื่อตำแหน่งงาน (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="job_title_th" id="job_title_th" value="<?php echo set_value('job_title_th', $info['job_title_th']); ?>" class="span6" />
                        <?php echo form_error( 'job_title_th' ); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="job_title_en">ชื่อตำแหน่งงาน (En) : *</label>
					<div class="controls">
						<input type="text" name="job_title_en" id="job_title_en" value="<?php echo set_value('job_title_en', $info['job_title_en']); ?>" class="span6" />
                        <?php echo form_error( 'job_title_en' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_remark_label_th">หมายเหตุ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="job_remark_label_th" id="job_remark_label_th" value="<?php echo set_value('job_remark_label_th', $info['job_remark_label_th']); ?>" class="span6" />
                        <?php echo form_error( 'job_remark_label_th' ); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="job_remark_label_en">หมายเหตุ (En) : </label>
					<div class="controls">
						<input type="text" name="job_remark_label_en" id="job_remark_label_en" value="<?php echo set_value('job_remark_label_en', $info['job_remark_label_en']); ?>" class="span6" />
                        <?php echo form_error( 'job_remark_label_en' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_responsibility_th">หน้าที่ความรับผิดชอบ (ไทย) : *</label>
					<div class="controls">
						<textarea name="job_responsibility_th" id="job_responsibility_th" rows="5" class="ckeditor"><?php echo set_value('job_responsibility_th', $info['job_responsibility_th']); ?></textarea>
                        <?php echo form_error( 'job_responsibility_th' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_responsibility_en">หน้าที่ความรับผิดชอบ (En) : *</label>
					<div class="controls">
						<textarea name="job_responsibility_en" id="job_responsibility_en" rows="5" class="ckeditor"><?php echo set_value('job_responsibility_en', $info['job_responsibility_en']); ?></textarea>
                        <?php echo form_error( 'job_responsibility_en' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_qualification_th">คุณสมบัติ (ไทย) : *</label>
					<div class="controls">
						<textarea name="job_qualification_th" id="job_qualification_th" rows="5" class="ckeditor"><?php echo set_value('job_qualification_th', $info['job_qualification_th']); ?></textarea>
                        <?php echo form_error( 'job_qualification_th' ); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="job_qualification_en">คุณสมบัติ (En) : *</label>
					<div class="controls">
						<textarea name="job_qualification_en" id="job_qualification_en" rows="5" class="ckeditor"><?php echo set_value('job_qualification_en', $info['job_qualification_en']); ?></textarea>
                        <?php echo form_error( 'job_qualification_en' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_amount">จำนวนที่รับสมัคร : *</label>
					<div class="controls">
						<input type="text" name="job_amount" id="job_amount" value="<?php echo set_value('job_amount', $info['job_amount'], 0); ?>" />
						<span class="help-inline">หากไม่มีให้ใส่ 0 </span>
                        <?php echo form_error( 'job_amount' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="is_appliable">เปิดรับสมัคร : </label>
					<div class="controls">
						<input type="checkbox" name="is_appliable" id="is_appliable" value="1" <?php echo set_checkbox('is_appliable', 1, $info['is_appliable'] == 1); ?> /> เปิดใช้
                        <?php echo form_error( 'is_appliable' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="is_profile_leaving">เปิดรับฝากประวัติ : </label>
					<div class="controls">
						<input type="checkbox" name="is_profile_leaving" id="is_profile_leaving" value="1" <?php echo set_checkbox('is_profile_leaving', 1, $info['is_profile_leaving'] == 1); ?> /> เปิดใช้
                        <?php echo form_error( 'is_profile_leaving' ); ?>
					</div>
				</div>

                <div class="control-group">
                    <label class="control-label" for="job_start_date">วันที่เริ่มต้น : *</label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="job_start_date" id="job_start_date" value="<?php echo set_value('job_start_date', date("d-m-Y", strtotime( $info['job_start_date'] ))); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('job_start_date'); ?>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="job_end_date">วันที่สิ้นสุด : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y", strtotime('+ 1 year')); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="job_end_date" id="job_end_date" value="<?php echo set_value( 'job_end_date', ( $info['job_end_date'] != '' ? date( "d-m-Y", strtotime( $info['job_end_date'] ) ) : '' ) ); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
							<a href="javascript:void(0);" id="btnClearDate" class="btn btn-inverse">ล้างข้อมูลวันทีสิ้นสุด</a>
                        </div>
                        <?php echo form_error('job_end_date'); ?>
                    </div>
                </div>

				<div class="control-group">
					<label class="control-label" for="job_meta_url">Meta URL : *</label>
					<div class="controls">
						<input type="text" name="job_meta_url" id="job_meta_url" value="<?php echo set_value('job_meta_url', $info['job_meta_url']); ?>" class="span6" />
                        <?php echo form_error( 'job_meta_url' ); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="job_meta_title_th">Title สำหรับ SEO (ไทย) :</label>
					<div class="controls">
						<input type="text" name="job_meta_title_th" id="job_meta_title_th" value="<?php echo set_value('job_meta_title_th', $info['job_meta_title_th']); ?>" class="span6" />
                        <?php echo form_error( 'job_meta_title_th' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_meta_title_en">Title สำหรับ SEO (En) :</label>
					<div class="controls">
						<input type="text" name="job_meta_title_en" id="job_meta_title_en" value="<?php echo set_value('job_meta_title_en', $info['job_meta_title_en']); ?>" class="span6" />
                        <?php echo form_error( 'job_meta_title_en' ); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="job_meta_description_th">Description สำหรับ SEO (ไทย) : </label>
					<div class="controls">
						<textarea name="job_meta_description_th" id="job_meta_description_th" rows="5" class="span6" style="resize:none;"><?php echo set_value('job_meta_description_th', $info['job_meta_description_th']); ?></textarea>
                        <?php echo form_error( 'job_meta_description_th' ); ?>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_meta_description_en">Description สำหรับ SEO (En) : </label>
					<div class="controls">
						<textarea name="job_meta_description_en" id="job_meta_description_en" rows="5" class="span6" style="resize:none;"><?php echo set_value('job_meta_description_en', $info['job_meta_description_en']); ?></textarea>
                        <?php echo form_error('job_meta_description_en'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="job_meta_keywords_th">Keyword สำหรับ SEO (ไทย) :</label>
					<div class="controls">
						<input type="text" name="job_meta_keywords_th" id="job_meta_keywords_th" value="<?php echo set_value('job_meta_keywords_th', $info['job_meta_keywords_th']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_meta_keywords_en">Keyword สำหรับ SEO (En) :</label>
					<div class="controls">
						<input type="text" name="job_meta_keywords_en" id="job_meta_keywords_en" value="<?php echo set_value('job_meta_keywords_en', $info['job_meta_keywords_en']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="job_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="job_status" id="job_status">
							<option value="approved" <?php echo set_select('job_status','approved', $info['job_status'] == 'approved'); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('job_status','pending', $info['job_status'] == 'pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managejobvacancy/index/".$location['location_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
	/* Auto Generate Meta Tag Title (en) - Start */
	$('body').on('keyup','#job_title_en', function(){
		if($(this).val()!=''){
			var url = ToSeoUrl( $(this).val() );
			$('#job_meta_url').val( url );
		}else{
			$('#job_meta_url').val('');
		}
	});
	/* Auto Generate Meta Tag Title (en) - End */

	/* Setting no limit on end date - Start */
	$('body').on('click', '#btnClearDate', function(){
		$('input[name="job_end_date"]').val('');
	});
	/* Setting no limit on end date - End */

});
</script>