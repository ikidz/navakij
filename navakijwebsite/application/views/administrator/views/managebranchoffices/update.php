<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มสาขาของภูมิภาค <?php echo $region['region_th']; ?></h4>
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
					<label class="control-label" for="name_th">ชื่อ (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="name_th" id="name_th" value="<?php echo set_value('name_th', $info['name_th']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name_en">ชื่อ (En) : *</label>
					<div class="controls">
						<input type="text" name="name_en" id="name_en" value="<?php echo set_value('name_en', $info['name_en']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="tel">เบอร์โทรศัพท์ : *</label>
					<div class="controls">
						<input type="text" name="tel" id="tel" value="<?php echo set_value('tel', $info['tel']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="map_img">รูปภาพแผนที่ : </label>
					<div class="controls">
                        <div class="preview">
							<?php if( $info['map_img'] != '' && is_file( realpath('public/core/uploaded/branchoffices/'.$info['map_img']) ) === true ): ?>
								<a href="<?php echo base_url('public/core/uploaded/branchoffices/'.$info['map_img']); ?>" target="_blank"><i class="icon-download"></i> ดาวน์โหลดไฟล์</a>
							<?php endif; ?>
						</div>
						<input type="file" name="map_img" id="map_img" />
						<label class="help-inline">* รองรับรูปภาพนามสกุล .jpg, .png, .gif และ .pdf เท่านั้น และต้องมีขนาดไม่เกิน 5 เมกะไบต์ (Mb)</label>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="map_google">Google Map URL : </label>
					<div class="controls">
						<input type="text" name="map_google" id="map_google" value="<?php echo set_value('map_google', $info['map_google']); ?>" class="span6" />
                        <span class="help-inline">ตัวอย่าง https://goo.gl/maps/YdZZvS2TKoxnSsQX6</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="status" id="status">
							<option value="approved" <?php echo set_select('status','approved', $info['status'] == 'approved'); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('status','pending', $info['status'] == 'pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
                    <input type="hidden" name="region_id" id="region_id" value="<?php echo $region['region_id']; ?>" />
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึก</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managebranchoffices/branches/".$region['region_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    /* select[name="province_id"] handler - Start */
    $('body').on('change','select[name="province_id"]', function(){
        var provinceId = $(this).val();
        $.post('<?php echo admin_url('managebranches/get_districts'); ?>', { 'province_id' : provinceId }, function(response){
            $('select[name="district_id"]').html( response );
        });
    });
    /* select[name="province_id"] handler - End */

    /* select[name="district_id"] handler - Start */
    $('body').on('change','select[name="district_id"]', function(){
        var districtId = $(this).val();
        $.post('<?php echo admin_url('managebranches/get_subdistricts'); ?>', { 'district_id' : districtId }, function(response){
            $('select[name="subdistrict_id"]').html( response );
        });
    });
    /* select[name="district_id"] handler - End */
});
</script>