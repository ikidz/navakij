<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('FPDF_FONTPATH','font/');
define('urlwebsite',config_item('base_url'));
require(APPPATH . '/controllers/fpdf/fpdf.php');
/**
* Project Name : crm.atfirstbyte.net
* Build Date : 2/20/2558 BE
* Author Name : Jarak Kritkiattisak
* File Name : receipt.php
* File Location : /Volumes/Macintosh HD/Users/mycools/Library/Caches/Coda 2/0E3A670A-04A4-413A-BA61-A7A21109F6EE
* File Type : Controller	
* Remote URL : http://crm.atfirstbyte.net/application/models/pdfmodel/receipt.php
*/
class Receipt extends CI_Model {
	private $pdf;
	private $curr_page=1;
	public function makepdf($type,$invoice_id,$send)
	{
		$row_quo=$this->database->row("SELECT * FROM tbl_invoice LEFT JOIN tbl_customers ON tbl_customers.customer_id=tbl_invoice.customer_id LEFT JOIN tbl_customers_contact ON tbl_customers_contact.contact_id=tbl_invoice.contact_id WHERE invoice_id='".$invoice_id."'");
			$sig=$this->database->row("SELECT * FROM tbl_users WHERE user_id=".$row_quo['approve_user']);
			if($sig['signature']==""||$row_quo['quotation']==0)
			{
				$sig['name']='';
				$sig['surname']='';
				$sig['signature']='';
				$w=0;
				$h=0;
			}
			else
			{
				$size=getImageSize('uploads/'.$sig['signature']);
							
				if($size['mime']=='image/gif'||$size['mime']=='image/jpeg'||$size['mime']=='image/pjpeg'||$size['mime']=='image/jpg'||$size['mime']=='image/png')
				{
					/*if($size[0]>$size[1])
					{*/
						$w=40;
						$h=$w*$size[1]/$size[0];
					/*}
					else
					{
						$h=10;
						$w=$h*$size[0]/$size[1];
					}*/
				}
			}
		
		
		$this->_call('ต้นฉบับ',$invoice_id,$this->pdf_mc_table,$row_quo,$sig,$w,$h);
		$this->_call('สำเนา',$invoice_id,$this->pdf_mc_table,$row_quo,$sig,$w,$h);
		$this->_call('สำเนา',$invoice_id,$this->pdf_mc_table,$row_quo,$sig,$w,$h);
		
		if(file_exists("pdf/".$type.$invoice_id.".pdf"))
			unlink("pdf/".$type.$invoice_id.".pdf");

		$this->pdf_mc_table->Output("pdf/".$type.$invoice_id.".pdf","F");

		if($send!="")
			header("location:".$urlwebsite.'order/send/'.$type.'/'.$invoice_id.'.html?mail='.(isset($_GET['mail'])?$_GET['mail']:'').'&cc='.(isset($_GET['cc'])?$_GET['cc']:'').'&subject='.(isset($_GET['subject'])?$_GET['subject']:''));
		else
			$this->pdf_mc_table->Output();
	}
	private function _call($title,$invoice_id,$pdf,$row_quo,$sig,$w,$h)
	{
		$this->_header($title,$invoice_id,$pdf,$row_quo,$sig,$w,$h,false);
		
		$query = $this->db->query("SELECT * FROM tbl_invoice_order WHERE invoice_id='".$invoice_id."' AND in_order_id=0 ORDER BY order_id ASC");
		$sum_price=0;	
		$pdf->SetWidths(array(20, 95,20, 20, 35));
		$pdf->SetAligns(array('C', 'L', 'C', 'R', 'R'));
		
		$this->_footer($title,$invoice_id,$pdf,$row_quo,$sig,$w,$h,$row_quo,$sum_price);
	}
	
