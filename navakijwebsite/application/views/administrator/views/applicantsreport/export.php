<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=exported_".date("dmYHis").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<table cellspacing="0" cellpadding="0" border="1" style="width:100%;">
	<tr>
		<th colspan="4"><h2>รายการสมัครงาน</h2></th>
	</tr>
	
	<?php
		if($aSort['sort_keywords']!=''){
			?>
			<tr>
				<th colspan="4" style="text-align:left;">คำค้นหา : "<?php echo $aSort['sort_keywords']; ?>"</th>
			</tr>
			<?php
		}
	?>
	<?php
		if($aSort['sort_start_date']!=''){
			?>
			<tr>
				<th colspan="4" style="text-align:left;">ช่วงวันที่ : <?php echo $aSort['sort_start_date'].' ถึงวันที่ '.$aSort['sort_end_date']; ?></th>
			</tr>
			<?php
		}
	?>
	<?php if( $aSort['sort_location_id'] > 0 ): ?>
		<?php $location = $this->applicantsreportmodel->get_locationinfo_byid( $aSort['sort_location_id'] ); ?>
		<tr>
			<th colspan="4" style="text-align:left;">สถานที่ปฏิบัติงาน : <?php echo $location['location_title_th']; ?></th>
		</tr>
	<?php endif; ?>
	<?php if( $aSort['sort_job_id'] > 0 ): ?>
		<?php $job = $this->applicantsreportmodel->get_jobinfo_byid( $aSort['sort_job_id'] ); ?>
		<tr>
			<th colspan="4" style="text-align:left;">ตำแหน่งงานที่ค้นหา : <?php echo $job['job_title_th']; ?></th>
		</tr>
	<?php endif; ?>
	<tr>
		<th class="" width="5%" >ลำดับ</th>
		<th class="" width="20%" >ตำแหน่งงาน</th>
		<th class="" width="20%" >ชื่อ-นามสกุล</th>
		<th class="" width="15%" >วันที่สมัคร</th>
	</tr>
	<?php
		if($lists){
			$i=0;
			foreach($lists as $list){
				
				$i++;
				?>
				<tr>
					<td style="text-align:center; vertical-align:middle;"><?php echo $i; ?>.</td>
					<td style="padding-left:15px; vertical-align:middle;">
						<?php if( $list['location_id'] > 0 ): ?>
							<?php $location = $this->applicantsreportmodel->get_locationinfo_byid( $list['location_id'] ); ?>
							<?php if( isset( $location ) && count( $location ) > 0 ): ?>
								<p style="margin:0.5rem 0;">สถานที่ปฏิบัติงาน : <?php echo $location['location_title_th']; ?></p>
							<?php endif; ?>
						<?php endif; ?>
						<?php if( $list['job_id'] > 0 ): ?>
							<?php $job = $this->applicantsreportmodel->get_jobinfo_byid( $list['job_id'] ); ?>
							<?php if( isset( $job ) && count( $job ) > 0 ): ?>
								<p style="margin:0.5rem 0;">ตำแหน่งงาน : <?php echo $job['job_title_th']; ?></p>
							<?php endif; ?>
						<?php endif; ?>
						<?php if( $list['applicant_salary'] > 0 ): ?>
							<p style="margin:0.5rem 0;">เงินเดือนที่คาดหวัง : <?php echo $list['applicant_salary']; ?></p>
						<?php endif; ?>
					</td>
					<td style="padding:15px; vertical-align:middle;">
						<?php
							$addresses = $this->applicantsreportmodel->get_addresss( $list['applicant_id'], 'current');
							$address = $addresses[0];
							$response = '<p style="margin:0.5rem;">ไทย : '.$list['applicant_fname_th'].' '.$list['applicant_lname_th'].'</p>';
							$response .= '<p style="margin:0.5rem;">En : '.$list['applicant_lname_th'].' '.$list['applicant_lname_en'].'</p>';
							if( isset( $address ) && count( $address ) > 0 ){
								$response .= '<p style="margin:0.5rem;">Tel : '.$address['address_tel'].'</p>';
								$response .= '<p style="margin:0.5rem;">Email : '.$address['address_email'].'</p>';
							}
							echo $response;
						?>
					</td>
					<td style="text-align:center;"><?php echo thai_convert_shortdate( $list['applicant_createdtime'] ); ?> <?php echo date("H:i:s", strtotime( $list['applicant_createdtime'] ) ); ?></td>
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