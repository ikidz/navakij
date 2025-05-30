<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['^(en|th)$'] = $route['default_controller'];
$route['404_override'] = '';
$route['src/(:any)'] = "sourcefile/index/$1";
$route['admin'] = "administrator/admin_route";
$route['administrator'] = "administrator/index";

/* Change Language - Start */
$route['(:any)/language/change/(:any)'] = 'language/change/$2';
/* Change Language - End */

/* Static Page - Start */

    /* Home - Start */
    $route['(:any)/home'] = $route['default_controller'];
    /* Home - End */

    /* APIs - Start */
    $route['(:any)/api/acceptCookies'] = 'api/acceptCookies';
    $route['(:any)/jobs/api/jobs'] = 'jobs/api_get_jobs';
    $route['(:any)/jobs/api/districts'] = 'jobs/api_get_districts';
    $route['(:any)/jobs/api/subdistricts'] = 'jobs/api_get_subdistricts';
    $route['(:any)/jobs/api/zipcodes'] = 'jobs/api_get_postcodes';
    $route['(:any)/jobs/debug-email/(admin|applicant)/(:num)'] = 'jobs/debug/$2/$3';
    $route['(:any)/jobs/saveProfile'] = 'jobs/saveProfile';
    /* APIs - End */

    /* Products - Start */
    $route['(:any)/products'] = 'products/index';
    $route['(:any)/products/search/(:any)'] = 'products/search_product/$2';
    $route['(:any)/products/save/(:any)'] = 'products/save_contact/$2';
    $route['(:any)/products/line'] = 'products/line_landing';
    /* Products - End */

    /* Service - Start */
    $route['(:any)/nki-services'] = 'service/index';
    $route['(:any)/nki-services/payment'] = 'service/payment';
    $route['(:any)/nki-services/claim-service'] = 'service/claim';
    /* Service - End */

    /* About us - Start */
    $route['(:any)/about-us'] = 'aboutus/index';
    $route['(:any)/about-us/board-of-directors'] = 'aboutus/boardofdirectors';
    $route['(:any)/about-us/sub-committee'] = 'aboutus/directors/2';
    $route['(:any)/about-us/managers'] = 'aboutus/directors/3';
    $route['(:any)/about-us/getProfile/(:num)'] = 'aboutus/getProfile/$2';
    /* About us - End */

    /* News Update - Start */
    $route['(:any)/news-update'] = 'articles/index';
    /* News Update - End */

    /* Sustainability - Start */
    $route['(:any)/sustainability/csr-news'] = 'sustainable/change_link';
    /* Sustainability - End */

    /* Investor Relations - Start */
    //$route['(:any)/financial-highlights'] = 'investors/financial';
    $route['(:any)/investor-relations/marketing-news'] = 'investors/change_link/marketingnews';
    /* Investor Relations - End */

    /* Policy - Start */
    $route['(:any)/policy'] = 'articles/cookies_policy';
    /* Policy - End */

    /* Risk Management - Start */
    //$route['(:any)/risk-management'] = 'staticpage/risk_management';
    /* Risk Management - End */

    /* Funding - Start */
    $route['(:any)/funding'] = 'staticpage/funding_amount';
    /* Funding - End */

    /* Public Documents - Start */
    $route['(:any)/public-documents'] = 'staticpage/public_documents';
    /* Public Documents - End */

    /* Objectives - Start */
    $route['(:any)/objectives'] = 'staticpage/objectives';
    /* Objectives - End */

    /* Product Details - Start */
    $route['(:any)/product-details'] = 'staticpage/product_details';
    /* Product Details - End */

    /* Asset Liability Management - Start */
    $route['(:any)/asset-liability-management'] = 'staticpage/alm';
    /* Asset Liability Management - End */

    /* Unexpected Risk - Start */
    $route['(:any)/expected-risk'] = 'staticpage/expected_risk';
    /* Unexpected Risk - End */

    /* Estimation - Start */
    $route['(:any)/estimation'] = 'staticpage/estimation';
    /* Estimation - End */

    /* Investment - Start */
    //$route['(:any)/investment'] = 'staticpage/investment';
    /* Investment - End */

    /* Analysis - Start */
    $route['(:any)/analysis'] = 'staticpage/analysis';
    /* Analysis - End */

    /* Job Vacancy - Start */
    $route['(:any)/job-vacancy'] = 'jobs/index';
    $route['(:any)/job-info/test-job'] = 'jobs/info';
    $route['(:any)/job-applicant'] = 'jobs/applicant/0';
    $route['(:any)/job-applicant/(:num)'] = 'jobs/applicant/$2';
    $route['(:any)/job-edit-applicant/(:any)'] = 'jobs/edit_applicant/$2';
    /* Job Vacancy - End */

