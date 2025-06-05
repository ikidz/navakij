<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มโครงสร้างองค์กรของตำแหน่ง : <?php echo $position['position_title_th']; ?></h4>
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
                    <label class="control-label" for="member_id">ผู้บริหาร * :</label>
                    <div class="controls">
                        <select name="member_id" id="member_id" class="chosen">
                            <option value="" <?php echo set_select('member_id', '', true); ?>>-- เลือกผู้บริหาร --</option>
                            <?php if( isset( $members ) && count( $members ) > 0 ): ?>
                                <?php foreach( $members as $member ): ?>
                                    <option value="<?php echo $member['member_id']; ?>" <?php echo set_select('member_id', $member['member_id']); ?>><?php echo $member['member_name_th']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="hierarchy_level">ลำดับชั้น * :</label>
                    <div class="controls">
                        <select name="hierarchy_level" id="hierarchy_level">
                            <option value="" <?php echo set_select('hierarchy_level','', true); ?>>-- เลือกลำดับชั้น --</option>
                            <?php for( $i=1; $i<=3; $i++ ): ?>
                                <option value="<?php echo $i; ?>" <?php echo set_select('hierarchy_level', $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="hierarchy_position_th">ชื่อตำแหน่ง (ไทย) : </label>
                    <div class="controls">
                        <input type="text" name="hierarchy_position_th" id="hierarchy_position_th" value="<?php echo set_value('hierarchy_position_th'); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="hierarchy_position_en">ชื่อตำแหน่ง (En) : </label>
                    <div class="controls">
                        <input type="text" name="hierarchy_position_en" id="hierarchy_position_en" value="<?php echo set_value('hierarchy_position_en'); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="hierarchy_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="hierarchy_status" id="hierarchy_status">
							<option value="approved" <?php echo set_select('hierarchy_status','approved', true); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('hierarchy_status','pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managehierarchy/hierarchy/".$position['position_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#member_id').chosen().change(function(){
        $.post( '<?php echo admin_url('managehierarchy/api_get_boardmemberinfo'); ?>', { memberId : $(this).val() }, function(response){
            var res = response.data.response;
            if( res.status == 200 ){
                $('#hierarchy_position_th').val( res.position_th );
                $('#hierarchy_position_en').val( res.position_en );
            }else{
                $('#hierarchy_position_th').val( '' );
                $('#hierarchy_position_en').val( '' );
            }
        });
    });
});
</script>