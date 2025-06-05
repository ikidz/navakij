<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=exported_".date("dmYHis").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<table cellspacing="0" cellpadding="0" border="1" style="width:100%;">
	<tr>
		<th colspan="6"><h2>รายชื่อผู้ติดต่อ</h2></th>
	</tr>
	
	<?php
		if($aSort['sort_keyword']!=''){
			?>
			<tr>
				<th colspan="6" style="text-align:left;">คำค้นหา : "<?php echo $aSort['sort_keyword']; ?>"</th>
			</tr>
			<?php
		}
	?>
	<?php
		if($aSort['sort_start_date']!=''){
			?>
			<tr>
				<th colspan="6" style="text-align:left;">ช่วงวันที่ : <?php echo $aSort['sort_start_date'].' ถึงวันที่ '.$aSort['sort_end_date']; ?></th>
			</tr>
			<?php
		}
	?>
	<tr>
		<th class="" width="5%" >ลำดับ</th>
		<th class="" width="10%" >ชื่อ-นามสกุล</th>
		<th class="" width="10%" >อีเมล</th>
		<th class="" width="10%" >เบอร์ติดต่อ</th>
		<th class="" width="10%" >ข้อความ</th>
		<th class="" width="10%" >เวลา</th>
	</tr>
	<?php
		if($lists){
			$i=0;
			foreach($lists as $list){
				$i++;
				?>
				<tr>
					<td style="text-align:center; vertical-align:middle;"><?php echo $i; ?>.</td>
					<td style="padding-left:15px; vertical-align:middle;"><?php echo $list['contact_name'].' '.$list['contact_lastname']; ?></td>
					<td style="padding-left:15px; vertical-align:middle;"><?php echo $list['contact_email']; ?></td>
					<td style="padding-left:15px; vertical-align:middle;"><?php echo $list['contact_mobile']; ?></td>
					<td style="padding-left:15px; vertical-align:middle;"><?php echo $list['contact_message']; ?></td>
					<td style="padding-left:15px; vertical-align:middle;"><?php echo date("Y-m-d H:i:s", strtotime($list['contact_createdtime'])); ?></td>
				</tr>
				<?php
			}
		}else{
			?>
			<tr>
				<td colspan="4" style="text-align:center;">-- ไม่มีข้อมูล --</td>
			</tr>
			<?php
		}
	?>
</table>