/* Static Page - End */

require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();

/* Product Categories - Start */
$product_categories = $db->where('insurance_category_status','approved')
                            ->order_by('insurance_category_order','asc')
                            ->get('insurance_categories')
                            ->result_array();
if( isset( $product_categories ) && count( $product_categories ) > 0 ){
    foreach( $product_categories as $category ){
        $route['(:any)/'.$category['insurance_category_meta_url']] = 'products/index/'.$category['insurance_category_id'];
    }
}
/* Product Categories - End */

/* Products - Start */
$products = $db->where('insurance_status','approved')
                ->order_by('insurance_id','asc')
                ->get('insurance')
                ->result_array();
if( isset( $products ) && count( $products ) > 0 ){
    foreach( $products as $product ){
        if( $product['insurance_meta_url'] == 'products/motor-insurance/ประกันภัยรถยนต์-2-นวกิจฯ-จัดให้' ){
            $route['page/5025'] = 'products/info/'.$product['insurance_id'];
        }
        $route['(:any)/'.$product['insurance_meta_url']] = 'products/info/'.$product['insurance_id'];
    }
}
/* Products - End */

/* Services - Start */
$services = $db->where('main_id', 1)
                ->order_by('category_order','asc')
                ->get('categories')
                ->result_array();
if( isset( $services ) && count( $services ) > 0 ){
    foreach( $services as $service ){
        $route['(:any)/nki-services/'.$service['category_meta_url']] = 'service/index/'.$service['category_meta_url'];

        /* Service Articles - Start */
        $service_articles = $db->where('category_id', $service['category_id'])
                        ->where('article_status','approved')
                        ->get('articles')
                        ->result_array();
        if( isset( $service_articles ) && count( $service_articles ) > 0 ){
            foreach( $service_articles as $article ){
                $route['(:any)/nki-services/'.$article['article_meta_url']] = 'service/info/'.$article['article_id'];
            }
        }
        /* Service Articles - End */

        /* Service Documents - Start */
        $document_category = $db->where('category_meta_url', $service['category_meta_url'])
                                ->where('main_id', 0)
                                ->where('category_status','approved')
                                ->limit(1)
                                ->get('document_categories')
                                ->row_array();
        if( isset( $document_category ) && count( $document_category ) > 0 ){
            $document_subcategories = $db->where('main_id', $document_category['category_id'])
                                ->where('category_status','approved')
                                ->get('document_categories')
                                ->result_array();
            if( isset( $document_subcategories ) && count( $document_subcategories ) > 0 ){
                foreach( $document_subcategories as $subcategory ){
                    $route['(:any)/nki-services/documents/'.$subcategory['category_meta_url']] = 'service/documents/'.$subcategory['category_id'];
                }
            }
        }
        /* Service Documents - End */
    }
}
/* Services - End */

/* About us - Start */
$aboutus_articles = $db->where('category_id', 6)
                ->where('article_status','approved')
                ->get('articles')
                ->result_array();
if( isset( $aboutus_articles ) && count( $aboutus_articles ) > 0 ){
    foreach( $aboutus_articles as $article ){
        if( $article['article_meta_url'] == 'about-us/company-history' ){
            $route['page/22'] = 'aboutus/info/'.$article['article_id'];
        }
        $route['(:any)/'.$article['article_meta_url']] = 'aboutus/info/'.$article['article_id'];
    }
}
$aboutus_documents = $db->where_in('main_id', array(26))
                                    ->where('category_status','approved')
                                    ->get('document_categories')
                                    ->result_array();
$maincategory = $db->where('category_id', 26)
                    ->where('category_status','approved')
                    ->get('document_categories')
                    ->row_array();
if( isset( $aboutus_documents ) && count( $aboutus_documents ) > 0 ){
    foreach( $aboutus_documents as $category ){
        $route['(:any)/'.$maincategory['category_meta_url'].'/'.$category['category_meta_url']] = 'aboutus/documents/'.$category['category_id'];
        $route['(:any)/'.$maincategory['category_meta_url'].'/'.$category['category_meta_url'].'/(:num)'] = 'aboutus/documents/'.$category['category_id'].'/$2';
    }
}

