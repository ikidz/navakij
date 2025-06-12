<div class="spacing"></div>
<section id="page-body" class="bg-white page-claim">
  <div class="container">
    <div class="row">
      <div id="breadcrumb" class="breadcrumb col-12 mb-3">
        <p><a href="<?php echo site_url(''); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Home' : 'หน้าหลัก' ); ?></a>
          <a href="<?php echo site_url('claim'); ?>" class="btn-text black">เครือข่ายบริการสินไหมฯ</a>
      </div>
      <div class="col-12 mb-3">
        <h4 class="navy"><i class="fas fa-project-diagram"></i> เครือข่ายบริการสินไหมฯ</h4>
      </div>
    </div>
    <form id="claimForm" name="claimForm" method="get" enctype="multipart/form-data"
      action="<?php echo site_url('claim');?>" class="row mt-0 mx-3 mb-3 pt-2 justify-content-center border-top form">
      <?php if($this->input->get('lat') != ""){ ?>
      <input type="hidden" name="lat" value="<?php echo $this->input->get('lat'); ?>">
      <?php } ?>
      <?php if($this->input->get('lng') != ""){ ?>
      <input type="hidden" name="lng" value="<?php echo $this->input->get('lng'); ?>">
      <?php } ?>
      <div class="col-12 col-lg-10">
        <div class="control-group mb-3">
          <i class="fas fa-search"></i>
          <input type="text" name="keywords" id="keywords" value="<?php echo $this->input->get('keywords'); ?>"
            placeholder="ชื่อสถานประกอบการ">
        </div>
        <?php //  print_r($this->input->post('category_id')); exit();?>
        <div class="row">
          <div class="col-12 col-md mb-3">
            <select name="category_id" id="category_id" class="w-100 h-100 navy">
              <option value="">ประเภทเครือข่าย</option>
              <?php foreach($category as $rs){?>
              <option value="<?php echo $rs['category_id'];?>"
                <?php if($rs['category_id'] == $this->input->get('category_id')) { echo "selected";} ?>>
                <?php echo $rs['category_title_'.$this->_language];?></option>
              <?php }?>
            </select>
          </div>
          <div class="col-12 col-md mb-3">
            <select name="province_id" id="province_id" class="w-100 h-100 navy">
              <option value="" <?php echo set_select('filter_2',''); ?>>จังหวัด</option>
              <?php foreach($province as $rs){?>
              <option value="<?php echo $rs['province_id'];?>"
                <?php if($rs['province_id'] == $this->input->get('province_id')) { echo "selected";} ?>>
                <?php echo ( $this->_language == 'th' ? $rs['name'] : $rs['name_alt'] );?></option>
              <?php }?>
            </select>
          </div>
          <div class="col-12 col-md mb-3">

            <select name="district_id" id="district_id" class="w-100 h-100 navy">
              <option value="" <?php echo set_select('district_id',''); ?>>อำเภอ/เขต</option>
              <?php $districts = $this->claim_model->get_districts( $this->input->get('province_id') ); ?>
              <?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
              <?php foreach( $districts as $district ){ ?>
              <option value="<?php echo $district['amphoe_id']; ?>"
                <?php if($district['amphoe_id'] == $this->input->get('district_id')) { echo "selected";} ?>>
                <?php echo ( $this->_language == 'th' ? $district['name'] : $district['name_alt'] ); ?></option>
              <?php } ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="col-12 col-md mb-3">
            <select name="brand" id="brand" class="w-100 h-100 navy">
              <option value="" <?php echo set_select('brand',''); ?>>ศูนย์บริการ</option>
          		<?php foreach($brand as $rs){?>
          			<option value="<?php echo $rs['brand_title'];?>"
            		<?php if($rs['brand_title'] == $this->input->get('brand')) { echo "selected";} ?>>
          			<?php echo $rs['brand_title'];?></option>
          		<?php }?>
          	</select>
        	</div>
        <div class="col-12 col-md mb-3">
          <button type="submit" name="btn-submit" class="btn btn-navy w-100">ค้นหา</button>
        </div>
      </div>
  </div>
  </form>
  <div class="row py-3">
    <div class="col-12 col-lg-10 px-0 px-md-3 mx-auto">
      <a href="<?php echo ('contact-us'); ?>" class="btn btn-navy w-100">สำนักงานใหญ่และสาขา</a>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-lg-10 px-0 px-md-3 mx-auto">

      <?php if( isset( $documents_subcatgories ) && count( $documents_subcatgories ) > 0 ): ?>
      <ul>
        <li class="list-group-item mx-0 ml-lg-3 py-4 px-3 border border-navy no-border-radius">
          <h5><a href="<?php echo site_url('claim/pdf'); ?>" class="btn-text navy d-flex align-items-center"><i
                class="fas fa-folder mr-3"></i>
              <?php echo ($this->_language == 'th' ? 'รายชื่อเครือข่ายบริการ' : 'NKI Partners' ); ?><i
                class="fas fa-chevron-circle-right ml-auto"></i></a></h5>
        </li>
        <?php foreach( $documents_subcatgories as $subcategory ): ?>
        <li class="list-group-item mx-0 ml-lg-3 py-4 px-3 border border-navy no-border-radius">
          <h5><a href="<?php echo site_url('nki-services/documents/'.$subcategory['category_meta_url']); ?>"
              class="btn-text navy d-flex align-items-center"><i class="fas fa-folder mr-3"></i>
              <?php echo $subcategory['category_title_'.$this->_language]; ?><i
                class="fas fa-chevron-circle-right ml-auto"></i></a></h5>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

    </div>
  </div>
  </div>
  <?php /*
  <div class="section-map">
    <div class="map-wrapper">
      <div class="map-iframe" id="map"></div>
    </div>
  </div>
  */ ?>

  <div class="container">
    <div id="branches-wrapper" class="row mt-5">
      <?php if(isset( $branch_list ) && count( $branch_list ) > 0 ){?>
			<div class="col-12 pb-3">
				<p class="text-center">ผลลัพธ์จำนวน <?php echo number_format($total_brances); ?> รายการ</p>
			</div>
      <div class="col-12 d-flex flex-wrap mb-3">
        <?php if( $this->_language == 'th' ): ?>
            <p class="col-12 small text-right navy mr-3">* หมายเหตุ : H = บัตร NKI HEALTH INSURANCE, P = บัตร NKI PA CARD</p>
            <p class="col-12 small text-right navy mr-3">** หมายเหตุ : I = ผู้ป่วยใน (IPD / In-Patient Department), O = ผู้ป่วยนอก (OPD / Out-Patient Department)</p>
        <?php else: ?>
            <p class="col-12 small text-right navy mr-3">* Note : H = NKI HEALTH INSURANCE CARD, P = NKI PA CARD</p>
            <p class="col-12 small text-right navy ml-3">** Note : I = Inpatient (IPD / In-Patient Department), O = Outpatient (OPD / Out-Patient Department)</p>
        <?php endif; ?>
      </div>
      <?php foreach($branch_list as $key=>$rs) { 
          $cate = $this->claim_model->get_category_branch_info($rs['category_id']);
          $brand = $this->claim_model->get_brand_title($rs['branch_id']);
          if($brand){

            // foreach($brand as $key=>$b_rs){
            //   if($key == 0){
            //     $brand_list = $b_rs['brand_title'];
            //   }else{
            //     $brand_list = $brand_list.", ".$b_rs['brand_title'];
            //   }
            // }
          }
          ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="item-claim noborder">
          <?php /*
              <div class="row-thumb">
                <?php if( $rs['branch_image'] != '' && is_file( realpath('public/core/uploaded/branches/'.$rs['branch_image']) ) === true ): ?>
          <img src="<?php echo base_url( 'public/core/uploaded/branches/'.$rs['branch_image'] ); ?>" />
          <?php else: ?>
          <img src="<?php echo base_url('public/core/img/default_image.jpg'); ?>" alt="" class="img-fullwidth" />
          <?php endif; ?>
          <img src="<?php echo base_url('public/core/img/default_image.jpg'); ?>" alt="" class="img-fullwidth" />
        </div>
        */ ?>
        <div class="row-detail bg-lightgrey">
          <h5 class="navy"><?php echo $rs['branch_title_'.$this->_language];?></h5>
          <div class="row">
            <div class="label">ประเภท</div>
            <div class="content text-break"><?php echo $cate['category_title_'.$this->_language];?></div>
          </div>
          <?php /*
                <div class="row">
                  <div class="label">ยี่ห้อรถ</div>
                  <div class="content text-break"><?php echo $brand_list;?>
        </div>
      </div>
      */ ?>
      <?php if( $rs['card'] != null && $rs['card'] != "-" ): ?>
        <div class="row">
          <div class="label">ประเภทบัตรที่เข้ารักษา</div>
          <div class="content text-break"><?php echo $rs['card'];?></div>
        </div>
      <?php endif; ?>
      <?php if( $rs['patient_department'] != null && $rs['patient_department'] != "-" ): ?>
        <div class="row">
          <div class="label">ประเภทการรักษา</div>
          <div class="content text-break"><?php echo $rs['patient_department'];?></div>
        </div>
      <?php endif; ?>
      <div class="row">
        <div class="label">โทรศัพท์</div>
        <div class="content text-break"><?php echo $rs['branch_tel'];?></div>
      </div>
      <div class="row">
        <div class="label">โทรสาร</div>
        <div class="content text-break"><?php echo $rs['branch_fax'];?></div>
      </div>
      <div class="row">
        <div class="label">อีเมล์</div>
        <div class="content text-break"><?php echo $rs['branch_email'];?></div>
      </div>
      <div class="row">
        <div class="label">เว็บไซต์</div>
        <div class="content text-break"><?php echo $rs['branch_website'];?></div>
      </div>
      <div class="row">
        <div class="label">สถานที่ตั้ง</div>
        <div class="content text-break"><?php echo $rs['branch_address'];?></div>
      </div>
      <?php if($this->input->get('lat') != "" && $this->input->get('lng') != ""){ ?>
      <div class="row">
        <div class="label">ระยะทาง</div>
        <div class="content text-break">ประมาณ <?php echo number_format($rs['distance'],2);?> กิโลเมตร</div>
      </div>
      <?php } ?>
      <?php if( $rs['branch_gmap_url'] != null ): ?>
				<?php if( $rs['branch_gmap_url'] != "-" ): ?>
      		<a href="<?php echo $rs['branch_gmap_url'];?>" class="btn" target="_blank">ขอรับเส้นทาง</a>
				<?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
  </div>
  <?php } ?>
  <?php } ?>
  </div>
  <div class="row m-0">
    <div class="col-12 mt-3 text-center">
      <?php if( $total_brances > $limit_branches ): ?>
      <div id="btnLoadMore" class="my-3 text-center">
        <input type="hidden" name="current_offset" value="0" />
        <?php /* Filtering - Start */ ?>
        <?php if( isset( $s_datas ) && count( $s_datas ) > 0 ): ?>
        <?php foreach( $s_datas as $key => $data ): ?>
        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $data; ?>" class="filters" />
        <?php endforeach; ?>
        <?php endif; ?>
        <?php /* Filtering - End */ ?>
        <a href="javascript:void(0);" id="btnLoadMore-branches" class="btn btn-navy"
          data-limit="<?php echo $limit_branches; ?>">เพิ่มเติม</a>
      </div>
      <?php endif; ?>
      <p class="my-3"><a href="<?php echo site_url(''); ?>" class="btn btn-lg btn-icon btn-navy-transparent"><i
            class="fas fa-chevron-left"></i> กลับ</a></p>
    </div>
  </div>
  </div>
