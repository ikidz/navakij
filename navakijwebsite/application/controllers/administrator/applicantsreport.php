<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Applicantsreport extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	var $_language = 'th';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/applicantsreport/applicantsreportmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการรับสมัครงาน",'icon-list-alt');
	}

	public function index( $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('156d833ba9d1de77f886c1f22270848c');
		$this->admin_model->set_detail('รายชื่อผู้สมัครงาน');
		
		$this->_data['locations'] = $this->applicantsreportmodel->get_locations();
		$this->_data['jobs'] = $this->applicantsreportmodel->get_jobs(0, 0);
		$this->_data['provinces'] = $this->applicantsreportmodel->get_provinces();
		
		/* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('applicantsreport/sorting', $this->_data);
		/* Set Custom Tools - End */
		
		$aSort = array(
			'sort_location_id' => ( $this->input->get('sort_location_id') ? $this->input->get('sort_location_id') : '' ),
			'sort_job_id' => ( $this->input->get('sort_job_id') ? $this->input->get('sort_job_id') : '' ),
			'sort_start_date' => ( $this->input->get('sort_start_date') ? $this->input->get('sort_start_date') : '' ),
			'sort_end_date' => ( $this->input->get('sort_end_date') ? $this->input->get('sort_end_date') : '' ),
			'sort_keywords' => ( $this->input->get('sort_keywords') ? $this->input->get('sort_keywords') : '' )
		);
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->applicantsreportmodel->get_applicants($aSort, $perpage, $offset));
		$totalrows = $this->applicantsreportmodel->count_applicants($aSort);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('applicant_id','ลำดับ','5%','icon-list-ol');
		$this->admin_model->set_column('location_id','ตำแหน่งงาน','20%','icon-map-marker');
		$this->admin_model->set_column('applicant_fname_th','ชื่อ-นามสกุล','20%','icon-user');
		$this->admin_model->set_column('applicant_createdtime','วันที่สมัคร','10%','icon-calendar-o');
		$this->admin_model->set_column('is_editable','อนุญาตให้แก้ไข','15%','icon-pencil-square');
		$this->admin_model->set_column('is_print','สั่งพิมพ์','10%','icon-print');
		$this->admin_model->set_action_button('ดูข้อมูล','applicantsreport/info/[applicant_id]','icon-eye','btn-primary','r');
		$this->admin_model->set_action_button('ลบข้อมูล','applicantsreport/delete/[applicant_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_action_button('สั่งพิมพ์','applicantsreport/print/[applicant_id]','icon-print','btn-default','r');
		$this->admin_model->set_action_button('ดาวน์โหลด PDF','applicantsreport/pdf/[applicant_id]','icon-download','btn-default','r');
		$this->admin_model->set_column_callback('applicant_id','show_seq');
		$this->admin_model->set_column_callback('location_id','show_location');
		$this->admin_model->set_column_callback('applicant_fname_th','show_name');
		$this->admin_model->set_column_callback('applicant_createdtime','show_datetime');
		$this->admin_model->set_column_callback('is_editable','show_edit_status');
		$this->admin_model->set_column_callback('is_print','show_icon_status');
		$this->admin_model->set_pagination("applicantsreport/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
		
	}
	
	public function info( $applicantid=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('156d833ba9d1de77f886c1f22270848c');
		$this->admin_model->set_detail('รายละเอียดข้อมูล');
		
		$this->_data['info'] = $this->applicantsreportmodel->get_applicantinfo_byid( $applicantid );
		$this->_data['locations'] = $this->applicantsreportmodel->get_locations();
		$this->_data['positions'] = $this->applicantsreportmodel->get_jobs(0, 1);
		$this->_data['prefixes'] = $this->applicantsreportmodel->get_prefixes();
		$this->_data['provinces'] = $this->applicantsreportmodel->get_provinces();
		$this->_data['districts'] = $this->applicantsreportmodel->get_districts();
		$this->_data['subdistricts'] = $this->applicantsreportmodel->get_subdistricts();
		$this->_data['postcodes'] = $this->applicantsreportmodel->get_zipcodes();
		$this->_data['sources'] = $this->applicantsreportmodel->get_news_sources();
		$this->_data['addresses'] = array(
			'current' => $this->applicantsreportmodel->get_addresss( $this->_data['info']['applicant_id'], 'current' ),
			'registration' => $this->applicantsreportmodel->get_addresss( $this->_data['info']['applicant_id'], 'registration' )
		);
		$this->admin_library->view('applicantsreport/info', $this->_data);
		$this->admin_library->output();
	}

	public function export(){
		// try{
		// 	/* Init PHPExcel - Start */
		// 	$this->load->library('PHPExcel');
		// 	$objPHPExcel =new PHPExcel;
		// 	$objPHPExcel->setActiveSheetIndex(0);

		// 	$styleArray = array(
		// 		'font'  => array(
		// 			'bold'  => true,
		// 			'color' => array('rgb' => 'FFFFFF'),
		// 			'size'  => 10,
		// 		),
		// 		'fill'  => array(
		// 			'type' => PHPExcel_Style_Fill::FILL_SOLID,
		// 			'color' => array('rgb' => '00008B'),
		// 		)
		// 	);

		// 	$objPHPExcel->getActiveSheet()->getStyle('A1:HO1')->applyFromArray($styleArray);

		// 		/* Setting file information - Start */
		// 		// $objPHPExcel->getProperties()->setCreator("Navakij Insurance Public Company Limited")  
		// 		// 							->setLastModifiedBy("Navakij Insurance Public Company Limited")  
		// 		// 							->setTitle("exported_applicants_".date("dmYHis"))  
		// 		// 							->setSubject("Applicants (Exported at ".date("dmYHis").")");
		// 		/* Setting file information - End */

		// 		/* Setting worksheet - Start */
		// 		// $objPHPExcel->getActiveSheet()->setTitle('Applicants list');
		// 		// $objPHPExcel->setActiveSheetIndex(0);
		// 		/* Setting worksheet - End */

		// 		/* Setting column width - Start */
		// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		// 		/* Setting column width - End */

		// 		/* Setting column title - Start */
		// 		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ลำดับที่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'ตำแหน่ง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'เงินเดือนที่ต้องการ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'คำนำหน้า (ไทย)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ชื่อ (ไทย)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'สกุล (ไทย)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Title (Eng)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Name (Eng)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Surname (Eng)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'วัน/เดือน/ปีเกิด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'อายุ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'สถานที่เกิด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'สัญชาติ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'เชื้อชาติ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'ศาสนา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'สถานภาพสมรส');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'เลขที่บัตรประชาชน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'บัตรหมดอายุ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('S1', 'สถานภาพทางทหาร');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('T1', 'น้ำหนัก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('U1', 'ส่วนสูง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('V1', 'ที่อยู่ปัจจุบัน - บ้านเลขที่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('W1', 'หมู่บ้าน/อาคาร');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('X1', 'ถนน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'แขวง/ตำบล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'เขต/อำเภอ');

		// 		$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'รหัสไปรษณีย์');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'ที่อยู่ปัจจุบัน (รวม)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'ภูมิลำเนา - บ้านเลขที่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'หมู่บ้าน/อาคาร');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'ถนน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'แขวง/ตำบล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'เขต/อำเภอ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AI1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'รหัสไปรษณีย์');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AK1', 'ภูมิลำเนา (รวม)');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AL1', 'โทรศัพท์บ้าน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AM1', 'โทรศัพท์มือถือ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AN1', 'E-mail');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AO1', 'บิดา/ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AP1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AQ1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AR1', 'มารดา/ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AS1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AT1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AU1', 'สามี-ภรรยา/ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AV1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AW1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AX1', 'บุตร/ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AY1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('AZ1', 'อาชีพ');

		// 		$objPHPExcel->getActiveSheet()->setCellValue('BA1', 'บุตร/ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BB1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BC1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BD1', 'บุตร/ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BE1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BF1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BG1', 'มีพี่น้องจำนวน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BH1', 'คนที่ 1 / ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BI1', 'ความเกี่ยวข้อง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BJ1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BK1', 'ชื่อสถานประกอบการ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BL1', 'คนที่ 2 / ชื่อ - นามสกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BM1', 'ความเกี่ยวข้อง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BN1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BO1', 'ชื่อสถานประกอบการ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BP1', 'คนที่ 3');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BQ1', 'ความเกี่ยวข้อง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BR1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BS1', 'ชื่อสถานประกอบการ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BT1', 'คนที่ 4');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BU1', 'ความเกี่ยวข้อง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BV1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BW1', 'ชื่อสถานประกอบการ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BX1', 'คนที่ 5');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BY1', 'ความเกี่ยวข้อง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('BZ1', 'อาชีพ');

		// 		$objPHPExcel->getActiveSheet()->setCellValue('CA1', 'ชื่อสถานประกอบการ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CB1', 'ท่านทราบการรับสมัครเข้าทำงานของบริษัทจาก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CC1', 'ท่านมีญาติพี่น้อง ที่เคยทำงานที่นี่หรือไม่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CD1', 'ในกรณีมีเหตุฉุกเฉินสามารถติดต่อได้ที่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CE1', 'โทร.');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CF1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CG1', 'เคยต้องโทษทางแพ่งหรือทางอาญาหรือไม่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CH1', 'ท่านมีโรคประจำตัวหรือไม่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CI1', 'ท่านเคยเจ็บป่วยหรือประสบอุบัติเหตุถึงขั้นนอนโรงพยาบาลหรือไม่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CJ1', 'รายชื่อบุคคลที่จะรับรองคนที่ 1 / ชื่อ - สกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CK1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CL1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CM1', 'จำนวนปีที่รู้จัก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CN1', 'รายชื่อบุคคลที่จะรับรองคนที่ 2 / ชื่อ - สกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CO1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CP1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CQ1', 'จำนวนปีที่รู้จัก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CR1', 'รายชื่อบุคคลที่จะรับรองคนที่ 3 / ชื่อ - สกุล');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CS1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CT1', 'อาชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CU1', 'จำนวนปีที่รู้จัก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CV1', 'ระบุข้อมูลเพิ่มเติมอื่น ๆ เกี่ยวกับตัวเอง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CW1', 'มัธยมศึกษา/สถานศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CX1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CY1', 'ปีการศึกษาที่จบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('CZ1', 'วิชาเอก');

		// 		$objPHPExcel->getActiveSheet()->setCellValue('DA1', 'เกรดเฉลี่ย');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DB1', 'ปวช. สถานศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DC1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DD1', 'ปีการศึกษาที่จบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DE1', 'วิชาเอก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DF1', 'เกรดเฉลี่ย');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DG1', 'ปวท./ปวส./สถานศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DH1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DI1', 'ปีการศึกษาที่จบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DJ1', 'วิชาเอก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DK1', 'เกรดเฉลี่ย');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DL1', 'ปริญญาตรี/สถานศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DM1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DN1', 'ปีการศึกษาที่จบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DO1', 'วิชาเอก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DP1', 'เกรดเฉลี่ย');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DQ1', 'ปริญญาโท/สถานศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DR1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DS1', 'ปีการศึกษาที่จบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DT1', 'วิชาเอก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DU1', 'เกรดเฉลี่ย');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DV1', 'การศึกษาอื่น ๆ/สถานศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DW1', 'จังหวัด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DX1', 'ปีการศึกษาที่จบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DY1', 'วิชาเอก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('DZ1', 'เกรดเฉลี่ย');

		// 		$objPHPExcel->getActiveSheet()->setCellValue('EA1', 'กลุ่มสถาบันการศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EB1', 'ยังอยู่ในระหว่างการศึกษาหรือไม่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EC1', 'ความรู้ / ความสามารถเกี่ยวกับคอมพิวเตอร์');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('ED1', 'อัตราการพิมพ์ดีด ภาษาไทย');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EE1', 'อัตราการพิมพ์ดีด ภาษาอังกฤษ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EF1', 'สามารถใช้เครื่องใช้สำนักงานอะไรบ้าง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EG1', 'ความรู้ / ความสามารถพิเศษอื่น ๆ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EH1', 'กิจกรรมระหว่างการศึกษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EI1', 'ยานยนต์ที่สามารถขับขี่ได้');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EJ1', 'ความรู้ด้านภาษา 1/ภาษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EK1', 'ฟัง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EL1', 'พูด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EM1', 'อ่าน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EN1', 'เขียน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EO1', 'ความรู้ด้านภาษา 2/ภาษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EP1', 'ฟัง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EQ1', 'พูด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('ER1', 'อ่าน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('ES1', 'เขียน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('ET1', 'ความรู้ด้านภาษา 3/ภาษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EU1', 'ฟัง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EV1', 'พูด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EW1', 'อ่าน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EX1', 'เขียน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EY1', 'ความรู้ด้านภาษา 4/ภาษา');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('EZ1', 'ฟัง');

		// 		$objPHPExcel->getActiveSheet()->setCellValue('FA1', 'พูด');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FB1', 'อ่าน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FC1', 'เขียน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FD1', 'บริษัทที่เคยทำงานครั้งล่าสุด/บริษัท');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FE1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FF1', 'โทร.');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FG1', 'ตั้งแต่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FH1', 'ถึง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FI1', 'ชื่อผู้บังคับบัญชา / ตำแหน่ง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FJ1', 'ตำแหน่งหน้าที่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FK1', 'ความรับผิดชอบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FL1', 'เงินเดือน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FM1', 'ค่าครองชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FN1', 'โบนัส/เดือน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FO1', 'อื่น ๆ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FP1', 'รวม');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FQ1', 'เหตุผลในการลาออก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FR1', 'บริษัทที่เคยทำงาน 2/บริษัท');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FS1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FT1', 'โทร.');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FU1', 'ตั้งแต่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FV1', 'ถึง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FW1', 'ชื่อผู้บังคับบัญชา / ตำแหน่ง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FX1', 'ตำแหน่งหน้าที่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FY1', 'ความรับผิดชอบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('FZ1', 'เงินเดือน');
							
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GA1', 'ค่าครองชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GB1', 'โบนัส/เดือน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GC1', 'อื่น ๆ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GD1', 'รวม');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GE1', 'เหตุผลในการลาออก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GF1', 'บริษัทที่เคยทำงาน 3/บริษัท');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GG1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GH1', 'โทร.');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GI1', 'ตั้งแต่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GJ1', 'ถึง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GK1', 'ชื่อผู้บังคับบัญชา / ตำแหน่ง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GL1', 'ตำแหน่งหน้าที่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GM1', 'ความรับผิดชอบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GN1', 'เงินเดือน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GO1', 'ค่าครองชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GP1', 'โบนัส/เดือน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GQ1', 'อื่น ๆ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GR1', 'รวม');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GS1', 'เหตุผลในการลาออก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GT1', 'บริษัทที่เคยทำงาน 4/บริษัท');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GU1', 'ที่อยู่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GV1', 'โทร.');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GW1', 'ตั้งแต่');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GX1', 'ถึง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GY1', 'ชื่อผู้บังคับบัญชา / ตำแหน่ง');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('GZ1', 'ตำแหน่งหน้าที่');

		// 		$objPHPExcel->getActiveSheet()->setCellValue('HA1', 'ความรับผิดชอบ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HB1', 'เงินเดือน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HC1', 'ค่าครองชีพ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HD1', 'โบนัส/เดือน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HE1', 'อื่น ๆ');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HF1', 'รวม');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HG1', 'เหตุผลในการลาออก');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HH1', 'อื่น ๆ เพิ่มเติม');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HI1', 'วันที่สมัคร');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HJ1', 'สาขาที่จะลง/สถานที่ทำงาน');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HK1', 'ไฟล์แนบ 1');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HL1', 'ไฟล์แนบ 2');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HM1', 'ไฟล์แนบ 3');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HN1', 'ไฟล์แนบ 4');
		// 		$objPHPExcel->getActiveSheet()->setCellValue('HO1', 'ไฟล์แนบ 5');
		// 		/* Setting column title - End */

		// 		$objPHPExcel->getActiveSheet()->setAutoFilter('A1:HO1');

		// 		/* Init Data - Start */
		// 		$aSort = array(
		// 			'sort_location_id' => $this->input->get('sort_location_id'),
		// 			'sort_job_id' => $this->input->get('sort_job_id'),
		// 			'sort_start_date' => $this->input->get('sort_start_date'),
		// 			'sort_end_date' => $this->input->get('sort_end_date'),
		// 			'sort_keywords' => $this->input->get('sort_keywords')
		// 		);
				
		// 		$this->_data['aSort'] = $aSort;
		// 		$lists = $this->applicantsreportmodel->get_applicants($aSort);
		// 		if( isset( $lists ) && count( $lists ) > 0 ){
		// 			$i_num=0;
		// 			$start_row = 2;
		// 			foreach( $lists as $list ){
		// 				$i_num++;

		// 				/* Setting related query data - Start */
		// 				$location = $this->applicantsreportmodel->get_locationinfo_byid( $list['location_id'] );
		// 				$job = $this->applicantsreportmodel->get_jobinfo_byid( $list['job_id'] );
		// 				$current_address = $this->applicantsreportmodel->get_addresss( $list['applicant_id'], 'current' );
		// 				if( isset( $current_address ) && count( $current_address ) > 0 ){
		// 					$province = $this->applicantsreportmodel->get_provinceinfo_byid( $current_address[0]['province_id'] );
		// 					$district = $this->applicantsreportmodel->get_districtinfo_byid( $current_address[0]['district_id'] );
		// 					$subdistrict = $this->applicantsreportmodel->get_subdistrictinfo_byid( $current_address[0]['subdistrict_id'] );
		// 					$postcode = $this->applicantsreportmodel->get_postcodeinfo_byid( $current_address[0]['postcode_id'] );
		// 					$current_address[0]['province'] = ( $current_address[0]['province_id'] > 0 ? $province['name'] : '' );
		// 					$current_address[0]['district'] = ( $current_address[0]['district_id'] > 0 ? $district['name'] : '' );
		// 					$current_address[0]['subdistrict'] = ( $current_address[0]['subdistrict_id'] > 0 ? $subdistrict['name'] : '' );
		// 					$current_address[0]['postcode'] = ( $current_address[0]['postcode_id'] > 0 ? $postcode['name'] : '' );
		// 				}
		// 				$registration_address = $this->applicantsreportmodel->get_addresss( $list['applicant_id'], 'registration' );
		// 				if( isset( $registration_address ) && count( $registration_address ) > 0 ){
		// 					$province = $this->applicantsreportmodel->get_provinceinfo_byid( $registration_address[0]['province_id'] );
		// 					$district = $this->applicantsreportmodel->get_districtinfo_byid( $registration_address[0]['district_id'] );
		// 					$subdistrict = $this->applicantsreportmodel->get_subdistrictinfo_byid( $registration_address[0]['subdistrict_id'] );
		// 					$postcode = $this->applicantsreportmodel->get_postcodeinfo_byid( $registration_address[0]['postcode_id'] );
		// 					$registration_address[0]['province'] = ( $registration_address[0]['province_id'] > 0 ? $province['name'] : '' );
		// 					$registration_address[0]['district'] = ( $registration_address[0]['district_id'] > 0 ? $district['name'] : '' );
		// 					$registration_address[0]['subdistrict'] = ( $registration_address[0]['subdistrict_id'] > 0 ? $subdistrict['name'] : '' );
		// 					$registration_address[0]['postcode'] = ( $registration_address[0]['postcode_id'] > 0 ? $postcode['name'] : '' );
		// 				}
		// 				$displayPrefix_th = '';
		// 				$displayPrefix_en = '';
		// 				if( $list['prefix_id'] == 999 ){
		// 					$displayPrefix_th = $list['prefix_other'];
		// 					$displayPrefix_en = $list['prefix_other'];
		// 				}else{
		// 					$prefix = $this->applicantsreportmodel->get_prefixinfo_byid( $list['prefix_id'] );
		// 					if( isset( $prefix ) && count( $prefix ) > 0 ){
		// 						$displayPrefix_th = $prefix['prefix_title_th'];
		// 						$displayPrefix_en = $prefix['prefix_title_en'];
		// 					}
		// 				}
		// 				$displayMilitaryStatus = '';
		// 				switch( $displayMilitaryStatus ){
		// 					case 'serving' : $displayMilitaryStatus = 'อยู่ระหว่างรับราชการทหาร / ทหารเกณฑ์'; break;
		// 					case 'completed' : $displayMilitaryStatus = 'ผ่านการเกณฑ์ทหาร'; break;
		// 					case 'exempted' : $displayMilitaryStatus = 'ได้รับการยกเว้น'; break;
		// 					default : $displayMilitaryStatus = '';
		// 				}
		// 				$source = $this->applicantsreportmodel->get_news_sourceinfo_byid( $list['applicant_news_source_id'] );
		// 				$highschool_province = $this->applicantsreportmodel->get_provinceinfo_byid( $list['applicant_education_highschool_province_id']);
		// 				$vocational_province = $this->applicantsreportmodel->get_provinceinfo_byid( $list['applicant_education_vocational_province_id']);
		// 				$diploma_province = $this->applicantsreportmodel->get_provinceinfo_byid( $list['applicant_education_diploma_province_id']);
		// 				$bachelor_province = $this->applicantsreportmodel->get_provinceinfo_byid( $list['applicant_education_bachelor_province_id']);
		// 				$master_province = $this->applicantsreportmodel->get_provinceinfo_byid( $list['applicant_education_master_province_id']);
		// 				$other_province = $this->applicantsreportmodel->get_provinceinfo_byid( $list['applicant_education_other_province_id']);
		// 				$languages = $this->applicantsreportmodel->get_languages( $list['applicant_id'] );
		// 				$aLanguage = array();
		// 				if( isset( $languages ) && count( $languages ) > 0 ){
		// 					foreach( $languages as $language ){
		// 						$aData = [
		// 							'name' => $language['language_name'],
		// 							'listen' => $this->languageSkill( $language['language_listen'] ),
		// 							'speaking' => $this->languageSkill( $language['language_listen'] ),
		// 							'reading' => $this->languageSkill( $language['language_listen'] ),
		// 							'writing' => $this->languageSkill( $language['language_listen'] )
		// 						];
		// 						array_push( $aLanguage, $aData );
		// 					}
		// 				}
		// 				$experiences = $this->applicantsreportmodel->get_experiences( $list['applicant_id'] );
		// 				$aExperience = array();
		// 				if( isset( $experiences ) && count( $experiences ) > 0 ){
		// 					foreach( $experiences as $experience ){
		// 						$aData = [
		// 							'name' => $experience['experience_company_name'],
		// 							'address' => $experience['experience_company_address'],
		// 							'tel' => $experience['experience_company_tel'],
		// 							'start' => $experience['experience_start'],
		// 							'end' => $experience['experience_end'],
		// 							'superior' => $experience['experience_superior'],
		// 							'position' => '',
		// 							'responsibility' => $experience['experience_job_description'],
		// 							'salary' => $experience['experience_salary'],
		// 							'cost_of_living' => $experience['experience_cost_of_living'],
		// 							'bonus' => $experience['experience_bonus'],
		// 							'other' => $experience['experience_other'],
		// 							'total' => $experience['experience_total'],
		// 							'reason' => $experience['experience_reason']
		// 						];
		// 						array_push( $aExperience, $aData );
		// 					}
		// 				}
		// 				/* Setting related query data - End */

		// 				/* Embed data into cells - Start */
		// 				$objPHPExcel->getActiveSheet()->setCellValue('A'.$start_row, $i_num);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('B'.$start_row, ( isset( $job ) && count( $job ) > 0 ? $job['job_title_th'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('C'.$start_row, $list['applicant_salary']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('D'.$start_row, $displayPrefix_th);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('E'.$start_row, $list['applicant_fname_th']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('F'.$start_row, $list['applicant_lname_th']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('G'.$start_row, $displayPrefix_en);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('H'.$start_row, $list['applicant_fname_en']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('I'.$start_row, $list['applicant_lname_en']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('J'.$start_row, ( $list['applicant_birthdate'] != null || $list['applicant_birthdate'] != '' ? date("d M Y", strtotime( $list['applicant_birthdate'] )) : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('K'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('L'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('M'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('N'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('O'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('P'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$start_row, $list['applicant_idcard']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('R'.$start_row, ( $list['applicant_idcard_expired'] != null || $list['applicant_idcard_expired'] != '' ? date("d M Y", strtotime( $list['applicant_idcard_expired'] )) : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('S'.$start_row, $displayMilitaryStatus);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('T'.$start_row, $list['applicant_weight']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('U'.$start_row, $list['applicant_height']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('V'.$start_row, $current_address[0]['address_no']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('W'.$start_row, $current_address[0]['address_building']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('X'.$start_row, $current_address[0]['address_street']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('Y'.$start_row, $current_address[0]['subdistrict']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('Z'.$start_row, $current_address[0]['district']);

		// 				$objPHPExcel->getActiveSheet()->setCellValue('AA'.$start_row, $current_address[0]['province']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AB'.$start_row, $current_address[0]['postcode']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AC'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AD'.$start_row, $registration_address[0]['address_no']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AE'.$start_row, $registration_address[0]['address_building']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AF'.$start_row, $registration_address[0]['address_street']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AG'.$start_row, $registration_address[0]['subdistrict']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AH'.$start_row, $registration_address[0]['district']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AI'.$start_row, $registration_address[0]['province']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$start_row, $registration_address[0]['postcode']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AK'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AL'.$start_row, $current_address[0]['address_tel']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AM'.$start_row, $current_address[0]['address_mobile']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AN'.$start_row, $current_address[0]['address_email']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AO'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AP'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AR'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AS'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AT'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AU'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AV'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AW'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AX'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AY'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$start_row, '');

		// 				$objPHPExcel->getActiveSheet()->setCellValue('BA'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BB'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BC'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BD'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BE'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BF'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BG'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BH'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BI'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BJ'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BK'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BL'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BM'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BN'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BO'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BP'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BQ'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BR'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BS'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BT'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BU'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BV'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BW'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BX'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BY'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('BZ'.$start_row, '');

		// 				$objPHPExcel->getActiveSheet()->setCellValue('CA'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CB'.$start_row, ( isset( $source ) && count( $source ) > 0 ? $source['source_title_th'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CC'.$start_row, ( $list['applicant_applied_status'] == 1 ? 'เคย' : 'ไม่เคย' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CD'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CE'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CF'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CG'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CH'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CI'.$start_row, ( $list['applicant_accident_status'] == 1 ? 'เคย' : 'ไม่เคย' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CJ'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CK'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CL'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CM'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CN'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CO'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CP'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CQ'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CR'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CS'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CT'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CU'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CV'.$start_row, $list['applicant_introduction']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CW'.$start_row, $list['applicant_education_highschool_name']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CX'.$start_row, ( $list['applicant_education_highschool_province_id'] > 0 ? $highschool_province['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CY'.$start_row, $list['applicant_education_highschool_year']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('CZ'.$start_row, $list['applicant_education_highschool_major']);

		// 				$objPHPExcel->getActiveSheet()->setCellValue('DA'.$start_row, $list['applicant_education_highschool_gpa']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DB'.$start_row, $list['applicant_education_vocational_name']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DC'.$start_row, ( $list['applicant_education_vocational_province_id'] > 0 ? $vocational_province['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DD'.$start_row, $list['applicant_education_vocational_year']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DE'.$start_row, $list['applicant_education_vocational_major']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DF'.$start_row, $list['applicant_education_vocational_gpa']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DG'.$start_row, $list['applicant_education_diploma_name']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DH'.$start_row, ( $list['applicant_education_diploma_province_id'] > 0 ? $diploma_province['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DI'.$start_row, $list['applicant_education_diploma_year']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DJ'.$start_row, $list['applicant_education_diploma_major']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DK'.$start_row, $list['applicant_education_diploma_gpa']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DL'.$start_row, $list['applicant_education_bachelor_name']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DM'.$start_row, ( $list['applicant_education_bachelor_province_id'] > 0 ? $bachelor_province['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DN'.$start_row, $list['applicant_education_bachelor_year']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DO'.$start_row, $list['applicant_education_bachelor_major']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DP'.$start_row, $list['applicant_education_bachelor_gpa']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DQ'.$start_row, $list['applicant_education_master_name']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DR'.$start_row, ( $list['applicant_education_master_province_id'] > 0 ? $master_province['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DS'.$start_row, $list['applicant_education_master_year']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DT'.$start_row, $list['applicant_education_master_major']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DU'.$start_row, $list['applicant_education_master_gpa']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DV'.$start_row, $list['applicant_education_other_name']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DW'.$start_row, ( $list['applicant_education_other_province_id'] > 0 ? $other_province['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DX'.$start_row, $list['applicant_education_other_year']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DY'.$start_row, $list['applicant_education_other_major']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('DZ'.$start_row, $list['applicant_education_other_gpa']);

		// 				$objPHPExcel->getActiveSheet()->setCellValue('EA'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EB'.$start_row, $list['applicant_studying_status'] == 1 ? 'ใช่' : 'ไม่ใช่');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EC'.$start_row, $list['applicant_skill_computer']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('ED'.$start_row, $list['applicant_skill_typing_thai']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EE'.$start_row, $list['applicant_skill_typing_english']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EF'.$start_row, $list['applicant_skill_office_tools']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EG'.$start_row, $list['applicant_skill_specials']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EH'.$start_row, $list['applicant_skill_activities']);
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EI'.$start_row, (( $list['applicant_skill_driving_status'] == 1 ) ? "รถยนต์ : ".( $list['applicant_skill_driving_status'] == 1 ? 'ได้' : 'ไม่ได้' )."\nหมายเลขใบขับขี่ : ".$list['applicant_skill_driving_license']."\n": "") . (( $list['applicant_skill_driving_status'] == 1 ) ? "รถจักรยานยนต์ : ".( $list['applicant_skill_riding_status'] == 1 ? 'ได้' : 'ไม่ได้' )."\nหมายเลขใบขับขี่ : ".$list['applicant_skill_riding_license']: "") );
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EJ'.$start_row, ( isset( $aLanguage[0] ) ? $aLanguage[0]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EK'.$start_row, ( isset( $aLanguage[0] ) ? $aLanguage[0]['listen'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EL'.$start_row, ( isset( $aLanguage[0] ) ? $aLanguage[0]['speaking'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EM'.$start_row, ( isset( $aLanguage[0] ) ? $aLanguage[0]['reading'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EN'.$start_row, ( isset( $aLanguage[0] ) ? $aLanguage[0]['writing'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EO'.$start_row, ( isset( $aLanguage[1] ) ? $aLanguage[1]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EP'.$start_row, ( isset( $aLanguage[1] ) ? $aLanguage[1]['listen'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EQ'.$start_row, ( isset( $aLanguage[1] ) ? $aLanguage[1]['speaking'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('ER'.$start_row, ( isset( $aLanguage[1] ) ? $aLanguage[1]['reading'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('ES'.$start_row, ( isset( $aLanguage[1] ) ? $aLanguage[1]['writing'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('ET'.$start_row, ( isset( $aLanguage[2] ) ? $aLanguage[2]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EU'.$start_row, ( isset( $aLanguage[2] ) ? $aLanguage[2]['listen'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EV'.$start_row, ( isset( $aLanguage[2] ) ? $aLanguage[2]['speaking'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EW'.$start_row, ( isset( $aLanguage[2] ) ? $aLanguage[2]['reading'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EX'.$start_row, ( isset( $aLanguage[2] ) ? $aLanguage[2]['writing'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EY'.$start_row, ( isset( $aLanguage[3] ) ? $aLanguage[3]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('EZ'.$start_row, ( isset( $aLanguage[3] ) ? $aLanguage[3]['listen'] : '' ));

		// 				$objPHPExcel->getActiveSheet()->setCellValue('FA'.$start_row, ( isset( $aLanguage[3] ) ? $aLanguage[3]['speaking'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FB'.$start_row, ( isset( $aLanguage[3] ) ? $aLanguage[3]['reading'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FC'.$start_row, ( isset( $aLanguage[3] ) ? $aLanguage[3]['writing'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FD'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FE'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['address'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FF'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['tel'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FG'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['start'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FH'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['end'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FI'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['superior'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FJ'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['position'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FK'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['responsibility'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FL'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['salary'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FM'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['cost_of_living'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FN'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['bonus'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FO'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['other'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FP'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['total'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FQ'.$start_row, ( isset( $aExperience[0] ) ? $aExperience[0]['reason'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FR'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FS'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['address'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FT'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['tel'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FU'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['start'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FV'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['end'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FW'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['superior'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FX'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['position'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FY'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['responsibility'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('FZ'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['salary'] : '' ));
							
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GA'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['cost_of_living'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GB'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['bonus'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GC'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['other'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GD'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['total'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GE'.$start_row, ( isset( $aExperience[1] ) ? $aExperience[1]['reason'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GF'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GG'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['address'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GH'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['tel'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GI'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['start'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GJ'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['end'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GK'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['superior'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GL'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['position'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GM'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['responsibility'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GN'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['salary'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GO'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['cost_of_living'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GP'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['bonus'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GQ'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['other'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GR'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['total'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GS'.$start_row, ( isset( $aExperience[2] ) ? $aExperience[2]['reason'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GT'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['name'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GU'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['address'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GV'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['tel'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GW'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['start'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GX'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['end'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GY'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['superior'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('GZ'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['position'] : '' ));

		// 				$objPHPExcel->getActiveSheet()->setCellValue('HA'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['responsibility'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HB'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['salary'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HC'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['cost_of_living'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HD'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['bonus'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HE'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['other'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HF'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['total'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HG'.$start_row, ( isset( $aExperience[3] ) ? $aExperience[3]['reason'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HH'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HI'.$start_row, date("d M Y H:i:s", strtotime( $list['applicant_createdtime'] )));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HJ'.$start_row, ( $list['location_id'] > 0 ? $location['location_title_th'] : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HK'.$start_row, ( $list['applicant_file_1'] != '' && is_file( realpath('public/core/uploaded/applicants/'.$list['applicant_file_1']) ) === true ? base_url('public/core/uploaded/applicants/'.$list['applicant_file_1']) : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HL'.$start_row, ( $list['applicant_file_2'] != '' && is_file( realpath('public/core/uploaded/applicants/'.$list['applicant_file_2']) ) === true ? base_url('public/core/uploaded/applicants/'.$list['applicant_file_2']) : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HM'.$start_row, ( $list['applicant_file_3'] != '' && is_file( realpath('public/core/uploaded/applicants/'.$list['applicant_file_3']) ) === true ? base_url('public/core/uploaded/applicants/'.$list['applicant_file_3']) : '' ));
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HN'.$start_row, '');
		// 				$objPHPExcel->getActiveSheet()->setCellValue('HO'.$start_row, '');
		// 				/* Embed data into cells - End */

		// 				$start_row++;
		// 			}

		// 			// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		// 			// ob_end_clean();
					
		// 			// $filename="exported_applicants_".date("dmYHis").".xlsx";
		// 			// header('Content-Type: application/vnd.ms-excel'); //mime type
		// 			// header('Content-Disposition: attachment; filename="'.$filename.'"'); //tell browser what's the file name
		// 			// header('Cache-Control: max-age=0'); //no cache

		// 			$filename="exported_applicants_".date("dmYHis").".xlsx";
		// 			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
					
		// 			header("Content-Type: application/vnd.ms-excel");
		// 			header('Content-Disposition: attachment;filename="'.$filename.'"');
		// 			header("Cache-Control: max-age=0");
		// 			ob_end_clean();
		// 			// $objPHPExcel->getActiveSheet()->calculateColumnWidths();
		// 			// sleep(2);
		// 			// ob_clean();
		// 			$objWriter->save("php://output");
		// 			exit();

		// 		}
		// 		/* Init Data - End */

		// 	/* Init PHPExcel - End */
		// }catch(Exception $e){
		// 	print_r( $e );
		// }
		$aSort = array(
			'sort_location_id' => ( $this->input->get('sort_location_id') ? $this->input->get('sort_location_id') : '' ),
			'sort_job_id' => ( $this->input->get('sort_job_id') ? $this->input->get('sort_job_id') : '' ),
			'sort_start_date' => ( $this->input->get('sort_start_date') ? $this->input->get('sort_start_date') : '' ),
			'sort_end_date' => ( $this->input->get('sort_end_date') ? $this->input->get('sort_end_date') : '' ),
			'sort_keywords' => ( $this->input->get('sort_keywords') ? $this->input->get('sort_keywords') : '' )
		);
		$this->_data['aSort'] = $aSort;
		$this->_data['lists'] = $this->applicantsreportmodel->get_applicants($aSort);
		$this->load->view('administrator/views/applicantsreport/export', $this->_data);
	}
	
	public function print( $applicantid=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('156d833ba9d1de77f886c1f22270848c');
		$this->admin_model->set_detail('รายละเอียดข้อมูล');
		
		$this->_data['info'] = $this->applicantsreportmodel->get_applicantinfo_byid( $applicantid );

		$this->applicantsreportmodel->stamp_printed( $applicantid );
		
		$this->load->view('administrator/views/applicantsreport/print', $this->_data);
		// $this->admin_library->output();
	}
	
	public function pdf( $applicantid=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('156d833ba9d1de77f886c1f22270848c');
		$this->admin_model->set_detail('รายละเอียดข้อมูล');
		
		$this->_data['info'] = $this->applicantsreportmodel->get_applicantinfo_byid( $applicantid );
		$this->load->model("pdfmodel/pdf_applicantsreport");
		$this->pdf_applicantsreport->makepdf($this->_data);
	}
	
	public function delete( $applicantid=0 ){
		$message = array();
		$message = $this->applicantsreportmodel->setStatus('discard', $applicantid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('applicantsreport/index');
	}

	public function setEdit( $setto='disabled', $applicantid=0 ){
		$message = array();
		$message = $this->applicantsreportmodel->setEdit( $setto, $applicantid );

		if( $setto == 'enabled' ){

			$this->sendEditRequestEmail( $message['payLoads']['applicant_id'] );

		}

		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('applicantsreport/index');
	}

	public function sendEditRequestEmail( $applicantid=0 ){

		if( $applicantid > 0 ){

			$info = $this->applicantsreportmodel->get_applicantinfo_byid( $applicantid );
			$address = $this->applicantsreportmodel->get_addresss( $info['applicant_id'], 'current');

			/* Email Setup - Start */
            $this->load->library('email');
            /* Email Setup - End */

			$this->email->subject( 'อีเมลแจ้งเตือนอนุญาตให้แก้ไขข้อมูลใบสมัครงานกับบริษัท นวกิจประกันภัย จำกัด (มหาชน)' );
			$this->email->from('system_navakij@navakij.co.th','no-reply');
            $this->email->to( $address[0]['address_email'] );

			$this->_data['info'] = $info;

			$mailbody = $this->load->view('administrator/views/applicantsreport/request_edit_email', $this->_data, TRUE);

            $this->email->message( $mailbody );
            $this->email->send();

		}

	}

	public function debugEmail( $applicantid=0 ){
		$info = $this->applicantsreportmodel->get_applicantinfo_byid( $applicantid );
		$address = $this->applicantsreportmodel->get_addresss( $info['applicant_id'], 'current');

		$this->_data['info'] = $info;

		$this->load->view('administrator/views/applicantsreport/request_edit_email', $this->_data);
	}

	public function profiles( $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('a337fef5bb391fdf501658fd56a2943e');
		$this->admin_model->set_detail('รายการฝากประวัติ');
		
		$this->_data['jobs'] = $this->applicantsreportmodel->get_jobs(0, 0, 1);
		$this->_data['provinces'] = $this->applicantsreportmodel->get_provinces();
		
		/* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('applicantsreport/profile_sorting', $this->_data);
		/* Set Custom Tools - End */
		
		$aSort = array(
			'sort_job_id' => ( $this->input->get('sort_job_id') ? $this->input->get('sort_job_id') : '' ),
			'sort_start_date' => ( $this->input->get('sort_start_date') ? $this->input->get('sort_start_date') : '' ),
			'sort_end_date' => ( $this->input->get('sort_end_date') ? $this->input->get('sort_end_date') : '' ),
			'sort_keywords' => ( $this->input->get('sort_keywords') ? $this->input->get('sort_keywords') : '' )
		);
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->applicantsreportmodel->get_profiles($aSort, $perpage, $offset));
		$totalrows = $this->applicantsreportmodel->count_profiles($aSort);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('profile_id','ลำดับ','5%','icon-list-ol');
		$this->admin_model->set_column('job_id','ตำแหน่งงาน','20%','icon-map-marker');
		$this->admin_model->set_column('profile_name','ชื่อ-นามสกุล','20%','icon-user');
		$this->admin_model->set_column('profile_mobile','ข้อมูลการติดต่อ','20%','icon-info');
		$this->admin_model->set_column('profile_createdtime','วันที่ฝาก','10%','icon-calendar-o');
		$this->admin_model->set_action_button('ดูข้อมูล','applicantsreport/profile_info/[profile_id]','icon-eye','btn-primary','r');
		$this->admin_model->set_action_button('ลบข้อมูล','applicantsreport/profile_delete/[profile_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('profile_id','show_seq');
		$this->admin_model->set_column_callback('job_id','show_job');
		$this->admin_model->set_column_callback('profile_mobile','show_profile_contact');
		$this->admin_model->set_column_callback('profile_createdtime','show_datetime');
		$this->admin_model->set_pagination("applicantsreport/profiles",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}

	public function profile_info( $profileid=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('a337fef5bb391fdf501658fd56a2943e');
		$this->admin_model->set_detail('ข้อมูลรายละเอียด');

		$this->_data['info'] = $this->applicantsreportmodel->get_profileinfo_byid( $profileid );
		$this->_data['positions'] = $this->applicantsreportmodel->get_jobs(0, 0, 1);

		$this->admin_library->view('applicantsreport/profile_info', $this->_data);
		$this->admin_library->output();
	}

	public function profile_delete( $profileid=0 ){
		$message = array();
		$message = $this->applicantsreportmodel->setProfileStatus('discard', $profileid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('applicantsreport/profiles');
	}

	public function profile_export( ){
		$aSort = array(
			'sort_job_id' => ( $this->input->get('sort_job_id') ? $this->input->get('sort_job_id') : '' ),
			'sort_start_date' => ( $this->input->get('sort_start_date') ? $this->input->get('sort_start_date') : '' ),
			'sort_end_date' => ( $this->input->get('sort_end_date') ? $this->input->get('sort_end_date') : '' ),
			'sort_keywords' => ( $this->input->get('sort_keywords') ? $this->input->get('sort_keywords') : '' )
		);
		$lists = $this->applicantsreportmodel->get_profiles($aSort);

		$this->_data['aSort'] = $aSort;
		$this->_data['lists'] = $lists;
		$this->load->view('administrator/views/applicantsreport/profile_export', $this->_data);
	}

	/* APIs - Start */
	public function api_get_jobs(){
        $locationId = htmlspecialchars( $this->input->post('location_id') );
        $options = $this->applicantsreportmodel->get_jobs( $locationId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['job_id'],
                    'name' => ( $this->_language == 'en' ? $option['job_title_en'] : $option['job_title_th'] )
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }

    public function api_get_districts(){
        $provinceId = htmlspecialchars( $this->input->post('province_id') );
        $options = $this->applicantsreportmodel->get_districts( $provinceId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['amphoe_id'],
                    'name' => ( $this->_language == 'en' ? $option['name_alt'] : $option['name'] )
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }

    public function api_get_subdistricts(){
        $districtId = htmlspecialchars( $this->input->post('district_id') );
        $options = $this->applicantsreportmodel->get_subdistricts( $districtId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['tambon_id'],
                    'name' => ( $this->_language == 'en' ? $option['name_alt'] : $option['name'] )
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }

    public function api_get_postcodes(){
        $subdistrictId = htmlspecialchars( $this->input->post('subdistrict_id') );
        $options = $this->applicantsreportmodel->get_zipcodes( $subdistrictId );

        $aOptions = array();
        if( isset( $options ) && count( $options ) > 0 ){
            foreach( $options as $option ){
                $data = array(
                    'id' => $option['postcode_id'],
                    'name' => $option['code']
                );
                array_push( $aOptions, $data );
            }

            $response = array(
                'status' => 200,
                'datas' => $aOptions
            );
        }else{
            $response = array(
                'status' => 404,
                'message' => 'Data not found'
            );
        }

        $this->json->set('response', $response);
        $this->json->send();
    }
	/* APIs - End */
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_status($text, $row){
		switch($text){
			case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
			case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
			default : return 'ไม่มีสถานะ';
		}
	}
	
	public function show_location( $text, $row ){
		$location = $this->applicantsreportmodel->get_locationinfo_byid( $text );
		$job = $this->applicantsreportmodel->get_jobinfo_byid( $row['job_id'] );
		
		$response = '';
		if( isset( $location ) && count( $location ) > 0 ){
			$response = '<p>'.$location['location_title_th'].'</p>';
		}
		if( isset( $job ) && count( $job ) > 0 ){
			$response = '<p>'.( $response != '' ? $response.' / '.$job['job_title_th'] : $job['job_title_th'] ).'</p>';
		}
		if( $row['applicant_salary'] != '' ){
			$response .= '<p>เงินเดือนที่คาดหวัง : '.$row['applicant_salary'].'</p>';
		}
		
		return $response;
	}
	
	public function show_name( $text, $row ){
		$addresses = $this->applicantsreportmodel->get_addresss( $row['applicant_id'], 'current');
		$address = $addresses[0];
		$response = '<p>ไทย : '.$row['applicant_fname_th'].' '.$row['applicant_lname_th'].'</p>';
		$response .= '<p>En : '.$row['applicant_fname_en'].' '.$row['applicant_lname_en'].'</p>';
		if( isset( $address ) && count( $address ) > 0 ){
			$response .= '<p>Tel : '.$address['address_mobile'].'</p>';
			$response .= '<p>Email : '.$address['address_email'].'</p>';
		} 
		return $response;
	}

	public function show_edit_status( $text, $row ){
		if( $text == 1 ){
			$response = '<p style="text-align:center; color:#43AD53;"><i class="icon-check-circle"></i></p>';
			$response .= '<p style="text-align:center;">[ <a href="'.admin_url('applicantsreport/setEdit/disabled/'.$row['applicant_id']).'"><i class="icon-times-circle"></i> ปิดการตั้งค่า</a> ]</p>';
			// else{
			// 	$response .= '<p style="text-align:center; color:#666;">ยังไม่มีการแก้ไข</p>';
			// }
			$response .= '<p style="text-align:center;"><a href="'.admin_url('applicantsreport/debugEmail/'.$row['applicant_id']).'" target="_blank">คลิกดูอีเมล</a></p>';
		}else{
			$response = '<p style="text-align:center; color:#666;"><i class="icon-times-circle"></i></p>';
			$response .= '<p style="text-align:center;">[ <a href="'.admin_url('applicantsreport/setEdit/enabled/'.$row['applicant_id']).'"><i class="icon-check-circle"></i> เปิดการตั้งค่า</a> ]</p>';
			if( $row['applicant_editedtime'] != null || $row['applicant_editedtime'] != '' ){
				$response .= '<p style="text-align:center; color:#43AD53;">มีการแก้ไขเมื่อ : '.thai_convert_shortdate( $row['applicant_editedtime'] ).'</p>';
			}
		}

		return $response;
	}
	
	public function show_icon_status( $text, $row ){
		if( $text == 1 ){
			$response = '<p style="text-align:center; color:#43AD53;"><i class="icon-check-circle"></i></p>';
		}else{
			$response = '<p style="text-align:center; color:#666;"><i class="icon-minus-circle"></i></p>';
		}
		return $response;
	}

	public function show_datetime( $text, $row ){
		return thai_convert_shortdate( $text );
	}

	public function show_job( $text, $row ){
		$job = $this->applicantsreportmodel->get_jobinfo_byid( $text );
		return $job['job_title_th'];
	}

	public function show_profile_contact( $text, $row ){
		$response = '<p>Tel : '.$row['profile_mobile'].'</p>';
		$response .= '<p>Email : '.$row['profile_email'].'</p>';

		return $response;
	}
	/* Default function -  End */

	private function languageSkill($lang){
		switch( $lang ){
		  case 'great' : $status = 'ดีมาก'; break;
		  case 'good' : $status = 'ดี'; break;
		  case 'moderate' : $status = 'พอใช้'; break;
		  default : $status = '';
		}
		return $status;
	}

}