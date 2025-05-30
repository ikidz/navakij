    <?php $navigations = $this->mainmodel->get_navigations(); ?>
    <?php $totalNav = count( $navigations ); ?>
    <?php /* #topbar - Start */ ?>
    <section id="topbar" class="position-absolute d-none d-lg-block">
        <div class="container d-flex">
            <div class="col-12 col-lg mt-1 d-flex flex-wrap justify-content-end align-items-center">
                <?php if( isset( $navigations ) && count( $navigations ) > 0 ): ?>
                    <?php foreach( $navigations as $key => $navigation ): ?>
                        <?php if( $key > 4 ): ?>
                            <?php
                                if( in_array( $navigation['content_type'], array('insurance','articles','documents') ) === true ){
                                    $content = array();
                                    $category = array();
                                    if( $navigation['content_type'] == 'insurance' ){
                                        $category = $this->mainmodel->get_insurance_categoryinfo_byid( $navigation['category_id'] );
                                        $content = $this->mainmodel->get_insuranceinfo_byid( $navigation['content_id'] );
                                    }else if( $navigation['content_type'] == 'articles' ){
                                        $category = $this->mainmodel->get_article_categoryinfo_byid( $navigation['category_id'] );
                                        $maincategory = $this->mainmodel->get_article_categoryinfo_byid( $category['main_id'] );
                                        $content = $this->mainmodel->get_articleinfo_byid( $navigation['content_id'] );
                                    }else if( $navigation['content_type'] == 'documents' ){
                                        $category = $this->mainmodel->get_document_categoryinfo_byid( $navigation['category_id'] );
                                        $content = $this->mainmodel->get_documentinfo_byid( $navigation['content_id'] );
                                    }

                                    if( isset( $content ) && count( $content ) > 0 ){
                                        $url = site_url($content['content_meta_url']);
                                    }else if( isset( $category ) && count( $category ) > 0 ){
                                        if( isset( $maincategory ) && count( $maincategory ) > 0 ){
                                            $url = site_url($maincategory['category_meta_url'].'/'.$category['category_meta_url']);
                                        }else{
                                            $url = site_url($category['category_meta_url']);
                                        }
                                    }else{
                                        $url = 'javascript:void(0);';
                                    }
                                }else if( $navigation['content_type'] == 'external_link' ){
                                    $url = $navigation['nav_external_url'];
                                }else if( $navigation['content_type'] == 'internal_link'){
                                    $url = site_url( $navigation['nav_internal_url'] );
                                }else{
                                    $url = 'javascript:void(0);';
                                }
                            ?>
                            <a href="<?php echo $url; ?>" <?php echo ( $navigation['is_newtab'] == 1 ? 'target="_blank" ' : '' ); ?>class="small btn-text navy px-1">
                                <?php echo $navigation['nav_title_'.$this->_language]; ?>
                            </a><?php echo ( intval( $totalNav - 1 ) != $key ? '|' : '' ); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <form id="searchForm" name="searchForm" method="get" enctype="multipart/form-data" action="<?php echo site_url('article-search'); ?>" class="form mx-3 mb-0">
                    <div class="control-group border border-1px border-navy border-radius px-3 py-1 my-0">
                        <i class="fas fa-search"></i>
                        <input type="text" name="keywords" id="keywords" value="<?php echo set_value('keywords'); ?>" placeholder="<?php echo ( $this->_language == 'th' ? 'คำค้นหา' : 'Keyword' ); ?>" class="noborder" />
                        <button type="submit" id="btn-submit" class="d-none">&nbsp;</button>
                    </div>
                </form>
                <div id="languages">
                    <p><a href="<?php echo site_url('language/change/th', false); ?>" class="btnLang lang-th btn-text uppercase small <?php echo ($this->_language=='th' ? 'navy' : 'grey'); ?>">TH</a> | <a href="<?php echo site_url('language/change/en', false); ?>" class="btnLang lang-en btn-text uppercase small <?php echo ($this->_language=='en' ? 'navy' : 'grey'); ?>">EN</a></p>
                </div>
            </div>
        </div>
    </section>
    <?php /* #topbar - End */ ?>
    
    <?php /* #navigation - Start */ ?>
    <nav id="navigation" class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand col-4 col-md-2" href="<?php echo site_url(''); ?>">
                <?php if( $this->_language == 'th' ): ?>
                    <img src="<?php echo assets_url('img/logo.png'); ?>" alt="" class="img-fullwidth" />
                <?php else: ?>
                    <img src="<?php echo assets_url('img/logo_en.png'); ?>" alt="" class="img-fullwidth" />
                <?php endif; ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <div id="nav-icon3" class="">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <label class="text uppercase blue small"></label>
                </div>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-lg-none">
                        <form id="searchForm" name="searchForm" method="get" enctype="multipart/form-data" action="<?php echo site_url('article-search'); ?>" class="form mx-3 mb-3">
                            <div class="control-group border border-1px border-navy border-radius px-3 py-1">
                                <i class="fas fa-search"></i>
                                <input type="text" name="keywords" id="keywords" value="<?php echo set_value('keywords'); ?>" placeholder="คำค้นหา" class="noborder" />
                                <button type="submit" id="btn-submit" class="d-none">&nbsp;</button>
                            </div>
                        </form>
                    </li>
                    <?php if( isset( $navigations ) && count( $navigations ) > 0 ): ?>
                        <?php foreach( $navigations as $key => $navigation ): ?>
                            <?php
                                if( in_array( $navigation['content_type'], array('insurance','articles','documents') ) === true ){
                                    $content = array();
                                    $category = array();
                                    if( $navigation['content_type'] == 'insurance' ){
                                        $category = $this->mainmodel->get_insurance_categoryinfo_byid( $navigation['category_id'] );
                                        $content = $this->mainmodel->get_insuranceinfo_byid( $navigation['content_id'] );
                                    }else if( $navigation['content_type'] == 'articles' ){
                                        $category = $this->mainmodel->get_article_categoryinfo_byid( $navigation['category_id'] );
                                        $content = $this->mainmodel->get_articleinfo_byid( $navigation['content_id'] );
                                    }else if( $navigation['content_type'] == 'documents' ){
                                        $category = $this->mainmodel->get_document_categoryinfo_byid( $navigation['category_id'] );
                                        $content = $this->mainmodel->get_documentinfo_byid( $navigation['content_id'] );
                                    }

                                    if( isset( $content ) && count( $content ) > 0 ){
                                        $url = site_url($content['content_meta_url']);
                                    }else if( isset( $category ) && count( $category ) > 0 ){
                                        $url = site_url($category['category_meta_url']);
                                    }else{
                                        $url = 'javascript:void(0);';
                                    }
                                }else if( $navigation['content_type'] == 'external_link' ){
                                    $url = $navigation['nav_external_url'];
                                }else if( $navigation['content_type'] == 'internal_link'){
                                    $url = site_url( $navigation['nav_internal_url'] );
                                }else{
                                    $url = 'javascript:void(0);';
                                }
                            ?>
                            <li class="nav-item <?php echo ( $key > 4 ? 'd-block d-lg-none' : '' ); ?>">
                                <a href="<?php echo $url; ?>" <?php echo ( $navigation['is_newtab'] == 1 ? 'target="_blank" ' : '' ); ?>class="nav-link btn-text">
                                    <?php echo $navigation['nav_title_'.$this->_language]; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php /* 
                    <li class="nav-item active">
                        <a class="nav-link btn-text navy" href="<?php echo site_url('products'); ?>">ประกันภัย</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-text navy" href="javascript:void(0);">บริการ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-text navy" href="<?php echo site_url('about-us'); ?>">เกี่ยวกับเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-text navy" href="<?php echo site_url('articles'); ?>">ข่าวสารและกิจกรรม</a>
                    </li>
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link btn-text navy" href="<?php echo site_url('sustainable'); ?>">การพัฒนาอย่างยั่งยืน</a>
                    </li>
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link btn-text navy" href="<?php echo site_url('investors'); ?>">นักลงทุนสัมพันธ์</a>
                    </li>
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link btn-text navy" href="<?php echo site_url('contact'); ?>">ติดต่อเรา</a>
                    </li>
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link btn-text navy" href="<?php echo site_url('articles'); ?>">ข่าวสารและกิจกรรม</a>
                    </li>
                    */ ?>
                    <li class="nav-item d-block d-lg-none">
                        <p class="text-right">
                            Language : 
                            <a href="<?php echo site_url('language/change/th', false); ?>" class="btnLang lang-th btn-text uppercase small <?php echo ($this->_language=='th' ? 'grey' : 'navy'); ?>">TH</a> | <a href="<?php echo site_url('language/change/en', false); ?>" class="btnLang lang-en btn-text uppercase small <?php echo ($this->_language=='en' ? 'grey' : 'navy'); ?>">EN</a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php /* #navigation - End */ ?>