</section>
<?php /*
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script>
let params = <?php echo $this->input->get() ? json_encode($this->input->get()) : json_encode([]); ?>;
function submitform()
{
if(document.claimForm.onsubmit &&
!document.claimForm.onsubmit())
{
return;
}
document.claimForm.submit();
}

var map;
var makerLocation = <?php echo json_encode($branch_list); ?>;

function initMap() {
let mapsparams = { lat: 13.72299, lng: 100.530332 };
if(params.lat || params.lng){
mapsparams.lat = parseFloat(params.lat);
mapsparams.lng = parseFloat(params.lng);
}
map = new google.maps.Map(document.getElementById("map"), {
zoom: 12,
center: mapsparams,
});
for(var x in makerLocation){
initMarker(makerLocation[x]);
}
}
function initMarker(row) {

if(parseFloat(row.branch_lat) == 0.000000){
return ;
}
if(parseFloat(row.branch_lng) == 0.000000){
return ;
}
console.log(row);
let contentString =
'<div id="content">' +
  '<div id="siteNotice">' +
    "</div>" +
  '<h1 id="firstHeading" class="firstHeading">'+row.branch_title_<?php echo $this->_language ?>+'</h1>' +
  '<div id="bodyContent">' +
    '<p>โทรศัพท์: <a href="tel:'+row.branch_tel+'">'+row.branch_tel+'</a> ' +
      '<p>ที่อยู่: '+row.branch_address+
        "</div>" +
  "</div>";
let infowindow = new google.maps.InfoWindow({
content: contentString,
});
let image = "<?php echo assets_url('img/marker.png'); ?>";
let marker = new google.maps.Marker({
position: { lat: parseFloat(row.branch_lat), lng: parseFloat(row.branch_lng) },
map,
icon: image,
title: row.branch_title_th,
});
marker.addListener("click", () => {
infowindow.open(map, marker); //กดแล้วเปิด POP UP
});
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAPS_KEY; ?>&callback=initMap&libraries=&v=weekly">
</script>

<script>
  function serialize(obj, prefix) {
    var str = [],
      p;
    for (p in obj) {
      if (obj.hasOwnProperty(p)) {
        var k = prefix ? prefix + "[" + p + "]" : p,
          v = obj[p];
        str.push((v !== null && typeof v === "object") ?
          serialize(v, k) :
          encodeURIComponent(k) + "=" + encodeURIComponent(v));
      }
    }
    return str.join("&");
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      console.log("Geolocation is not supported by this browser.");
    }
  }

  function showPosition(position) {
    console.log("Latitude: ", position)

    params['lat'] = position.coords.latitude;
    params['lng'] = position.coords.longitude;
    var str = serialize(params);
    console.log(params, str);
    window.location = "<?php echo site_url('claim'); ?>?" + str;
  }
  window.onload = function () {
    if (params.lat || params.lng || params.province_id) {
      return;
    }
    //getLocation();
  }
</script>
*/ ?>