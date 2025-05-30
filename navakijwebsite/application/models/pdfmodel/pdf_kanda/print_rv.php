<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Print_rv extends CI_Model
{
    public function __construct()
    {
      parent::__construct();
      $this->load->model('administrator/admin_model');
      $this->load->model('administrator/rv_model');
      $this->load->model("administrator/bank_model");
      $this->load->model('holiday');
    }
    public function make($rv_id)
    {
        $rv = $this->rv_model->get($rv_id); 
		$items = $this->rv_model->get_items($rv_id);
		$items_0 = $this->rv_model->get_items_tax($rv_id,0);
		foreach(explode('|',TAX_RATE) as $rate){ 
			$ratekey = str_replace('.','_',$rate);
			${ 'items_'.$ratekey }= $this->rv_model->get_items_tax($rv_id,$rate);
			${ '$sum_tax_'.$ratekey } = 0;
			foreach(${ 'items_'.$ratekey } as $row){
				${ 'sum_tax_'.$ratekey } += $row['total'];
			}
		}
	

		
		$itms = [];
		foreach($items as $itm){
			if(($itm['detail']=="" && $itm['reftext']==$itms[count($itms)-1]['reftext']) && count($itms) > 0){
				$itms[count($itms)-1]['total'] = $itms[count($itms)-1]['total'] + floatval($itm['total']);
			}else{
				$itms[] = $itm;
			}
		}
		$items = $itms;
		$this->load->model("pdfmodel/fpdf");
		$this->load->model("pdfmodel/pdf_mc_table");
		$this->fpdf = new PDF_MC_Table();
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->SetDisplayMode("real");
		$this->fpdf->SetLeftMargin(20);
		$this->fpdf->SetAutoPageBreak(true,0);
	    $this->fpdf->AddFont('brow','','browa.php');
	    $this->fpdf->AddFont('brow','B','browab.php');
	    $this->fpdf->AddFont('sukhumvitset','','sukhumvitset.php');
	    $this->fpdf->AddFont('sukhumvitset','B','sukhumvitset-bold.php');
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->SetFont('brow','B',28);
        $this->fpdf->Cell( 180  , 15 , setUTF8('KANDA DIGITAL CO., LTD.') , 'TRL', 1 , 'C' );
        $this->fpdf->SetFont('sukhumvitset','B',16);
        $this->fpdf->Cell( 180  , 8 , setUTF8('ใบสำคัญรับ (RV.)') , 'BRL', 1 , 'C' );

        $y = $this->fpdf->getY();
        $this->fpdf->Line(20,$y,20,$y+29);
        $this->fpdf->Line(200,$y,200,$y+29);
        $this->fpdf->Ln(3);
		
		
		
		//เลขที่
		$this->fpdf->SetLineWidth(0.3);
		$this->fpdf->SetFont('sukhumvitset','B',10);
		$this->fpdf->Cell( 130  , 8 , setUTF8('เลขที่') , 0, 0 , 'R' );
		$this->fpdf->SetFont('sukhumvitset','',10);
		$this->fpdf->Cell( 50  , 8 , setUTF8('RV.'.thai_shortyear($rv['rv_date']).date("m",strtotime($rv['rv_date'])).'/') , 'B', 1 , 'L' );
		$this->fpdf->Ln(3);
		
		//รับจาก
		$this->fpdf->SetFont('sukhumvitset','B',14);
		$this->fpdf->Cell( 20  , 6 , setUTF8('รับจาก') , 0, 0 , 'L' );
		$this->fpdf->SetFont('sukhumvitset','B',10);
		$this->fpdf->Cell( 85  , 6 , setUTF8($rv['rv_name']) , 'B', 0 , 'L' );
		//วันที่
		$this->fpdf->SetFont('sukhumvitset','B',10);
		$this->fpdf->Cell( 25  , 6 , setUTF8('วันที่') , 0, 0 , 'R' );
		$this->fpdf->SetFont('sukhumvitset','',10);
		$this->fpdf->Cell( 50  , 6 , setUTF8(ldateth($rv['rv_date'])) , 'B', 1 , 'L' );
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->Ln(5);
		//คำอธิบายรายการ
		$this->fpdf->SetFont('sukhumvitset','B',10);
		$this->fpdf->Cell( 135  , 8 , setUTF8('คำอธิบายรายการ') , 1, 0 , 'C' );
		$this->fpdf->Cell( 45  , 8 , setUTF8('จำนวนเงิน') , 1, 1 , 'C' );
		

		
		$sy = $this->fpdf->getY();
		$sumitm =0;
		$sumitm_vat = 0;
		$lineheight=7;
		$fontsize=8;
		if(count($items) > 5){
			$lineheight=6;
			$fontsize=7;
		}
		$this->fpdf->SetFont('sukhumvitset','',$fontsize);
		foreach($items as $itms){
			$sumitm += $itms['total'];
			if($itms['is_vat']==1){
				$sumitm_vat += $itms['total'];	
			}
			if($itms['reftext']){
				$this->fpdf->SetWidths(array(107,25,3, 45));
				$this->fpdf->SetAligns(array('L','C','R','R'));
				$this->fpdf->Row(
					array(
						setUTF8(strtoupper($itms['detail'])),
						setUTF8($itms['reftext']),
						"",
						number_format($itms['total'],2)
						)
				,[1,2,1,1],['','B','',''],$lineheight,0,['',[255,0,0],'','']);
			}else{
				$this->fpdf->SetWidths(array(107,25,3, 45));
				$this->fpdf->SetAligns(array('L','C','R','R'));
				$this->fpdf->Row(
					array(
						setUTF8($itms['detail']),
						"",
						"",
						number_format($itms['total'],2)
						)
				,[1,0,0,1],['','','',''],$lineheight,0,['','','','']);
				// $this->fpdf->Row(
				// 	array(
				// 		setUTF8($itms['detail']),
				// 		number_format($itms['total'],2)
				// 		)
				// ,[1,1],'',7,0);
			}
			
		}
		$this->fpdf->SetWidths(array(135, 45));
		$this->fpdf->SetAligns(array('L','R'));
		$this->fpdf->Cell(20, $lineheight ,'','L',0);
		$this->fpdf->SetFont('sukhumvitset','B',$fontsize);
		$this->fpdf->Cell( 115  , $lineheight , setUTF8('รวม') , 'R', 0 , 'L' );
		$this->fpdf->Cell( 45  , $lineheight , number_format($sumitm,2) , 'R', 1 , 'R' );
		if($rv['rv_vat'] > 0){
			$this->fpdf->SetFont('sukhumvitset','B',$fontsize);
			$this->fpdf->Cell(20, $lineheight ,setUTF8('บวก'),'L',0,'R');
			$this->fpdf->SetFont('sukhumvitset','',$fontsize);
			$this->fpdf->Cell( 47  , $lineheight , setUTF8('ภาษีมูลค่าเพิ่ม  7 %') , 'R', 0 , 'L' );
			$this->fpdf->SetLineWidth(0.7);
			$this->fpdf->Cell( 35  , $lineheight , number_format($sumitm_vat,2) , 1, 0 , 'C' );
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->Cell( 33  , $lineheight , '' , 'R', 0 , 'L' );
			$this->fpdf->Cell( 45  , $lineheight , number_format($rv['rv_vat'],2) , 'R', 1 , 'R' );
			$this->fpdf->Cell(20,8,'','L',0);
			$this->fpdf->SetFont('sukhumvitset','B',$fontsize);
			$this->fpdf->Cell( 115  , $lineheight , setUTF8('รวม') , 'R', 0 , 'L' );
			$this->fpdf->Cell( 45  , $lineheight , number_format($rv['rv_sum'],2) , 'R', 1 , 'R' );
			$this->fpdf->SetFont('sukhumvitset','',$fontsize);
		}
		foreach(explode('|',TAX_RATE) as $rate){ 
			$ratekey = str_replace('.','_',$rate);
			if($rv['rv_tax'.$ratekey] > 0){
				$this->fpdf->SetFont('sukhumvitset','B',$fontsize);
				$this->fpdf->Cell(20, $lineheight ,setUTF8('หัก'),'L',0,'R');
				$this->fpdf->SetFont('sukhumvitset','',$fontsize);
				$this->fpdf->Cell( 47  , $lineheight , setUTF8('ภาษี ณ ที่จ่าย  '.$rate.'%') , 'R', 0 , 'L' );
				$this->fpdf->SetLineWidth(0.7);
				$this->fpdf->Cell( 35  , $lineheight , number_format(${ 'sum_tax_'.$ratekey },2) , 1, 0 , 'C' );
				$this->fpdf->SetLineWidth(0.50);
				$this->fpdf->Cell( 33  , $lineheight , '' , 'R', 0 , 'L' );
				$this->fpdf->Cell( 45  , $lineheight , '('.number_format($rv['rv_tax'.$ratekey],2).')' , 'R', 1 , 'R' );
			}
		}
		
		
		if($rv['rv_bank_fee'] > 0){
			$this->fpdf->SetFont('sukhumvitset','B',$fontsize);
			$this->fpdf->Cell(20, $lineheight ,setUTF8('หัก'),'L',0,'R');
			$this->fpdf->SetFont('sukhumvitset','',$fontsize);
			$this->fpdf->Cell( 115  , $lineheight , setUTF8('ค่าธรรมเนียมธนาคาร') , 'R', 0 , 'L' );
			$this->fpdf->Cell( 45  , $lineheight , '('.number_format($rv['rv_bank_fee'],2).')' , 'R', 1 , 'R' );
		}
		if($rv['rv_discount'] > 0){
			$this->fpdf->SetFont('sukhumvitset','B',$fontsize);
			$this->fpdf->Cell(20, $lineheight ,setUTF8('หัก'),'L',0,'R');
			$this->fpdf->SetFont('sukhumvitset','',$fontsize);
			$this->fpdf->Cell( 115  , $lineheight , setUTF8('อื่น ๆ/ส่วนลด') , 'R', 0 , 'L' );
			$this->fpdf->Cell( 45  , $lineheight , '('.number_format($rv['rv_discount'],2).')' , 'R', 1 , 'R' );
		}
		if($rv['rv_remark'] != ""){
			$this->fpdf->Row(
				array(
					'',
					''
					)
			,[1,1],'', $lineheight ,0);
			$this->fpdf->Row(
				array(
					'',
					''
					)
			,[1,1],'', $lineheight ,0);
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->Row(
				array(
					setUTF8($rv['rv_remark']),
					''
					)
			,[1,1],'', $lineheight ,0);
		}
		
		do {
			$this->fpdf->Row(
									array(
										"",
										""
										)
										,'','', $lineheight ,0);
		} while (  $this->fpdf->getY() < 170);

		$endy = $this->fpdf->getY();
		
		
		$y = $this->fpdf->getY();
		$this->fpdf->Line(20,$y,190,$y);
		if($rv['pay_with']=="cheque"){
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->Cell(15,7,setUTF8('ธนาคาร'),'LT',0,'R');
			$this->fpdf->SetTextColor(19,27,205);
			$this->fpdf->SetLineWidth(0.3);
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->Cell(35,7,setUTF8($rv['bank_name']),'TB',0,'L');
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->Cell(15,7,setUTF8('สาขา'),'T',0,'R');
			$this->fpdf->SetTextColor(19,27,205);
			$this->fpdf->SetLineWidth(0.3);
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->Cell(25,7,setUTF8($rv['rv_bank_branch']),'TB',0,'L');
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->Cell(15,7,setUTF8('เลขที่เช็ค'),'T',0,'R');
			$this->fpdf->SetTextColor(209,19,19);
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->SetLineWidth(0.3);
			$this->fpdf->Cell(28,7,setUTF8($rv['rv_cheque_no']),'TB',0,'L');
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->Cell(2,7,setUTF8(''),'TR',0,'R');
			$this->fpdf->SetFont('sukhumvitset','B',16);
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->Cell(45,14,setUTF8(number_format($rv['rv_amount'],2)),'TRB',1,'R');
		}else{
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->Cell(15,7,setUTF8('ธนาคาร'),'LT',0,'R');
			$this->fpdf->SetTextColor(19,27,205);
			$this->fpdf->SetLineWidth(0.3);
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->Cell(35,7,setUTF8(""),'TB',0,'L');
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->Cell(15,7,setUTF8('สาขา'),'T',0,'R');
			$this->fpdf->SetTextColor(19,27,205);
			$this->fpdf->SetLineWidth(0.3);
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->Cell(25,7,setUTF8(''),'TB',0,'L');
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->Cell(15,7,setUTF8('เลขที่เช็ค'),'T',0,'R');
			$this->fpdf->SetTextColor(209,19,19);
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->SetLineWidth(0.3);
			$this->fpdf->Cell(28,7,setUTF8(""),'TB',0,'L');
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->Cell(2,7,setUTF8(''),'TR',0,'R');
			$this->fpdf->SetFont('sukhumvitset','B',16);
			$this->fpdf->SetLineWidth(0.50);
			$this->fpdf->Cell(45,14,setUTF8(number_format($rv['rv_amount'],2)),'TRB',1,'R');
		}
		//exit($rv['pay_with']);
		
		$this->fpdf->setY($y+7);
		$this->fpdf->SetFont('sukhumvitset','',8);
		
		$this->fpdf->Cell(2,7,setUTF8(''),'LB',0,'R');
		
		$this->fpdf->Rect(23,$y+8,4,4);
		$this->fpdf->Rect(42,$y+8,4,4);
		if($rv['pay_with']=="cash"){
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->Text(24,$y+11,'X');
			$this->fpdf->Cell(20,7,setUTF8('เงินสด'),'B',0,'C');
			$this->fpdf->SetFont('sukhumvitset','',8);
		}else{
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->Cell(20,7,setUTF8('เงินสด'),'B',0,'C');
			$this->fpdf->SetFont('sukhumvitset','',8);
		}
		if($rv['pay_with']=="transfer"){
			
			$this->fpdf->SetFont('sukhumvitset','B',8);
			$this->fpdf->Text(43,$y+11,'X');
			$this->fpdf->Cell(16,7,setUTF8('โอนเงิน'),'B',0,'R');
			$this->fpdf->SetFont('sukhumvitset','',8);
			if($rv['rv_bookbank_id']){
				$bookbank = $this->bank_model->BookbankProfile($rv['rv_bookbank_id']);
				$this->fpdf->SetLineWidth(0.30);
				$this->fpdf->Line(
					$this->fpdf->getX(),
					$this->fpdf->getY()+6,
					$this->fpdf->getX()+70,
					$this->fpdf->getY()+6);
				$this->fpdf->SetLineWidth(0.50);
				$this->fpdf->Cell(20,7,setUTF8($bookbank['bookbank_callname']),'B',0,'L');
				
				
			}
			
		}else{
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->Cell(16,7,setUTF8('โอนเงิน'),'B',0,'R');
			$this->fpdf->SetFont('sukhumvitset','',8);
			$this->fpdf->SetLineWidth(0.30);
				$this->fpdf->Line(
					$this->fpdf->getX(),
					$this->fpdf->getY()+6,
					$this->fpdf->getX()+70,
					$this->fpdf->getY()+6);
				$this->fpdf->SetLineWidth(0.50);
		}
		
		
		$this->fpdf->setX(112);
		$this->fpdf->Cell(41,7,setUTF8('จำนวนเงิน (บาท)'),'B',0,'R');
		$this->fpdf->Cell(2,7,setUTF8(''),'BR',1,'R');
		$sss = $this->fpdf->getY();

		$this->fpdf->setY($sy);
		$this->fpdf->SetLineWidth(0.3);
		$this->fpdf->SetDrawColor(78,78,78);
		$this->fpdf->SetDash(0.3,0.5);
		do {
			$this->fpdf->Cell(180, $lineheight ,setUTF8(''),'B',1,'R');
		} while (  $this->fpdf->getY() < $endy-7);
		$this->fpdf->SetDash(0,0);
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->setY($sss);
		//คำอธิบายรายการ
		//$this->fpdf->Ln();
		$this->fpdf->SetFont('sukhumvitset','B',8);
		$this->fpdf->Cell( 20  , 6 , setUTF8('รหัสบัญชี') , 1, 0 , 'C' );
		$this->fpdf->Cell( 70  , 6 , setUTF8('ชื่อบัญชี') , 1, 0 , 'C' );
		$this->fpdf->Cell( 45  , 6 , setUTF8('เดบิท') , 1, 0 , 'C' );
		$this->fpdf->Cell( 45  , 6 , setUTF8('เครดิต') , 1, 1 , 'C' );
		$this->fpdf->SetFont('sukhumvitset','',10);

		$this->fpdf->SetWidths(array(20,70,35,10,35,10));
		//$this->fpdf->SetAligns(array('L','R'));
		$sy = $this->fpdf->getY();
		do {
			$this->fpdf->Row(
									array(
										"",
										"",
										"",
										"",
										"",
										""
										)
										,'','',$lineheight,0);
		} while (  $this->fpdf->getY() < 250);

		$endy = $this->fpdf->getY();
		
		$this->fpdf->SetFont('sukhumvitset','B',8);
		$this->fpdf->Cell( 20  , 6 , setUTF8('') , 1, 0 , 'C' );
		$this->fpdf->Cell( 70  , 6 , setUTF8('ยอดรวม') , 1, 0 , 'C' );
		$this->fpdf->Cell( 35  , 6 , setUTF8('') , 1, 0 , 'C' );
		$this->fpdf->Cell( 10  , 6 , setUTF8('') , 1, 0 , 'C' );
		$this->fpdf->Cell( 35  , 6 , setUTF8('') , 1, 0 , 'C' );
		$this->fpdf->Cell( 10  , 6 , setUTF8('') , 1, 1, 'C' );
		
		$this->fpdf->Cell( 180  , 0.5 , setUTF8('') , 'BLR', 1, 'C' );
		$endy2 = $this->fpdf->getY();

		$this->fpdf->setY($sy);
		$this->fpdf->SetLineWidth(0.3);
		$this->fpdf->SetDrawColor(78,78,78);
		$this->fpdf->SetDash(0.3,0.5);
		do {
			$this->fpdf->Cell(180,6,setUTF8(''),'B',1,'R');
		} while (  $this->fpdf->getY() < $endy-10);
		$this->fpdf->SetDash(0,0);
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		
		$this->fpdf->SetWidths(array(36,36,36,36,36));
		$this->fpdf->setY($endy2);
		$sy = $this->fpdf->getY();
		do {
			$this->fpdf->Row(
									array(
										"",
										"",
										"",
										"",
										""
										)
								);
		} while (  $this->fpdf->getY() < 275);

		$endy = $this->fpdf->getY();
		
		$this->fpdf->SetFont('sukhumvitset','B',8);
		$this->fpdf->Cell( 36  , 6 , setUTF8('ผู้จัดทำ') , 1, 0 , 'C' );
		$this->fpdf->Cell( 36  , 6 , setUTF8('ฝ่ายบัญชี') , 1, 0 , 'C' );
		$this->fpdf->Cell( 36  , 6 , setUTF8('ตรวจสอบ') , 1, 0 , 'C' );
		$this->fpdf->Cell( 36  , 6 , setUTF8('ผู้อนุมัติ') , 1, 0 , 'C' );
		$this->fpdf->Cell( 36  , 6 , setUTF8('ผู้รับเงิน') , 1, 1 , 'C' );
		$me = $this->admin_library->me();
		if($me['user_signature']){
			if(file_exists('public/uploads/user_signature/'.$me['user_signature'])){
				$this->fpdf->Image('public/uploads/user_signature/'.$me['user_signature'], 28,262,20.125,8.25);
			}
			
		}
		$this->fpdf->SetFont('sukhumvitset','',6);
		//$this->fpdf->SetTextColor(182,182,182);
		$ref  = 'REF : ' . sprintf("DOC-RV%06d",$rv['rv_id']);
		$ref .= ', RE-PRINT : '.sdateth(date("d F Y H:i:s"));
		$ref .= ', IP : '.$this->input->ip_address();
		$ref .= ', System Version : '. $this->config->item("system_version");
		$this->fpdf->setY(287);
		$this->fpdf->Cell( 0  , 5 , setUTF8($ref) , 0 ,1,'R');
		if($rv['rv_status']=="deleted"){
			$this->fpdf->Image('public/cheque/cancelled.png', 70,140,50,32);
		}
		$this->fpdf->Output('pdf/pv_'.$rv_id.'.pdf',"I");
    }
}