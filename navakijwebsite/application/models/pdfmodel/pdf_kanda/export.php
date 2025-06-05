<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Export extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('administrator/admin_model');
        $this->load->model('administrator/cheque_model');
        $this->load->model("administrator/bank_model");
        $this->load->model('holiday');
    }
    function excel_export($m,$y,$pay_with)
	{
		$month_array = array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
		$this->load->library("PHPExcel");
		$objPHPExcel =new PHPExcel;
		$objPHPExcel->setActiveSheetIndex(0);  
		$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.'1', 'บริษัท กานดา ดิจิทัล จำกัด'); 
		$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.'2', 'ทะเบียนจ่ายเช็ค เดือน'.$month_array[$m-1] . ' ' . ($y+543)); 

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.'3', 'วัน เดือน ปี'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.'3', 'ชื่อผู้รับ'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.'3', 'รายการ'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.'3', 'เลขที่เช็ค'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.'3', 'เลขที่ IV'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.'3', 'เลขที่ต้นทุน/QT'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.'3', 'เงินต้น'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.'3', 'VAT 7%'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.'3', 'ยอดรวม'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.'3', 'ภาษีหัก ณ ที่จ่าย'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.'3', 'จำนวนเงิน'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.'3', 'ยอดหน้าเช็ค'); 
		$objPHPExcel->getActiveSheet()->getStyle(
			'A3:L3'
		)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->db->where("cheque_date BETWEEN '{$y}-{$m}-01 00:00:00' and '{$y}-{$m}-31 23:59:59'");
		$this->db->where("pay_with","cheque");
		$res = $this->db->get("cheque_data")->result_array();
		$line = 4;
		foreach($res as $row){
			$tax = 0;
			$tax += floatval($row['cheque_tax1']);
			$tax += floatval($row['cheque_tax2']);
			$tax += floatval($row['cheque_tax3']);
			$tax += floatval($row['cheque_tax5']);
			$sum = floatval($row['cheque_sum']);
			$vat = floatval($row['cheque_vat']);
			$total = floatval($row['cheque_total']);
			$amount = floatval($row['cheque_amount']);
			$remain = $tax;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$line, sdateth($row['cheque_date'])); 
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$line, $row['cheque_name']); 
			
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$line, $row['cheque_no']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$line, ''); 
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$line, ''); 
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$line, number_format($total,2)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$line, number_format($vat,2)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$line, number_format($sum,2)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$line, number_format($tax,2)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$line, number_format($remain,2)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$line, number_format($amount,2)); 
			$objPHPExcel->getActiveSheet()->getStyle('C'.$line)->getAlignment()->setWrapText(true);
			if($row['cheque_api_version']==1){
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, ''); 
			}
			if($row['cheque_api_version']==2){
				$row_items = $this->cheque_model->get_items($row['cheque_id']);
				if(count($row_items)==1){
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, $row_items[0]['detail']); 
				}else{
					$detail = [];
					foreach($row_items as $itm){
						$detail[] = $itm['detail'] . " ยอด " . number_format($itm['total'],2) . " บาท\n";
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$line, implode('-',$detail)); 
				}
				
			}
			$objPHPExcel->getActiveSheet()->getStyle(
				'A'.$line.':L'.$line
			)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$line++;
		}

		foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
			$objPHPExcel->getActiveSheet()
					->getColumnDimension($col)
					->setAutoSize(true);
					
		} 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		//$objWriter->writeAllSheets();
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="report-cheque-'.$y.'-'.$m.'.xlsx"'); 
		header('Content-Transfer-Encoding: binary');
		$objWriter->save('php://output');
		header("");
		//$filename = "Student-data-sheet".".xlsx";
		//$objWriter->save($filename);
	}
}
