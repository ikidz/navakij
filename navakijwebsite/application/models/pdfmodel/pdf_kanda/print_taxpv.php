<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Print_taxpv extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('administrator/admin_model');
        $this->load->model('administrator/cheque_model');
        $this->load->model("administrator/bank_model");
        $this->load->model('holiday');
    }
    public function print_taxpv_one($cheque_id)
    {
        $cheque = $this->cheque_model->get($cheque_id);
        $items = $this->cheque_model->get_items($cheque_id);
        $items_0 = $this->cheque_model->get_items_tax($cheque_id, 0);
        $items_1 = $this->cheque_model->get_items_tax($cheque_id, 1);
        $items_2 = $this->cheque_model->get_items_tax($cheque_id, 2);
        $items_3 = $this->cheque_model->get_items_tax($cheque_id, 3);
        $items_5 = $this->cheque_model->get_items_tax($cheque_id, 5);
        $items_10 = $this->cheque_model->get_items_tax($cheque_id, 10);
        $sum_tax_1 = 0;
        $sum_tax_2 = 0;
        $sum_tax_3 = 0;
        $sum_tax_5 = 0;
        $sum_tax_10 = 0;

        foreach ($items_1 as $row) {
            $sum_tax_1 += $row['total'];
        }
        foreach ($items_2 as $row) {
            $sum_tax_2 += $row['total'];
        }
        foreach ($items_3 as $row) {
            $sum_tax_3 += $row['total'];
        }
        foreach ($items_5 as $row) {
            $sum_tax_5 += $row['total'];
        }
        foreach ($items_10 as $row) {
            $sum_tax_10 += $row['total'];
        }
        $this->load->model("pdfmodel/fpdf");
        $this->load->model("pdfmodel/pdf_mc_table");
        $this->fpdf = new PDF_MC_Table();
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->SetDisplayMode("real");
        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->SetAutoPageBreak(true, 0);
        $this->fpdf->AddFont('brow', '', 'browa.php');
        $this->fpdf->AddFont('brow', 'B', 'browab.php');
        $this->fpdf->AddFont('sukhumvitset', '', 'sukhumvitset.php');
        $this->fpdf->AddFont('sukhumvitset', 'B', 'sukhumvitset-bold.php');
        $this->fpdf->AddPage('P', 'A4');
        //HEAD
        // $this->fpdf->SetFont('sukhumvitset','B',12);
        // $this->fpdf->Cell( 195  , 6 , setUTF8('บริษัท แอท เฟิร์ส ไบท์ จำกัด') , 0, 0 , 'L' );
        // $this->fpdf->Image('public/assets/img/logo_document.png', 185,8,18,18);
        // $this->fpdf->SetFont('sukhumvitset','',6);
        // $this->fpdf->Ln();
        // $this->fpdf->Cell( 195  , 3 , setUTF8('23/51-53 ชั้น 2-4 รอยัลซิตี้อเวนิว ซอยศูนย์วิจัย ถนนพระราม 9') , 0, 0 , 'L' );
        // $this->fpdf->Ln(3);
        // $this->fpdf->Cell( 195  , 3 , setUTF8('แขวงบางกะปิ เขตห้วยขวาง กรุงเทพมหานคร 10320') , 0, 0 , 'L' );
        // $this->fpdf->Ln(3);
        // $this->fpdf->Cell( 195  , 3 , setUTF8('โทรศัพท์ 0-2641-4699 แฟกซ์ 0-2641-4979') , 0, 0 , 'L' );
        // $this->fpdf->Ln(3);
        // $this->fpdf->SetFillColor(236, 94, 162);
        // $this->fpdf->Cell(50,1,'',0,0,'L',true);
        // $this->fpdf->SetFillColor(214, 117, 173);
        // $this->fpdf->Cell(20,1,'',0,0,'L',true);
        // $this->fpdf->SetFillColor(173, 148, 196);
        // $this->fpdf->Cell(20,1,'',0,0,'L',true);
        // $this->fpdf->SetFillColor(138, 205, 238);
        // $this->fpdf->Cell(20,1,'',0,0,'L',true);
        // $this->fpdf->Ln(5);
        //PV
        $this->fpdf->SetFont('brow', 'B', 36);
        $this->fpdf->Cell(180, 20, setUTF8('KANDA DIGITAL CO., LTD.'), 'TRL', 1, 'C');
        $this->fpdf->SetFont('sukhumvitset', 'B', 20);
        // $this->fpdf->Cell( 180  , 10 , setUTF8('ใบสำคัญจ่าย (PV.)') , 'B', 1 , 'C' );
        $this->fpdf->Cell(180, 10, setUTF8('ใบชำระเงิน (PS.)'), 'BRL', 1, 'C');

        $y = $this->fpdf->getY();
        $this->fpdf->Line(20, $y, 20, $y + 29);
        $this->fpdf->Line(200, $y, 200, $y + 29);
        $this->fpdf->Ln(5);
        //เลขที่
        $this->fpdf->SetLineWidth(0.3);
        $this->fpdf->SetFont('sukhumvitset', 'B', 10);
        $this->fpdf->Cell(130, 8, setUTF8('เลขที่'), 0, 0, 'R');
        $this->fpdf->SetFont('sukhumvitset', '', 10);
        $this->fpdf->Cell(50, 8, setUTF8('PS.' . thai_shortyear($cheque['cheque_date']) . date("m", strtotime($cheque['cheque_date'])) . '/'), 'B', 1, 'L');
        $this->fpdf->Ln(5);

        //จ่ายให้
        $this->fpdf->SetFont('sukhumvitset', 'B', 14);
        $this->fpdf->Cell(20, 6, setUTF8('จ่ายให้'), 0, 0, 'L');
        $this->fpdf->SetFont('sukhumvitset', 'B', 12);
        $this->fpdf->Cell(85, 6, setUTF8($cheque['cheque_name']), 'B', 0, 'L');
        //วันที่
        $this->fpdf->SetFont('sukhumvitset', 'B', 10);
        $this->fpdf->Cell(25, 6, setUTF8('วันที่'), 0, 0, 'R');
        $this->fpdf->SetFont('sukhumvitset', '', 10);
        $this->fpdf->Cell(50, 6, setUTF8(ldateth($cheque['cheque_date'])), 'B', 1, 'L');
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->Ln(5);
        //คำอธิบายรายการ
        $this->fpdf->SetFont('sukhumvitset', 'B', 10);
        $this->fpdf->Cell(135, 8, setUTF8('คำอธิบายรายการ'), 1, 0, 'C');
        $this->fpdf->Cell(45, 8, setUTF8('จำนวนเงิน'), 1, 1, 'C');
        $this->fpdf->SetFont('sukhumvitset', '', 9);

        $sy = $this->fpdf->getY();
        $sumitm = 0;
        foreach ($items as $itms) {
            $sumitm += $itms['total'];
            if ($itms['reftext']) {
                $this->fpdf->SetWidths(array(97, 35, 3, 45));
                $this->fpdf->SetAligns(array('L', 'C', 'R', 'R'));
                $this->fpdf->Row(
                    array(
                        setUTF8(strtoupper($itms['detail'])),
                        setUTF8($itms['reftext']),
                        "",
                        number_format($itms['total'], 2),
                    )
                    , [1, 2, 1, 1], ['B', 'B', '', ''], 7, 0, ['', [255, 0, 0], '', '']);
            } else {
                $this->fpdf->SetWidths(array(102, 30, 3, 45));
                $this->fpdf->SetAligns(array('L', 'C', 'R', 'R'));
                $this->fpdf->Row(
                    array(
                        setUTF8($itms['detail']),
                        "",
                        "",
                        number_format($itms['total'], 2),
                    )
                    , [1, 2, 1, 1], ['', 'B', '', ''], 7, 0, ['', [255, 0, 0], '', '']);
                // $this->fpdf->Row(
                //     array(
                //         setUTF8($itms['detail']),
                //         number_format($itms['total'],2)
                //         )
                // ,[1,1],'',7,0);
            }

        }
        $this->fpdf->SetWidths(array(135, 45));
        $this->fpdf->SetAligns(array('L', 'R'));
        $this->fpdf->Cell(20, 7, '', 'L', 0);
        $this->fpdf->SetFont('sukhumvitset', 'B', 9);
        $this->fpdf->Cell(115, 7, setUTF8('รวม'), 'R', 0, 'L');
        $this->fpdf->Cell(45, 7, number_format($sumitm, 2), 'R', 1, 'R');
        if ($cheque['cheque_vat'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('บวก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษีมูลค่าเพิ่ม  7 %'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sumitm, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, number_format($cheque['cheque_vat'], 2), 'R', 1, 'R');
            $this->fpdf->Cell(20, 8, '', 'L', 0);
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(115, 7, setUTF8('รวม'), 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, number_format($cheque['cheque_sum'], 2), 'R', 1, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
        }
        if ($cheque['cheque_tax1'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  1%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_tax_1, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($cheque['cheque_tax1'], 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax2'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  2%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_tax_2, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($cheque['cheque_tax2'], 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax3'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  3%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_tax_3, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($cheque['cheque_tax3'], 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax5'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  5%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_tax_5, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($cheque['cheque_tax5'], 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax10'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  10%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_tax_10, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($cheque['cheque_tax10'], 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_discount'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(115, 7, setUTF8('อื่น ๆ/ส่วนลด'), 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($cheque['cheque_discount'], 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_remark'] != "") {
            $this->fpdf->Row(
                array(
                    '',
                    '',
                )
                , [1, 1], '', 7, 0);
            $this->fpdf->Row(
                array(
                    '',
                    '',
                )
                , [1, 1], '', 7, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Row(
                array(
                    setUTF8($cheque['cheque_remark']),
                    '',
                )
                , [1, 1], '', 7, 0);
        }

        do {
            $this->fpdf->Row(
                array(
                    "",
                    "",
                )
                , '', '', 7, 0);
        } while ($this->fpdf->getY() < 170);

        $endy = $this->fpdf->getY();

        $y = $this->fpdf->getY();
        $this->fpdf->Line(20, $y, 190, $y);
        if ($cheque['pay_with'] == "cheque") {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(15, 7, setUTF8('ธนาคาร'), 'LT', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(35, 7, setUTF8($cheque['bank_name']), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('สาขา'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(25, 7, setUTF8($cheque['bookbank_branch']), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('เลขที่เช็ค'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(209, 19, 19);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->Cell(28, 7, setUTF8($cheque['cheque_no']), 'TB', 0, 'L');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(2, 7, setUTF8(''), 'TR', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', 'B', 16);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(45, 14, setUTF8(number_format($cheque['cheque_amount'], 2)), 'TRB', 1, 'R');
        } else {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(15, 7, setUTF8('ธนาคาร'), 'LT', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(35, 7, setUTF8(""), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('สาขา'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(25, 7, setUTF8(""), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('เลขที่เช็ค'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(209, 19, 19);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->Cell(28, 7, setUTF8(""), 'TB', 0, 'L');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(2, 7, setUTF8(''), 'TR', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', 'B', 16);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(45, 14, setUTF8(number_format($cheque['cheque_amount'], 2)), 'TRB', 1, 'R');
        }
        //exit($cheque['pay_with']);

        $this->fpdf->setY($y + 7);
        $this->fpdf->SetFont('sukhumvitset', '', 8);

        $this->fpdf->Cell(2, 7, setUTF8(''), 'LB', 0, 'R');
        if ($cheque['pay_with'] == "cash") {
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->SetFillColor(240, 240, 240);
            $this->fpdf->Cell(17, 7, setUTF8('เงินสดย่อย '), 'B', 0, 'L', 0);
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);

            $this->fpdf->Cell(33, 7, setUTF8($this->cheque_model->getCashBookName($cheque['cheque_cash_id'])), 'B', 0, 'L', 0);
            $this->fpdf->Line(40, $y + 12, 70, $y + 12);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        } else {
            $this->fpdf->Cell(50, 7, setUTF8('เงินสดย่อย'), 'B', 0, 'L');
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->Line(40, $y + 12, 70, $y + 12);
            $this->fpdf->SetLineWidth(0.5);
        }
        $this->fpdf->Rect(72, $y + 8, 4, 4);
        $this->fpdf->Rect(91, $y + 8, 4, 4);
        if ($cheque['pay_with'] == "transfer") {
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Text(73, $y + 11, 'X');
            $this->fpdf->Cell(20, 7, setUTF8('โอนเงิน'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        } else {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(20, 7, setUTF8('โอนเงิน'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        }

        if ($cheque['pay_with'] == "autotransfer") {
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Text(92, $y + 11, 'X');
            $this->fpdf->Cell(20, 7, setUTF8('หักบัญชี'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        } else {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(20, 7, setUTF8('หักบัญชี'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        }
        $this->fpdf->Cell(41, 7, setUTF8('จำนวนเงิน (บาท)'), 'B', 0, 'R');
        $this->fpdf->Cell(2, 7, setUTF8(''), 'BR', 1, 'R');
        $sss = $this->fpdf->getY();

        $this->fpdf->setY($sy);
        $this->fpdf->SetLineWidth(0.3);
        $this->fpdf->SetDrawColor(78, 78, 78);
        $this->fpdf->SetDash(0.3, 0.5);
        do {
            $this->fpdf->Cell(180, 7, setUTF8(''), 'B', 1, 'R');
        } while ($this->fpdf->getY() < $endy - 7);
        $this->fpdf->SetDash(0, 0);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->setY($sss);
        //คำอธิบายรายการ
        //$this->fpdf->Ln();
        $this->fpdf->SetFont('sukhumvitset', 'B', 8);
        $this->fpdf->Cell(20, 6, setUTF8('รหัสบัญชี'), 1, 0, 'C');
        $this->fpdf->Cell(70, 6, setUTF8('ชื่อบัญชี'), 1, 0, 'C');
        $this->fpdf->Cell(45, 6, setUTF8('เดบิท'), 1, 0, 'C');
        $this->fpdf->Cell(45, 6, setUTF8('เครดิต'), 1, 1, 'C');
        $this->fpdf->SetFont('sukhumvitset', '', 10);

        $this->fpdf->SetWidths(array(20, 70, 35, 10, 35, 10));
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
                    "",
                )
                , '', '', 7, 0);
        } while ($this->fpdf->getY() < 250);

        $endy = $this->fpdf->getY();

        $this->fpdf->SetFont('sukhumvitset', 'B', 8);
        $this->fpdf->Cell(20, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(70, 6, setUTF8('ยอดรวม'), 1, 0, 'C');
        $this->fpdf->Cell(35, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(10, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(35, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(10, 6, setUTF8(''), 1, 1, 'C');

        $this->fpdf->Cell(180, 0.5, setUTF8(''), 'BLR', 1, 'C');
        $endy2 = $this->fpdf->getY();

        $this->fpdf->setY($sy);
        $this->fpdf->SetLineWidth(0.3);
        $this->fpdf->SetDrawColor(78, 78, 78);
        $this->fpdf->SetDash(0.3, 0.5);
        do {
            $this->fpdf->Cell(180, 6, setUTF8(''), 'B', 1, 'R');
        } while ($this->fpdf->getY() < $endy - 10);
        $this->fpdf->SetDash(0, 0);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetLineWidth(0.50);

        $this->fpdf->SetWidths(array(36, 36, 36, 36, 36));
        $this->fpdf->setY($endy2);
        $sy = $this->fpdf->getY();
        do {
            $this->fpdf->Row(
                array(
                    "",
                    "",
                    "",
                    "",
                    "",
                )
            );
        } while ($this->fpdf->getY() < 275);

        $endy = $this->fpdf->getY();

        $this->fpdf->SetFont('sukhumvitset', 'B', 8);
        $this->fpdf->Cell(36, 6, setUTF8('ผู้จัดทำ'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ฝ่ายบัญชี'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ตรวจสอบ'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ผู้อนุมัติ'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ผู้รับเงิน'), 1, 1, 'C');

        $this->fpdf->Image('public/sig-wannisa.png', 28, 262, 20.125, 8.25);

        $this->fpdf->SetFont('sukhumvitset', '', 6);
        //$this->fpdf->SetTextColor(182,182,182);
        $ref = 'REF : ' . sprintf("DOC-PV%06d", $cheque['cheque_id']);
        $ref .= ', RE-PRINT : ' . sdateth(date("d F Y H:i:s"));
        $ref .= ', IP : ' . $this->input->ip_address();
        $ref .= ', System Version : ' . $this->config->item("system_version");
        $this->fpdf->setY(287);
        $this->fpdf->Cell(0, 5, setUTF8($ref), 0, 1, 'R');
        if ($cheque['cheque_status'] == "deleted") {
            $this->fpdf->Image('public/cheque/cancelled.png', 70, 140, 50, 32);
        }
        $this->fpdf->Output('pdf/pv_' . $cheque_id . '.pdf', "I");
    }

    public function print_taxpv_many($tax_id)
    {
        $tax = $this->cheque_model->getTaxInfo($tax_id);
        $row = $this->cheque_model->get($tax['cheque_id']);
        $cheque = $this->cheque_model->get($tax['cheque_id']);
        //var_dump($tax);exit();
        //$cheque = $this->cheque_model->get($cheque_id);
        $items = $this->cheque_model->get_items($tax['cheque_id']);
        $sum_tax_1 = 0;
        $sum_tax_2 = 0;
        $sum_tax_3 = 0;
        $sum_tax_5 = 0;
        $sum_tax_10 = 0;
        $sum_pay_1 = 0;
        $sum_pay_2 = 0;
        $sum_pay_3 = 0;
        $sum_pay_5 = 0;
        $sum_pay_10 = 0;
        $amount = $tax['tax_pay_amount'] - $tax['tax_amount'];
        switch ($tax['tax_percent']) {
            case "1.00":
                $sum_tax_1 = $tax['tax_amount'];
                $sum_pay_1 = $tax['tax_pay_amount'];
                break;
            case "2.00":
                $sum_tax_2 = $tax['tax_amount'];
                $sum_pay_2 = $tax['tax_pay_amount'];
                break;
            case "3.00":
                $sum_tax_3 = $tax['tax_amount'];
                $sum_pay_3 = $tax['tax_pay_amount'];
                break;
            case "5.00":
                $sum_tax_5 = $tax['tax_amount'];
                $sum_pay_5 = $tax['tax_pay_amount'];
                break;
                break;
            case "10.00":
                $sum_tax_10 = $tax['tax_amount'];
                $sum_pay_10 = $tax['tax_pay_amount'];
                break;
        }

        $this->load->model("pdfmodel/fpdf");
        $this->load->model("pdfmodel/pdf_mc_table");
        $this->fpdf = new PDF_MC_Table();
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->SetDisplayMode("real");
        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->SetAutoPageBreak(true, 0);
        $this->fpdf->AddFont('brow', '', 'browa.php');
        $this->fpdf->AddFont('brow', 'B', 'browab.php');
        $this->fpdf->AddFont('sukhumvitset', '', 'sukhumvitset.php');
        $this->fpdf->AddFont('sukhumvitset', 'B', 'sukhumvitset-bold.php');
        $this->fpdf->AddPage('P', 'A4');
        //HEAD
        // $this->fpdf->SetFont('sukhumvitset','B',12);
        // $this->fpdf->Cell( 195  , 6 , setUTF8('บริษัท แอท เฟิร์ส ไบท์ จำกัด') , 0, 0 , 'L' );
        // $this->fpdf->Image('public/assets/img/logo_document.png', 185,8,18,18);
        // $this->fpdf->SetFont('sukhumvitset','',6);
        // $this->fpdf->Ln();
        // $this->fpdf->Cell( 195  , 3 , setUTF8('23/51-53 ชั้น 2-4 รอยัลซิตี้อเวนิว ซอยศูนย์วิจัย ถนนพระราม 9') , 0, 0 , 'L' );
        // $this->fpdf->Ln(3);
        // $this->fpdf->Cell( 195  , 3 , setUTF8('แขวงบางกะปิ เขตห้วยขวาง กรุงเทพมหานคร 10320') , 0, 0 , 'L' );
        // $this->fpdf->Ln(3);
        // $this->fpdf->Cell( 195  , 3 , setUTF8('โทรศัพท์ 0-2641-4699 แฟกซ์ 0-2641-4979') , 0, 0 , 'L' );
        // $this->fpdf->Ln(3);
        // $this->fpdf->SetFillColor(236, 94, 162);
        // $this->fpdf->Cell(50,1,'',0,0,'L',true);
        // $this->fpdf->SetFillColor(214, 117, 173);
        // $this->fpdf->Cell(20,1,'',0,0,'L',true);
        // $this->fpdf->SetFillColor(173, 148, 196);
        // $this->fpdf->Cell(20,1,'',0,0,'L',true);
        // $this->fpdf->SetFillColor(138, 205, 238);
        // $this->fpdf->Cell(20,1,'',0,0,'L',true);
        // $this->fpdf->Ln(5);
        //PV
        $this->fpdf->SetFont('brow', 'B', 36);
        $this->fpdf->Cell(180, 20, setUTF8('KANDA DIGITALE CO., LTD.'), 'TRL', 1, 'C');
        $this->fpdf->SetFont('sukhumvitset', 'B', 20);
        // $this->fpdf->Cell( 180  , 10 , setUTF8('ใบสำคัญจ่าย (PV.)') , 'B', 1 , 'C' );
        $this->fpdf->Cell(180, 10, setUTF8('ใบชำระเงิน (PS.)'), 'BRL', 1, 'C');

        $y = $this->fpdf->getY();
        $this->fpdf->Line(20, $y, 20, $y + 29);
        $this->fpdf->Line(200, $y, 200, $y + 29);
        $this->fpdf->Ln(5);
        //เลขที่
        $this->fpdf->SetLineWidth(0.3);
        $this->fpdf->SetFont('sukhumvitset', 'B', 10);
        $this->fpdf->Cell(130, 8, setUTF8('เลขที่'), 0, 0, 'R');
        $this->fpdf->SetFont('sukhumvitset', '', 10);
        $this->fpdf->Cell(50, 8, setUTF8('PS.' . thai_shortyear($tax['tax_date']) . date("m", strtotime($cheque['cheque_date'])) . '/'), 'B', 1, 'L');
        $this->fpdf->Ln(5);

        //จ่ายให้
        $this->fpdf->SetFont('sukhumvitset', 'B', 14);
        $this->fpdf->Cell(20, 6, setUTF8('จ่ายให้'), 0, 0, 'L');
        $this->fpdf->SetFont('sukhumvitset', 'B', 12);
        $this->fpdf->Cell(85, 6, setUTF8($tax['tax_name']), 'B', 0, 'L');
        //วันที่
        $this->fpdf->SetFont('sukhumvitset', 'B', 10);
        $this->fpdf->Cell(25, 6, setUTF8('วันที่'), 0, 0, 'R');
        $this->fpdf->SetFont('sukhumvitset', '', 10);
        $this->fpdf->Cell(50, 6, setUTF8(ldateth($tax['tax_date'])), 'B', 1, 'L');
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->Ln(5);
        //คำอธิบายรายการ
        $this->fpdf->SetFont('sukhumvitset', 'B', 10);
        $this->fpdf->Cell(135, 8, setUTF8('คำอธิบายรายการ'), 1, 0, 'C');
        $this->fpdf->Cell(45, 8, setUTF8('จำนวนเงิน'), 1, 1, 'C');
        $this->fpdf->SetFont('sukhumvitset', '', 9);

        $sy = $this->fpdf->getY();
        $sumitm = $tax['tax_pay_amount'];
        foreach ($items as $i => $itms) {
            //$sumitm += $itms['total'];
            if ($itms['reftext']) {
                $this->fpdf->SetWidths(array(97, 35, 3, 45));
                $this->fpdf->SetAligns(array('L', 'C', 'R', 'R'));
                $this->fpdf->Row(
                    array(
                        setUTF8(strtoupper($itms['detail'])),
                        setUTF8($itms['reftext']),
                        "",
                        $i == 0 ? number_format($tax['tax_pay_amount'], 2) : "-",
                    )
                    , [1, 2, 1, 1], ['B', 'B', '', ''], 7, 0, ['', [255, 0, 0], '', '']);
            } else {
                $this->fpdf->SetWidths(array(102, 30, 3, 45));
                $this->fpdf->SetAligns(array('L', 'C', 'R', 'R'));
                $this->fpdf->Row(
                    array(
                        setUTF8($itms['detail']),
                        "",
                        "",
                        number_format($itms['total'], 2),
                    )
                    , [1, 2, 1, 1], ['', 'B', '', ''], 7, 0, ['', [255, 0, 0], '', '']);
                // $this->fpdf->Row(
                //     array(
                //         setUTF8($itms['detail']),
                //         number_format($itms['total'],2)
                //         )
                // ,[1,1],'',7,0);
            }

        }
        $this->fpdf->SetWidths(array(135, 45));
        $this->fpdf->SetAligns(array('L', 'R'));
        $this->fpdf->Cell(20, 7, '', 'L', 0);
        $this->fpdf->SetFont('sukhumvitset', 'B', 9);
        $this->fpdf->Cell(115, 7, setUTF8('รวม'), 'R', 0, 'L');
        $this->fpdf->Cell(45, 7, number_format($sumitm, 2), 'R', 1, 'R');

        if ($cheque['cheque_tax1'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  1%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_pay_1, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($sum_tax_1, 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax2'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  2%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_pay_2, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($sum_tax_2, 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax3'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  3%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_pay_3, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($sum_tax_3, 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax5'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  5%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_pay_5, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($sum_tax_5, 2) . ')', 'R', 1, 'R');
        }
        if ($cheque['cheque_tax10'] > 0) {
            $this->fpdf->SetFont('sukhumvitset', 'B', 9);
            $this->fpdf->Cell(20, 7, setUTF8('หัก'), 'L', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', '', 9);
            $this->fpdf->Cell(47, 7, setUTF8('ภาษี ณ ที่จ่าย  10%'), 'R', 0, 'L');
            $this->fpdf->SetLineWidth(0.7);
            $this->fpdf->Cell(35, 7, number_format($sum_pay_10, 2), 1, 0, 'C');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(33, 7, '', 'R', 0, 'L');
            $this->fpdf->Cell(45, 7, '(' . number_format($sum_tax_10, 2) . ')', 'R', 1, 'R');
        }

        if ($cheque['cheque_remark'] != "") {
            $this->fpdf->Row(
                array(
                    '',
                    '',
                )
                , [1, 1], '', 7, 0);
            $this->fpdf->Row(
                array(
                    '',
                    '',
                )
                , [1, 1], '', 7, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Row(
                array(
                    setUTF8($cheque['cheque_remark']),
                    '',
                )
                , [1, 1], '', 7, 0);
        }

        do {
            $this->fpdf->Row(
                array(
                    "",
                    "",
                )
                , '', '', 7, 0);
        } while ($this->fpdf->getY() < 170);

        $endy = $this->fpdf->getY();

        $y = $this->fpdf->getY();
        $this->fpdf->Line(20, $y, 190, $y);
        if ($cheque['pay_with'] == "cheque") {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(15, 7, setUTF8('ธนาคาร'), 'LT', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(35, 7, setUTF8($cheque['bank_name']), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('สาขา'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(25, 7, setUTF8($cheque['bookbank_branch']), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('เลขที่เช็ค'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(209, 19, 19);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->Cell(28, 7, setUTF8($cheque['cheque_no']), 'TB', 0, 'L');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(2, 7, setUTF8(''), 'TR', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', 'B', 16);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(45, 14, setUTF8(number_format($amount, 2)), 'TRB', 1, 'R');
        } else {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(15, 7, setUTF8('ธนาคาร'), 'LT', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(35, 7, setUTF8(""), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('สาขา'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Cell(25, 7, setUTF8(""), 'TB', 0, 'L');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(15, 7, setUTF8('เลขที่เช็ค'), 'T', 0, 'R');
            $this->fpdf->SetTextColor(209, 19, 19);
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->Cell(28, 7, setUTF8(""), 'TB', 0, 'L');
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(2, 7, setUTF8(''), 'TR', 0, 'R');
            $this->fpdf->SetFont('sukhumvitset', 'B', 16);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->Cell(45, 14, setUTF8(number_format($amount, 2)), 'TRB', 1, 'R');
        }
        //exit($cheque['pay_with']);

        $this->fpdf->setY($y + 7);
        $this->fpdf->SetFont('sukhumvitset', '', 8);

        $this->fpdf->Cell(2, 7, setUTF8(''), 'LB', 0, 'R');
        if ($cheque['pay_with'] == "cash") {
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->SetFillColor(240, 240, 240);
            $this->fpdf->Cell(17, 7, setUTF8('เงินสดย่อย '), 'B', 0, 'L', 0);
            $this->fpdf->SetTextColor(19, 27, 205);
            $this->fpdf->SetLineWidth(0.3);

            $this->fpdf->Cell(33, 7, setUTF8($this->cheque_model->getCashBookName($cheque['cheque_cash_id'])), 'B', 0, 'L', 0);
            $this->fpdf->Line(40, $y + 12, 70, $y + 12);
            $this->fpdf->SetLineWidth(0.50);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        } else {
            $this->fpdf->Cell(50, 7, setUTF8('เงินสดย่อย'), 'B', 0, 'L');
            $this->fpdf->SetLineWidth(0.3);
            $this->fpdf->Line(40, $y + 12, 70, $y + 12);
            $this->fpdf->SetLineWidth(0.5);
        }
        $this->fpdf->Rect(72, $y + 8, 4, 4);
        $this->fpdf->Rect(91, $y + 8, 4, 4);
        if ($cheque['pay_with'] == "transfer") {
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Text(73, $y + 11, 'X');
            $this->fpdf->Cell(20, 7, setUTF8('โอนเงิน'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        } else {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(20, 7, setUTF8('โอนเงิน'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        }

        if ($cheque['pay_with'] == "autotransfer") {
            $this->fpdf->SetFont('sukhumvitset', 'B', 8);
            $this->fpdf->Text(92, $y + 11, 'X');
            $this->fpdf->Cell(20, 7, setUTF8('หักบัญชี'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        } else {
            $this->fpdf->SetFont('sukhumvitset', '', 8);
            $this->fpdf->Cell(20, 7, setUTF8('หักบัญชี'), 'B', 0, 'C');
            $this->fpdf->SetFont('sukhumvitset', '', 8);
        }
        $this->fpdf->Cell(41, 7, setUTF8('จำนวนเงิน (บาท)'), 'B', 0, 'R');
        $this->fpdf->Cell(2, 7, setUTF8(''), 'BR', 1, 'R');
        $sss = $this->fpdf->getY();

        $this->fpdf->setY($sy);
        $this->fpdf->SetLineWidth(0.3);
        $this->fpdf->SetDrawColor(78, 78, 78);
        $this->fpdf->SetDash(0.3, 0.5);
        do {
            $this->fpdf->Cell(180, 7, setUTF8(''), 'B', 1, 'R');
        } while ($this->fpdf->getY() < $endy - 7);
        $this->fpdf->SetDash(0, 0);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->setY($sss);
        //คำอธิบายรายการ
        //$this->fpdf->Ln();
        $this->fpdf->SetFont('sukhumvitset', 'B', 8);
        $this->fpdf->Cell(20, 6, setUTF8('รหัสบัญชี'), 1, 0, 'C');
        $this->fpdf->Cell(70, 6, setUTF8('ชื่อบัญชี'), 1, 0, 'C');
        $this->fpdf->Cell(45, 6, setUTF8('เดบิท'), 1, 0, 'C');
        $this->fpdf->Cell(45, 6, setUTF8('เครดิต'), 1, 1, 'C');
        $this->fpdf->SetFont('sukhumvitset', '', 10);

        $this->fpdf->SetWidths(array(20, 70, 35, 10, 35, 10));
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
                    "",
                )
                , '', '', 7, 0);
        } while ($this->fpdf->getY() < 250);

        $endy = $this->fpdf->getY();

        $this->fpdf->SetFont('sukhumvitset', 'B', 8);
        $this->fpdf->Cell(20, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(70, 6, setUTF8('ยอดรวม'), 1, 0, 'C');
        $this->fpdf->Cell(35, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(10, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(35, 6, setUTF8(''), 1, 0, 'C');
        $this->fpdf->Cell(10, 6, setUTF8(''), 1, 1, 'C');

        $this->fpdf->Cell(180, 0.5, setUTF8(''), 'BLR', 1, 'C');
        $endy2 = $this->fpdf->getY();

        $this->fpdf->setY($sy);
        $this->fpdf->SetLineWidth(0.3);
        $this->fpdf->SetDrawColor(78, 78, 78);
        $this->fpdf->SetDash(0.3, 0.5);
        do {
            $this->fpdf->Cell(180, 6, setUTF8(''), 'B', 1, 'R');
        } while ($this->fpdf->getY() < $endy - 10);
        $this->fpdf->SetDash(0, 0);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetLineWidth(0.50);

        $this->fpdf->SetWidths(array(36, 36, 36, 36, 36));
        $this->fpdf->setY($endy2);
        $sy = $this->fpdf->getY();
        do {
            $this->fpdf->Row(
                array(
                    "",
                    "",
                    "",
                    "",
                    "",
                )
            );
        } while ($this->fpdf->getY() < 275);

        $endy = $this->fpdf->getY();

        $this->fpdf->SetFont('sukhumvitset', 'B', 8);
        $this->fpdf->Cell(36, 6, setUTF8('ผู้จัดทำ'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ฝ่ายบัญชี'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ตรวจสอบ'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ผู้อนุมัติ'), 1, 0, 'C');
        $this->fpdf->Cell(36, 6, setUTF8('ผู้รับเงิน'), 1, 1, 'C');

        $this->fpdf->Image('public/sig-wannisa.png', 28, 262, 20.125, 8.25);

        $this->fpdf->SetFont('sukhumvitset', '', 6);
        //$this->fpdf->SetTextColor(182,182,182);
        $ref = 'REF : ' . sprintf("DOC-PV%06d", $cheque['cheque_id']);
        $ref .= ', RE-PRINT : ' . sdateth(date("d F Y H:i:s"));
        $ref .= ', IP : ' . $this->input->ip_address();
        $ref .= ', System Version : ' . $this->config->item("system_version");
        $this->fpdf->setY(287);
        $this->fpdf->Cell(0, 5, setUTF8($ref), 0, 1, 'R');
        if ($cheque['cheque_status'] == "deleted") {
            $this->fpdf->Image('public/cheque/cancelled.png', 70, 140, 50, 32);
        }
        $this->fpdf->Output('pdf/pv_' . $cheque['cheque_id'] . '.pdf', "I");
    }
}
