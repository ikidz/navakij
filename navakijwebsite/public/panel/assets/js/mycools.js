(function ($) { 
	var timestampJS = 0;
	$.AdminInit = function(){
		$.handleMainMenu();
		$.handleUniform();
		$.handleInput();
		$.handleGoTop();
		$.handleWidgetTools();
		$.handleFancyBox();
		$('#form-date-range span').html(Date.today().add({
            days: -29
        }).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));


        if (!jQuery().datepicker || !jQuery().timepicker) {
            return;
        }
        $('.date-picker').datepicker({
			autoclose: true,
			format : "dd-mm-yyyy"
		});

        $('.timepicker-default').timepicker();

        $('.timepicker-24').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });
	}
	$.handleFancyBox = function () {
        
        if (jQuery(".fancybox-button").size() > 0) {
            jQuery(".fancybox-button").fancybox({
                groupAttr: 'data-rel',
                prevEffect: 'none',
                nextEffect: 'none',
                closeBtn: true,
                helpers: {
                    title: {
                        type: 'inside'
                    }
                }
            });
        }
    }
	$.handleInput = function () {
        if (!jQuery().chosen) {
            return;
        }
        $(".chosen").chosen();
        $(".chosen-with-diselect").chosen({
            allow_single_deselect: true
        });
		var toggle = $('.text-toggle-button');
		for(i=0;i<toggle.length;i++){
		 $('.text-toggle-button').eq(i).toggleButtons({
            width: 200,
            label: {
                enabled:  $('.text-toggle-button').eq(i).attr('enable_text'),
                disabled:  $('.text-toggle-button').eq(i).attr('disable_text')
            }
        });
		}
    }
	$.handleGoTop = function () {
        /* set variables locally for increased performance */
        jQuery('#footer .go-top').click(function () {
            App.scrollTo();
        });

    }
	$.fn.handleCheckAll = function(tools){
		var ck = this;
		$(tools).addClass('disabled');  
		//tools = $(tools);
		$(this).change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
			var l = 0;
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
					l++;
                } else {
                    $(this).attr("checked", false);
                }
            });
		   jQuery.uniform.update(set);
		   var ll2 =  $($(ck).attr("data-set") + ":checked");
		   if(ll2.length > 0){
			 $(tools).removeClass('disabled');  
		   }else{
			  $(tools).addClass('disabled');  
		   }
		    $(tools).find(".select_count").text(l);
           
        });
		$($(this).attr("data-set")).change(function(e) {
		   var ll =  $(this).is(":checked");
		  
		   if(ll){
			 $(tools).removeClass('disabled');  
		   }else{
			  $(ck).attr("checked", false);
			  
		   }
		   var ll2 =  $($(ck).attr("data-set") + ":checked");
		   var ll3 =  $($(ck).attr("data-set"));
		   if(ll3.length==ll2.length){
			   $(ck).attr("checked", true); 
		   }
		    if(ll2.length > 0){
			  $(tools).removeClass('disabled');  
		   }else{
			  $(tools).addClass('disabled');  
		   }
		   $(tools).find(".select_count").text(ll2.length);
		   jQuery.uniform.update($(ck));
		});
	}
	$.fn.useDataTable = function(){
		$(this).dataTable({
            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "<span class='checktools'></span> _MENU_ records per page",
                "oPaginate" : {
                    "sPrevious" : "Prev",
                    "sNext" : "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });	
	}
	$.makeURLChange = function(){
		window.addEventListener("popstate", function(e) {
			$("#container")._blockUI(); 
			e.preventDefault();
			$._makeRequest(location.pathname,{},"GET");
			
		});
		
	}
	$.getLocation = function(url){
		//$._makeRequest(url,{},"GET");
		window.location=url;
	}
	$.fn.handleformSubmit = function(el){
		$(this).submit(function(e) {
			
			var action = $(this).attr('action');
			if(!action){
				action = window.location.href;	
			}
			var require = $(this).find('required');
            for(x=0;x<require.length;x++){
				var eq = require.eq(x);
				if(eq.val()==""){
					eq.focus();
					return false;	
				}
			}
			$("#container")._blockUI(); 
			var param = $(this).serialize();
			$._makeRequest(action,param,"POST");
			return false;	
        });
	}
	$.fn.makeHTML5loadPage = function(el){
		//if($(this).is("a")){
			$(this).unbind('click');
			$(this).click(function(e) {
				if($(this).hasClass('force_redirect')){
					return true;	
				}
				$(this).parent().parent().find(".active").removeClass('active');
				$(this).parent().addClass('active');
				var href =  $(this).attr("href");
				var title =  $(this).text();
				var param={}
				if(href.indexOf("#") !== -1){
					return true;	
				}
				if(href.indexOf("javascript") !== -1){
					return true;	
				}
				if(!href){
					return true;	
				}
				if(typeof(window.history.pushState)!="function"){
					window.location=href;
				}else{
					window.history.pushState({},title,href);
					
					$("#container")._blockUI(); 
					$._makeRequest(href,param,"GET");
					return false;
				}
				
			});
		//}
	}	
	$._makeRequest = function(url,param,method){
		try{
		if(method=="GET"){
			$.get(url,param,function(data,txtStatus){
				$("#container")._unblockUI(); 
				if(txtStatus=="success"){
					$("#container").html(data);
				}
				});
		}
		if(method=="POST"){
			$.post(url,param,function(data,txtStatus){
				$("#container")._unblockUI(); 
				if(txtStatus=="success"){
					$("#container").html(data);
				}
				});
		}
		}catch(e){
			
		}
	}
	$.fn._blockUI = function(){		
		$(this).parent().block({
					message: '<img src="./assets/img/loading.gif" align="absmiddle">',
					css: {
						border: 'none',
						padding: '2px',
						backgroundColor: 'none'
					},
					overlayCSS: {
						backgroundColor: '#000',
						opacity: 0.09,
						cursor: 'wait'
					}
				});	
	}
	$.fn._unblockUI = function (el){
		$(this).parent().unblock({
					onUnblock: function () {
						jQuery(el).removeAttr("style");
					}
				});
	}
	$.handleMainMenu = function () {
		jQuery('#sidebar .has-sub > a').click(function () {
            var sub = jQuery(this).next();
            if (sub.is(":visible")) {
                jQuery('.arrow', jQuery(this)).removeClass("open");
                sub.slideUp(200);
            } else {
                jQuery('.arrow', jQuery(this)).addClass("open");
                sub.slideDown(200);
            }
        });
	$.handleUniform = function () {
			if (!jQuery().uniform) {
				return;
			}
			if (test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle), input[type=file]")) {
				test.uniform(); 
			}
    	}
	}
	$.handleWidgetTools = function () {
		
        jQuery('.widget .tools .icon-remove').click(function () {
            jQuery(this).parents(".widget").parent().remove();
        });

        jQuery('.widget .tools .icon-refresh').click(function () {
            var el = jQuery(this).parents(".widget");
			var callback = jQuery(this).attr("callback");
			
			if(typeof(callback)){
				App.blockUI(el); 
				eval(callback+"(el)");	
				//App.unblockUI(el); 
			}
        });

        jQuery('.widget .tools .icon-chevron-down, .widget .tools .icon-chevron-up').click(function () {
            var el = jQuery(this).parents(".widget").children(".widget-body");
            if (jQuery(this).hasClass("icon-chevron-down")) {
                jQuery(this).removeClass("icon-chevron-down").addClass("icon-chevron-up");
                el.slideUp(200);
            } else {
                jQuery(this).removeClass("icon-chevron-up").addClass("icon-chevron-down");
                el.slideDown(200);
            }
        });
    }
})(jQuery, document);

