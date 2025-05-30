<div id="sidebar-wrapper" class="col-12 col-md-3 px-0 px-md-3 mb-3">
    <?php $subnavigations = $this->mainmodel->get_navigations( 8 ); ?>
    <?php if( isset( $subnavigations ) && count( $subnavigations ) > 0 ): ?>
        <h4 class="navy border-bottom border-2px border-navy pb-3 d-flex flex-wrap align-items-center">
            นักลงทุนสัมพันธ์

            <button class="navbar-toggler ml-auto d-block d-lg-none" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-chevron-circle-up navy"></i>
                <i class="fas fa-chevron-circle-down navy"></i>
            </button>
        </h4>
        <nav class="navbar navbar-expand-lg navbar-light pt-3">

            <div class="collapse navbar-collapse" id="sidebar">
                <ul class="">
                    <?php foreach( $subnavigations as $navigation ): ?>

                        <?php
                            $active = '';
                            $color = 'black';
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
                                
                                if( $navigation['content_type'] == 'documents' ){
                                    if( isset( $content ) && count( $content ) > 0 ){
                                        $url = site_url($content['content_meta_url']);

                                        $active = ( $navigation['content_id'] == @$info['article_id'] ? 'active':'' );
                                        $color = ( $navigation['content_id'] == @$info['article_id'] ? 'navy':'black' );
                                    }else if( isset( $category ) && count( $category ) > 0 ){
                                        $url = site_url($category['category_meta_url']);

                                        $active = ( $navigation['category_id'] == @$info['category_id'] ? 'active':'' );
                                        $color = ( $navigation['category_id'] == @$info['category_id'] ? 'navy':'black' );
                                    }else{
                                        $url = 'javascript:void(0);';
                                    }
                                }else{
                                    if( isset( $content ) && count( $content ) > 0 ){
                                        $url = site_url($content['content_meta_url']);

                                        $active = ( $navigation['content_id'] == @$info['article_id'] ? 'active':'' );
                                        $color = ( $navigation['content_id'] == @$info['article_id'] ? 'navy':'black' );
                                    }else if( isset( $category ) && count( $category ) > 0 ){
                                        $url = site_url($category['category_meta_url']);

                                        $active = ( $navigation['category_id'] == @$info['category_id'] ? 'active':'' );
                                        $color = ( $navigation['category_id'] == @$info['category_id'] ? 'navy':'black' );
                                    }else{
                                        $url = 'javascript:void(0);';
                                    }
                                }

                            }else if( $navigation['content_type'] == 'external_link' ){
                                $url = $navigation['nav_external_url'];
                            }else if( $navigation['content_type'] == 'internal_link'){
                                $url = site_url( $navigation['nav_internal_url'] );
                                $currentURL = $this->uri->uri_string();

                                $active = ( $this->_language.'/'.$navigation['nav_internal_url'] == $currentURL ? 'active':'' );
                                $color = ( $this->_language.'/'.$navigation['nav_internal_url'] == $currentURL ? 'navy':'black' );
                            }else{
                                $url = 'javascript:void(0);';
                            }
                        ?>

                        <li class="<?php echo $active; ?>">
                            <a href="<?php echo $url; ?>" <?php echo ( $navigation['is_newtab'] == 1 ? 'target="_blank" ' : '' ); ?>class="btn-text <?php echo $color; ?> px-1">
                                <?php echo $navigation['nav_title_'.$this->_language]; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    <?php endif; ?>
</div>