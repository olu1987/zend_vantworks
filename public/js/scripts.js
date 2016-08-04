/* check if website is loaded in an iframe and redirect - iFrame stealing prevention */
if(top.location!=location){
	top.location.href=document.location.href;
}

/* how long the success/error messages are shown before next animation is triggered or cleanup is made */
window.myCustomOptions={
	timer_success:1000,			// how long the success messages should be visible
	timer_success_long:2000,	// some success messages will show longer than others
	timer_error:6000,			// how long the error messages should be visible
	input_slide:250				// how much time messages should be animated
};

/* error processing, coded for Bootstrap 3 forms, it won't work as standalone */
var errors=[];
function addToError(element,message){
	errors.push({0:element,1:message})
}
function showErrors(){
	if(errors.length>0){
		for(i=0;i<errors.length;i++){
			if(!errors[i][0].parents('.form-group').hasClass('has-error')){
				errors[i][0].after('<span class="fa fa-times fa-fw form-control-feedback error-tooltips" title="'+errors[i][1]+'"></span>').parents('.form-group').addClass('has-error has-feedback');
				if($('.error-tooltips','.has-error').length>0){
					$('.error-tooltips:visible').tooltip({
						animation:true,
						container:$('body'),
						placement:'bottom',
						html:true
					}).tooltip('show');
				}
				if($('[data-toggle="tab"]').length){
					$('[data-toggle="tab"]').each(function(k,v){
						if($($(v).attr('href')).find('.has-error').length){
							if($(v).find('span.fa').length===0){
								$(v).append('<span class="fa fa-exclamation-triangle fa-fw text-danger"></span>');
							}
						}
					});
				}
			}
		}
	}
	clearError();
}
function clearError(){
	while(errors.length>0){
		errors.pop();
	}
}

$(document).ready(function(){
	/* bs 3 modal scroll fix - when main page is scrolled and modal shows and hides, page is scrolled back to top, with this code, it returns to where it was */
	$('.modal').on('show.bs.modal',function(){
		window.BS_Modal_fix=$(window).scrollTop();
	});
	$('.modal').on('hidden.bs.modal',function(){
		setTimeout(function(){
			$(window).scrollTop(window.BS_Modal_fix);
		},100);
	});

	/* show input errors on Bootstrap's tab change */
	$('a[data-toggle="tab"]').on('shown.bs.tab',function(e){
		// clear notification if no errors left
		if($($(e.relatedTarget).attr('href')).find('.has-error').length===0){
			$(e.relatedTarget).find('span.fa').remove();
		}
		// clear tooltips on hidden tab
		if($($(e.relatedTarget).attr('href')).find('.error-tooltips').length){
			$($(e.relatedTarget).attr('href')).find('.error-tooltips').tooltip('destroy');
		}
		// show tooltips on active tab
		if($($(e.target).attr('href')).find('.error-tooltips').length){
			$('.error-tooltips:visible').tooltip({
				animation:true,
				container:$('body'),
				placement:'bottom',
				html:true
			}).tooltip('show');
		}
	});

	/* enable submit buttons - I'm minifying CSS/JS through API with PHP code, so I want to prevent users clicking on buttons before the JS code is ready */
	if($('button[type=submit]').length){
		$('button[type=submit]').prop('disabled',false);
	}

	/* clear input errors on click/type/focus */
	$('body').on('focusin click input','.form-group',function(){
		if($(this).hasClass('has-error')){
			$(this).removeClass('has-error');
			$(this).find('.form-control-feedback').slideUp(myCustomOptions.input_slide,function(){
				$('#'+$(this).attr('aria-describedby')).remove();
				$(this).remove();
			});
			if($(this).parents('.tab-pane').length){
				$('a[data-toggle="tab"][href="#'+$(this).parents('.tab-pane').attr('id')+'"]').find('span.fa').remove();
			}
		}
	});

	/* load all tooltips */
	if($('.tooltips').length>0){
		$('.tooltips').tooltip({
			animation:true,
			trigger:'hover',
			container:$('body'),
			placement:'bottom'
		});
	}

	/* EU Cookie Law */
	if($('.alert-cookies').length){
		var cName = 'cookie_agreement';
		function readCookie(name){
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i<ca.length;i++){
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}
		if(readCookie(cName)===null){
			$('.alert-cookies').slideUp(function(){
				$('.alert-cookies').removeClass('hidden').slideDown();
				$('body').addClass('eu-cookie-visible');
			});
			$('body').on('click','.eu-cookie-law',function(e){
				e.preventDefault();
				var theDate = new Date();
				var fiveYearsLater = new Date( theDate.getTime() + (31536000000 * 5));
				var expiryDate = fiveYearsLater.toGMTString();
				document.cookie = cName+'=1;expires='+expiryDate+';path=/';
				$('.alert-cookies').slideUp(function(){
					$('.alert-cookies').remove();
					$('body').removeClass('eu-cookie-visible');
				});
			});
		}
	}

	/* prevent search form submission if input is empty */
	$('#search_form').on('submit',function(e){
		if($('input',$(this)).val()==''){
			addToError($('input',$(this)),'Please enter a search term ...');
			showErrors();
			e.preventDefault();
		}
	});
	
	/*jquery form validation configuration. Here we declare the values that make the form valid and its error messages. The following is for the sign up form page validation*/
	
	$("#leadForm").validate({
		rules: {
				first_name: "required",
				last_name: "required",
				
				
				email: {
					required: true,
					email: true
				},
				company: "required",
				website: "required",
				position: "required",
				
			},
	    messages: {
				first_name: "First name required",
				last_name: "Last name required",
				Company: "Your company name is required",
				
				email: "Please enter a valid email address",
				WebsiteURL: "Please enter your company website URL",
				position: "Please state your position at your company",
			}
			
		});
});