$route['(:any)/about-us/awards'] = 'aboutus/awards';
$route['(:any)/about-us/sell-agents'] = 'aboutus/sellagents';
/* About us - End */

/* News - Start */
$news_categories = $db->where_in('category_id', array(7,8,9))
                        ->where('category_status','approved')
                        ->get('categories')
                        ->result_array();
if( isset( $news_categories ) && count( $news_categories ) > 0 ){
    foreach( $news_categories as $category ){
        $route['(:any)/news-update/'.$category['category_meta_url']] = 'articles/index/'.$category['category_id'];
        $route['(:any)/news-update/'.$category['category_meta_url'].'/(:num)'] = 'articles/index/'.$category['category_id'].'/$2';
        $articles = $db->where('category_id', $category['category_id'])
                        ->where('article_status','approved')
                        ->get('articles')
                        ->result_array();
        if( isset( $articles ) && count( $articles ) > 0 ){
            foreach( $articles as $article ){
                $route['(:any)/news-update/'.$article['article_meta_url']] = 'articles/info/'.$article['article_id'];
            }
        }
    }
}
/* News - End */

/* Knowledges - Start */
$route['(:any)/knowledges'] = 'articles/knowledges';
$knowledge_categories = $db->where_in('main_id', array(26))
                            ->where('category_status','approved')
                            ->get('categories')
                            ->result_array();
if( isset( $knowledge_categories ) && count( $knowledge_categories ) > 0 ){
    foreach( $knowledge_categories as $category ){
        $route['(:any)/knowledges/'.$category['category_meta_url']] = 'articles/knowledges/'.$category['category_id'];
        $route['(:any)/knowledges/'.$category['category_meta_url'].'/(:num)'] = 'articles/knowledges/'.$category['category_id'].'/$2';
        $articles = $db->where('category_id', $category['category_id'])
                        ->where('article_status','approved')
                        ->get('articles')
                        ->result_array();
        if( isset( $articles ) && count( $articles ) > 0 ){
            foreach( $articles as $article ){
                $route['(:any)/knowledges/'.$article['article_meta_url']] = 'articles/knowledge_info/'.$article['article_id'];
            }
        }
    }
}
// print_r( $route );
// exit();
/* Knowledges - End */

/* Sustainability - Start */
$sustainability_document_categories = $db->where('main_id', 1)
                                ->where('category_status','approved')
                                ->get('document_categories')
                                ->result_array();
if( isset( $sustainability_document_categories ) && count( $sustainability_document_categories ) > 0 ){
    foreach( $sustainability_document_categories as $key => $category ){
        if( $key == 0 ){
            $route['(:any)/sustainability'] = 'sustainable/documents/'.$category['category_id'];
        }
        $route['(:any)/'.$category['category_meta_url']] = 'sustainable/documents/'.$category['category_id'];
    }
}
/* Sustainability - End */

/* Investors - Start */
$investors_article_categories = $db->where('main_id', 10)
                            ->where('category_status','approved')
                            ->get('categories')
                            ->result_array();

if( isset( $investors_article_categories ) && count( $investors_article_categories ) > 0 ){
    foreach( $investors_article_categories as $category ){
        $route['(:any)/'.$category['category_meta_url']] = 'investors/articles/'.$category['category_id'];
        $route['(:any)/'.$category['category_meta_url'].'/(:num)'] = 'investors/articles/'.$category['category_id'].'/$2';
        $articles = $db->where('category_id', $category['category_id'])
                        ->where('article_status','approved')
                        ->get('articles')
                        ->result_array();
        if( isset( $articles ) && count( $articles ) > 0 ){
            foreach( $articles as $article ){
                $route['(:any)/'.$article['article_meta_url']] = 'investors/info/'.$article['article_id'];
            }
        }
    }
}
$investors_document_categories = $db->where_in('main_id', array(5, 8, 12, 13))
                                    ->where('category_status','approved')
                                    ->get('document_categories')
                                    ->result_array();
if( isset( $investors_document_categories ) && count( $investors_document_categories ) > 0 ){
    foreach( $investors_document_categories as $category ){
        $route['(:any)/'.$category['category_meta_url']] = 'investors/documents/'.$category['category_id'];
        $route['(:any)/'.$category['category_meta_url'].'/(:num)'] = 'investors/documents/'.$category['category_id'].'/$2';
    }
}
/* Investors - End */

