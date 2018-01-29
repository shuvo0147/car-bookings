/*
*  Application custom js 
*/

var App = {

	// form validation 
	formValidation : function(postData,target) {
		var i = 0;
 		$.each(postData,function(index,item){
 			if ( item.value === '' ) {
 				$(target+' [name="'+item.name+'"]').addClass('border border-danger');
 				i++;
 			} else {
 				$(target+' [name="'+item.name+'"]').removeClass('border border-danger');
 			}
 		});
		if (i > 0) 
			return false; 
		else 
			return true;
	},

	// login request
	login : function(postData) {
	  postData.push({
	  	name : 'action',
	  	'value':'login'
	  });

	  var req = $.ajax({
	  	url    : 'users/users.php',
	  	method : 'POST',
	  	data   : postData,
	  	dataType:'json'
	  });
	  req.done(function(resp){
	  	if ( resp.status ) {
	  		window.location = "users/home.php";
	  	} else {
        $("#loginAlert").show().html('<span class="text-danger"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' + resp.msg + '</strong></span>');
	  	}
	  });
	  req.fail(function(xhr,textStatus){
	  	console.log('Request Failed: ',textStatus);
	  });
	},
	
	// logout 
	logout : function(){
		var request = $.ajax({
			url      : '/users/users.php',
			method   : 'POST',
			dataType : 'JSON',
      data : {
      	'action' : 'logout'
      }
		});
		request.done(function(resp){
			if ( resp.status ) {
				window.location = "/";
			}
		});
		request.fail(function(xhr,textStatus){
			console.log('Connection Failed: ', textStatus);
		});
	},
	booking : function (postData) {
		postData.push({
			'name':'action',
			'value':'booking'
		})
		var request = $.ajax({
			url      : '/users/booking.php',
			method   : 'POST',
			dataType : 'JSON',
			data     : postData
		});
		request.done(function(resp){
			if ( resp.status ) {
					$('#bookingForm')[0].reset();
					$(".addActionMsg").show().html('<h5 class="alert alert-success"><strong><i class="fa fa-check-circle-o"></i> '+resp.msg+'</strong></h5>');
			} else {
				$(".addActionMsg").show().html('<h5 class="alert alert-danger"><strong><i class="fa fa-exclamation-circle"></i> '+resp.msg+'</strong></h5>');
			}
		});
    request.fail(function(xhr,textStatus){
    	console.log('Request Failed: ',textStatus);
    });
	},
	editBooking : function (postData) {
		postData.push({
			'name'  : 'action',
			'value' : 'update-booking'
		});
		var req = $.ajax({
			url      : '/users/booking.php',
			method   : 'POST',
			dataType : 'JSON',
			data     : postData
		});
		req.done(function(resp){
			if ( resp.status ) {
				$(".editBookMsg").show().html('<h5 class="alert alert-success"><strong><i class="fa fa-check-circle-o"></i> '+resp.msg+'</strong></h5>');
			} else {
				$(".editBookMsg").show().html('<h5 class="alert alert-danger"><strong><i class="fa fa-exclamation-circle"></i> '+resp.msg+'</strong></h5>');
			}
		});
		req.fail(function(xhr,textStatus){
			console.log("Request Failed: ", textStatus);
		});
	},
	deleteBooking : function (bookingId,$this) {
		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this booking!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		}).then((isConfirmed) => {
		  if ( isConfirmed ) {
		    var request = $.ajax({
		    	url : '/users/booking.php',
		    	method : 'POST',
		    	dataType : 'JSON',
		    	data : {
		    		'action'   : 'delete-booking',
		    		 id : bookingId 
		    	}
		    });
		    request.done(function(resp){
		    	if ( resp.status ) {
		    		$this.parent().parent().fadeOut(300,function(){
		    			$this.remove();
		    		});
		    		$(".actionMsg").show()
		    		.html('<h5 class="text-success"><strong>'+
		    			'<i class="fa fa-check-circle-o" aria-hidden="true"></i>' + resp.msg + '</strong></h5>'
		    			);
		    	} else {
		    		$(".actionMsg").show().html('<span class="text-danger"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' + resp.msg + '</strong></span>');
		    	}
		    	swal.close();
		    });
		    request.fail(function(xhr,textStatus){

		    });
		  } else {
		    swal.close();
		  }
		});
	} 

}

$(document).ready(function(){
	// login event 
	$(document).on('click','#loginBtn',function(evt){
		var target = "#loginFrom";
		var postData = $('#loginFrom').serializeArray();
    if ( App.formValidation(postData,target) ) {	
			App.login(postData);
			return;
    }
	}); 

	// logout event 
	$(document).on('click','#logoutBtn',function(evt){
		App.logout();
	});

	// save booking form 
	$(document).on('click','#bookingBtn',function(evt){
		var target = "#bookingForm";
		var postData = $('#bookingForm').serializeArray();
		if( App.formValidation(postData,target) ){
			App.booking(postData);
			return false;
		}
		return false;
	});

	// update booking  
	$(document).on('click','#editBookBtn',function(evt){
		// console.log('Hey Hello');
		var target   = "#editBookingForm";
		var postData = $("#editBookingForm").serializeArray();
		if ( App.formValidation(postData,target) ) {
			App.editBooking(postData);
		} 
		return false;
	});

	// delete booking
	$(document).on('click','.deleteBtn',function(){
		var bookingId = $(this).data('id');
		App.deleteBooking(bookingId,$(this));
	});
});