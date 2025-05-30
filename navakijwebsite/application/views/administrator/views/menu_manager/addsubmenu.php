<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มเมนูใหม่</h4>
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
			<input type="hidden" name="menu_id" value="<?php echo set_value('menu_id',$this->_data['menu_id']); ?>" />
				<div class="control-group">
					<label class="control-label" for="username">ชื่อเมนู : *</label>
					<div class="controls">
						<div class="input-prepend">
						   <span class="add-on"><i class="icon-code"></i></span>
						   <input class="input-large" name="menu_label" id="username" type="text" placeholder="กรุณาระบุชื่อเมนู" value="<?php echo set_value('menu_label'); ?>" />	
						</div>
					
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" >เชื่อมโยงไปยัง : *</label>
					<div class="controls">
						<select name="menu_link" id="menu_link" class="span4" data-placeholder="เลือกลิ้งค์เชื่อมโยง">
						   <?php foreach($this->controllerlist->getControllers() as $cont=>$rs){ ?>
					       <optgroup label="<?php echo ucfirst($cont); ?>">
					       		<?php foreach($rs as $method){ ?>
					       		<?php 
					       		
					       		$url =  $cont."/".$method; 
					       		?>
					       			<option value="<?php echo $url; ?>" <?php if(set_value("menu_link")==$url){ ?> selected="selected" <?php } ?>><?php echo ucfirst($url); ?></option>
					       		<?php } ?>
					       </optgroup>
					       <?php } ?>
						</select>
					</div>
				</div>
				<!--
<div class="control-group">
					<label class="control-label" >การเรียงลำดับ : *</label>
					<div class="controls">
						<select name="menu_sequent" id="menu_sequent" class="span4 chosen" data-placeholder="เลือกการเรียงลำดับ">
							<option value=""></option>
						   <?php foreach($this->menu_model->dataTable() as $rs){ ?>
					       <option value="<?php echo $rs['menu_sequent']; ?>">แสดงก่อน "<?php echo $rs['menu_label']; ?>"</option>
					       <?php } ?>
					       <option value="<?php echo $this->menu_model->get_menu_last_sequent(); ?>" selected="selected">อยู่ล่างสุดเสมอ</option>
						</select>
					</div>
				</div>
-->
				<div class="control-group">
					<label class="control-label" >Icon : *</label>
					<div class="controls">
						<select name="menu_icon" id="menu_icon" class="span4 chosen" data-placeholder="เลือก Icon" style="font-family: 'FontAwesome',Tahoma;">
							<option value=""></option>
						   <?php foreach($this->menu_model->get_icons() as $key=>$text){ ?>
					       <option  style="font-family: 'FontAwesome',Tahoma;" value="<?php echo $key; ?>" <?php if(set_value("menu_icon")==$key){ ?> selected="selected" <?php } ?>><?php echo str_replace("\\","&#x",$text); ?> <?php echo ucfirst(str_replace("icon-","",$key)); ?></option>
					       <?php } ?>
						</select>
					</div>
				</div>
				<?php //var_dump($this->menu_model->get_icons()); ?>
				<div class="form-actions">
				 	<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกการเปลี่ยนแปลง</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("user_admin/index"); ?>"><i class="icon-reply"></i> ยกเลิกการแก้ไข</a>
				</div>
			 </form>
		</div>
	</div>
</div>
<style type="text/css">
#menu_icon_chzn{
	font-family: 'FontAwesome',Tahoma;
}
</style>