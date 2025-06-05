var $window = $(window);
$(document).ready(function() {

    /* Reveal Animation On Scroll - Start */
	$window.on('scroll', revealOnScroll);
	
	revealOnScroll();
	/* Reveal Animation On Scroll - End */

    /* #navigation on scrolling handler - Start */
    var header = $("#navigation");
    if( $(window).scrollTop() >= 10 ){
        header.addClass("stick");
    }else{
        header.removeClass("stick");
    }
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 10) {
            header.addClass("stick");
        } else {
            header.removeClass("stick");
        }
    });
    /* #navigation on scrolling handler - End */

    /* .select2 - Start */
    $('.select2').select2();
    /* .select2 - End */

    /* .slick - Start */
    $('.slick-slider').slick();
	/* .slick - End */
	
	/* .content-box handler - Start */
	$('.content-box').find('img').each(function(){
		$(this).removeAttr('style').removeAttr('width').removeAttr('height').addClass('img-fullwidth');
	});
	$('.content-box').find('table').each(function(){
        var tableHTML = $(this).html();
        var noborderStatus = $(this).hasClass('noborder');
        var noborderClass = '';
        if( noborderStatus === true ){
            noborderClass = 'noborder';
        }
		$(this).replaceWith('<div class="table-responsive"><table class="'+noborderClass+'" border="1">'+tableHTML+'</table></div>');
	});
	/* .content-box handler - End */

    /* Adjust iframe tag - Start */
    var iframe;
    for( iframe = 0; iframe <= $('.content-box').find('iframe').length; iframe++ ){
        $('.content-box iframe')
        .removeAttr('width')
        .removeAttr('height');

        var iframeUrl = $('.content-box').find('iframe').eq(iframe).attr('src');
        $('.content-box').find('iframe').eq(iframe).parents('p').replaceWith('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'+iframeUrl+'"></iframe></div>');

        console.log( $('.content-box').find('iframe').eq(iframe).attr('src') );
    }
    /* Adjust iframe tag - End */

	/* select[name="province_id"] handler - Start */
    $('body').on('change','select[name="province_id"]', function(){
		var provinceId = $(this).val();
        $.post(base_url+language+'/claim/get_districts', { 'province_id' : provinceId }, function(response){
            $('select[name="district_id"]').html( response );
        });
    });
    /* select[name="province_id"] handler - End */

    /* #subscribeForm handler - Start */
    $('body').on('submit','#subscribeForm', function(e){
        e.preventDefault();
        var email = $(this).find('input[name="subscribe_email"]');
        if( email.val() == '' ){
            swalMessage('message-warning','คำเตือน!','กรุณาระบุอีเมลของท่านค่ะ');
        }else{
            $.ajax({
                method: "POST",
                url : base_url+'/api/save_subscribe',
                data : { email : email.val() }
            }).done( function( response ){
                var res = response.data.response;
                console.log( response );
                if( res.status == 200 ){
                    swalMessage('message-success','สำเร็จ!','ขอบคุณที่ลงทะเบียนรับข่าวสารจากเรา');
                }else{
                    swalMessage('message-error','เกิดข้อผิดพลาด!',res.text);
                }
            })
        }
    });
    /* #subscribeForm handler - End */

    /* Masonry - Start */
	var $grid = $('.grid').imagesLoaded( function(){
		$('.grid-item > a > img').lazyload({
			effect: 'fadeIn',
			load: function(){
				$(this).removeClass('not-loaded');
				$grid.isotope({
					itemSelector: '.grid-item',
					layoutMode : 'masonry',
				});
			}
		});
	});
	/* Masonry - End */

    /* FancyBox - Start */
	$('[data-fancybox], .fancybox').fancybox({
		protect			: true,
		thumbs          : false,
		hash            : false,
		loop            : true,
		keyboard        : true,
		toolbar         : true,
		buttons			: [
			'close'
		],
		animationEffect : 'fade',
		arrows          : true,
		clickContent    : false
	});
	/* FancyBox - End */

    $('html').on('click','#btnLoadMore-gallery', function(){

        $('#loading').fadeIn('fast');

        var limit = $(this).attr('data-limit');
        var offset = $(this).parents('#btnLoadMore').find('input[name="current_offset"]').val();
        var article_id = $(this).parents('#btnLoadMore').find('input[name="article_id"]').val();
        $.post( base_url+'/api/load_gallery', { articleId : article_id, limit : limit, offset : offset, language : language }, function(response){
            var res = response.data.response;
            if( res.status == 200 ){

                $('#loading').fadeOut('fast');
                
                $('#gallery-wrapper').append( res.items );
                $('input[name="current_offset"]').val( res.offset );

                $grid.imagesLoaded(function(){
					$('.grid-item > a > img.not-loaded').lazyload({
						effect: 'fadeIn',
						load: function(){
							$(this).removeClass('not-loaded');
						}
					});
				});

                /* FancyBox - Start */
				$('[data-fancybox]').fancybox({
					protect			: true,
					thumbs          : false,
					hash            : false,
					loop            : true,
					keyboard        : true,
					toolbar         : true,
					buttons			: [
						'close'
					],
					animationEffect : 'fade',
					arrows          : true,
					clickContent    : false
				});
				/* FancyBox - End */

            }
        });

    });

    $('html').on('click','#btnLoadMore-branches', function(){

        var filters = {};
        $(this).parents('#btnLoadMore').find('input.filters').each(function(){
            filters[this.name] = $(this).val();
        });

        $('#loading').fadeIn('fast');

        var limit = $(this).attr('data-limit');
        var offset = $(this).parents('#btnLoadMore').find('input[name="current_offset"]').val();

        var data = {
            limit : limit,
            offset : offset,
            language : language,
            filters
        };

				console.log( data );

        $.post( base_url+'/api/load_branches', data, function(response){
            var res = response.data.response;
            console.log('response', res );
            if( res.status == 200 && res.items != '' ){

                $('#loading').fadeOut('fast');
                
                $('#branches-wrapper').append( res.items );
                $('#btnLoadMore').find('input[name="current_offset"]').val( res.offset );

            }else{
							$('#loading').fadeOut('fast');
							$('#btnLoadMore').hide();
						}
        });

    });

    /* .btnMessageModal handler - Start */
    $('body').on('click','.btnMessageModal', function(){
        var employeeId = $(this).attr('data-employeeId');
        $('#messageModal').modal('show');
    });
    /* .btnMessageModal handler - End */

    /* Job Applicant Page - Start */

        /* .date-picker handler - Start */
        $('.date-picker').datepicker({
			autoHide: true,
			format : "dd-mm-yyyy"
		}).on('changeDate', function( e ){
            (e.viewMode == 'days' ? $(this).datepicker('hide') : '' );
        });
        /* .date-picker handler - End */

        /* .btnStep - Start */
        $('body').on('click', '.btnStep', function(){
            var step = $(this).attr('data-targetStep');
            var currentStep = $(this).parents('#steps').find('.list-inline-item.active a.btnStep').attr('data-targetStep');
            var status = true;
            var reason = 'required';

            /* Validation - Start */
            $('#applicantForm').find('.step-item.step-'+currentStep+' input.required').each(function(i){
                if( $(this).attr('type') == 'checkbox' ){
                    if( $(this).prop('checked') === false ){
                        $(this).addClass('error');
                        if( i == 0 ){
                            $(this).focus();
                        }
                        status = false;
                    }
                }else{
                    if( $(this).val() == '' ){
                        $(this).addClass('error');
                        console.log('Required at ', i);
                        if( i == 0 ){
                            $(this).focus();
                        }
                        status = false;
                    }
                }
            });
            $('#applicantForm').find('.step-item.step-'+currentStep+' input.validate_email').each(function(i){
                if( $(this).val() != '' && checkEmail( $(this).val() ) == 0 && status === true ){
                    $(this).addClass('error');
                    if( i == 0 ){
                        $(this).focus();
                    }
                    status = false;
                    reason = 'email';
                }
            });
            $('#applicantForm').find('.step-item.step-'+currentStep+' input.validate_mobile').each(function(){
                if( $(this).val() != '' && mobile_only( $(this).val() ) == 0 && status === true ){
                    $(this).addClass('error');
                    if( i == 0 ){
                        $(this).focus();
                    }
                    status = false;
                    reason = 'mobile';
                }
            });
            /* Validation - End */

            if( status === true ){
                $('#steps').find('.list-inline-item').removeClass('active');
                $(this).parents('.list-inline-item').addClass('active');
                
                $('.step-item').removeClass('active');
                $('.step-item.step-'+step).addClass('active');
            }else{
                if( reason == 'required' ){
                    swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Required field must not leave empty' : 'กรุณากรอกข้อมูลให้ครบถ้วน' ) );
                }else if( reason == 'email' ){
                    swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Invalid email format' : 'อีเมลมีรูปแบบไม่ถูกต้อง' ) );
                }else if( reason == 'mobile' ){
                    swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Invalid mobile number format' : 'เบอร์โทรศัพท์มือถือมีรูปแบบไม่ถูกต้อง' ) );
                }
            }

        });
        /* .btnStep - End */

        /* .btnNextStep - Start */
        $('body').on('click', '.btnNextStep', function(){
            var step = $(this).attr('data-targetStep');
            var status = true;
            var reason = 'required';

            /* Validation - Start */
            $(this).parents('.step-item').find('input.required').each(function(i){
                if( $(this).attr('type') == 'checkbox' ){
                    if( $(this).prop('checked') === false ){
                        $(this).addClass('error');
                        if( i == 0 ){
                            $(this).focus();
                        }
                        status = false;
                    }
                }else{
                    if( $(this).val() == '' ){
                        $(this).addClass('error');
                        console.log('Required at ', i);
                        if( i == 0 ){
                            $(this).focus();
                        }
                        status = false;
                    }
                }
            });
            $(this).parents('.step-item').find('input.validate_email').each(function(i){
                if( $(this).val() != '' && checkEmail( $(this).val() ) == 0 && status === true ){
                    $(this).addClass('error');
                    if( i == 0 ){
                        $(this).focus();
                    }
                    status = false;
                    reason = 'email';
                }
            });
            $(this).parents('.step-item').find('input.validate_mobile').each(function(){
                if( $(this).val() != '' && mobile_only( $(this).val() ) == 0 && status === true ){
                    $(this).addClass('error');
                    if( i == 0 ){
                        $(this).focus();
                    }
                    status = false;
                    reason = 'mobile';
                }
            });
            /* Validation - End */

            if( status === true ){
                $('#steps').find('.list-inline-item').removeClass('active');
                $('#steps').find('a[data-targetStep="'+step+'"]').parents('.list-inline-item').addClass('active');

                $('.step-item').removeClass('active');
                $('.step-item.step-'+step).addClass('active');

                /* Scroll Screen to top - Start */
                $('html, body').animate({
                    scrollTop:0
                }, 500);
                /* Scroll Screen to top - End */
            }else{
                if( reason == 'required' ){
                    swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Required field must not leave empty' : 'กรุณากรอกข้อมูลให้ครบถ้วน' ) );
                }else if( reason == 'email' ){
                    swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Invalid email format' : 'อีเมลมีรูปแบบไม่ถูกต้อง' ) );
                }else if( reason == 'mobile' ){
                    swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Invalid mobile number format' : 'เบอร์โทรศัพท์มือถือมีรูปแบบไม่ถูกต้อง' ) );
                }
            }
        });
        /* .btnNextStep - End */

        /* .btnBackStep, .btnNextStep - Start */
        $('body').on('click', '.btnBackStep', function(){
            var step = $(this).attr('data-targetStep');
            $('#steps').find('.list-inline-item').removeClass('active');
            $('#steps').find('a[data-targetStep="'+step+'"]').parents('.list-inline-item').addClass('active');

            $('.step-item').removeClass('active');
            $('.step-item.step-'+step).addClass('active');
        });
        /* .btnBackStep, .btnNextStep - End */

        /* #location_id handler - Start */
        $('body').on('change', '#location_id', function(){
            if( $(this).val() != '' ){
                var datas = {
                    'location_id' : $(this).val()
                };
                $.ajax({
                    type : 'POST',
                    url : base_url+'/'+language+'/jobs/api/jobs',
                    data : datas
                }).done( function( response ){
                    var res = response.data.response;
                    if( res.status == 200 ){
                        options = $.map(res.datas, function(item){
                            return '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        $('#job_id').find('option')
                            .remove()
                            .end()
                            .append( '<option value="">-- '+( language == 'en' ? 'Choose, position' : 'เลือกตำแหน่ง' )+' --</option>')
                            .append( options );
                        $('#job_id').select2();
                    }
                });
            }
        });
        /* #location_id handler - End */

        /* #prefix_id handler - Start */
        $('body').on('change', '#prefix_id', function(){
            if( $(this).val() == 999 ){
                $('#prefix_other_box').removeClass('d-none');
            }else{
                $('#prefix_other_box').addClass('d-none');
            }
        });
        /* #prefix_id handler - End */

        /* #applicant_current_province_id handler - Start */
        $('body').on('change', '#applicant_current_province_id', function(){
            if( $(this).val() != '' ){
                var datas = {
                    'province_id' : $(this).val()
                };
                $.ajax({
                    type : 'POST',
                    url : base_url+'/'+language+'/jobs/api/districts',
                    data : datas
                }).done( function( response ){
                    var res = response.data.response;
                    if( res.status == 200 ){
                        options = $.map(res.datas, function(item){
                            return '<option value="'+item.id+'">'+item.name+'</option>';
                        })
                        $('#applicant_current_district_id').find('option')
                            .remove()
                            .end()
                            .append( ( language == 'en' ? '<option value="">-- Choose, district --</option>' : '<option value="">-- เลือกเขต/อำเภอ --</option>' ) )
                            .append( options );
                        $('#applicant_current_district_id').select2();
                    }
                });
            }
        });
        /* #applicant_current_province_id handler - End */

        /* #applicant_current_district_id handler - Start */
        $('body').on('change','#applicant_current_district_id', function(){
            if( $(this).val() != '' ){
                var datas = {
                    'district_id' : $(this).val()
                };
                $.ajax({
                    type : 'POST',
                    url : base_url+'/'+language+'/jobs/api/subdistricts',
                    data : datas
                }).done( function( response ){
                    var res = response.data.response;
                    if( res.status == 200 ){
                        options = $.map(res.datas, function( item ){
                            return '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        $('#applicant_current_subdistrict_id').find('option')
                            .remove()
                            .end()
                            .append( ( language == 'en' ? '<option value="">-- Choose, sub district --</option>' : '<option value="">-- เลือกแขวง/ตำบล --</option>' ) )
                            .append( options );
                        $('#applicant_current_subdistrict_id').select2();
                    }
                })
            }
        });
        /* #applicant_current_district_id handler - End */

        /* #applicant_current_subdistrict_id handler - Start */
        $('body').on('change','#applicant_current_subdistrict_id', function(){
            if( $(this).val() != '' ){
                var datas = {
                    'subdistrict_id' : $(this).val()
                };
                $.ajax({
                    type : 'POST',
                    url : base_url+'/'+language+'/jobs/api/zipcodes',
                    data : datas
                }).done( function( response ){
                    var res = response.data.response;
                    if( res.status == 200 ){
                        options = $.map(res.datas, function( item ){
                            return '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        $('#applicant_current_postcode_id').find('option')
                            .remove()
                            .end()
                            .append( options );
                        $('#applicant_current_postcode_id').select2();
                    }
                })
            }
        })
        /* #applicant_current_subdistrict_id handler - End */

        /* #applicant_register_same_address handler - Start */
        $('body').on('change', '#applicant_register_same_address', function(){
            if( $(this).prop('checked') === true ){
                $('#different_address').slideUp('fast');
            }else{
                $('#different_address').slideDown('fast');
            }
        });
        /* #applicant_register_same_address handler - End */

        /* #applicant_register_province_id handler - Start */
        $('body').on('change', '#applicant_register_province_id', function(){
            if( $(this).val() != '' ){
                var datas = {
                    'province_id' : $(this).val()
                };
                $.ajax({
                    type : 'POST',
                    url : base_url+'/'+language+'/jobs/api/districts',
                    data : datas
                }).done( function( response ){
                    var res = response.data.response;
                    if( res.status == 200 ){
                        options = $.map(res.datas, function(item){
                            return '<option value="'+item.id+'">'+item.name+'</option>';
                        })
                        $('#applicant_register_district_id').find('option')
                            .remove()
                            .end()
                            .append( ( language == 'en' ? '<option value="">-- Choose, district --</option>' : '<option value="">-- เลือกเขต/อำเภอ --</option>' ) )
                            .append( options );
                        $('#applicant_register_district_id').select2();
                    }
                });
            }
        });
        /* #applicant_register_province_id handler - End */

        /* #applicant_register_district_id handler - Start */
        $('body').on('change','#applicant_register_district_id', function(){
            if( $(this).val() != '' ){
                var datas = {
                    'district_id' : $(this).val()
                };
                $.ajax({
                    type : 'POST',
                    url : base_url+'/'+language+'/jobs/api/subdistricts',
                    data : datas
                }).done( function( response ){
                    var res = response.data.response;
                    if( res.status == 200 ){
                        options = $.map(res.datas, function( item ){
                            return '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        $('#applicant_register_subdistrict_id').find('option')
                            .remove()
                            .end()
                            .append( ( language == 'en' ? '<option value="">-- Choose, sub district --</option>' : '<option value="">-- เลือกแขวง/ตำบล --</option>' ) )
                            .append( options );
                        $('#applicant_register_subdistrict_id').select2();
                    }
                })
            }
        });
        /* #applicant_register_district_id handler - End */

        /* #applicant_register_subdistrict_id handler - Start */
        $('body').on('change','#applicant_register_subdistrict_id', function(){
            if( $(this).val() != '' ){
                var datas = {
                    'subdistrict_id' : $(this).val()
                };
                $.ajax({
                    type : 'POST',
                    url : base_url+'/'+language+'/jobs/api/zipcodes',
                    data : datas
                }).done( function( response ){
                    var res = response.data.response;
                    if( res.status == 200 ){
                        options = $.map(res.datas, function( item ){
                            return '<option value="'+item.id+'">'+item.name+'</option>';
                        });
                        $('#applicant_register_postcode_id').find('option')
                            .remove()
                            .end()
                            .append( options );
                        $('#applicant_register_postcode_id').select2();
                    }
                })
            }
        })
        /* #applicant_register_subdistrict_id handler - End */

        /* .btnClone handler - Start */
        $('body').on('click','.btnClone', function(){
            var target = $(this).attr('data-target');
            var parents = $(this).attr('data-parents');

            var innerHTML = $(parents).find( target+':last-child').html();
            var fullHTML = '<div class="language-skill-item control-group pb-3 position-relative"><a href="javascript:void(0);" class="btnRemove btn-text red" data-target=".language-skill-item"><i class="fas fa-times-circle"></i></a>'+innerHTML+'</div>';
            $(parents).append( fullHTML );

        });
        /* .btnClone handler - End */

        /* .btnRemove handler - Start */
        $('body').on('click','.btnRemove', function(){
            var target = $(this).attr('data-target');
            $(this).parents( target ).remove();
        });
        /* .btnRemove handler - End */

        /* .btnExpClone handler - Start */
        $('body').on('click','.btnExpClone', function(){
            var target = $(this).attr('data-target');
            var parents = $(this).attr('data-parents');

            var total = $(parents).find('.experience-item').length;
            var newItemNo = parseInt( total ) + 1;
            var innerHTML = $(parents).find( target+':last-child .collapse').html();
            var fullHTML = '<div class="experience-item px-3 my-3 position-relative">'+
                                '<a href="javascript:void(0);" class="btnExpRemove ml-auto white" data-target=".experience-item"><i class="fas fa-times-circle"></i></a>'+
                                '<a href="#experience-item-'+newItemNo+'" data-toggle="collapse" role="button" aria-expended="false" aria-controls="experience-'+newItemNo+'" class="btn btn-navy w-100" aria-expanded="true">'+
                                    'บริษัท <span class="number">3</span>'+
                                '</a>'+
                                '<div class="collapse" id="experience-item-'+newItemNo+'" data-parent="#experiences">'+
                                    innerHTML+
                                '</div>'+
                            '</div>';
            $(parents).append( fullHTML );

            $(parents).find( target+':last-child a[data-toggle="collapse"]').trigger('click');

            /* Replace number - Start */
            $(parents).find('.experience-item span.number').each(function(i){
                $(this).html( i+1 );
            })
            /* Replace number - End */
        });
        /* .btnExpClone handler - End */

        /* .btnExpRemove handler - Start */
        $('body').on('click','.btnExpRemove', function(){
            var target = $(this).attr('data-target');
            $(this).parents( target ).remove();

            /* Replace number - Start */
            $('#experiences').find('.experience-item span.number').each(function(i){
                $(this).html( i+1 );
            })
            /* Replace number - End */

            // $('#experiences').find( target+':last-child a[data-toggle="collapse"]').trigger('click');
        });
        /* .btnExpRemove handler - End */

        /* #btn-submit handler - Start */
        $('body').on('submit', '#applicantForm', function(e){
            
            e.preventDefault();

            $('#loading').fadeIn('fast');
            $('#btn-submit').prop('disabled',true);

            var notValidate = 0;
            var index = 0;
            var invalidMobileFormat = 0;
            var invalidMobileIndex = 0;
            var invalidEmailFormat = 0;
            var invalidEmailIndex = 0;

            /* Validate : required - Start */
            if( $('#applicantForm').find('input.required').length > 0 ){
                $('#applicantForm').find('input.required').each(function(i){
                    
                    if( $(this).attr('type') == 'checkbox' ){
                        if( $(this).prop('checked') === false ){
                            notValidate++;
                            $(this).addClass('error');
                        }
                    }else{
                        if( $(this).val() == '' ){
                            notValidate++;
                            $(this).addClass('error');
                        }
                    }

                    if( notValidate == 1 ){
                        index = i;
                    }

                });
            }
            /* Validate : required - End */

            /* Validate : mobile - Start */
            if( $('#applicantForm').find('input.validate_mobile').length > 0 ){
                $('#applicantForm').find('input.validate_mobile').each(function(i){
                    if( $(this).val() != '' ){
                        var validated_status = mobile_only( $(this).val() );
                        if( validated_status == 0 ){
                            invalidMobileFormat++;
                            $(this).addClass('error');
                        }

                        if( invalidMobileFormat == 1 ){
                            invalidMobileIndex = 1;
                        }
                    }
                });
            }
            /* Validate : mobile - End */

            /* Validate : email - Start */
            if( $('#applicantForm').find('input.validate_email').length > 0 ){
                $('#applicantForm').find('input.validate_email').each(function(i){
                    if( $(this).val() != '' ){
                        var validated_status = checkEmail( $(this).val() );
                        if( validated_status == 0 ){
                            invalidEmailFormat++;
                            $(this).addClass('error');
                        }

                        if( invalidEmailFormat == 1 ){
                            invalidEmailIndex = 1;
                        }
                    }
                })
            }
            /* Validate : email - End */

            if( notValidate > 0 ){

                $('#applicantForm').find('.step-item').removeClass('active');
                $('#applicantForm').find('input.required').eq(index).parents('.step-item').addClass('active');
                $('#applicantForm').find('input.required').eq(index).focus();

                swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Required field must not leave empty' : 'กรุณากรอกข้อมูลให้ครบถ้วน' ) );
                $('#loading').hide();
                $('#btn-submit').prop('disabled',false);
            }else if( invalidEmailFormat > 0 ){
                swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Invalid email format' : 'อีเมลมีรูปแบบไม่ถูกต้อง' ) );
                $('#loading').hide();
                $('#btn-submit').prop('disabled',false);
            }else if( invalidMobileFormat > 0 ){
                swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Invalid mobile number format' : 'เบอร์โทรศัพท์มือถือมีรูปแบบไม่ถูกต้อง' ) );
                $('#loading').hide();
                $('#btn-submit').prop('disabled',false);
            }else{
                e.currentTarget.submit();
                // $('#applicationForm').submit();
            }
        });
        /* #btn-submit handler - End */

        /* input.required handler - Start */
        $('body').on('keypress change','input:not([type="checkbox"]).required', function(){
            $(this).removeClass('error');
        });
        $('body').on('change','input[type="checkbox"].required', function(){
            $(this).removeClass('error');
        });
        $('body').on('change','select.required', function(){
            if( $(this).val() > 0 ){
                $(this).parents('.controls').find('.select2-selection').removeClass('error');
            }
        });
        /* input.required handler - End */

    /* Job Applicant Page - End */

    /* #btnLeavingProfile handler - Start */
    $('body').on('click', '.btnLeavingProfile', function(){
        $('#leavingProfileModal').modal('show');
        var selectedJobId = $(this).attr('data-jobId');
        if( selectedJobId > 0 ){
            $('#leavingProfileModal').on('shown.bs.modal', function(e){
                $(this).find('select#profile_job_id').val( selectedJobId ).trigger('change');
            });
        }
    });
    /* #btnLeavingProfile handler - End */

    /* #btn-profile-submit handler - Start */
    $('body').on('click', '#btn-profile-submit', function(){
        $('#loading').fadeIn('fast');

        var validated = true;
        $('#leavingProfileForm').find('input:not([type="checkbox"]).required').each(function(){
            if( $(this).val() == '' ){
                $('#loading').fadeOut('fast');
                $(this).addClass('error');
                validated = false;
            }
        });
        $('#leavingProfileForm').find('select.required').each(function(){
            if( $(this).val() == 0 ){
                $('#loading').fadeOut('fast');
                $(this).parents('.controls').find('.select2-selection').addClass('error');
                validated = false;
            }
        });
        $('#leavingProfileForm').find('input[type="checkbox"].required').each(function(){
            if( $(this).prop('checked') === false ){
                $('#loading').fadeOut('fast');
                $(this).addClass('error');
                validated = false;
            }
        });

        /* Validate : mobile - Start */
        if( $('#leavingProfileForm').find('input.validate_mobile').length > 0 ){
            $('#leavingProfileForm').find('input.validate_mobile').each(function(i){
                if( $(this).val() != '' ){
                    var validated_status = mobile_only( $(this).val() );
                    if( validated_status == 0 ){
                        $(this).addClass('error');
                        validated = false;
                    }
                }
            });
        }
        /* Validate : mobile - End */

        /* Validate : email - Start */
        if( $('#leavingProfileForm').find('input.validate_email').length > 0 ){
            $('#leavingProfileForm').find('input.validate_email').each(function(i){
                if( $(this).val() != '' ){
                    var validated_status = checkEmail( $(this).val() );
                    if( validated_status == 0 ){
                        $(this).addClass('error');
                        validated = false;
                    }
                }
            })
        }
        /* Validate : email - End */

        $('#leavingProfileForm').find('#profile_file').each(function(){
            var file = this.files[0];
            if( !file ){
                $('#loading').fadeOut('fast');
                $(this).addClass('error');
                validated = false;
            }
        });

        if( validated === false ){
            swalMessage('message-warning', ( language == 'en' ? 'Warning!' : 'คำเตือน!'), ( language == 'en' ? 'Required field must not leave empty' : 'กรุณากรอกข้อมูลให้ครบถ้วน' ) );
        }else{
            $('#leavingProfileForm').submit();
        }
    });
    /* #btn-profile-submit handler - End */
    
    /* #profile_file handler - Start */
    $('body').on('change', '#profile_file', function(){
        var file = this.files[0];
        var fname = file.name;
        $(this).removeClass('error');
        fextension = fname.substring(fname.lastIndexOf('.')+1);
        validExtensions = ["jpg","pdf","jpeg","gif","png","doc","docx","xls","xlsx","ppt","pptx"];
        if( file.size >= 5000000 ){
            swalMessage('message-warning','คำเตือน','กำหนดขนาดไม่เกิน 5 เมกะไบต์');
            $(this).addClass('error');
            $(this).val('');
        }else if( $.inArray(fextension, validExtensions) == -1 ){
            swalMessage('message-warning','คำเตือน','ไฟล์อัพโหลดไม่ถูกต้อง');
            $(this).addClass('error');
            $(this).val('');
        }
    });
    /* #profile_file handler - End */

    /* #leavingProfileForm submit handler - Start */
    $('body').on('submit', '#leavingProfileForm', function(e){
        e.preventDefault();
        $.ajax({
            url : base_url+'/'+language+'/jobs/saveProfile',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend : function(){
                $('#leavingProfileModal').modal('hide');
                $('#loading').fadeIn('fast');
            },
            success: function( res ){
                var response = res.data.response;
                if( response.status == 200 ){
                    $('#leavingProfileModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: response.text,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'ตกลง',
                    }).then(( result )=>{
                        if( result.isConfirmed ){
                            top.location.href=base_url+'/'+language+'/job-vacancy';
                        }
                    })
                }
            },
            error: function(e){
                swalMessage('message-error','Something wrong!', 'Please, try again.');
                $('#leavingProfileModal').modal('show');
            }
        })
    });
    /* #leavingProfileForm submit handler - End */

    /* #applicant_idcard handler - Start */
    $('body').on('keyup','#applicant_idcard', function(){
        var target = $(this);
        if( $.trim(target.val()) != '' && isNumeric( target.val() ) === true ){
            if($.trim(target.val()) != '' && target.val().length == 13){
                target.removeClass('error');
                id = target.val().replace(/-/g,"");
                var result = Script_checkID(id);
                if(result === false){
                    target.addClass('error');
                    target.val('');
                    swalMessage('message-error','ผิดพลาด','เลขบัตรไม่ถูกต้อง');
                }
            }
        }else{
            target.addClass('error');
            target.val('');
            swalMessage('message-error','ผิดพลาด','ระบุเป็นตัวเลขเท่านั้น');
        }
    });
    /* #applicant_idcard handler - End */

    /* #applicant_current_mobile handler - Start */
    $('body').on('keyup', '#applicant_current_mobile', function(){
        var target = $(this);
        if( $.trim(target.val()) != '' && isNumeric( target.val() ) === false ){
            target.addClass('error');
            target.val('');
            swalMessage('message-error','ผิดพลาด','ระบุเป็นตัวเลขเท่านั้น');
        }
    });
    /* #applicant_current_mobile handler - End */

    /* #applicant_file_1 handler - Start */
    $('body').on('change', '#applicant_file_1', function(){
        var file = this.files[0];
        var fname = file.name;
        fextension = fname.substring(fname.lastIndexOf('.')+1);
        validExtensions = ["jpg","pdf","jpeg","gif","png","doc","docx","xls","xlsx","ppt","pptx"];
        if( file.size >= 5000000 ){
            swalMessage('message-warning','คำเตือน','กำหนดขนาดไม่เกิน 5 เมกะไบต์');
            $(this).val('');
        }else if( $.inArray(fextension, validExtensions) == -1 ){
            swalMessage('message-warning','คำเตือน','ไฟล์อัพโหลดไม่ถูกต้อง');
            $(this).val('');
        }
    });
    /* #applicant_file_1 handler - End */

    /* #applicant_file_2 handler - Start */
    $('body').on('change', '#applicant_file_2', function(){
        var file = this.files[0];
        var fname = file.name;
        fextension = fname.substring(fname.lastIndexOf('.')+1);
        validExtensions = ["jpg","pdf","jpeg","gif","png","doc","docx","xls","xlsx","ppt","pptx"];
        if( file.size >= 5000000 ){
            swalMessage('message-warning','คำเตือน','กำหนดขนาดไม่เกิน 5 เมกะไบต์');
            $(this).val('');
        }else if( $.inArray(fextension, validExtensions) == -1 ){
            swalMessage('message-warning','คำเตือน','ไฟล์อัพโหลดไม่ถูกต้อง');
            $(this).val('');
        }
    });
    /* #applicant_file_2 handler - End */

    /* #applicant_file_3 handler - Start */
    $('body').on('change', '#applicant_file_3', function(){
        var file = this.files[0];
        var fname = file.name;
        fextension = fname.substring(fname.lastIndexOf('.')+1);
        validExtensions = ["jpg","pdf","jpeg","gif","png","doc","docx","xls","xlsx","ppt","pptx"];
        if( file.size >= 5000000 ){
            swalMessage('message-warning','คำเตือน','กำหนดขนาดไม่เกิน 5 เมกะไบต์');
            $(this).val('');
        }else if( $.inArray(fextension, validExtensions) == -1 ){
            swalMessage('message-warning','คำเตือน','ไฟล์อัพโหลดไม่ถูกต้อง');
            $(this).val('');
        }
    });
    /* #applicant_file_3 handler - End */

    /* .showProfile handler - Start */
    $('body').on('click', '.showProfile', function(){
        $.ajax({
            url : base_url+language+'/about-us/getProfile/'+$(this).attr('data-memberid'),
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend : function(){
                $('#loading').fadeIn('fast');
            },
            success: function( res ){
                var response = res.data.response;
                console.log( response.payLoads );
                if( response.status == 200 ){
                    $('#loading').fadeOut('fast');
                    $('#memberProfileModal').find('#modal-member-name').html( response.payLoads.member_name );
                    $('#memberProfileModal').find('.modal-body').html( response.payLoads.views );
                    $('#memberProfileModal').modal('show');
                }else{
                    $('#memberProfileModal').modal('hide');
                    $('#loading').fadeOut('fast');
                    swalMessage('message-error','Something wrong!', 'Please, try again.');
                }
            },
            error: function(e){
                $('#loading').fadeOut('fast');
                swalMessage('message-error','Something wrong!', 'Please, try again.');
            }
        });
    });
    /* .showProfile handler - End */

});

function revealOnScroll() {
	var scrolled = $window.scrollTop(),
		win_height_padded = $window.height() * 1.1;

	// Showed...
	$(".revealOnScroll:not(.animated)").each(function () {
		var $this     = $(this),
			offsetTop = $this.offset().top;

		if (scrolled + win_height_padded > offsetTop) {
			if ($this.data('timeout')) {
				window.setTimeout(function(){
					$this.addClass('animated ' + $this.data('animation'));
				}, parseInt($this.data('timeout'),10));
			} else {
				$this.addClass('animated ' + $this.data('animation'));
			}
		}
	});
	
	// Hidden...
	$(".revealOnScroll.animated").each(function (index) {
		var $this     = $(this),
			offsetTop = $this.offset().top;
		if (scrolled + win_height_padded < offsetTop) {
			$(this).removeClass('animated').removeClass($this.data('animation'));
		}
	});
}

/* Sweet Alert - Start */
function swalMessage( status, title, message ){
    console.log( status+' | '+title+' | '+message );
    var theIcon = 'error';
    if( status == 'message-success' ){
        theIcon = 'success';
    }else if( status == 'message-warning' ){
        theIcon = 'warning';
    }else if( status == 'message-info' ){
        theIcon = 'info';
    }

    Swal.fire({
        title : title,
        text : message,
        icon : theIcon
    })
}
/* Sweet Alert - End */

/* Form validation - Start */
function checkEmail(myEmail) {
	var email = myEmail;
	var filter = /^.+@.+\..{2,3}$/;
	if (!filter.test(email)) {
		return 0;
	}else{
		return 1;
	}
}

function mobile_only(text) {
    var filter = /^\d*$/;
	if(text!=''){
        if( !filter.test( text ) ){
            return 0;
        }else{
            if((text.substr(0,2)=="06") || (text.substr(0,2)=="08") || (text.substr(0,2)=="09")){
                return 1;
            } else { 
                return 0;
            }
        }
	}else{
		return 0;
	}
}

function checkNumber(data, maxlength){
	var filter = /^\d*$/;
	var nume = data;
	if(nume.length < maxlength){
		return  1;
	}else{
		if(!filter.test(nume)){
			data.value='';
			return 2;
		}else{
			return 0;
		}
	}
}

function checkValidNumber(data){
	var filter = /^\d*$/;
	if(!filter.test(data)){
		return 0;
	}else{
		return 1;
	}
}

function isThaichar(str,obj){
	var orgi_text="ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
	var str_length=str.length;
	var str_length_end=str_length-1;
	var isThai=true;
	var Char_At="";
	for(i=0;i<str_length;i++){
		Char_At=str.charAt(i);
		if(orgi_text.indexOf(Char_At)==-1){
			isThai=false;
		}   
	}
	if(str_length>=1){
		if(isThai==false){
			obj.value=str.substr(0,str_length_end);
		}
	}
	return isThai; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด
}

function isEngchar(str,obj){
	var orgi_text="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	var str_length=str.length;
	var str_length_end=str_length-1;
	var isEng=true;
	var Char_At="";
	for(i=0;i<str_length;i++){
		Char_At=str.charAt(i);
		if(orgi_text.indexOf(Char_At)==-1){
			isEng=false;
		}   
	}
	if(str_length>=1){
		if(isEng==false){
			obj.value=str.substr(0,str_length_end);
		}
	}
	return isEng; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด
}

function isNumeric(str,obj){
	var orgi_text="0123456789";
	var str_length=str.length;
	var str_length_end=str_length-1;
	var isNumeric=true;
	var Char_At="";
	for(i=0;i<str_length;i++){
		Char_At=str.charAt(i);
		if(orgi_text.indexOf(Char_At)==-1){
			isNumeric=false;
		}   
	}
	// if(str_length>=1){
	// 	if(isNumeric==false){
	// 		obj.value=str.substr(0,str_length_end);
	// 	}
	// }
	return isNumeric; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด
}
function Script_checkID(id){
    var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    if(! RE.test(id)) return false;
    if(id.substring(0,1)== 0) return false;
    if(id.length != 13) return false;
    for(i=0, sum=0; i < 12; i++)
        sum += parseFloat(id.charAt(i))*(13-i);
    if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
    return true;
}
/* Form validation - End */