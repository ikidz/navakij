<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มประกันภัย</h4>
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
					<label class="control-label" for="insurance_thumbnail">รูปภาพปก : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="insurance_thumbnail" id="insurance_thumbnail" class="readfile" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น ต้องมีขนาด (กว้าง x ยาว) 1200 x 630 พิกเซล  และต้องมีขนาด (Size) ไม่เกิน 1 เมกะไบต์ (Mb).</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="insurance_image">รูปภาพหลัก : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="insurance_image" id="insurance_image" class="readfile" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_file_th">ใบคำขอ (ไทย) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_th" id="insurance_file_th" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="insurance_file_en">ใบคำขอ (En) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_en" id="insurance_file_en" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_file_2_th">Factsheet (ไทย) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_2_th" id="insurance_file_2_th" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_file_2_en">Factsheet (En) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_2_en" id="insurance_file_2_en" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_file_3_th">File 3 (ไทย) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_3_th" id="insurance_file_3_th" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
					<div class="controls" style="margin-top:0.5rem;">
						<input type="text" name="insurance_file_3_label_th" id="insurance_file_3_label_th" value="<?php echo set_value('insurance_file_3_label_th'); ?>" placeholder="ชื่อปุ่มสำหรับ File 3 (ไทย)" class="span4" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_file_3_en">File 3 (En) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_3_en" id="insurance_file_3_en" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
					<div class="controls" style="margin-top:0.5rem;">
						<input type="text" name="insurance_file_3_label_en" id="insurance_file_3_label_en" value="<?php echo set_value('insurance_file_3_label_en'); ?>" placeholder="ชื่อปุ่มสำหรับ File 3 (En)" class="span4" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_file_4_th">File 4 (ไทย) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_4_th" id="insurance_file_4_th" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
					<div class="controls" style="margin-top:0.5rem;">
						<input type="text" name="insurance_file_4_label_th" id="insurance_file_4_label_th" value="<?php echo set_value('insurance_file_4_label_th'); ?>" placeholder="ชื่อปุ่มสำหรับ File 4 (ไทย)" class="span4" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_file_4_en">File 4 (En) : </label>
					<div class="controls">
						<input type="file" name="insurance_file_4_en" id="insurance_file_4_en" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf, .doc, .docx, .xlsx, .xls, .zip เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
					<div class="controls" style="margin-top:0.5rem;">
						<input type="text" name="insurance_file_4_label_en" id="insurance_file_4_label_en" value="<?php echo set_value('insurance_file_4_label_en'); ?>" placeholder="ชื่อปุ่มสำหรับ File 4 (En)" class="span4" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_facebook">รูปภาพสำหรับ Facebook : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="insurance_facebook" id="insurance_facebook" class="readfile" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น และต้องมีขนาด (กว้างxสูง) 1200x630 พิกเซล และต้องมีขนาด (Size) ไม่เกิน 1 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label for="insurance_icons" class="control-label">Icons:</label>
				</div>
				
				<div class="control-group">
				<?php foreach($icons as $key=> $icon) : ?>
					<?php if($icon['icon_id']) : ?>
						<div class="controls" style="width:45%; float:left; display:block; margin:1rem 0;">
							<div style="display:flex; align-items:center;">
								<input type="checkbox" name="insurance_icons_<?php echo $key?>" value="yes" />
								<img src="<?php echo base_url('public/core/uploaded/icons/'.$icon['icon_image']); ?>" alt="" style="width:64px;" />
								<div class="group" style="margin-left:1rem;">
									<input type="text" name="insurance_label_th_<?php echo $key; ?>" id="insurance_label_th_<?php echo $key; ?>" value="<?php echo set_value('insurance_label_th_'.$key); ?>" placeholder="Icon Label (ไทย)" style="margin-bottom:0.5rem;" /><br />
									<input type="text" name="insurance_label_en_<?php echo $key; ?>" id="insurance_label_en_<?php echo $key; ?>" value="<?php echo set_value('insurance_label_en_'.$key); ?>" placeholder="Icon Label (EN)" />
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="insurance_title_th">ชื่อประกันภัย (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="insurance_title_th" id="insurance_title_th" value="<?php echo set_value('insurance_title_th'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_title_en">ชื่อประกันภัย (En) : *</label>
					<div class="controls">
						<input type="text" name="insurance_title_en" id="insurance_title_en" value="<?php echo set_value('insurance_title_en'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="sum_insured">เงินเอาประกันภัยสูงสุด : *</label>
					<div class="controls">
						<input type="text" name="sum_insured" id="sum_insured" value="<?php echo set_value('sum_insured'); ?>" />
						<span class="help-inline">หากไม่มีให้ใส่ 0 </span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="price">เบี้ยประกันภัยเริ่มต้น : *</label>
					<div class="controls">
						<input type="text" name="price" id="price" value="<?php echo set_value('price'); ?>" />
						<span class="help-inline">หากไม่มีให้ใส่ 0 </span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="insurance_sdesc_th">รายละเอียดย่อ (ไทย) : </label>
					<div class="controls">
						<textarea name="insurance_sdesc_th" id="insurance_sdesc_th" rows="3" class="ckeditor"><?php echo set_value('insurance_sdesc_th'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_sdesc_en">รายละเอียดย่อ (En) : </label>
					<div class="controls">
						<textarea name="insurance_sdesc_en" id="insurance_sdesc_en" rows="3" class="ckeditor"><?php echo set_value('insurance_sdesc_en'); ?></textarea>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="insurance_desc_th">รายละเอียด (ไทย) : </label>
					<div class="controls">
						<textarea name="insurance_desc_th" id="insurance_desc_th" rows="5" class="ckeditor"><?php echo set_value('insurance_desc_th'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_desc_en">รายละเอียด (En) : </label>
					<div class="controls">
						<textarea name="insurance_desc_en" id="insurance_desc_en" rows="5" class="ckeditor"><?php echo set_value('insurance_desc_en'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="insurance_start_date">วันที่เริ่มต้น : *</label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="insurance_start_date" id="insurance_start_date" value="<?php echo set_value('insurance_start_date', date("d-m-Y")); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('insurance_start_date'); ?>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="insurance_end_date">วันที่สิ้นสุด : *</label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y", strtotime('+ 1 year')); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="insurance_end_date" id="insurance_end_date" value="<?php echo set_value('insurance_end_date', date("d-m-Y", strtotime('+ 1 year'))); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
							<a href="javascript:void(0);" id="btnClearDate" class="btn btn-inverse">ล้างข้อมูลวันทีสิ้นสุด</a>
                        </div>
                        <?php echo form_error('insurance_end_date'); ?>
                    </div>
                </div>

				<div class="control-group">
					<label class="control-label" for="insurance_contact_form">ฟอร์มติดต่อกลับ : </label>
					<div class="controls">
						<input type="checkbox" name="insurance_contact_form" id="insurance_contact_form" value="1" <?php echo set_checkbox('insurance_contact_form', 1); ?> /> เปิดใช้
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_highlight">Highlight : </label>
					<div class="controls">
						<input type="checkbox" name="insurance_highlight" id="insurance_highlight" value="1" <?php echo set_checkbox('insurance_highlight', 1); ?> /> ตั้งค่า
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="insurance_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="insurance_status" id="insurance_status">
							<option value="approved" <?php echo set_select('insurance_status','approved', true); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('insurance_status','pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_meta_title">Title สำหรับ SEO :</label>
					<div class="controls">
						<input type="text" name="insurance_meta_title" id="insurance_meta_title" value="<?php echo set_value('insurance_meta_title'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_meta_description">Description สำหรับ SEO : </label>
					<div class="controls">
						<textarea name="insurance_meta_description" id="insurance_meta_description" rows="5" class="span6" style="resize:none;"><?php echo set_value('insurance_meta_description'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_meta_keyword">Keyword สำหรับ SEO :</label>
					<div class="controls">
						<input type="text" name="insurance_meta_keyword" id="insurance_meta_keyword" value="<?php echo set_value('insurance_meta_keyword'); ?>" class="span6" />
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึก</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageinsurance/index/".$category['insurance_category_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	var category_meta_title = '<?php echo $category['insurance_category_meta_url']; ?>';
	
	/* Auto Generate Meta Tag Title (en) - Start */
	$('body').on('keyup','#insurance_title_en', function(){
		if($(this).val()!=''){
			var url = ToSeoUrl( $(this).val() );
			$('#insurance_meta_url').val( category_meta_title+'/'+url );
		}else{
			$('#insurance_meta_url').val('');
		}
	});
	/* Auto Generate Meta Tag Title (en) - End */

	/* Setting no limit on end date - Start */
	$('body').on('click', '#btnClearDate', function(){
		$('input[name="insurance_end_date"]').val('');
	});
	/* Setting no limit on end date - End */
});
</script>