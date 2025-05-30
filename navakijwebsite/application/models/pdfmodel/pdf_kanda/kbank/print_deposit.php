<?php
if (!defined("BASEPATH")) {
	exit("No direct script access allowed");
}

class Print_deposit extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("administrator/admin_model");
		$this->load->model("administrator/cheque_model");
		$this->load->model("administrator/bank_model");
		$this->load->model("holiday");
	}
	function make($cheque_id)
	{
		$cheque = $this->cheque_model->get($cheque_id);
		$this->load->model("pdfmodel/fpdf");
		$this->load->model("pdfmodel/pdf_mc_table");
		$this->load->library("mpdf");
		$this->fpdf = new FPDF();
		$this->fpdf->SetDisplayMode("real");
		$this->fpdf->SetAutoPageBreak(false, 0);

		$this->fpdf->AddFont("cheque", "", "cheque.php");
		$this->fpdf->AddFont("brow", "", "browa.php");
		$this->fpdf->AddFont("brow", "B", "browab.php");
		$this->fpdf->AddFont("angsa", "", "sukhumvitset.php");
		$this->fpdf->AddFont("angsa", "B", "sukhumvitset-bold.php");
		$this->fpdf->AddPage("L", "kbank_payin");
		$this->fpdf->SetLeftMargin(6);
		// $this->fpdf->Image("public/payin/payin_cash_kbank.png", 0, 2, 210, 0);
		// $this->fpdf->Line(0, 33, 210, 33);
		// $this->fpdf->Line(5, 0, 5, 114);
		// $this->fpdf->SetTopMargin(40);
		$this->fpdf->SetFont("angsa", "", 8);
		$this->fpdf->SetY(40 + 3);
		$this->fpdf->SetX(12);
		$day = date("d/m/Y", strtotime($cheque["cheque_date"]));
		$this->fpdf->Cell(23, 6, setUTF8($day), 0, 0, "L");
		$this->fpdf->SetX(109.5);
		$this->fpdf->Cell(10, 6, setUTF8("X"), 0, 0, "L");
		// print_r($cheque);
		// exit();
		$this->fpdf->SetY(55 + 3);
		$this->fpdf->SetX(8);
		$cheque_name = $cheque["cheque_cash"] == "1" ? "" : $cheque["cheque_name"];
		$this->fpdf->Cell(23, 6, setUTF8($cheque_name), 0, 0, "L");

		$this->fpdf->SetFont("angsa", "", 6);
		$this->fpdf->SetY(65 + 3);
		$this->fpdf->SetX(13);
		$this->fpdf->Cell(23, 5, setUTF8($cheque["bank_name"] . " " . $cheque["bookbank_branch"]), 0, 0, "L");
		$this->fpdf->SetX(75);
		$this->fpdf->Cell(23, 5, setUTF8($cheque["cheque_no"]), 0, 0, "L");
		$this->fpdf->SetX(114);
		$cheque_date = date("d/m/Y", strtotime($cheque["cheque_date"]));
		$this->fpdf->Cell(23, 5, setUTF8($cheque_date), 0, 0, "L");
		$this->fpdf->SetX(139);
		$this->fpdf->Cell(62, 4, setUTF8("**" . number_format($cheque["cheque_amount"], 2) . "**"), 0, 0, "R");
		$this->fpdf->SetY(85 + 3);
		$this->fpdf->SetX(139);
		$this->fpdf->SetFont("angsa", "", 8);
		$this->fpdf->Cell(62, 5, setUTF8("**" . number_format($cheque["cheque_amount"], 2) . "**"), 0, 0, "R");

		$this->fpdf->SetY(93 + 3);
		$this->fpdf->SetX(42);
		$this->fpdf->SetFont("angsa", "", 8);
		$this->fpdf->Cell(62, 5, setUTF8(thaitext($cheque["cheque_amount"])), 0, 0, "R");

		$this->fpdf->Output("pdf/payin_cash_kbank_" . $cheque_id . ".pdf", "I");
	}
}
