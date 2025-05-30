<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=exported_".date("dmYHis").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<table cellspacing="0" cellpadding="0" border="1" style="width:100%;">
	<tr>
		<th colspan="4"><h2>รายการบันทึก IP Address</h2></th>
	</tr>
	
	<?php
		if($aSort['sort_keyword']!=''){
			?>
			<tr>
				<th colspan="4" style="text-align:left;">คำค้นหา : "<?php echo $aSort['sort_keyword']; ?>"</th>
			</tr>
			<?php
		}
	?>
	<?php if( $aSort['sort_onlythai'] == 1 ) : ?>
		<tr>
			<th colspan="4" style="text-align:left;">รายการ IP Address เฉพาะในประเทศไทย</th>
		</tr>
	<?php endif; ?>
	<tr>
		<th colspan="4" style="text-align:left;">จำนวนผู้ใช้งาน https://www.navakij.co.th <?php echo ( $aSort['sort_start_date'] != '' ? 'ช่วงวันที่ : '.$aSort['sort_start_date'].' ถึงวันที่ '.$aSort['sort_end_date'] : 'ทั้งหมด' ); ?> รวมทั้งสิ้น : <?php echo $total; ?> รายการ</th>
	</tr>
	<tr>
		<th class="" width="5%" >HASH</th>
		<th class="" width="10%" >IP</th>
		<th class="" width="10%" >ประเทศ</th>
		<th class="" width="10%" >วันที่</th>
	</tr>
	<?php
		if($lists){
			$i=0;
			foreach($lists as $list){
				$i++;
				?>
				<tr>
					<td style="text-align:center; vertical-align:middle;"><?php echo $list['hash']; ?>.</td>
					<td style="padding-left:15px; vertical-align:middle;"><?php echo $list['ip']; ?></td>
					<td style="padding-left:15px; vertical-align:middle;">
						<?php
							$countryList = [
								'TH' => 'ประเทศไทย',
								'US' => 'สหรัฐอเมริกา',
								'GB' => 'สหราชอาณาจักร',
								'JP' => 'ญี่ปุ่น',
								'KR' => 'เกาหลีใต้',
								'CN' => 'จีน',
								'FR' => 'ฝรั่งเศส',
								'DE' => 'เยอรมนี',
								'IN' => 'อินเดีย',
								'IT' => 'อิตาลี',
								'AU' => 'ออสเตรเลีย',
								'CA' => 'แคนาดา',
								'RU' => 'รัสเซีย',
								'BR' => 'บราซิล',
								'MX' => 'เม็กซิโก',
								'SG' => 'สิงคโปร์',
								'MY' => 'มาเลเซีย',
								'PH' => 'ฟิลิปปินส์',
								'VN' => 'เวียดนาม',
								'ID' => 'อินโดนีเซีย',
								'ZA' => 'แอฟริกาใต้',
								'EG' => 'อียิปต์',
								'AR' => 'อาร์เจนตินา',
								'SA' => 'ซาอุดีอาระเบีย',
								'AE' => 'สหรัฐอาหรับเอมิเรตส์',
								// Add more countries as needed
							];

							echo $countryCode = strtoupper($list['country_code']);
						?>
					</td>
					<td style="padding-left:15px; vertical-align:middle;"><?php echo $list['created_at']; ?></td>
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