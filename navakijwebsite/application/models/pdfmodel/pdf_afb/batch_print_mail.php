<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Batch_print_mail extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('administrator/admin_model');
        $this->load->model('administrator/cheque_model');
        $this->load->model("administrator/bank_model");
        $this->load->model('holiday');
    }
    public function make($tax_type,$tax_id,$tax_id_to="")
    {
        $this->load->model("pdfmodel/fpdf");
        $this->load->model("pdfmodel/pdf_mc_table");
        $this->fpdf = new FPDF('L', 'mm', 'A4');

        $this->fpdf->AddFont('brow', '', 'browa.php');
        $this->fpdf->AddFont('brow', 'B', 'browab.php');
        $this->fpdf->AddFont('sukhumvitset', '', 'sukhumvitset.php');
        $this->fpdf->AddFont('sukhumvitset', 'B', 'sukhumvitset-bold.php');

        if($tax_id_to==""){
            $tax_id_to = $tax_id;
        }
        if($tax_id_to < $tax_id){
            $tax_id_to = $tax_id;
        }
       
        for($id=$tax_id;$id<=$tax_id_to;$id++){
            $this->makePage($tax_type,$id);
        }
        $this->fpdf->Output('pdf/batch_mail_' . $tax_id . $tax_id_to . '.pdf', "I");
    }
    public function makePage($tax_type,$tax_id)
    {
        $tax = $this->cheque_model->getTaxInfo($tax_id);
        if($tax['tax_type']!=$tax_type){
            return;
        }
        $row = $this->cheque_model->get($tax['cheque_id']);
        //$tax = $this->cheque_model->gettax($cheque_id);
        //var_dump($tax);exit();
        
        //$this->fpdf->SetLineWidth(0.50);
        //$this->fpdf->SetDisplayMode("real");
        //$this->fpdf->SetLeftMargin(20);
        //$this->fpdf->SetAutoPageBreak(true,0);
        $this->fpdf->AddPage();

        $this->fpdf->SetFont('brow', 'B', 16);
        $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
        $this->fpdf->Cell(215, 6, setUTF8('ผู้ส่ง'), 0, 1, 'L');
        $this->fpdf->SetFont('brow', 'B', 14);
        if (setting('company_slug') == "ao") {

            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(215, 6, setUTF8('บริษัท อะโฮ้ จำกัด'), 0, 1, 'L');
            $this->fpdf->SetFont('brow', '', 14);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 6, setUTF8('23/51-53 ซอยศูนย์วิจัย แขวงบางกะปิ'), 0, 1, 'L');
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 6, setUTF8('ถนนพระราม 9 เขตห้วยขวาง'), 0, 1, 'L');
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 6, setUTF8('กรุงเทพมหานคร'), 0, 1, 'L');
            $this->fpdf->SetFont('brow', 'B', 18);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 8, setUTF8('10310'), 0, 1, 'L');
        } else {

            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(215, 6, setUTF8('บริษัท แอท เฟิร์ส ไบท์ จำกัด'), 0, 1, 'L');
            $this->fpdf->SetFont('brow', '', 14);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 6, setUTF8('23/51-53 ชั้น 2-4 รอยัลซิตี้อเวนิว ซอยศูนย์วิจัย'), 0, 1, 'L');
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 6, setUTF8('ถนนพระราม 9 แขวงบางกะปิ เขตห้วยขวาง'), 0, 1, 'L');
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 6, setUTF8('กรุงเทพมหานคร'), 0, 1, 'L');
            $this->fpdf->SetFont('brow', 'B', 18);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'L');
            $this->fpdf->Cell(230, 8, setUTF8('10310'), 0, 1, 'L');
        }

        $this->fpdf->SetFont('brow', 'B', 20);
        $this->fpdf->Cell(160, 8, '', 0, 0, 'L');
        $this->fpdf->Cell(115, 8, setUTF8('ผู้รับ'), 0, 1, 'L');
        $this->fpdf->SetFont('brow', 'B', 16);
        $this->fpdf->Cell(160, 8, '', 0, 0, 'L');
        $this->fpdf->Cell(115, 8, setUTF8($tax['tax_name']), 0, 1, 'L');
        $this->fpdf->SetFont('brow', '', 14);
        $this->fpdf->Cell(160, 8, '', 0, 0, 'L');
        $this->fpdf->MultiCell(70, 8, setUTF8($tax['tax_address']), 0, 'L');

        

    }
}