/* Principle of Economics and Governance - Start */
$eg_maincat = $db->where('category_id', 29)
                    ->where('main_id', 0)
                    ->where('category_status', 'approved')
                    ->get('document_categories')
                    ->row_array();
if( isset( $eg_maincat ) && count( $eg_maincat ) > 0 ){
    $route['(:any)/'.$eg_maincat['category_meta_url']] = 'economicsgovernance/landing';
    $eg_categories = $db->where('main_id', 29)
                        ->where('category_status','approved')
                        ->get('document_categories')
                        ->result_array();
    if( isset( $eg_categories ) && count( $eg_categories ) > 0 ){
        foreach( $eg_categories as $category ){
            $route['(:any)/'.$eg_maincat['category_meta_url'].'/'.$category['category_meta_url']] = 'economicsgovernance/documents/'.$category['category_id'];
            $route['(:any)/'.$eg_maincat['category_meta_url'].'/'.$category['category_meta_url'].'/(:num)'] = 'economicsgovernance/documents/'.$category['category_id'].'/$2';
        }
    }
}
/* Principle of Economics and Governance - End */

/* Claims - Start */
$route['partner'] = 'claim/index';
$route['(:any)/claim'] = 'claim/index';
$route['(:any)/claim/pdf'] = 'claim/pdflist';
$route['(:any)/claim/pdf/(:num)'] = 'claim/pdflist/$2';
$route['(:any)/claim/get_districts'] = 'claim/get_districts';
/* Claims - End */

/* Contacts - Start */
$route['page/99'] = 'contact/index';
$route['contactcenter'] = 'contact/index';
$route['(:any)/contact-us'] = 'contact/index';
/* Contacts - End */

/* Hidden View - Start */
$hidden_articles = $db->where('article_status','approved')
                        ->get('hidden_articles')
                        ->result_array();
if( isset( $hidden_articles ) && count( $hidden_articles ) > 0 ){
    foreach( $hidden_articles as $hidden_article ){
        $route['(:any)/'.$hidden_article['article_meta_url']] = 'articles/stview/'.$hidden_article['article_id'];
    }
}
$hidden_documents = $db->where('document_status','approved')
                        ->get('hidden_documents')
                        ->result_array();
if( isset( $hidden_documents ) && count( $hidden_documents ) > 0 ){
    foreach( $hidden_documents as $hidden_document ){
        $route['th/'.$hidden_document['document_meta_url']] = 'articles/stfile/'.$hidden_document['document_id'];
        $route['en/'.$hidden_document['document_meta_url']] = 'articles/stfile/'.$hidden_document['document_id'];
    }
}
/* Hidden View - End */

$route['(:any)/article-search'] = 'articles/search_article';
$route['(:any)/article-search'.'/(:num)'] = 'articles/search_article/$2';

/* Mapping Link - Start */
$baseURL = $this->config->item('base_url');
$mappingurls = $db->where('map_status','approved')
                    ->order_by('map_createdtime','desc')
                    ->get('mapping_urls')
                    ->result_array();
if( isset( $mappingurls ) && count( $mappingurls ) > 0 ){
    foreach( $mappingurls as $url ){
        //echo $baseURL;
        $origin = str_replace( $baseURL, '', $url['map_origin']);
        $route[ $origin ] = 'siteredirection/index/'.$url['map_id'];
    }
}
/* Mapping Link - End */

/* Responses - Start */
$responses = $db->where('response_status','approved')
                    ->order_by('response_createdtime','desc')
                    ->get('responses')
                    ->result_array();
if( isset( $responses ) && count( $responses ) > 0 ){
    foreach( $responses as $response ){
        $route['(:any)/response/(:num)'] = 'response/index/$2';
    }
}
/* Responses - End */

/* Job Vacancy - Start */
$jobs = $db->where('job_status','approved')
            ->order_by('job_order','asc')
            ->get('applicant_jobs')
            ->result_array();
if( isset( $jobs ) && count( $jobs ) > 0 ){
    foreach( $jobs as $job ){
        $route['(:any)/job-info/'.$job['job_meta_url']] = 'jobs/info/'.$job['job_id'];
    }
}
/* Job Vacancy - End */

// print_r( $route );
// exit();
/* End of file routes.php */
/* Location: ./application/config/routes.php */