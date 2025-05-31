<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขข้อมูลเครือข่าย</h4>
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
					<label class="control-label" for="branch_image">รูปภาพ : </label>
					<div class="controls">
                        <div class="preview">
							<?php if( $info['branch_image'] != '' && is_file( realpath('public/core/uploaded/branches/'.$info['branch_image']) ) === true ): ?>
								<img src="<?php echo base_url('public/core/uploaded/icons/'.$info['branch_image']); ?>" alt="" style="width:300px;" />
							<?php endif; ?>
						</div>
						<input type="file" name="branch_image" id="branch_image" class="readfile" />
						<label class="help-inline">* รองรับรูปภาพนามสกุล .jpg, .png, .gif เท่านั้น และต้องมีขนาดไม่เกิน 2 เมกะไบต์ (Mb)</label>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_title_th">ชื่อ (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="branch_title_th" id="branch_title_th" value="<?php echo set_value('branch_title_th', $info['branch_title_th']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="branch_title_en">ชื่อ (En) : *</label>
					<div class="controls">
						<input type="text" name="branch_title_en" id="branch_title_en" value="<?php echo set_value('branch_title_en', $info['branch_title_en']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_tel">เบอร์โทรศัพท์ : *</label>
					<div class="controls">
						<input type="text" name="branch_tel" id="branch_tel" value="<?php echo set_value('branch_tel', $info['branch_tel']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_fax">เบอร์โทรสาร : </label>
					<div class="controls">
						<input type="text" name="branch_fax" id="branch_fax" value="<?php echo set_value('branch_fax', $info['branch_fax']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_email">อีเมลติดต่อ : </label>
					<div class="controls">
						<input type="text" name="branch_email" id="branch_email" value="<?php echo set_value('branch_email', $info['branch_email']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_website">เว็บไซต์ : </label>
					<div class="controls">
						<input type="text" name="branch_website" id="branch_website" value="<?php echo set_value('branch_website', $info['branch_website']); ?>" class="span6" />
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_address">ที่อยู่ : *</label>
					<div class="controls">
						<textarea name="branch_address" id="branch_address" class="span6" rows="4" style="resize:none;"><?php echo set_value('branch_address', $info['branch_address']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="province_id">จังหวัด : </label>
                    <div class="controls">
                        <select name="province_id" id="province_id">
                            <option value="" <?php echo set_select('province_id','', true); ?>>-- เลือกจังหวัด --</option>
                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                <?php foreach( $provinces as $province ): ?>
                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('province_id', $province['province_id'], $info['province_id'] == $province['province_id']); ?>><?php echo $province['name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="district_id">อำเภอ / เขต : </label>
                    <div class="controls">
                        <select name="district_id" id="district_id">
                            <option value="" <?php echo set_select('district_id','', true); ?>>-- เลือกอำเภอ / เขต --</option>
                            <?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
                                <?php foreach( $districts as $district ): ?>
                                    <option value="<?php echo $district['amphoe_id']; ?>" <?php echo set_select('district_id', $district['amphoe_id'], $info['district_id'] == $district['amphoe_id']); ?>><?php echo $district['name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="subdistrict_id">ตำบล / แขวง : </label>
                    <div class="controls">
                        <select name="subdistrict_id" id="subdistrict_id">
                            <option value="" <?php echo set_select('subdistrict_id','', true); ?>>-- เลือกตำบล / แขวง --</option>
                            <?php if( isset( $subdistricts ) && count( $subdistricts ) > 0 ): ?>
                                <?php foreach( $subdistricts as $subdistrict ): ?>
                                    <option value="<?php echo $subdistrict['tambon_id']; ?>" <?php echo set_select('subdistrict_id', $subdistrict['tambon_id'], $info['subdistrict_id'] == $subdistrict['tambon_id']); ?>><?php echo $subdistrict['name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

				<div class="control-group">
					<label class="control-label" for="card">บัตร :</label>
					<div class="controls">
						<input type="text" name="card" id="card" value="<?php echo set_value('card', $info['card']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="patient_department">IPD/OPD :</label>
					<div class="controls">
						<input type="text" name="patient_department" id="patient_department" value="<?php echo set_value('patient_department', $info['patient_department']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="is_partner">เป็นพันธมิตรในเครือ : </label>
                    <div class="controls">
                        <input type="checkbox" name="is_partner" id="is_partner" value="1" <?php echo set_checkbox('is_partner', 1, $info['is_partner'] == 1); ?> />
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="branch_lat">Latitude : </label>
					<div class="controls">
						<input type="text" name="branch_lat" id="branch_lat" value="<?php echo set_value('branch_lat', $info['branch_lat']); ?>" class="span4" />
                        <span class="help-inline">ตัวอย่าง 13.722989490371138</span>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_lng">Longitude : </label>
					<div class="controls">
						<input type="text" name="branch_lng" id="branch_lng" value="<?php echo set_value('branch_lng', $info['branch_lng']); ?>" class="span4" />
                        <span class="help-inline">ตัวอย่าง 100.53034302667552</span>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="branch_gmap_url">Google Map URL : </label>
					<div class="controls">
						<input type="text" name="branch_gmap_url" id="branch_gmap_url" value="<?php echo set_value('branch_gmap_url', $info['branch_gmap_url']); ?>" class="span6" />
                        <span class="help-inline">ตัวอย่าง https://goo.gl/maps/YdZZvS2TKoxnSsQX6</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="branch_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="branch_status" id="branch_status">
							<option value="approved" <?php echo set_select('branch_status','approved', $info['branch_status'] == 'approved' ); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('branch_status','pending',  $info['branch_status'] == 'pending' ); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
                    <input type="hidden" name="category_id" id="category_id" value="<?php echo $category['category_id']; ?>" />
                    <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $info['branch_id']; ?>" />
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึก</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managebranches/index/".$category['category_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
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