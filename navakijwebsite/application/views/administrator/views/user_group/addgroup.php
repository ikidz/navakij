<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> ปรับปรุงข้อมูลกลุ่มผู้ใช้งาน</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			 <form method="post" class="form-horizontal">
			 
				<div class="control-group">
				 <label class="control-label" for="group_name">ชื่อกลุ่มผู้ใช้งาน</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-group"></i></span><input class="input-medium" name="group_name" id="group_name" type="text" placeholder="กรุณาระบุชื่อกลุ่มผู้ใช้งาน" value="<?php echo set_value('group_name'); ?>" />			 
				    </div>
				 </div>
				</div>
				<div class="control-group">
                                 <label class="control-label" >บริษัทสังกัด :</label>
                                 <div class="controls">
                                    <select class="span3" data-placeholder="Choose a Company" tabindex="1" name="company_id">
           
                                       <?php foreach($this->admin_library->getAllCompany()->result_array() as  $company){ ?>
                                       <option value="<?php echo $company['company_id']; ?>" <?php echo ($company['company_id']==set_value("company_id"))?'selected="selected"':''; ?> ><?php echo $company['company_name']; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
				<div class="control-group">
				 <label class="control-label" >ระดับสิทธิการเข้าถึง</label>
				 <div class="controls">
				    <div class="superadmin-enable">
				       <input type="checkbox" class="toggle" <?php echo (set_value('group_superadmin')=="yes")?'checked="checked"':""; ?> name="group_superadmin" id="group_superadmin" value="yes" />
				    </div>
				 </div>
				</div>
				<table class="table-menu table table-bordered table-advance <?php echo (set_value('group_superadmin')=="yes")?'hidden':''; ?>">
					<thead>
						<tr>
							<?php /* ?><th width="20">
								<input type="checkbox" class="group-checkable-menu" />
							</th>
							<th width="20"></th><?php */ ?>
							<th>ชื่อเมนู</th>
							<th width="50">อ่าน</th>
							<th width="50">เขียน</th>
							<th width="50">ลบ</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($this->admin_library->getAllMenu() as $menu_row){ ?>
						
						<tr>
							<td><?php echo $menu_row['label']; ?></td>
							<td><input type="checkbox" class="mainmenu checkmenu_r mainmenu_r_<?php echo $menu_row['id']; ?>" name="perm[<?php echo $menu_row['key']; ?>][r]" value="yes" data-set=".submenu_r_<?php echo $menu_row['id']; ?>" /></td>
							<td><input type="checkbox" class="mainmenu checkmenu_w mainmenu_w_<?php echo $menu_row['id']; ?>" name="perm[<?php echo $menu_row['key']; ?>][w]" value="yes" data-set=".submenu_w_<?php echo $menu_row['id']; ?>" /></td>
							<td><input type="checkbox" class="mainmenu checkmenu_d mainmenu_d_<?php echo $menu_row['id']; ?>" name="perm[<?php echo $menu_row['key']; ?>][d]" value="yes" data-set=".submenu_d_<?php echo $menu_row['id']; ?>" /></td>
						</tr>
						<?php foreach($menu_row['submenu_entry'] as $submenu_row){ ?>
						<tr>
							<td>--&raquo;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $submenu_row['label']; ?></td>
							<td class="subx">--&raquo;<input type="checkbox" class="submenu checkmenu_r submenu_r_<?php echo $menu_row['id']; ?>" name="perm[<?php echo $submenu_row['key']; ?>][r]" value="yes" data-set=".mainmenu_r_<?php echo $menu_row['id']; ?>" data-ref=".submenu_r_<?php echo $menu_row['id']; ?>" /></td>
							<td class="subx">--&raquo;<input type="checkbox" class="submenu checkmenu_w submenu_w_<?php echo $menu_row['id']; ?>" name="perm[<?php echo $submenu_row['key']; ?>][w]" value="yes" data-set=".mainmenu_w_<?php echo $menu_row['id']; ?>" data-ref=".submenu_w_<?php echo $menu_row['id']; ?>" /></td>
							<td class="subx">--&raquo;<input type="checkbox" class="submenu checkmenu_d submenu_d_<?php echo $menu_row['id']; ?>" name="perm[<?php echo $submenu_row['key']; ?>][d]" value="yes" data-set=".mainmenu_d_<?php echo $menu_row['id']; ?>" data-ref=".submenu_d_<?php echo $menu_row['id']; ?>" /></td>
						</tr>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
				<div class="form-actions">
				 <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
				 <button type="button" class="btn" onclick="window.location='<?php echo admin_url("user_group/index"); ?>';">ยกเลิกการแก้ไข</button>
				</div>
			 </form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.superadmin-enable').toggleButtons({
            width: 230, 
            label: {
                enabled: "สิทธิ์สูงสุด",
                disabled: "ตั้งค่าด้วยตนเอง"
            }
        });
    $("#group_superadmin").change(function(){
										    if($(this).is(":checked")){
											    $(".table-menu").addClass("hidden");
										    }else{
											    $(".table-menu").removeClass("hidden");
										    }
										    
									    });
	$(".mainmenu").change(function(){
		var target = $(this).attr("data-set");
		if($(this).is(":checked") && !$(this).is(":readonly")){
			$(target).attr("checked",true);
			
		}else{
			$(target).attr("checked",false);
		}
		var nc = $(target).length;
		var c = $(target+":checked").length;
		
		$.uniform.update(target);
	});
	$(".submenu").change(function(){
		var target = $(this).attr("data-set");
		var refer = $(this).attr("data-ref");
		
		var nc = $(refer).length;
		var c = $(refer+":checked").length;
		console.log(c);
		if(c > 0){
			$(target).attr("checked",true);
			
		}else{
			$(target).attr("checked",false);
		}
		
		$.uniform.update(target);
	});
	setTimeout(function(){
		$(".mainmenu_r_1,.mainmenu_w_1,.mainmenu_d_1").attr("checked",true);
		$.uniform.update(".mainmenu_r_1");
		$.uniform.update(".mainmenu_w_1");
		$.uniform.update(".mainmenu_d_1");
	},500);
});
</script>
<style type="text/css">
.subx{
	background-color: rgba(201,201,201,1);
}
</style>