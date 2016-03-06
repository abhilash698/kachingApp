$(document).ready(function() {

	$('#change-mobile-btn').click(function(){
		var mobile = $('#mobile-change').val();
		if(mobile.length != 10){
			$('#mobile-error-msg').text('Invalid Mobile Number');
		}else{
			$('.loading-changeMobile').css('display','block');
			$.post("/merchant/profile/sendOtp",
		    {
		        mobile: mobile ,
		        _token: $('#token-change').val()
		    },
		    function(data, status){
		    	$('.loading-changeMobile').css('display','none');
		        if(data.response_code == 'FAIL'){
		        	$('#mobile-error-msg').text(data.message);
		        }
		        else {
		        	$('#change-mobile-btn').css('display','none');
		        	$('#verify-mobile-btn').css('display','block');
		        	$('.mobile').css('display','none');
		        	$('.otp').css('display','block');
		        }
		    });
		}
	});

	$('#verify-mobile-btn').click(function(){
		var otp  = $('#otp-change').val();
		if(otp.length != 6){
			$('#otp-error-msg').text('Invalid OTP');
		}else{
			$('.loading-changeMobile').css('display','block');
			$.post("/merchant/profile/validateOtp",
		    {
		        otp: otp ,
		        _token: $('#token-change').val()
		    },
		    function(data, status){
		    	$('.loading-changeMobile').css('display','none');
		        if(data.response_code == 'FAIL'){
		        	$('#otp-error-msg').text(data.message);
		        }
		        else {
		        	$('#verify-mobile-btn').css('display','none');
		        	$('.otp').css('display','none');
		        	$('.update-msg').css('display','block');
		        	$('#mobile-orginal').val(data.dataValue);
		        }
		    });
		}
	});


	$('.offerDisable').click(function(){
		var id = $(this).siblings('input[name=offerId]').val();
		$('#modalSlideLeft').modal('show');
		$('#disable').siblings('input[name=deleteId]').val(id);

	});

	$('#disable').click(function(){
		var id = $(this).siblings('input[name=deleteId]').val();
		var token = $(this).siblings('input[name=token]').val();
		$('#modalSlideLeft').modal('hide');
		$.post("/merchant/disableOffer",
	    {
	        offer_id: id,
	        _token: token
	    },
	    function(data, status){
	        if(data == 'fail'){
	        	alert('There is error communicating with server. Please contact administrator.');
	        }
	        else if(data == 'enabled'){
	        	$('.toggleI'+id).removeClass( "fa-toggle-off" ).addClass( "fa-toggle-on" )
	        }
	        else if(data == 'disabled'){
	        	$('.toggleI'+id).removeClass( "fa-toggle-on" ).addClass( "fa-toggle-off" )
	        }
	        else {
	        	alert('No response from server');
	        }
	    });
	});

	$('.offerEdit').click(function(){
		var id = $(this).siblings('input[name=offerId]').val();
		var title = $(this).siblings('input[name=offerTitle]').val();
		var startDate = $(this).siblings('input[name=offerStartDate]').val();
		var endDate = $(this).siblings('input[name=offerEndDate]').val();
		var fineprint = $(this).siblings('input[name=offerFineprint]').val();

		fineprint = fineprint.replace(/\<li>/g, "");
		fineprint = fineprint.replace(/\<\/li>/g, "\n");
		fineprint = fineprint.substring(0, fineprint.length - 2);

		$('#myModal').modal('show');
		$('#myModal :input[name=offer_id]').val(id);
		$('#myModal :input[name=title]').val(title);
		$('#myModal :input[name=startDate]').val(startDate);
		$('#myModal :input[name=endDate]').val(endDate);
		$('#myModal :input[name=fineprint]').val(fineprint);

	});

	$('#submitEdit').click(function(){
		$('.loading').css('display','block');
		$.post("/merchant/editOffer",
	    {
	        offer_id: $('#myModal :input[name=offer_id]').val(),
	        _token: $('#myModal :input[name=token]').val(),
	        title: $('#myModal :input[name=title]').val(),
	        startDate: $('#myModal :input[name=startDate]').val(),
	        endDate: $('#myModal :input[name=endDate]').val(),
	        fineprint: $('#myModal :input[name=fineprint]').val()
	    },
	    function(data, status){
	    	$('.loading').css('display','none');

	        if(data.status == 'fail'){
	        	$('#errorMsg').text(data.message);
	        	//alert(data.message);
	        }
	        else {
	        	var id  = data.data.id;
	        	var obj = $('.editObj'+id);
	        	obj.siblings('input[name=offerTitle]').val(data.data.title);
	        	obj.siblings('input[name=offerStartDate]').val(data.data.startDate);
	        	obj.siblings('input[name=offerEndDate]').val(data.data.endDate);
	        	obj.siblings('input[name=offerFineprint]').val(data.data.fineprint);
	        	$('#errorMsg').text('');
	        	$('#myModal').modal('hide');
	        	$('.title'+id).text(data.data.title);
	        	$('.fineprint'+id).html(data.data.fineprint);
	        	$('.startDate'+id).text(data.data.startDate);
	        	$('.endDate'+id).text(data.data.endDate);
	        }
	    });

	});
});