	private function _header($title,$invoice_id,$pdf,$row_quo,$sig,$w,$h,$is_not_firstpage=false)
	{
		if($is_not_firstpage){
			
			$pdf->Cell( 20  , 5 ,'', 'RLB' ,0,'C');
			$pdf->Cell( 95  , 5 ,'', 'RB' ,0,'L');
			$pdf->Cell( 20  , 5 ,'', 'RB' ,0,'R');
			$pdf->Cell( 20  , 5 ,'', 'RB' ,0,'R');
			$pdf->Cell( 35  , 5 ,'', 'RB' ,1,'R');
			$pdf->Cell( 190  , 7 , $this->pdf_mc_table->setUTF8('มีต่อหน้าที่ '.($this->curr_page).'>>') , 0 , 1 , 'R' );
		}else{
			$this->curr_page=1;
		}
		$pdf->AddPage();
		$pdf->AddFont('brow','','browa.php');
		$pdf->AddFont('brow','B','browab.php');
		$pdf->AddFont('brow','I','browai.php');
		$pdf->AddFont('brow','BI','browaz.php');
		$pdf->SetTextColor(0,0,0);

		// Start Head Bill

		$pdf->SetFont('brow','B',20);
		$row_quo['vat']!=0?
			$pdf->Cell( 0  , 5 , $this->pdf_mc_table->setUTF8($this->common->web_config('bill_name')) , 0, 1, 'L' ):
			$pdf->Cell( 0  , 5 , $this->pdf_mc_table->setUTF8($this->common->web_config('bill_name2')) , 0, 1, 'L' );

		$pdf->SetFont('brow','',13);
		$pdf->Cell( 165  , 5 , $this->pdf_mc_table->setUTF8($this->common->web_config('bill_address')) , 0, 0 , 'L' );
		$pdf->Cell( 25  , 5 , $pdf->Image('images/logo_web.png',($pdf->GetX()-24),($pdf->GetY()-9),53,15,'') , 0, 1 , 'L' );

		$id=($row_quo['vat']!=0)?$this->common->web_config('bill_id'):"";
		$pdf->Cell( 0  ,5 , $this->pdf_mc_table->setUTF8('หมายเลขประจำตัวผู้เสียภาษี '.$id) , 0, 1 , 'L' );
		
		$pdf->Cell( 0  , 5 , $this->pdf_mc_table->setUTF8('TEL : '.$this->common->web_config('bill_phone')) , 0 , 1 , 'L' );
		
		// End Head Bill

		$pdf->SetFont('brow','B',18);
		$pdf->Cell( 0  , 5 ,$this->pdf_mc_table->setUTF8('ใบแจ้งหนี้') , 0 , 1 , 'C' );
		$pdf->SetFont('brow','',15);
		$pdf->Cell( 0  , 5 ,$this->pdf_mc_table->setUTF8('INVOICE') , 0 , 1 , 'C' );
		
		$_id=$row_quo['invoice_id'];
		$date=($row_quo['date_receipt2']!='0000-00-00')?$this->time_fnc->trans_fulldate($row_quo['date_receipt2']):$this->time_fnc->trans_fulldate(date("Y-m-d"));
		
		$pdf->SetFont('brow','B',22);
		$pdf->Cell( 25  , 5 , $this->pdf_mc_table->setUTF8($title));
		
		$pdf->Ln();
		$pdf->Ln();
		
		// Start Customer detail
		
		$pdf->SetFont('brow','B',12);
		
		$pdf->Cell( 120  , 8 , '' , 0 ,0,'C');
		$pdf->Cell( 35  , 8 , $this->pdf_mc_table->setUTF8('เลขที่ / No.' ) , "TL" ,0,'C');
		$pdf->Cell( 35  , 8 , $this->pdf_mc_table->setUTF8('วันที่ / Date') , "TRL" ,1,'C');
		
		$pdf->Cell( 190  , 0 , '' , "B" ,1,'R');
		
		$pdf->Cell( 20  , 8 , $this->pdf_mc_table->setUTF8('รหัสลูกค้า') , 'L' ,0,'R');
		$pdf->SetFont('brow','',12);
		$pdf->Cell( 100  , 8 , $this->pdf_mc_table->setUTF8(($row_quo['code']!='')?$row_quo['code'].$row_quo['code_no']:'...................................................' ) , 0 ,0,'L');
		$pdf->Cell( 35  , 8 , $this->pdf_mc_table->setUTF8($row_quo['billing_id']) , "BL" ,0,'C');
		$pdf->Cell( 35  , 8 , $this->pdf_mc_table->setUTF8($date) , "RL" ,1,'C');

		$row_quo['address']==""?$row_quo['address']='-':'';
		$row_quo['company']==""?$row_quo['company']='-':'';
		
		$pdf->SetFont('brow','B',12);
		$pdf->Cell( 20  , 6 , $this->pdf_mc_table->setUTF8('นาม/Name') , 'L' ,0,'R');
		$pdf->SetFont('brow','',12);
		$pdf->Cell( 135  , 6 , $this->pdf_mc_table->setUTF8($row_quo['company']) , 0 ,0,'L');
		$pdf->Cell( 35  , 6 , $this->pdf_mc_table->setUTF8('หน้าที่ '.$this->curr_page) , "RL" ,1,'C');
		
		$address=str_replace('<br />','',$row_quo['address']);
		
		$address=explode(' ',$address);
		$addr[0]='';
		$addr[1]='';
		$i=0;
		foreach($address as $address)
		{
			$addr[$i].=$address.' ';
			
			if(strlen($addr[$i])>160&&$i==0)
				$i++;
		}
		
		$pdf->SetFont('brow','B',12);
		$pdf->Cell( 20  , 6 , $this->pdf_mc_table->setUTF8('ที่อยู่/Addr') , 'L' ,0,'R');
		//$pdf->SetFont('brow','',12);
		$pdf->Cell( 135  , 6 , $this->pdf_mc_table->setUTF8($addr[0]) , 0 ,0,'L');
		$pdf->Cell( 35  , 6 , $this->pdf_mc_table->setUTF8('เงื่อนไขในการชำระเงิน') , "RL" ,1,'C');
		
		$pdf->Cell( 20  , 6 , '' , 'L');
		$pdf->Cell( 135  , 6 ,  $this->pdf_mc_table->setUTF8($addr[1]) , 0 ,0,'L');
		$pdf->Cell( 35  , 6 , $this->pdf_mc_table->setUTF8('TERM OF PAYMENT') , "RLB" ,1,'C');
		
		$pdf->SetFont('brow','B',12);
		$pdf->Cell( 20  , 7 , $this->pdf_mc_table->setUTF8('โทรศัพท์') , 'L' ,0,'R');
		$pdf->SetFont('brow','',12);
		$pdf->Cell( 135  , 7 , $this->pdf_mc_table->setUTF8($row_quo['phone'].(($row_quo['contact_tel']!="")?', Mobile : '.$row_quo['contact_tel']:'')) , 0 ,0,'L');
		$pdf->Cell( 35  , 7 , $this->pdf_mc_table->setUTF8($row_quo['pay_note']) , "RL" ,1,'C');
		
		$pdf->SetFont('brow','B',12);
		$pdf->Cell( 35  , 7 ,$this->pdf_mc_table->setUTF8('เลขประจำตัวผู้เสียภาษี'), "L" ,0,'R');
		$pdf->SetFont('brow','',12);
		$pdf->Cell( 120  , 7 , $this->pdf_mc_table->setUTF8($row_quo['tax_id']) , "R" ,0,'L');
		$pdf->Cell( 35  , 7 , '' , "RL" ,1,'C');
		// End Customer detail
			
		// Start order detail
		
		$pdf->SetFont('brow','B',12);
		
		$pdf->Cell( 20  , 7 , $this->pdf_mc_table->setUTF8('ลำดับ') , 'TL' ,0,'C');
		$pdf->Cell( 95  , 7 , $this->pdf_mc_table->setUTF8('รหัสบริการ/รายละเอียด') , 'TL' ,0,'C');
		$pdf->Cell( 20  , 7 , $this->pdf_mc_table->setUTF8('จำนวน' ) , 'TL' ,0,'C');
		$pdf->Cell( 20  , 7 , $this->pdf_mc_table->setUTF8('หน่วยละ' ) , 'TL' ,0,'C');
		$pdf->Cell( 35  , 7 , $this->pdf_mc_table->setUTF8('จำนวนเงิน' ) , 'TLR' ,1,'C');
		
		$pdf->SetFont('brow','',12);
		
		$pdf->Cell( 20  , 5 , 'ITEM', 'LB' ,0,'C');
		$pdf->Cell( 95  , 5 , 'DESCRIPTION', 'LB' ,0,'C');
		$pdf->Cell( 20  , 5 , 'QTY.', 'LB' ,0,'C');
		$pdf->Cell( 20  , 5 , 'UNIT/PRICE', 'LB' ,0,'C');
		$pdf->Cell( 35  , 5 , 'AMOUT', 'LBR' ,1,'C');
		$this->curr_page++;
	}
	private function _footer($title,$invoice_id,$pdf,$row_quo,$sig,$w,$h,$row_quo,$sum_price)
	{
		$pdf->SetFont('brow','B',12);
		if($row_quo['vat']!=0)
			$pdf->Cell( 115  , 7 , '' , 'LT' , 0 , 'LR' );
		else
		{
			$pdf->Cell( 20  , 7 , $this->pdf_mc_table->setUTF8('ตัวอักษร') , 'LT' , 0 , 'C' );
			$pdf->SetFont('brow','',12);
			$pdf->Cell( 95  , 7 , $this->pdf_mc_table->setUTF8('- '.$this->common->convert((number_format($sum_price,2,'.',''))).' -') , 'LT' , 0 , 'C' );
			$pdf->SetFont('brow','B',12);
		}
		$pdf->Cell( 40  , 7 , $this->pdf_mc_table->setUTF8('รวมเป็นเงิน') , "LBT" , 0 , 'L' );
		$pdf->SetFont('brow','',12);
		$pdf->Cell( 35  , 7 , number_format((number_format($sum_price,2,'.','')),2) , 1 , 1 , 'R' );
		
		if($row_quo['vat']!=0)
		{
			$vat=$this->pdf_mc_table->setUTF8('ภาษีมูลค่าเพิ่ม '.$this->common->web_config('vat').'%');			
			$sum_vat=$this->pdf_mc_table->setUTF8('รวมสุทธิ');
			$_vat=number_format(($row_quo['price']-(number_format($sum_price,2,'.',''))),2);
			$_sum_vat=number_format(($row_quo['price']),2);
		}
		else
		{
			$vat="";
			$_vat="";
			$sum_vat="";
			$_sum_vat="";
		}
		
		if($row_quo['vat']!=0)
		{
			$pdf->SetFont('brow','B',12);
			$pdf->Cell( 115  , 7 , '' , 'L' , 0 , 'R' );
			$pdf->Cell( 40  , 7 , $vat , 'BL' , 0 , 'L' );
			$pdf->SetFont('brow','',12);
			$pdf->Cell( 35  , 7 , $_vat, 'BRL' , 1 , 'R' );
			
			$pdf->SetFont('brow','B',12);
			$pdf->Cell( 20  , 7 , $this->pdf_mc_table->setUTF8('ตัวอักษร') , 'LT' , 0 , 'C' );
			$pdf->SetFont('brow','',12);
			$pdf->Cell( 95  , 7 , $this->pdf_mc_table->setUTF8('- '.$this->common->convert($_sum_vat).' -') , 'LT' , 0 , 'C' );
			$pdf->SetFont('brow','B',12);
			$pdf->Cell( 40  , 7 , $sum_vat , 'L' , 0 , 'L' );
			$pdf->SetFont('brow','',12);
			$pdf->Cell( 35  , 7 , $_sum_vat , 'RL' , 1 , 'R' );
		}
		$pdf->Cell( 190  , 0 , '' , 'T' , 1 , 'R' );
		// End order sumary

		$pdf->Ln();
		
		$company=($row_quo['vat']!=0)?
			$this->common->web_config('bill_name'):
			$this->common->web_config('bill_name2');
			
		//Start text Signature
		$pdf->Cell( 40  , 7 , $this->pdf_mc_table->setUTF8('ตามใบสั่งซื้อ') , 'L' , 0 , 'C' );
		$pdf->Cell( 60  , 7 , $this->pdf_mc_table->setUTF8('  ในนามของ '.$company) , 'L' , 0 , 'L' );
		$pdf->Cell( 30  , 7 , $this->pdf_mc_table->setUTF8('') , 'L' , 0 , 'C' );
		$pdf->SetFont('brow','',11);
		$pdf->Cell( 60  , 7 , $this->pdf_mc_table->setUTF8('ข้าพเจ้าได้รับใบแจ้งหนี้') , 'LR' , 1 , 'C' );
		
		$pdf->SetFont('brow','',12);
		$pdf->Cell( 40  , 7 , $this->pdf_mc_table->setUTF8('PURCHASE ORDER NO.') , 'LB' , 0 , 'C' );
		$pdf->Cell( 60  , 7 , '' , 'L' , 0 , 'L' );
		$pdf->Cell( 30  , 7 , '' , 'L' , 0 , 'C' );
		$pdf->SetFont('brow','',11);
		$pdf->Cell( 60  , 7 , $this->pdf_mc_table->setUTF8('ตามที่ระบุข้างบนนี้โดยถูกต้อง และทราบเงื่อนไขแล้ว') , 'LR' , 1 , 'C' );
		
		$pdf->SetFont('brow','',12);
		
		$pdf->Cell( 40  , 7 , $this->pdf_mc_table->setUTF8('เลขที่ '.$row_quo['purchase_no']) , 'L' , 0 , 'L' );
		$pdf->Cell( 60  , 7 , '..........................................................' , 'L' , 0 , 'C' );
		$pdf->Cell( 30  , 7 , '..............................' , 'L' , 0 , 'C' );
		$pdf->Cell( 60  , 7 , '..........................................................' , 'LR' , 1 , 'C' );
		
		$pdf->Cell( 40  , 6 , $this->pdf_mc_table->setUTF8('ลงวันที่ '.(($row_quo['purchase_date']!='0000-00-00')?$this->time_fnc->trans_date($row_quo['purchase_date']):'')) , 'LB' , 0 , 'L' );
		$pdf->Cell( 60  , 6 , $this->pdf_mc_table->setUTF8('ผู้มีอำนาจลงนาม / Authorized') , 'LB' , 0 , 'C' );
		$pdf->Cell( 30  , 6 , $this->pdf_mc_table->setUTF8('ผู้ส่ง/ Deliverred By') , 'LB' , 0 , 'C' );
		$pdf->Cell( 60  , 6 , $this->pdf_mc_table->setUTF8('ผู้รับ/Receiver By') , 'LRB' , 1 , 'C' );
		//End text Signature
		
		$pdf->SetFont('','',10);
		$pdf->Cell( 190  , 5 , $this->pdf_mc_table->setUTF8("ในการชำระค่าบริการด้วยเช็คโปรดขีดคร่อมและสั่งจ่ายระบุชื่อ ".$company." กรรมสิทธ์ตามใบกำกับภาษีฉบับนี้จะโอนไปยังท่านเมื่อท่านได้ชำระเงินเสร็จแล้ว") , 0 , 1 , 'C' );
	}
}

/* End of file receipt.php */
/* Location: ./application/controllers/receipt.php */