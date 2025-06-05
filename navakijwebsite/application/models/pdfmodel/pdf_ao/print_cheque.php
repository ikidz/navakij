<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Print_cheque extends CI_Model
{
  public function __construct()
    {
      parent::__construct();
      $this->load->model('administrator/admin_model');
      $this->load->model('administrator/cheque_model');
      $this->load->model("administrator/bank_model");
      $this->load->model('holiday');
    }
  function cheque($cheque_id)
	{
		$cheque = $this->cheque_model->get($cheque_id);
		$this->load->model("pdfmodel/fpdf");
		$this->load->model("pdfmodel/pdf_mc_table");
		$this->load->library('mpdf');
		$this->fpdf = new FPDF();
	    $this->fpdf->SetDisplayMode("real");
	    $this->mpdf->SetAutoPageBreak(true,0);
	    $this->fpdf->AddFont('cheque','','cheque.php');
	    $this->fpdf->AddFont('brow','','browa.php');
	    $this->fpdf->AddFont('brow','B','browab.php');
	    $this->fpdf->AddFont('sukhumvitset','','sukhumvitset.php');
	    $this->fpdf->AddFont('sukhumvitset','B','sukhumvitset-bold.php');
	    $this->fpdf->AddPage('P','A4');
		
//		$left_margin=0;
//    	$top_margin=0;
//		$this->fpdf->Image('public/cheque/background-cheque.jpg', $left_margin, $top_margin,177,0);
//		$this->fpdf->SetFont('cheque','',18);
//    	$this->fpdf->Text( $left_margin+7  , $top_margin+82 , setUTF8('A37 C31974473C011D0014A 0141074922C'));
		
	    $this->fpdf->SetY(4);
	    $this->fpdf->SetFont('brow','B',25);
	    $day = date("d",strtotime($cheque['cheque_date']));
	    $month = date("m",strtotime($cheque['cheque_date']));
	    $years = date("Y",strtotime($cheque['cheque_date']))+543;
	    $years="{$years}";
	    $cheque_name = ($cheque['cheque_cash']=="1")?"เงินสด":$cheque['cheque_name'];
	    $this->fpdf->Cell( 110  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 50  , 6 , setUTF8("{$day[0]}  {$day[1]}  {$month[0]}  {$month[1]}  {$years[0]}  {$years[1]}  {$years[2]}  {$years[3]}") , 0, 0 , 'L' );
		
		
		if($cheque['cheque_cash']=="1"){	
		
		}else if($cheque['cheque_acpayee']=="0"){
			
		}else {
			$this->fpdf->SetFont('brow','B',18);
			$this->fpdf->SetTextColor(255,4,0);
			$this->fpdf->SetDrawColor(255,4,0);
			$this->fpdf->SetY(10);
			$this->fpdf->SetX(42);
			$this->fpdf->Line(41,10,81,10);
			$this->fpdf->Line(41,17,81,17);
	    	$this->fpdf->Cell( 10  , 6 , setUTF8('A/C PAYEE ONLY') , 0, 0 , 'L' );
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetDrawColor(0,0,0);
			$this->fpdf->Line(160,23,172,23);
			$this->fpdf->Line(160,24,172,24);
			$this->fpdf->Line(160,25,172,25);
		}
	
	    $this->fpdf->SetFont('brow','B',14);
	    $this->fpdf->Ln();
	    $this->fpdf->SetY(20);
	    $this->fpdf->Cell( 10  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 135  , 6 , setUTF8($cheque_name) , 0, 0 , 'L' );
	    $this->fpdf->Ln();
	    $this->fpdf->SetY(28);
	    $this->fpdf->Cell( 10  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 135  , 6 , setUTF8('** '.thaitext($cheque['cheque_amount']).' **') , 0, 0 , 'L' );
	    $this->fpdf->SetFont('brow','B',18);
	    $this->fpdf->Ln();
	    $this->fpdf->SetY(37);
	    $this->fpdf->Cell( 100  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 55  , 6 , setUTF8('** '.number_format($cheque['cheque_amount'],2).' **') , 0, 0 , 'L' );
	    $this->fpdf->Output('pdf/cheque_'.$cheque_id.'.pdf',"I");
	}
	function cheque_cancel($cheque_id)
	{
		$cheque = $this->cheque_model->get($cheque_id);
		$this->load->model("pdfmodel/fpdf");
		$this->load->model("pdfmodel/pdf_mc_table");
		$this->load->library('mpdf');
		$this->fpdf = new FPDF();
	    $this->fpdf->SetDisplayMode("real");
	    $this->mpdf->SetAutoPageBreak(true,0);
	    $this->fpdf->AddFont('cheque','','cheque.php');
	    $this->fpdf->AddFont('brow','','browa.php');
	    $this->fpdf->AddFont('brow','B','browab.php');
	    $this->fpdf->AddFont('sukhumvitset','','sukhumvitset.php');
	    $this->fpdf->AddFont('sukhumvitset','B','sukhumvitset-bold.php');
	    $this->fpdf->AddPage('P','A4');
		
		$left_margin=15;
    	$top_margin=15;
		$this->fpdf->Image('public/cheque/background-cheque.jpg', $left_margin, $top_margin,177,0);
		$this->fpdf->SetFont('cheque','',18);
    	$this->fpdf->Text( $left_margin+7  , $top_margin+82 , setUTF8('A37 C'.$cheque['cheque_no'].'C011D0014A 0141074922C'));
		
	    $this->fpdf->SetY(18.5);
	    $this->fpdf->SetFont('brow','B',25);
	    $day = date("d",strtotime($cheque['cheque_date']));
	    $month = date("m",strtotime($cheque['cheque_date']));
	    $years = date("Y",strtotime($cheque['cheque_date']))+543;
	    $years="{$years}";
	    $cheque_name = ($cheque['cheque_cash']=="1")?"เงินสด":$cheque['cheque_name'];
		$this->fpdf->SetX(10+$left_margin);
	    $this->fpdf->Cell( 110  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 50  , 6 , setUTF8("{$day[0]}  {$day[1]}  {$month[0]}  {$month[1]}  {$years[0]}  {$years[1]}  {$years[2]}  {$years[3]}") , 0, 0 , 'L' );
		
		$this->fpdf->Image('public/assets/img/cancelled_stamp.png', 128, 62,50,0);
		
		if($cheque['cheque_cash']=="1"){	
		
		}else if($cheque['cheque_acpayee']=="0"){
			
		}else {
			$this->fpdf->SetFont('brow','B',18);
			$this->fpdf->SetTextColor(255,4,0);
			$this->fpdf->SetDrawColor(255,4,0);
			$this->fpdf->SetY(25);
			$this->fpdf->SetX(57);
			$this->fpdf->Line(56,25,96,25);
			$this->fpdf->Line(56,32,96,32);
	    	$this->fpdf->Cell( 10  , 6 , setUTF8('A/C PAYEE ONLY') , 0, 0 , 'L' );
			$this->fpdf->SetTextColor(0,0,0);
			$this->fpdf->SetDrawColor(0,0,0);
			$this->fpdf->Line(175,38,187,38);
			$this->fpdf->Line(175,39,187,39);
			$this->fpdf->Line(175,40,187,40);
		}
		
	    $this->fpdf->SetFont('brow','B',14);
	    $this->fpdf->Ln();
	    $this->fpdf->SetY(35);
		$this->fpdf->SetX(10+$left_margin);
	    $this->fpdf->Cell( 10  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 135  , 6 , setUTF8($cheque_name) , 0, 0 , 'L' );
	    $this->fpdf->Ln();
	    $this->fpdf->SetY(43);
		$this->fpdf->SetX(10+$left_margin);
	    $this->fpdf->Cell( 10  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 135  , 6 , setUTF8('** '.thaitext($cheque['cheque_amount']).' **') , 0, 0 , 'L' );
	    $this->fpdf->SetFont('brow','B',18);
	    $this->fpdf->Ln();
	    $this->fpdf->SetY(52);
		$this->fpdf->SetX(10+$left_margin);
	    $this->fpdf->Cell( 100  , 6 , setUTF8('') , 0, 0 , 'L' );
	    $this->fpdf->Cell( 55  , 6 , setUTF8('** '.number_format($cheque['cheque_amount'],2).' **') , 0, 0 , 'L' );
	    $this->fpdf->Output('pdf/cheque_cancel_'.$cheque_id.'.pdf',"I");
	}
}