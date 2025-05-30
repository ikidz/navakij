<?php
$table_unique_id = "list_".time();

?>
<div class="span12">
	<!-- BEGIN SAMPLE TABLE PORTLET-->
	<div class="widget">
		<div class="widget-title">
			<h4><i class="<?php echo $icon; ?>"></i> <?php echo $title; ?></h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body">
			<?php $success = $this->session->flashdata("message-success"); ?>
			<?php if($success){ ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>การทำรายการเสร็จสมบูรณ์ </strong> <?php echo $success; ?>
			</div>
			<?php } ?>
			
			<?php $info = $this->session->flashdata("message-info"); ?>
			<?php if($info){ ?>
			<div class="alert alert-info">
				<button class="close" data-dismiss="alert">×</button>
				<strong>ข้อมูลเพิ่มเติม </strong> <?php echo $info; ?>
			</div>
			<?php } ?>
			
			<?php $error = $this->session->flashdata("message-error"); ?>
			<?php if($error){ ?>
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong> <?php echo $error; ?>
			</div>
			<?php } ?>
			<?php $warning = $this->session->flashdata("message-warning"); ?>
			<?php if($warning){ ?>
			<div class="alert">
				<button class="close" data-dismiss="alert">×</button>
				<strong>คำเตือน </strong> <?php echo $warning; ?>
			</div>
			<?php } ?>
			<?php if(@$custom_tools){ echo $custom_tools; } ?>
			<form method="get" enctype="multipart/form-data" class="formsearch_sample_<?php echo $table_unique_id ; ?>">
			<?php if(@$search_date){ ?>
				<div class="control-group">
				 <label class="control-label" for="username">เลือกช่วงวันที่สมัคร :</label>
				 <div class="controls">
				    <span class="input-append date date-picker" data-date="<?php echo set_value("start_date",date("d-m-Y")); ?>" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       <input class="input-small date-picker" size="16" type="text" name="start_date" id="start_date" value="<?php echo set_get_value("start_date",date("d-m-Y")); ?>" /><span class="add-on"><i class="icon-calendar"></i></span>
                    </span>
                    <span>&nbsp;&nbsp;ถึงวันที่&nbsp;&nbsp;</span>
                    <span class="input-append date date-picker" data-date="<?php echo set_value("start_date",date("d-m-Y")); ?>" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       <input class="input-small date-picker" size="16" type="text" name="end_date" id="end_date" value="<?php echo set_get_value("end_date",date("d-m-Y")); ?>" /><span class="add-on"><i class="icon-calendar"></i></span>
                    </span>
                    
				 </div>
				</div>
			<?php } ?>
			<?php if(@$search_date){ ?>
			<div class="control-group">
				<div class="controls">
				<input type="submit" class="btn btn-info" value="Search" />
				</div>
			</div>	
			<?php } ?>
			</form>
			
			<form method="get" enctype="multipart/form-data" class="form_sample_<?php echo $table_unique_id ; ?>">
			<?php if(count($checkall_dropdown)+count($top_button) > 0){ ?>
			<div class="row-fluid">
				
				<div class="span8">
					<div class="<?php if(count($checkall_dropdown)+count($top_button) > 1){ ?>input-prepend input-append btn-group<?php } ?> checktools">
					<?php if($checkall && count($checkall_dropdown) > 0){ ?>
					<button type="button" class="hidden-phone btn btn-normal dropdown-toggle checkable-dropdown-<?php echo $table_unique_id; ?>" data-toggle="dropdown"><i class="icon-check"></i> การกระทำกับรายการที่เลือก (<span class="select_count">0</span>) <span class="icon-caret-down"></span></button>
					  <ul class="dropdown-menu">
					     
					     <?php foreach($checkall_dropdown as $but){ ?>
					     <?php if($this->admin_model->check_permision($but['permision'])){ ?>
					     <?php $confirm_del = ($but['permision']=="d")?'true':'false'; ?>
					     <li><a  onclick="checkall_take_action('<?php echo admin_url($but['url']); ?>',<?php echo $confirm_del; ?>);"><?php echo $but['name']; ?></a></li>
					     <?php } ?>
					     <?php } ?>
					  </ul>
					  <?php } ?>
					<?php foreach($top_button as $but){ ?>
					<?php if($this->admin_model->check_permision($but['permision'])){ ?>
					<?php $confirm_del = ($but['permision']=="d")?'onclick="return confirm(\'ยืนยันการลบรายการที่เลือกนี้ ?\');"':''; ?>
							<a href="<?php echo admin_url($but['url']); ?>" class="btn btn-normal <?php echo $but['type']; ?> <?php echo $but['class']; ?>" <?php echo $confirm_del; ?>><i class="<?php echo $but['icon']; ?>"></i> <?php echo $but['name']; ?></a>
					<?php }else{ ?>
							<a  class="btn btn-normal disabled <?php echo $but['class']; ?>"><i class="<?php echo $but['icon']; ?>"></i> <?php echo $but['name']; ?></a>
					<?php } ?>
					<?php } ?>
					
					</div>
				</div>
				<?php if(@$search_text){ ?>
				<div class="span4">
					<div class="btn-group input-prepend input-append">
						<span class="add-on"><i class="icon-search"></i></span>
						<input type="text" name="q" class="input-large" value="<?php echo $this->input->get("q"); ?>" />
						<input type="submit" class="btn btn-info" value="ค้นหา" />
					</div>
				</div>
				<?php } ?>
			</div>
			<p></p>
			<?php } ?>
			<?php /* <table class="table table-striped table-bordered table-advance table-hover dataTable_<?php echo $table_unique_id; ?>"> */ ?>
			<table class="table table-striped table-bordered table-advance table-hover">
				<thead>
					<tr>
						<?php if($checkall && count($checkall_dropdown) > 0){ ?>
						<th width="20" class="hidden-phone">
							<input type="checkbox"  class="group-checkable-<?php echo $table_unique_id; ?>" data-set=".<?php echo $table_unique_id; ?>"  />
						</th>
						<?php } ?>
						<?php foreach($column as $col){ ?>
						<?php $th_width = ($col['width'] > 0)?'width="'.$col['width'].'"':""; ?>
						<th class="<?php echo $col['class']; ?>" <?php echo $th_width; ?> ><i class="<?php echo $col['icon']; ?>"></i> <?php echo $col['name']; ?></th>
						<?php } ?>
						<?php $th_tools_width = ($tools_width > 0)?'width="'.$tools_width.'"':""; ?>
						<th <?php echo $th_tools_width; ?>></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(is_array($datatable)){
							$data_res = $datatable;
						}else{
							$data_res = $datatable->result_array();
						}
					?>
					<?php foreach($data_res as $row){ $row_ori=$row; ?>
					<tr>
						<?php if($checkall && count($checkall_dropdown) > 0){ ?>
						<td class="hidden-phone">
							<input type="checkbox" name="select_item[]" class="<?php echo $table_unique_id; ?>" id="<?php echo $table_unique_id; ?>" value="<?php echo $row[$checkall_key]; ?>" />
						</td>
						<?php } ?>
						<?php foreach($column as $col){ ?>
						<?php 
							if(isset($column_callback[$col['field']])){
								$field_val = call_user_func(array($this->admin_model->me,$column_callback[@$col['field']]),@$row[$col['field']],$row_ori);
							}else{
								$field_val = $row[$col['field']];
							}
						?>
						<td class="<?php echo $col['class']; ?>"><?php echo $field_val; ?></td>
						<?php } ?>
						<td style="text-align:right">
						<?php foreach($button as $but){ ?>
						<?php if($this->admin_model->check_permision($but['permision'])){ ?>
						<?php $confirm_del = ($but['permision']=="d")?'onclick="return confirm(\'ยืนยันการลบรายการนี้ ?\');"':''; ?>
						<?php $external_link = ($but['permision']=='e')?'target="_blank"':''; ?>
						<a href="<?php echo admin_url($this->admin_model->assign_param($but['url'],$row)); ?>" class="btn btn-mini <?php echo $but['type']; ?> <?php echo $but['class']; ?>" <?php echo $confirm_del; ?> <?php echo $external_link; ?>><i class="<?php echo $but['icon']; ?>"></i> <?php echo $but['name']; ?></a>						<?php }else{ ?>
						<a  class="btn btn-mini disabled <?php echo $but['class']; ?>"><i class="<?php echo $but['icon']; ?>"></i> <?php echo $but['name']; ?></a>
				<?php } ?>
						<?php } ?>
						</td>
					</tr>
					<?php } ?>
					<?php if(count($data_res)==0){ ?> 
					<tr>
						<td colspan="<?php echo count($column)+1; ?>" style="text-align:center;">== ไม่มีข้อมูล ==</td>
						
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<p>
				<?php
				if($pagination){
					create_pagination($url,$total_rows,$perpage,$uri_segment);
				}
				?>
			</p>
			</form>
		</div>
	</div>
	<!-- END SAMPLE TABLE PORTLET-->
</div>
<script  type="text/javascript">
var dataTableTT = false;
$(document).ready(function(e) {
	$(".popovers").popover({ html:'true' });
	setBtnAction();
	
	if($(".dataTable_<?php echo $table_unique_id; ?> tr").length > 105){
		dataTableTT = $(".dataTable_<?php echo $table_unique_id; ?>").dataTable();
		//$("dataTables_paginate").click(setBtnAction);
		
	}
		<?php if($checkall){ ?>
	$(".group-checkable-<?php echo $table_unique_id; ?>").handleCheckAll('.checkable-dropdown-<?php echo $table_unique_id; ?>');
	
});
	<?php } ?>
function checkall_take_action(url,delete_confirm){
	if(delete_confirm){
		if(confirm('ยืนยันการลบรายการที่เลือกนี้ ?')==false){
			return false;
		}
	}
	$("form.form_sample_<?php echo $table_unique_id ; ?>").attr("action",url);
	$("form.form_sample_<?php echo $table_unique_id ; ?>").submit();
	
}
function setBtnAction()
{
	$(".callme-and-disable").click(function(){
		if($(this).hasClass("disabled")){
			return ;
		}
		var u = $(this).attr("data-call");
		if(!u){
			return;
		}
		$(this).find("i").eq(0).remove();
		$(this).prepend('<i class="icon-spinner icon-spin"></i> ');
		$(this).addClass("disabled");
		var uu = admin_url + "/"+u;
		var t = this;
		$.post(uu).done(function(script){
			$(t).find("i").eq(0).remove();
			$(t).prepend('<i class="icon-check text-success"></i> ');
			eval(script);
			if(dataTableTT){
				//dataTableTT.destroy();
				dataTableTT.fnDraw();
			}
		}).fail(function(){
			$(t).removeClass("disabled");
			$(t).find("i").eq(0).remove();
			$(t).prepend('<i class="icon-warning text-warning"></i> ');
		});
	});
}
</script>