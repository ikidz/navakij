<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มบทความ</h4>
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
					<label class="control-label" for="article_thumbnail">รูปภาพปก : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="article_thumbnail" id="article_thumbnail" class="readfile" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น ต้องมีขนาด (กว้างxสูง) ไม่เกิน 370x240 พิกเซล และต้องมีขนาด (Size) ไม่เกิน 1 เมกะไบต์ (Mb).</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="article_image_th">รูปภาพหลัก (ไทย) : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="article_image_th" id="article_image_th" class="readfile" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_image_en">รูปภาพหลัก (En) : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="article_image_en" id="article_image_en" class="readfile" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_file">ไฟล์สำหรับดาวน์โหลด : </label>
					<div class="controls">
						<input type="file" name="article_file" id="article_file" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .pdf เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 10 เมกะไบต์ (Mb).</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_facebook">รูปภาพสำหรับ Facebook : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="article_facebook" id="article_facebook" class="readfile" />
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น และต้องมีขนาด (กว้างxสูง) 1200x630 พิกเซล และต้องมีขนาด (Size) ไม่เกิน 1 เมกะไบต์ (Mb).</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="article_title_th">ชื่อเรื่อง (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="article_title_th" id="article_title_th" value="<?php echo set_value('article_title_th'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_title_en">ชื่อเรื่อง (En) : *</label>
					<div class="controls">
						<input type="text" name="article_title_en" id="article_title_en" value="<?php echo set_value('article_title_en'); ?>" class="span6" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="article_desc_th">รายละเอียด (ไทย) : </label>
					<div class="controls">
						<textarea name="article_desc_th" id="article_desc_th" rows="5" class="ckeditor"><?php echo set_value('article_desc_th'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_desc_en">รายละเอียด (En) : </label>
					<div class="controls">
						<textarea name="article_desc_en" id="article_desc_en" rows="5" class="ckeditor"><?php echo set_value('article_desc_en'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="article_postdate">วันที่โพสต์ : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="article_postdate" id="article_postdate" value="<?php echo set_value('article_postdate', date("d-m-Y")); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('article_postdate'); ?>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="article_start_date">วันที่เริ่ม : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="article_start_date" id="article_start_date" value="<?php echo set_value('article_start_date', date("d-m-Y")); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('article_start_date'); ?>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="article_end_date">วันที่สิ้นสุด : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="article_end_date" id="article_end_date" value="<?php echo set_value('article_end_date', date("d-m-Y", strtotime('+1 year'))); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
							<a href="javascript:void(0);" id="btnClearDate" class="btn btn-inverse">ล้างข้อมูลวันทีสิ้นสุด</a>
                        </div>
                        <?php echo form_error('article_end_date'); ?>
                    </div>
                </div>
				
				<div class="control-group">
					<label class="control-label" for="article_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="article_status" id="article_status">
							<option value="approved" <?php echo set_select('article_status','approved', true); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('article_status','pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_meta_title">Title สำหรับ SEO :</label>
					<div class="controls">
						<input type="text" name="article_meta_title" id="article_meta_title" value="<?php echo set_value('article_meta_title'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_meta_description">Description สำหรับ SEO : </label>
					<div class="controls">
						<textarea name="article_meta_description" id="article_meta_description" rows="5" class="span6" style="resize:none;"><?php echo set_value('article_meta_description'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_meta_keyword">Keyword สำหรับ SEO :</label>
					<div class="controls">
						<input type="text" name="article_meta_keyword" id="article_meta_keyword" value="<?php echo set_value('article_meta_keyword'); ?>" class="span6" />
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึก</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managearticle/index/".$category['category_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	var category_meta_title = '<?php echo $category['category_meta_url']; ?>';
	
	/* Auto Generate Meta Tag Title (en) - Start */
	$('body').on('keyup','#article_title_en', function(){
		if($(this).val()!=''){
			var url = ToSeoUrl( $(this).val() );
			$('#article_meta_url').val( category_meta_title+'/'+url );
		}else{
			$('#article_meta_url').val('');
		}
	});
	/* Auto Generate Meta Tag Title (en) - End */

	/* Setting no limit on end date - Start */
	$('body').on('click', '#btnClearDate', function(){
		$('input[name="article_end_date"]').val('');
	});
	/* Setting no limit on end date - End */
});
</script>