<?php
include("fpdf.php");
class Pdf_applicantsreport extends CI_Model{
  var $_data = array();
  var $document_no = "";
  var $_line_per_page = 27;
  var $_item_max_y = 250;
  var $_max_y_lastpage = 210;
  var $total_line = 0;
  var $total_page=1;
  var $current_page=1;
  public function __construct()
	{
		parent::__construct();
	}
	public function makepdf($params)
	{
    $this->_data = $params;
    $info =  $params['info'];
    $this->load->model("pdfmodel/fpdf");
    $this->load->model("pdfmodel/pdf_mc_table");
    $this->fpdf = new PDF_MC_Table();
    $this->fpdf->SetDisplayMode("real");
    $this->fpdf->SetAutoPageBreak(true,0);
    $this->fpdf->AddFont('brow','','browa.php');
		$this->fpdf->AddFont('brow','B','browab.php');
    $this->fpdf->AddFont('sukhumvitset','','sukhumvitset.php');
    $this->fpdf->AddFont('sukhumvitset','B','sukhumvitset-bold.php');
    $this->fpdf->AddFont('supermarket','','supermarket.php');
    $this->fpdf->AddPage('P','A4');

    $this->fpdf->SetFont('supermarket', '', 18);
    $this->fpdf->Cell(130, 8, $this->setUTF8('รายละเอียดตำแหน่งที่สมัครงาน'), 0, 1, 'L');
    $this->fpdf->Ln(3); 
    $this->fpdf->SetWidths([40, 70, 40, 40]);
    $this->fpdf->SetAligns(['L', 'L', 'L', 'L']);
    $this->fpdf->SetFont('sukhumvitset', '', 8);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $location = $this->applicantsreportmodel->get_locationinfo_byid( $info['location_id'] );
    $this->fpdf->Row([
      $this->setUTF8("สถานที่ปฏิบัติงาน\nArea Expected"),
      $this->setUTF8(( isset( $location ) && count( $location ) > 0 ) ? $location['location_title_th'] : ""),
      $this->setUTF8("เงินเดือนที่คาดหวัง\nExpected Salary"),
      $this->setUTF8($info['applicant_salary'])
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->SetWidths([40, 150]);
    $job = $this->applicantsreportmodel->get_jobinfo_byid( $info['job_id'] );
    $this->fpdf->Row([
      $this->setUTF8("ตำแหน่ง\nPosition Applied"),
      $this->setUTF8(( isset( $job ) && count( $job ) > 0 ) ? $job['job_title_th'] : "")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());


    $this->fpdf->SetFont('supermarket', '', 18);
    $this->fpdf->Ln();
    $this->fpdf->Cell(130, 8, $this->setUTF8('ประวัติส่วนตัว (Personal Information)'), 0, 1, 'L');
    $this->fpdf->Ln(3);
    $this->fpdf->SetWidths([40, 55, 40, 55]);
    $this->fpdf->SetAligns(['L', 'L', 'L', 'L']);
    $this->fpdf->SetFont('sukhumvitset', '', 8);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    if( $info['prefix_id'] == 999 ){
      $title = $info['prefix_other'];
    }else{
      $prefix = $this->applicantsreportmodel->get_prefixinfo_byid( $info['prefix_id'] );
      $title = ( isset( $prefix ) && count( $prefix ) > 0 ? $prefix['prefix_title_th'] : '' );
    }
    $this->fpdf->Row([
      $this->setUTF8("ชื่อ-นามสกุล\nName - Surname"),
      $this->setUTF8($title.' '.$info['applicant_fname_th'].' '.$info['applicant_lname_th']),
      $this->setUTF8("วัน / เดือน / ปี เกิด\nDate of birth"),
      $this->setUTF8( date("d/m/Y", strtotime( $info['applicant_birthdate'] ) ))
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->Row([
      $this->setUTF8("บัตรประจำตัวประชาชน\nIdentity Card No."),
      $this->setUTF8($info['applicant_idcard']),
      $this->setUTF8("วันที่บัตรหมดอายุ\nDate of Expiry"),
      $this->setUTF8(date('d/m/Y', strtotime( $info['applicant_idcard_expired'] )))
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->Row([
      $this->setUTF8("ส่วนสูง\nHeight"),
      $this->setUTF8($info['applicant_height'] . " ซม. (cm.)"),
      $this->setUTF8("น้ำหนัก\nWeight"),
      $this->setUTF8($info['applicant_weight'] . " กก. (kg.)")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $military = "";
    if( $info['applicant_military_status'] != '' || $info['applicant_military_status'] != null ){
      switch( $info['applicant_military_status'] ){
          case 'serving' :  $military =  'อยู่ระหว่างรับราชการทหาร / ทหารเกณฑ์'; break;
          case 'completed' :  $military =  'ผ่านการเกณฑ์ทหาร'; break;
          default :  $military =  'ได้รับการยกเว้น';
      }
  }
    $this->fpdf->Row([
      $this->setUTF8("สถานะภาพทางทหาร\nMilitary Status"),
      $this->setUTF8( $military ),
      $this->setUTF8(""),
      $this->setUTF8("")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $addresses = $this->applicantsreportmodel->get_addresss( $info['applicant_id'] );
    if( isset( $addresses ) && count( $addresses ) > 0 ){
      foreach( $addresses as $address ){
        $subdistrict = $this->applicantsreportmodel->get_subdistrictinfo_byid( $address['subdistrict_id'] );
        $district = $this->applicantsreportmodel->get_districtinfo_byid( $address['district_id'] );
        $province = $this->applicantsreportmodel->get_provinceinfo_byid( $address['province_id'] );
        $postcode = $this->applicantsreportmodel->get_postcodeinfo_byid( $address['postcode_id'] );
        $this->fpdf->SetFont('supermarket', '', 18);
        $this->fpdf->Ln();
        if( $address['address_type'] == 'current' ){
          $this->fpdf->Cell(130, 8, $this->setUTF8('ที่อยู่ปัจจุบัน (Present Address)'), 0, 1, 'L');
        }else{
          $this->fpdf->Cell(130, 8, $this->setUTF8('ที่อยู่ตามสำเนาทะเบียนบ้าน (Address as in housing register)'), 0, 1, 'L');
        }
        
        $this->fpdf->Ln(3);
        $this->fpdf->SetWidths([40, 55, 40, 55]);
        $this->fpdf->SetAligns(['L', 'L', 'L', 'L']);
        $this->fpdf->SetFont('sukhumvitset', '', 8);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("เลขที่\nAddress No."),
          $this->setUTF8($address['address_no']),
          $this->setUTF8("หมู่บ้าน/อาคาร\nVillage/Bldg."),
          $this->setUTF8($address['address_building'])
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("ตรอก/ซอย\nSoi"),
          $this->setUTF8($address['address_avenue']),
          $this->setUTF8("ถนน\nRoad"),
          $this->setUTF8($address['address_street'])
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("แขวง/ตำบล\nSub District"),
          $this->setUTF8(( isset( $subdistrict ) && count( $subdistrict ) > 0 )?$subdistrict['name']:""),
          $this->setUTF8("เขต/อำเภอ\nDistrict"),
          $this->setUTF8(( isset( $district ) && count( $district ) > 0 )?$district['name']:"")
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("จังหวัด\nProvince"),
          $this->setUTF8(( isset( $province ) && count( $province ) > 0 )?$province['name']:""),
          $this->setUTF8("รหัสไปรณีย์\nPost Code"),
          $this->setUTF8(( isset( $postcode ) && count( $postcode ) > 0 )?$postcode['name']:"")
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("โทรศัพท์\nTelephone"),
          $this->setUTF8($address['address_tel']),
          $this->setUTF8("โทรศัพท์มือถือ\nTelephone"),
          $this->setUTF8($address['address_mobile'])
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("อีเมล\nEmail"),
          $this->setUTF8($address['address_email']),
          $this->setUTF8(""),
          $this->setUTF8("")
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Ln();
      }
    }
    
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->SetWidths([190]);
    $this->fpdf->SetAligns(['L']);
    $this->fpdf->Row([
      $this->setUTF8("ทราบการรับสมัครงานของ บมจ. นวกิจประกันภัย จากที่ใด\nYou know to apply to the Company from?")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $source = $this->applicantsreportmodel->get_news_sourceinfo_byid( $info['applicant_news_source_id'] );
    $this->fpdf->Row([
      $this->setUTF8(( isset( $source ) && count( $source ) > 0 ) ? $source['source_title_th']:"")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());

    $this->fpdf->Row([
      $this->setUTF8("เคยสมัครงานกับ บมจ.​นวกิจประกันภัย มาก่อนหรือไม่?\nHave you to applied for employment with us before?")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->Row([
      $this->setUTF8($info['applicant_applied_status'] == 1 ? 'เคย' : 'ไม่เคย')
    ]);
    $this->fpdf->Row([
      $this->setUTF8(( $info['applicant_applied_status'] == 1 && $info['applicant_applied_year'] != '' )?"เมื่อปี : ".$info['applicant_applied_year']:"")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->Row([
      $this->setUTF8("ท่านเคยประสบอุบัติเหตุถึงขั้นเข้าโรงพยาบาลหรือไม่?\nHave you ever had an accident or illness to step into the hospital?")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->Row([
      $this->setUTF8($info['applicant_accident_status'] == 1 ? 'เคย' : 'ไม่เคย')
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());

    $this->fpdf->SetFont('supermarket', '', 18);
    $this->fpdf->Ln();
    $this->fpdf->Cell(130, 8, $this->setUTF8('ประวัติการศึกษา (Education Information)'), 0, 1, 'L');
    $this->fpdf->Ln(3);
    $this->fpdf->SetFont('sukhumvitset', '', 8);
    $this->fpdf->SetWidths([90,100]);
    $this->fpdf->SetAligns(['L','L']);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->Row([
      $this->setUTF8("ขณะนี้ท่านอยู่ระหว่างการศึกษาหรือไม่?\nAre you currently studying?"),
      $this->setUTF8($info['applicant_studying_status'] == 1 ? 'ใช่' : 'ไม่ใช่')
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->SetWidths([40,50,30,20,30,20]);
    $this->fpdf->SetAligns(['C','C','C','C','C','C']);
    $this->fpdf->Row([
      $this->setUTF8("ระดับการศึกษา"),
      $this->setUTF8("สถาบัน"),
      $this->setUTF8("จังหวัด"),
      $this->setUTF8("ปีที่จบ"),
      $this->setUTF8("วิชาเอก"),
      $this->setUTF8("เกรดเฉลี่ย"),
    ]);
    $this->fpdf->SetAligns(['L','L','L','L','L','L']);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    if( $info['applicant_education_highschool_province_id'] > 0 ){
      $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_highschool_province_id'] )['name'];
    }else{
      $province = "";
    }
    $this->fpdf->Row([
      $this->setUTF8("มัธยมศึกษา\nHigh school"),
      $this->setUTF8($info['applicant_education_highschool_name']),
      $this->setUTF8($province),
      $this->setUTF8($info['applicant_education_highschool_year']),
      $this->setUTF8($info['applicant_education_highschool_major']),
      $this->setUTF8(number_format($info['applicant_education_highschool_gpa'],2)),
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    if( $info['applicant_education_vocational_province_id'] > 0 ){
      $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_vocational_province_id'] )['name'];
    }else{
      $province = "";
    }
    $this->fpdf->Row([
      $this->setUTF8("ปวช.\nVocational"),
      $this->setUTF8($info['applicant_education_vocational_name']),
      $this->setUTF8($province),
      $this->setUTF8($info['applicant_education_highschool_year']),
      $this->setUTF8($info['applicant_education_highschool_major']),
      $this->setUTF8(number_format($info['applicant_education_highschool_gpa'],2)),
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    if( $info['applicant_education_diploma_province_id'] > 0 ){
      $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_diploma_province_id'] )['name'];
    }else{
      $province = "";
    }
    $this->fpdf->Row([
      $this->setUTF8("ปวท./ปวส.\nDiploma"),
      $this->setUTF8($info['applicant_education_diploma_name']),
      $this->setUTF8($province),
      $this->setUTF8($info['applicant_education_diploma_year']),
      $this->setUTF8($info['applicant_education_diploma_major']),
      $this->setUTF8(number_format($info['applicant_education_diploma_gpa'],2)),
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    if( $info['applicant_education_bachelor_province_id'] > 0 ){
      $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_bachelor_province_id'] )['name'];
    }else{
      $province = "";
    }
    $this->fpdf->Row([
      $this->setUTF8("ปริญญาตรี\nBachelor's degree"),
      $this->setUTF8($info['applicant_education_bachelor_name']),
      $this->setUTF8($province),
      $this->setUTF8($info['applicant_education_bachelor_year']),
      $this->setUTF8($info['applicant_education_bachelor_major']),
      $this->setUTF8(number_format($info['applicant_education_bachelor_gpa'],2)),
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    if( $info['applicant_education_master_province_id'] > 0 ){
      $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_master_province_id'] )['name'];
    }else{
      $province = "";
    }
    $this->fpdf->Row([
      $this->setUTF8("ปริญญาโท\nMaster's degree"),
      $this->setUTF8($info['applicant_education_master_name']),
      $this->setUTF8($province),
      $this->setUTF8($info['applicant_education_master_year']),
      $this->setUTF8($info['applicant_education_master_major']),
      $this->setUTF8(number_format($info['applicant_education_master_gpa'],2)),
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    if( $info['applicant_education_other_province_id'] > 0 ){
      $province = $this->applicantsreportmodel->get_provinceinfo_byid( $info['applicant_education_other_province_id'] )['name'];
    }else{
      $province = "";
    }
    $this->fpdf->Row([
      $this->setUTF8("อื่นๆ\nOther"),
      $this->setUTF8($info['applicant_education_other_name']),
      $this->setUTF8($province),
      $this->setUTF8($info['applicant_education_other_year']),
      $this->setUTF8($info['applicant_education_other_major']),
      $this->setUTF8(number_format($info['applicant_education_other_gpa'],2)),
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());

    $this->fpdf->SetFont('supermarket', '', 18);
    $this->fpdf->Ln();
    $this->fpdf->Cell(130, 8, $this->setUTF8('ความสามารถอื่นๆ (Knowledge/Skills)'), 0, 1, 'L');
    $this->fpdf->Ln(3);
    $this->fpdf->SetFont('sukhumvitset', '', 8);
    $this->fpdf->SetWidths([40,150]);
    $this->fpdf->SetAligns(['L','L']);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());

    $skills = [
      "applicant_skill_computer" => ["label" => "ความรู้/ความสามารถ\nเกี่ยวกับคอมพิวเตอร์?\nComputer Skill","unit" => ""],
      "applicant_skill_typing_thai" => ["label" => "อัตราพิมพ์ดีด ภาษาไทย\nTyping rate in Thai","unit" => "คำ/นาที (words / minute)"],
      "applicant_skill_typing_english" => ["label" => "อัตราพิมพ์ดีด ภาษาอังกฤษ\nTyping rate in English","unit" => "คำ/นาที (words / minute)"],
      "applicant_skill_office_tools" => ["label" => "สามารถใช้เครื่องใช้\nสำนักงานอะไรได้บ้าง\nWhat office equipment can be used to do?","unit" => ""],
      "applicant_skill_specials" => ["label" => "ความรู้/ความสามารถพิเศษ\nKnowledge/Skills","unit" => ""],
      "applicant_skill_activities" => ["label" => "กิจกรรมระหว่างการศึกษา\nActivities during the study","unit" => ""],
    ];
    foreach($skills as $key=>$l){
      $this->fpdf->Row([
        $this->setUTF8($l['label']),
        $this->setUTF8($info[$key] . " " . $l['unit']),
      ]);
      $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    }
    $this->fpdf->Row([
      $this->setUTF8("ความสามารถในการ\nขับขี่ยานพาหนะ\nVehicel driving skil"),
      $this->setUTF8((( $info['applicant_skill_driving_status'] == 1 ) ? "รถยนต์ : ".( $info['applicant_skill_driving_status'] == 1 ? 'ได้' : 'ไม่ได้' )."\nหมายเลขใบขับขี่ : ".$info['applicant_skill_driving_license']."\n": "") . (( $info['applicant_skill_driving_status'] == 1 ) ? "รถจักรยานยนต์ : ".( $info['applicant_skill_riding_status'] == 1 ? 'ได้' : 'ไม่ได้' )."\nหมายเลขใบขับขี่ : ".$info['applicant_skill_riding_license']: "")),
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $languages = $this->applicantsreportmodel->get_languages( $info['applicant_id'] );
    if( isset( $languages ) && count( $languages ) > 0 ){
      $this->fpdf->SetFont('supermarket', '', 18);
      $this->fpdf->Ln();
      $this->fpdf->Cell(130, 8, $this->setUTF8('ความรู้ด้านภาษา (Language abilities)'), 0, 1, 'L');
      $this->fpdf->Ln(3);
      $this->fpdf->SetFont('sukhumvitset', '', 8);
      $this->fpdf->SetWidths([38,38,38,38,38]);
      $this->fpdf->SetAligns(['L','L','L','L','L']);
      $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
      $this->fpdf->Row([
        $this->setUTF8("ภาษา\nLanguage"),
        $this->setUTF8("ฟัง\nListening"),
        $this->setUTF8("พูด\nSpeaking"),
        $this->setUTF8("อ่าน\nReading"),
        $this->setUTF8("เขียน\nWriting"),
      ]);
      $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
      
      foreach( $languages as $language ){
        $this->fpdf->Row([
          $this->setUTF8($language['language_name']),
          $this->setUTF8($this->languageSkill($language['language_listen'])),
          $this->setUTF8($this->languageSkill($language['language_speaking'])),
          $this->setUTF8($this->languageSkill($language['language_reading'])),
          $this->setUTF8($this->languageSkill($language['language_writing'])),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
      }
    }

    $experiences = $this->applicantsreportmodel->get_experiences( $info['applicant_id'] );
    if( isset( $experiences ) && count( $experiences ) > 0 ){
      $this->fpdf->SetFont('supermarket', '', 18);
      $this->fpdf->Ln();
      $this->fpdf->Cell(130, 8, $this->setUTF8('ประวัติการทำงาน (Working Experience In Chronological)'), 0, 1, 'L');
      $this->fpdf->Ln(3);
      $this->fpdf->SetFont('sukhumvitset', '', 8);
  
      foreach( $experiences as $experience ){
        $this->fpdf->SetWidths([45,50,45,50]);
        $this->fpdf->SetAligns(['L','L','L','L']);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("ชื่อบริษัท\nCompany Name"),
          $this->setUTF8($experience['experience_company_name']),
          $this->setUTF8("ที่อยู่\nAddress"),
          $this->setUTF8($experience['experience_company_address']),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("โทรศัพท์\nTelephone"),
          $this->setUTF8($experience['experience_company_tel']),
          $this->setUTF8("ตั้งแต่\nSince - until"),
          $this->setUTF8(thai_convert_shortdate( $experience['experience_start'] ) . " - " . (( $experience['experience_end'] != '' ? thai_convert_shortdate( $experience['experience_start'] ) : 'ปัจจุบัน' ))),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->SetWidths([45,50,95]);
        $this->fpdf->Row([
          $this->setUTF8("ชื่อผู้บังคับบัญชา/ตำแหน่ง\nName of superior/position."),
          $this->setUTF8($experience['experience_superior']),
          $this->setUTF8(""),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->SetWidths([45,145]);
        $this->fpdf->Row([
          $this->setUTF8("หน้าที่ความรับผิดชอบ\nResponsibilities"),
          $this->setUTF8($experience['experience_job_description']),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->SetWidths([45,50,45,50]);
        $this->fpdf->SetAligns(['L','L','L','L']);
        $this->fpdf->Row([
          $this->setUTF8("เงินเดือน\nSalary"),
          $this->setUTF8(number_format( $experience['experience_salary'] ) . " บาท"),
          $this->setUTF8("ค่าครองชีพ\nCost of living"),
          $this->setUTF8(number_format( $experience['experience_cost_of_living'] ) . " บาท"),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        
        $this->fpdf->Row([
          $this->setUTF8("โบนัส/เดือน\nBonus/month"),
          $this->setUTF8(number_format( $experience['experience_bonus'] ) . " บาท"),
          $this->setUTF8("รายได้อื่นๆ\nOther"),
          $this->setUTF8(number_format( $experience['experience_other'] ) . " บาท"),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Row([
          $this->setUTF8("รวม\nTotal"),
          $this->setUTF8(number_format( $experience['experience_total'] ) . " บาท"),
          $this->setUTF8("เหตุผลในการลาออก\nReason for resignation"),
          $this->setUTF8($experience['experience_reason']),
        ]);
        $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
        $this->fpdf->Ln();
      }
      
    }

    



    $this->fpdf->SetFont('supermarket', '', 18);
    $this->fpdf->Ln();
    $this->fpdf->Cell(130, 8, $this->setUTF8('แนะนำตนเอง (Introduction)'), 0, 1, 'L');
    $this->fpdf->Ln(3);
    $this->fpdf->SetFont('sukhumvitset', '', 8);
    
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->SetWidths([190]);
    $this->fpdf->SetAligns(['L']);
    $this->fpdf->Row([
      $this->setUTF8("กรุณาแนะนำตัวท่านเองเพื่อให้บริษัทรู้จักตัวท่านดีขึ้น\nPlease provide any further information about yourself which will allow our company to know you better.")
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    $this->fpdf->Row([
      $this->setUTF8($info['applicant_introduction'])
    ]);
    $this->fpdf->Line(10,$this->fpdf->getY(),200,$this->fpdf->getY());
    
    
 

    $this->fpdf->Output('pdf/applicantsreport_'.$this->_data['info']['applicant_id'].'.pdf',"D");
  }

  private function setUTF8($text)
	{
		return iconv( 'UTF-8','cp874//IGNORE',$text);
	}
  private function languageSkill($lang){
    switch( $lang ){
      case 'great' : $status = 'ดีมาก'; break;
      case 'good' : $status = 'ดี'; break;
      case 'moderate' : $status = 'พอใช้'; break;
      default : $status = '-';
    }
    return $status;
  }
}
