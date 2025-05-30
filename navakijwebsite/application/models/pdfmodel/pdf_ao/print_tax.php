<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Print_tax extends CI_Model
{
    public function print_tax_many($tax_id)
    {
       
        $this->load->model("pdfmodel/fpdf");
        $this->load->model("pdfmodel/fpdi");
        $this->fpdf = new FPDI();
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->SetDisplayMode("real");
        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->SetAutoPageBreak(true, 0);
        $this->fpdf->AddFont('brow', '', 'browa.php');
        $this->fpdf->AddFont('brow', 'B', 'browab.php');
        $this->fpdf->AddFont('sukhumvitset', '', 'sukhumvitset.php');
        $this->fpdf->AddFont('sukhumvitset', 'B', 'sukhumvitset-bold.php');
        $this->add_print_tax_many($tax_id, 'ฉบับที่ 1 ( สำหรับผู้ถูกหักภาษี ณ ที่จ่าย ใช้แนบพร้อมกับแบบแสดงรายการภาษี )');
        $this->add_print_tax_many($tax_id, 'ฉบับที่ 2 ( สำหรับผู้ถูกหักภาษี ณ ที่จ่าย เก็บไว้เป็นหลักฐาน)');
        $this->add_print_tax_many($tax_id, 'ฉบับที่ 3 ( สำหรับผู้หักภาษี ณ ที่จ่าย ใช้แนบพร้อมกับแบบแสดงรายการภาษี )');
        $this->add_print_tax_many($tax_id, 'ฉบับที่ 4 ( สำหรับผู้หักภาษี ณ ที่จ่าย เก็บไว้เป็นหลักฐาน)');
        $this->fpdf->Output('pdf/tax_split_' . $tax_id . '.pdf', "I");
    }
    public function add_print_tax_many($tax_id, $title)
    {
        $tax = $this->cheque_model->getTaxInfo($tax_id);
        $row = $this->cheque_model->get($tax['cheque_id']);
        $cheque = $this->cheque_model->get($tax['cheque_id']);
        $tax = $this->cheque_model->gettax_many($tax_id);

        $amt_tax = 0;
        $sum_tax = 0;
        // foreach(explode('|',TAX_RATE) as $rate){
        //     $ratekey = str_replace('.','_',$rate);
        // }
        foreach (explode('|', TAX_RATE) as $rate) {
            ${'sum_tax_' . $rate} = 0;
            ${'amt_tax_' . $rate} = 0;
            if ($tax['tax_percent'] == $rate) {
                ${'sum_tax_' . $rate} = $tax['tax_amount'];
                ${'amt_tax_' . $rate} = $tax['tax_pay_amount'];
            }
        }

        $tax_other = [];
        foreach (explode('|', TAX_RATE) as $rate) {
            $sum_tax += ${'sum_tax_' . $rate};
        }

        //exit(FCPATH.'public/wh3.pdf');
        $pagecount = $this->fpdf->setSourceFile(FCPATH . 'public/wh3.pdf');
        $tplidx = $this->fpdf->importPage(1, '/MediaBox');
        $this->fpdf->addPage('P', 'A4');
        $this->fpdf->useTemplate($tplidx);

        $this->fpdf->SetFont('brow', 'B', 12);

        $this->fpdf->SetY(8);
        $this->fpdf->SetX(10);
        $this->fpdf->Cell(0, 5, setUTF8($title), 0, 1);

        $this->fpdf->SetFont('brow', 'B', 14);
        $this->fpdf->SetY(17);
        $this->fpdf->SetX(183);
        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_docno']), 0, 1);
        $this->fpdf->SetX(183);
        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_runno']), 0, 1);
        $this->fpdf->SetFont('brow', 'B', 12);
        if (setting('company_slug') == "ao") {
            $this->fpdf->SetY(35);
            $this->fpdf->Cell(0, 5, setUTF8("บริษัท อะโฮ้ จำกัด"), 0, 1);
            $this->fpdf->SetY(43);
            $this->fpdf->Cell(0, 5, setUTF8("23/51-53 ซอยศูนย์วิจัย แขวงบางกะปิ เขตห้วยขวาง กรุงเทพมหานคร"), 0, 1);

            $this->fpdf->SetY(29);
            $this->fpdf->SetX(132);
            $this->fpdf->SetFont('brow', 'B', 18);
            $tax_no = "0105562115416";
        } else {
            $this->fpdf->SetY(35);
            $this->fpdf->Cell(0, 5, setUTF8("บริษัท แอท เฟิร์ส ไบท์ จำกัด"), 0, 1);
            $this->fpdf->SetY(43);
            $this->fpdf->Cell(0, 5, setUTF8("23/51-53 ชั้น 2-4 รอยัลซิตี้อเวนิว ซอยศูนย์วิจัย ถนนพระราม 9 แขวงบางกะปิ เขตห้วยขวาง กรุงเทพมหานคร"), 0, 1);

            $this->fpdf->SetY(29);
            $this->fpdf->SetX(132);
            $this->fpdf->SetFont('brow', 'B', 18);
            $tax_no = "0105557160310";
        }

        foreach ([7, 4, 4, 4, 7, 4, 4, 4, 4, 7, 4, 7, 4] as $i => $j) {
            $this->fpdf->Cell($j, 5, setUTF8($tax_no[$i]), 0, 0);
        }
        $this->fpdf->SetFont('brow', 'B', 12);

        $this->fpdf->SetY(60);
        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_name']), 0, 1);
        $this->fpdf->SetY(69.5);
        if (mb_strlen($tax['tax_address']) > 100) {
            $this->fpdf->SetFont('brow', 'B', 10);
        }

        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_address']), 0, 1);

        $this->fpdf->SetFont('brow', 'B', 18);
        $this->fpdf->SetY(53);
        $this->fpdf->SetX(132);
        foreach ([7, 4, 4, 4, 7, 4, 4, 4, 4, 7, 4, 7, 4] as $i => $j) {
            $this->fpdf->Cell($j, 5, setUTF8($tax['tax_no'][$i]), 0, 0);
        }
        $this->fpdf->SetFont('brow', 'B', 12);
        list($prefixs, $running) = explode("-", $tax['tax_runno']);
        $this->fpdf->SetY(80);
        $this->fpdf->SetX(27);
        $this->fpdf->Cell(21.5, 5, setUTF8(intval($running)), 0, 1, 'C');

        if ($tax['tax_type'] == 2) {
            $this->fpdf->SetY(79.5);
            $this->fpdf->SetX(139.5);
            $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);
        } else if ($tax['tax_type'] == 3) {
            $this->fpdf->SetY(79.5);
            $this->fpdf->SetX(166.5);
            $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);
        } else {
            $this->fpdf->SetY(86);
            $this->fpdf->SetX(139.5);
            $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);
        }
        if ($amt_tax_10 > 0 && $sum_tax_10 > 0) {
            $amt_tax += $amt_tax_10;
            $this->fpdf->SetY(125);
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("10%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($amt_tax_10, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($sum_tax_10, 2)), 0, 1, 'R');
            $this->fpdf->Line(24, 130.5, 35, 130.5);
        }
        $this->fpdf->SetY(201);
        $x112 = 112;
        $x123 = 201;
        $xot = 222;
        foreach (explode('|', TAX_RATE) as $rate) {
            $ratekey = str_replace('.', '_', $rate);
            if (${'amt_tax_' . $rate} <= 0) {
                continue;
            }
            $amt_tax += ${'amt_tax_' . $rate};
            $isother = false;
            if ($tax['tax_type'] == 3) {
                if ($rate == 2 || $rate == 3 || $rate == 5) {
                    $tax_for = json_decode(TAX_FOR, true);
                    if (array_key_exists($tax['tax_for'], $tax_for)) {
                        $this->fpdf->Line(
                            $tax_for[$tax['tax_for']][0],
                            $tax_for[$tax['tax_for']][1],
                            $tax_for[$tax['tax_for']][2],
                            $tax_for[$tax['tax_for']][3]
                        );
                    } else {
                        $isother = true;
                    }

                    if ($other == true) {
                        $this->fpdf->SetY($xot);
                        $xot += 5;
                        $this->fpdf->SetX(33);
                        $this->fpdf->Cell(65, 5, setUTF8($tax['tax_for']), 0, 0);
                        $this->fpdf->SetX(110);
                        $this->fpdf->Cell(6, 5, setUTF8($rate . "%"), 0, 0);
                        $this->fpdf->Cell(27, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
                        $this->fpdf->Cell(29, 5, setUTF8(number_format(${'amt_tax_' . $rate}, 2)), 0, 0, 'R');
                        $this->fpdf->Cell(25.3, 5, setUTF8(number_format(${'sum_tax_' . $rate}, 2)), 0, 1, 'R');
                    } else {
                        $this->fpdf->SetY($x123);
                        $x123 += 5;

                        $this->fpdf->SetX(112);
                        $this->fpdf->Cell(6, 5, setUTF8($rate . "%"), 0, 0);
                        $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
                        $this->fpdf->Cell(28, 5, setUTF8(number_format(${'amt_tax_' . $rate}, 2)), 0, 0, 'R');
                        $this->fpdf->Cell(25.3, 5, setUTF8(number_format(${'sum_tax_' . $rate}, 2)), 0, 1, 'R');
                    }
                } else {
                    $this->fpdf->SetY($xot);
                    $xot += 5;
                    $this->fpdf->SetX(33);
                    $this->fpdf->Cell(65, 5, setUTF8($tax['tax_for']), 0, 0);
                    $this->fpdf->SetX(110);
                    $this->fpdf->Cell(6, 5, setUTF8($rate . "%"), 0, 0);
                    $this->fpdf->Cell(27, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
                    $this->fpdf->Cell(29, 5, setUTF8(number_format(${'amt_tax_' . $rate}, 2)), 0, 0, 'R');
                    $this->fpdf->Cell(25.3, 5, setUTF8(number_format(${'sum_tax_' . $rate}, 2)), 0, 1, 'R');
                    //$this->fpdf->Line(41,222.5,47,222.5);
                }
            }else if ($tax['tax_type'] == 53) {
                if ($rate == 2 || $rate == 3 || $rate == 5) {
                    $tax_for = json_decode(TAX_FOR, true);
                    if (array_key_exists($tax['tax_for'], $tax_for)) {
                        $this->fpdf->Line(
                            $tax_for[$tax['tax_for']][0],
                            $tax_for[$tax['tax_for']][1],
                            $tax_for[$tax['tax_for']][2],
                            $tax_for[$tax['tax_for']][3]
                        );
                    } else {
                        $isother = true;
                    }

                    if ($other == true) {
                        $this->fpdf->SetY($xot);
                        $xot += 5;
                        $this->fpdf->SetX(33);
                        $this->fpdf->Cell(65, 5, setUTF8($tax['tax_for']), 0, 0);
                        $this->fpdf->SetX(110);
                        $this->fpdf->Cell(6, 5, setUTF8($rate . "%"), 0, 0);
                        $this->fpdf->Cell(27, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
                        $this->fpdf->Cell(29, 5, setUTF8(number_format(${'amt_tax_' . $rate}, 2)), 0, 0, 'R');
                        $this->fpdf->Cell(25.3, 5, setUTF8(number_format(${'sum_tax_' . $rate}, 2)), 0, 1, 'R');
                    } else {
                        $this->fpdf->SetY($x123);
                        $x123 += 5;

                        $this->fpdf->SetX(112);
                        $this->fpdf->Cell(6, 5, setUTF8($rate . "%"), 0, 0);
                        $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
                        $this->fpdf->Cell(28, 5, setUTF8(number_format(${'amt_tax_' . $rate}, 2)), 0, 0, 'R');
                        $this->fpdf->Cell(25.3, 5, setUTF8(number_format(${'sum_tax_' . $rate}, 2)), 0, 1, 'R');
                    }
                } else {
                    $this->fpdf->SetY($xot);
                    $xot += 5;
                    $this->fpdf->SetX(33);
                    $this->fpdf->Cell(65, 5, setUTF8($tax['tax_for']), 0, 0);
                    $this->fpdf->SetX(110);
                    $this->fpdf->Cell(6, 5, setUTF8($rate . "%"), 0, 0);
                    $this->fpdf->Cell(27, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
                    $this->fpdf->Cell(29, 5, setUTF8(number_format(${'amt_tax_' . $rate}, 2)), 0, 0, 'R');
                    $this->fpdf->Cell(25.3, 5, setUTF8(number_format(${'sum_tax_' . $rate}, 2)), 0, 1, 'R');
                    //$this->fpdf->Line(41,222.5,47,222.5);
                }
            }

        }

        $this->fpdf->SetY(222);

        $this->fpdf->SetY(228.5);
        $this->fpdf->SetX(152);
        $this->fpdf->Cell(20, 5, setUTF8(number_format($amt_tax, 2)), 0, 0, 'R');

        $this->fpdf->SetY(228.5);
        $this->fpdf->SetX(177.2);
        $this->fpdf->Cell(20, 5, setUTF8(number_format($sum_tax, 2)), 0, 0, 'R');

        $this->fpdf->SetY(236);
        $this->fpdf->SetX(65);
        $this->fpdf->Cell(0, 5, setUTF8(thaitext(number_format($sum_tax, 2, '.', ''))), 0, 1);

        $this->fpdf->SetY(250);
        $this->fpdf->SetX(29.5);
        $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);

        $this->fpdf->Image('public/sig-wannisa.png', 135, 258, 20.125, 8.25);
        $this->fpdf->SetY(266);
        $this->fpdf->SetX(117);
        $this->fpdf->Cell(13, 5, setUTF8(date("d", strtotime($cheque['cheque_date']))), 0, 0, 'C');
        $this->fpdf->Cell(19, 5, setUTF8(thai_fullmonth($cheque['cheque_date'])), 0, 0, 'C');
        $this->fpdf->Cell(19, 5, setUTF8(date("Y", strtotime($cheque['cheque_date'])) + 543), 0, 0, 'C');

        if ($cheque['cheque_status'] == "deleted") {
            $this->fpdf->Image('public/cheque/cancelled.png', 130, 140, 50, 32);
        }

    }
    public function print_tax_one($cheque_id)
    {
        $this->load->model("pdfmodel/fpdf");
        $this->load->model("pdfmodel/fpdi");
        $this->fpdf = new FPDI();
        $this->fpdf->SetLineWidth(0.50);
        $this->fpdf->SetDisplayMode("real");
        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->SetAutoPageBreak(true, 0);
        $this->fpdf->AddFont('brow', '', 'browa.php');
        $this->fpdf->AddFont('brow', 'B', 'browab.php');
        $this->fpdf->AddFont('sukhumvitset', '', 'sukhumvitset.php');
        $this->fpdf->AddFont('sukhumvitset', 'B', 'sukhumvitset-bold.php');
        $this->add_print_tax($cheque_id, 'ฉบับที่ 1 ( สำหรับผู้ถูกหักภาษี ณ ที่จ่าย ใช้แนบพร้อมกับแบบแสดงรายการภาษี )');
        $this->add_print_tax($cheque_id, 'ฉบับที่ 2 ( สำหรับผู้ถูกหักภาษี ณ ที่จ่าย เก็บไว้เป็นหลักฐาน)');
        $this->add_print_tax($cheque_id, 'ฉบับที่ 3 ( สำหรับผู้หักภาษี ณ ที่จ่าย ใช้แนบพร้อมกับแบบแสดงรายการภาษี )');
        $this->add_print_tax($cheque_id, 'ฉบับที่ 4 ( สำหรับผู้หักภาษี ณ ที่จ่าย เก็บไว้เป็นหลักฐาน)');
        $this->fpdf->Output('pdf/tax_' . $cheque_id . '.pdf', "I");
    }
    public function add_print_tax($cheque_id, $title)
    {
        $cheque = $this->cheque_model->get($cheque_id);
        $tax = $this->cheque_model->gettax($cheque_id);

        $items = $this->cheque_model->get_items($cheque_id);
        $items_0 = $this->cheque_model->get_items_tax($cheque_id, 0);
        $amt_tax = 0;
        $sum_tax = 0;
        $tax_other = [];
        foreach (${'items_0'} as $row) {
            if ($row['tax_percent_for'] != "") {
                $tax_other[] = $row;
            } else {
                ${'sum_tax_0'} += $row['total'];
                ${'sum_tax_0'} += $row['total'];
            }
        }
        foreach (explode('|', TAX_RATE) as $rate) {
            $ratekey = str_replace('.', '_', $rate);
            ${'sum_tax_' . $ratekey} = 0;
            ${'amt_tax_' . $ratekey} = 0;
            ${'items_' . $ratekey} = $this->cheque_model->get_items_tax($cheque_id, $rate);

            foreach (${'items_' . $ratekey} as $row) {

                if ($row['tax_percent_for'] != "") {
                    $tax_other[] = $row;
                } else {
                    ${'sum_tax_' . $ratekey} += $row['total'];
                    ${'amt_tax_' . $ratekey} += $row['total_tax'];
                }
            }
        }

        foreach (explode('|', TAX_RATE) as $rate) {
            $ratekey = str_replace('.', '_', $rate);
            $sum_tax += ${'sum_tax_' . $ratekey};
            $amt_tax += ${'amt_tax_' . $ratekey};
        }

        //exit(FCPATH.'public/wh3.pdf');
        $pagecount = $this->fpdf->setSourceFile(FCPATH . 'public/wh3.pdf');
        $tplidx = $this->fpdf->importPage(1, '/MediaBox');
        $this->fpdf->addPage('P', 'A4');
        $this->fpdf->useTemplate($tplidx);

        $this->fpdf->SetFont('brow', 'B', 12);

        $this->fpdf->SetY(8);
        $this->fpdf->SetX(10);
        $this->fpdf->Cell(0, 5, setUTF8($title), 0, 1);

        $this->fpdf->SetFont('brow', 'B', 14);
        $this->fpdf->SetY(17);
        $this->fpdf->SetX(183);
        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_docno']), 0, 1);
        $this->fpdf->SetX(183);
        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_runno']), 0, 1);
        $this->fpdf->SetFont('brow', 'B', 12);
        if (setting('company_slug') == "ao") {
            $this->fpdf->SetY(35);
            $this->fpdf->Cell(0, 5, setUTF8("บริษัท อะโฮ้ จำกัด"), 0, 1);
            $this->fpdf->SetY(43);
            $this->fpdf->Cell(0, 5, setUTF8("23/51-53 ซอยศูนย์วิจัย แขวงบางกะปิ เขตห้วยขวาง กรุงเทพมหานคร"), 0, 1);

            $this->fpdf->SetY(29);
            $this->fpdf->SetX(132);
            $this->fpdf->SetFont('brow', 'B', 18);
            $tax_no = "0105562115416";
        } else {
            $this->fpdf->SetY(35);
            $this->fpdf->Cell(0, 5, setUTF8("บริษัท แอท เฟิร์ส ไบท์ จำกัด"), 0, 1);
            $this->fpdf->SetY(43);
            $this->fpdf->Cell(0, 5, setUTF8("23/51-53 ชั้น 2-4 รอยัลซิตี้อเวนิว ซอยศูนย์วิจัย ถนนพระราม 9 แขวงบางกะปิ เขตห้วยขวาง กรุงเทพมหานคร"), 0, 1);

            $this->fpdf->SetY(29);
            $this->fpdf->SetX(132);
            $this->fpdf->SetFont('brow', 'B', 18);
            $tax_no = "0105557160310";
        }
        foreach ([7, 4, 4, 4, 7, 4, 4, 4, 4, 7, 4, 7, 4] as $i => $j) {
            $this->fpdf->Cell($j, 5, setUTF8($tax_no[$i]), 0, 0);
        }
        $this->fpdf->SetFont('brow', 'B', 12);

        $this->fpdf->SetY(60);
        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_name']), 0, 1);
        $this->fpdf->SetY(69.5);
        if (mb_strlen($tax['tax_address']) > 100) {
            $this->fpdf->SetFont('brow', 'B', 10);
        }

        $this->fpdf->Cell(0, 5, setUTF8($tax['tax_address']), 0, 1);

        $this->fpdf->SetFont('brow', 'B', 18);
        $this->fpdf->SetY(53);
        $this->fpdf->SetX(132);
        foreach ([7, 4, 4, 4, 7, 4, 4, 4, 4, 7, 4, 7, 4] as $i => $j) {
            $this->fpdf->Cell($j, 5, setUTF8($tax['tax_no'][$i]), 0, 0);
        }
        $this->fpdf->SetFont('brow', 'B', 12);
        list($prefixs, $running) = explode("-", $tax['tax_runno']);
        $this->fpdf->SetY(80);
        $this->fpdf->SetX(27);
        $this->fpdf->Cell(21.5, 5, setUTF8(intval($running)), 0, 1, 'C');

        if ($tax['tax_type'] == 2) {
            $this->fpdf->SetY(79.5);
            $this->fpdf->SetX(139.5);
            $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);
        } else if ($tax['tax_type'] == 3) {
            $this->fpdf->SetY(79.5);
            $this->fpdf->SetX(166.5);
            $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);
        } else {
            $this->fpdf->SetY(86);
            $this->fpdf->SetX(139.5);
            $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);
        }
        if ($cheque['cheque_tax10'] > 0 && $sum_tax_10 > 0) {
            //$amt_tax += $cheque['cheque_tax10'];
            $this->fpdf->SetY(125);
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("10%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($sum_tax_10, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax10'], 2)), 0, 1, 'R');
            $this->fpdf->Line(24, 130.5, 35, 130.5);
        }
        if ($cheque['cheque_tax15'] > 0 && $sum_tax_15 > 0) {
            //$amt_tax += $cheque['cheque_tax10'];
            $this->fpdf->SetY(125);
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("10%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($sum_tax_15, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax15'], 2)), 0, 1, 'R');
            $this->fpdf->Line(24, 130.5, 35, 130.5);
        }
        $this->fpdf->SetY(201);

        if ($cheque['cheque_tax2'] > 0 && $sum_tax_2 > 0) {
            //$amt_tax += $cheque['cheque_tax2'];
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("2%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($sum_tax_2, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax2'], 2)), 0, 1, 'R');
            $this->fpdf->Line(27, 222.5, 39, 222.5);
        }
        if ($cheque['cheque_tax3'] > 0 && $sum_tax_3 > 0) {
            //$amt_tax += $cheque['cheque_tax3'];
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("3%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($sum_tax_3, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax3'], 2)), 0, 1, 'R');
            $this->fpdf->Line(61, 222.5, 72, 222.5);

        }
        if ($cheque['cheque_tax1_5'] > 0 && $sum_tax_1_5 > 0) {
            //$amt_tax += $cheque['cheque_tax3'];
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("1.5%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($sum_tax_1_5, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax1_5'], 2)), 0, 1, 'R');
            $this->fpdf->Line(61, 222.5, 72, 222.5);

        }
        if ($cheque['cheque_tax5'] > 0 && $sum_tax_5 > 0) {
            //$amt_tax += $cheque['cheque_tax5'];
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("5%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($sum_tax_5, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax5'], 2)), 0, 1, 'R');
            $this->fpdf->Line(41, 222.5, 47, 222.5);
        }

        $this->fpdf->SetY(221);
        if ($cheque['cheque_tax1'] > 0 && $sum_tax_1 > 0) {
            //$amt_tax += $cheque['cheque_tax1'];
            $this->fpdf->SetX(110);
            $this->fpdf->Cell(6, 5, setUTF8("1%"), 0, 0);
            $this->fpdf->Cell(27, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(29, 5, setUTF8(number_format($sum_tax_1, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax1'], 2)), 0, 1, 'R');
        }

        if ($cheque['cheque_tax0_75'] > 0 && $sum_tax_0_75 > 0) {
            //$amt_tax += $cheque['cheque_tax3'];
            $this->fpdf->SetX(112);
            $this->fpdf->Cell(6, 5, setUTF8("0.75%"), 0, 0);
            $this->fpdf->Cell(26, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(28, 5, setUTF8(number_format($sum_tax_0_75, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($cheque['cheque_tax0_75'], 2)), 0, 1, 'R');
            $this->fpdf->Line(61, 222.5, 72, 222.5);

        }
        $this->fpdf->SetY(222);
        if ($tax_other) {
            $tax_percent_for = [];
            $tax_percent = [];
            $tax_other_sum = 0;
            $tax_other_sum_tax = 0;
            foreach ($tax_other as $tax2) {
                $amt_tax += $tax2['total_tax'];
                $sum_tax += $tax2['total'];
                $tax_other_sum += $tax2['total'];
                $tax_other_sum_tax += $tax2['total_tax'];
                if (in_array($tax2['tax_percent_for'], $tax_percent_for) === false) {
                    $tax_percent_for[] = $tax2['tax_percent_for'];
                }

                if (in_array($tax2['tax_percent'] . "%", $tax_percent) === false) {
                    $tax_percent[] = $tax2['tax_percent'] . "%";
                }

            }
            $this->fpdf->SetX(33);
            $this->fpdf->Cell(65, 5, setUTF8(implode(", ", $tax_percent_for)), 0, 0);

            $this->fpdf->SetX(110);
            $this->fpdf->Cell(6, 5, setUTF8(implode(", ", $tax_percent)), 0, 0);
            $this->fpdf->Cell(27, 5, setUTF8(dateth($tax['tax_date'])), 0, 0, 'C');
            $this->fpdf->Cell(29, 5, setUTF8(number_format($tax_other_sum, 2)), 0, 0, 'R');
            $this->fpdf->Cell(25.3, 5, setUTF8(number_format($tax_other_sum_tax, 2)), 0, 1, 'R');
        }
        $this->fpdf->SetY(228.5);
        $this->fpdf->SetX(152);
        $this->fpdf->Cell(20, 5, setUTF8(number_format($sum_tax, 2)), 0, 0, 'R');

        $this->fpdf->SetY(228.5);
        $this->fpdf->SetX(177.2);
        $this->fpdf->Cell(20, 5, setUTF8(number_format($amt_tax, 2)), 0, 0, 'R');

        $this->fpdf->SetY(228.5);
        $this->fpdf->SetX(177.2);
        $this->fpdf->Cell(20, 5, setUTF8(number_format($amt_tax, 2)), 0, 0, 'R');

        $this->fpdf->SetY(236);
        $this->fpdf->SetX(65);
        $this->fpdf->Cell(0, 5, setUTF8(thaitext(number_format($amt_tax, 2, '.', ''))), 0, 1);

        $this->fpdf->SetY(250);
        $this->fpdf->SetX(29.5);
        $this->fpdf->Cell(0, 5, setUTF8("X"), 0, 1);

        $this->fpdf->Image('public/sig-wannisa.png', 135, 258, 20.125, 8.25);
        $this->fpdf->SetY(266);
        $this->fpdf->SetX(117);
        $this->fpdf->Cell(13, 5, setUTF8(date("d", strtotime($cheque['cheque_date']))), 0, 0, 'C');
        $this->fpdf->Cell(19, 5, setUTF8(thai_fullmonth($cheque['cheque_date'])), 0, 0, 'C');
        $this->fpdf->Cell(19, 5, setUTF8(date("Y", strtotime($cheque['cheque_date'])) + 543), 0, 0, 'C');

        if ($cheque['cheque_status'] == "deleted") {
            $this->fpdf->Image('public/cheque/cancelled.png', 130, 140, 50, 32);
        }

    }
}