/*function makeHTML5loadPage(e)
{
	var href = "";
	var param={}
	if($(this).is("a")){
		href = $(this).attr("href");
	}
	if($(this).is("form")){
		if($(this).find("input[type='file']").length > 0){
			return true;
		}
		href = $(this).attr("action");
		if(href==null){
			href = window.location.href;	
		}
		param = $(this).serialize();
	}
	if(href.indexOf("#") !== -1){
		return true;	
	}
	
	if(typeof(window.history.pushState)!="function"){
		window.location=href;
	}else{
		window.history.pushState({},null,href);
		_blockUI($("#body")); 
		//$.blockUI({ css: { backgroundColor: '#f00', color: '#fff'} });
		if($(this).is("a")){
			$.get(href,param,function(data,txtStatus){
				_unblockUI($("#body"));
				if(txtStatus=="success"){
					$("#body").html(data);
				}
				
				});
		}
		if($(this).is("form")){
			$.post(href,param,function(data,txtStatus){
				_unblockUI($("#body"));
				if(txtStatus=="success"){
					$("#body").html(data);
					
				}
				});
		}
		return false;
	}
	
}
function _updateJS()
{
	var d = new Date();
	$.getScript(admin_url + "updatejs", {'t' : timestampJS.toString()}, function(data, textStatus, jqxhr) {
	   console.log(data); //data returned
	   console.log(textStatus); //success
	   console.log(jqxhr.status); //200
	   console.log('Load was performed.');
	});
	
}
function _notif_inbox(id,message,inbox_id)
{
	if($("#header_notification_inbox  > a.dropdown-toggle").find(".notif_badge").length == 0){
		$("#header_notification_inbox  > a.dropdown-toggle").append("<span class=\"label label-info notif_badge\"></span>");
	}
}*/

$(document).ready(function(e) {
	$('body').on('change', '.readfile', function(){
		var file = this.files[0];
		if( file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg' ){
			readURL( this, $(this).parents('.controls').find('.preview') );
		}else{
			alert('Support only .png or .jpg');
		}
	});
});
var tablesetting = {
            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate" : {
                    "sPrevious" : "Prev",
                    "sNext" : "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        }

jQuery.fn.dataTableExt.oApi.fnDataUpdate = function ( oSettings, nRowObject, iRowIndex )
{
    jQuery(nRowObject).find("TD").each( function(i) {
          var iColIndex = oSettings.oApi._fnVisibleToColumnIndex( oSettings, i );
          oSettings.oApi._fnSetCellData( oSettings, iRowIndex, iColIndex, jQuery(this).html() );
    } );
};

function ToSeoUrl(url) {
        
	// make the url lowercase
	var encodedUrl = url.toString().toLowerCase(); 

	// replace & with and
	encodedUrl = encodedUrl.split(/\&+/).join("-and-")

	// remove invalid characters
	encodedUrl = encodedUrl.split(/[^a-z0-9ก-๏]/).join("-");

	// remove duplicates
	encodedUrl = encodedUrl.split(/-+/).join("-");

	// trim leading & trailing characters
	encodedUrl = encodedUrl.trim('-'); 

	return encodedUrl;
}

function readURL(input, previewTarget) {
    if (input.files && input.files[0]) {
		var reader = new FileReader();
        reader.onload = function(e) {
            previewTarget.html('');
			previewTarget.append('<img src="'+e.target.result+'" style="width:300px;" />');
			var image = new Image();
			var width, height;
			image.src = e.target.result;
			image.onload = function() {
				// access image size here 
				width = this.width;
				height = this.height;
				previewTarget.append('<p style="font-size:12px; font-style:italic;">รูปนี้กว้าง : '+width+' พิกเซล สูง : '+height+' พิกเซล</p>');
			};
        }
      
        reader.readAsDataURL(input.files[0]);
    }
}