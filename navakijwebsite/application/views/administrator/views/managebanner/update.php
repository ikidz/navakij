<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขแบนเนอร์</h4>
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
					<label class="control-label" for="article_id">ลิงก์ไปยังปลายทาง * : </label>
					<div class="controls">
						<select class="span6 chosen" id="article_id" name="article_id" tabindex="1">
							<option value="0" <?php echo set_select('article_id', 0, $info['article_id'] == 0); ?>>ไม่ลิงก์</option>
							<option value="9999" <?php echo set_select('article_id', '9999', $info['article_id'] == 9999); ?>>ลิงก์ไปยังที่อื่น</option>
						</select>
					</div>
				</div>

				<div id="url_other" class="control-group" <?php echo ( $info['article_id'] == 9999 ? '' : 'style="display:none;"' ); ?>>
					<label class="control-label" for="banner_url">URL * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-link"></i></span>
							<input type="text" class="input-large" name="banner_url" id="banner_url" placeholder="URL *" value="<?php echo set_value('banner_url', $info['banner_url']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="banner_image">รูปแบนเนอร์ * : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['banner_image'] != '' && is_file( realpath('public/core/uploaded/banner/'.$info['banner_image']) ) === true ): ?>
								<img src="<?php echo base_url('public/core/uploaded/banner/'.$info['banner_image']); ?>" alt="" style="width:300px;" />
							<?php endif; ?>
						</div>
						<input type="file" name="banner_image" id="banner_image" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb) และต้องมีขนาด (กว้าง x ยาว) เท่ากับ 1920x650 พิกเซล (Pixels) เท่านั้น</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="banner_image_mobile">รูปแบนเนอร์ (Mobile) * : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['banner_image_mobile'] != '' && is_file( realpath('public/core/uploaded/banner/mobile/'.$info['banner_image_mobile']) ) === true ): ?>
								<img src="<?php echo base_url('public/core/uploaded/banner/mobile/'.$info['banner_image_mobile']); ?>" alt="" style="width:300px;" />
							<?php endif; ?>
						</div>
						<input type="file" name="banner_image_mobile" id="banner_image_mobile" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb) และต้องมีขนาด (กว้าง x ยาว) เท่ากับ 640x709 พิกเซล (Pixels) เท่านั้น</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="banner_title_th">ชื่อแบนเนอร์ (ไทย) * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="banner_title_th" id="banner_title_th" placeholder="ชื่อแบนเนอร์ *" value="<?php echo set_value('banner_title_th', $info['banner_title_th']); ?>" />
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="banner_title_en">ชื่อแบนเนอร์ (En) * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="banner_title_en" id="banner_title_en" placeholder="ชื่อแบนเนอร์ *" value="<?php echo set_value('banner_title_en', $info['banner_title_en']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="banner_caption_th">แคปชันแบนเนอร์ (ไทย) : </label>
					<div class="controls">
						<textarea name="banner_caption_th" id="banner_caption_th" rows="5" class="span6 wysihtml5"><?php echo set_value('banner_caption_th', $info['banner_caption_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="banner_caption_en">แคปชันแบนเนอร์ (En) : </label>
					<div class="controls">
						<textarea name="banner_caption_en" id="banner_caption_en" rows="5" class="span6 wysihtml5"><?php echo set_value('banner_caption_en', $info['banner_caption_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="banner_start_date">วันที่เริ่ม : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y", strtotime( ( $info['banner_start_date'] ? $info['banner_start_date'] : date("Y-m-d") ) ) ); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="banner_start_date" id="banner_start_date" value="<?php echo set_value('banner_start_date', date("d-m-Y", strtotime( ( $info['banner_start_date'] ? $info['banner_start_date'] : date("Y-m-d") ) ) ) ); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('banner_start_date'); ?>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="banner_end_date">วันที่สิ้นสุด : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="banner_end_date" id="banner_end_date" value="<?php echo set_value('banner_end_date', ( $info['banner_end_date'] != '' ? date("d-m-Y", strtotime( $info['banner_end_date'] ) ) : '' ) ); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
							<a href="javascript:void(0);" id="btnClearDate" class="btn btn-inverse">ล้างข้อมูลวันทีสิ้นสุด</a>
                        </div>
                        <?php echo form_error('banner_end_date'); ?>
                    </div>
                </div>
				
				<div class="control-group">
					<label class="control-label" for="banner_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="banner_status" id="banner_status">
							<option value="approved" <?php echo set_select('banner_status','approved', $info['banner_status'] == 'approved'); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('banner_status','pending', $info['banner_status'] == 'pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managebanner/index"); ?>"><i class="icon-save"></i> ยกเลิก</a>
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
			$('#url_other').find('input[name="banner_url"]').val('');
			$('#url_other').slideUp('fast');
		}
	});

	/* Setting no limit on end date - Start */
	$('body').on('click', '#btnClearDate', function(){
		$('input[name="banner_end_date"]').val('');
	});
	/* Setting no limit on end date - End */
});
</script>