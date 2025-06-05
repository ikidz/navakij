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
    <form id="claimForm" name="claimForm" method="post" enctype="multipart/form-data" action="" class="row mt-0 mx-3 mb-3 pt-2 justify-content-center border-top form">
      <div class="col-12 col-lg-10">
        <div class="control-group mb-3">
          <i class="fas fa-search"></i>
          <input type="text" name="keywords" id="keywords" value="" placeholder="ชื่อสถานประกอบการ">
        </div>
        <div class="row">
          <div class="col-12 col-md mb-3">
            <select name="filter_1" id="filter_1" class="w-100 h-100 navy">
              <option value="" <?php echo set_select('filter_1','', true); ?>>ประเภท</option>
            </select>
          </div>
          <div class="col-12 col-md mb-3">
            <select name="filter_2" id="filter_2" class="w-100 h-100 navy">
              <option value="" <?php echo set_select('filter_2','', true); ?>>จังหวัด</option>
            </select>
          </div>
          <div class="col-12 col-md mb-3">
            <select name="filter_3" id="filter_3" class="w-100 h-100 navy">
              <option value="" <?php echo set_select('filter_3','', true); ?>>อำเภอ/เขต</option>
            </select>
          </div>
          <div class="col-12 col-md mb-3">
            <select name="filter_4" id="filter_4" class="w-100 h-100 navy">
              <option value="" <?php echo set_select('filter_4','', true); ?>>ยี่ห้อรถ</option>
            </select>
          </div>
          <div class="col-12 col-md mb-3">
            <a href="#" class="btn btn-navy w-100">ค้นหา</a>
          </div>
        </div>
      </div>
    </form>
  </div>
 
  <div class="section-map">
    <div class="map-wrapper">
      <div class="map-iframe" id="map">
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62009.06503555816!2d100.52834880346352!3d13.744671375675447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29f32af4a2795%3A0x2ea6a8623d95571f!2z4Lia4Lij4Li04Lip4Lix4LiXIOC4meC4p-C4geC4tOC4iOC4m-C4o-C4sOC4geC4seC4meC4oOC4seC4oiDguIjguLPguIHguLHguJQgKOC4oeC4q-C4suC4iuC4mSk!5e0!3m2!1sth!2sth!4v1607341635696!5m2!1sth!2sth" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
      </div>
      <!-- <div class="map-pin"><img src="<?php echo assets_url('img/icon_map_pin.png'); ?>" /></div> -->
    </div>
  </div>

  <div class="container">
    <div class="row mt-5">
      <?php for($i=0; $i<6; $i++) { ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="item-claim noborder">
            <div class="row-thumb">
              <!-- <img src="<?php echo assets_url('img/mockup-claim.jpg'); ?>" /> -->
            </div>
            <div class="row-detail bg-lightgrey">
              <h5 class="navy">คลินิกโรงพยาบาลสมิติเวช ศรีราชา</h5>
              <div class="row">
                <div class="label">ประเภท</div>
                <div class="content">คลีนิค</div>
              </div>
              <div class="row">
                <div class="label">โทรศัพท์</div>
                <div class="content">038-8955437-8</div>
              </div>
              <div class="row">
                <div class="label">โทรสาร</div>
                <div class="content">038-955437</div>
              </div>
              <div class="row">
                <div class="label">อีเมล์</div>
                <div class="content">sshboowin@samitivej.co.th</div>
              </div>
              <div class="row">
                <div class="label">เว็บไซต์</div>
                <div class="content">www.samitivejsriracha.com</div>
              </div>
              <div class="row">
                <div class="label">สถานที่ตั้ง</div>
                <div class="content">เลขที่ 116/44 หมู่ที่ 3 ถนน331 
      ตำบลบ่อวิน อำเภอศรีราชา 
      จังหวัดชลบุรี 20230</div>
              </div>
              <a href="#" class="btn">ขอรับเส้นทาง</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>  
    <div class="row m-0">
      <div class="col-12 mt-3 text-center">
        <p class="my-3"><a href="<?php echo site_url(''); ?>" class="btn btn-lg btn-icon btn-navy-transparent"><i class="fas fa-chevron-left"></i> กลับ</a></p>
      </div>
    </div>
  </div>

</section>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script>
var map;
function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: { lat: 13.72299, lng: 100.530332 },
  });
  initMarker();
}
function initMarker() {
  let contentString =
    '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
    '<div id="bodyContent">' +
    "<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>";
    let infowindow = new google.maps.InfoWindow({
    content: contentString,
  });
  let image = "<?php echo assets_url('img/marker.png'); ?>";
  let marker = new google.maps.Marker({
    position: { lat: 13.72299, lng: 100.530332 },
    map,
    icon: image,
    title: "Uluru (Ayers Rock)",
  });
  marker.addListener("click", () => {
    infowindow.open(map, marker);
  });
}
</script>
<script
  src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item("GMAP_API_KEY"); ?>&callback=initMap&libraries=&v=weekly"
  
></script>