(function($){
	 $(document).ready(function() {
		$(".booking-form").submit(function(event){
			event.preventDefault();

            var form    = $(event.currentTarget);
            var send    = {};
            form.find( 'input' ).each( function() {
                var key     = $(this).attr('name');
                send[key]   = $(this).val();
            });

            console.log(send);

           	$.ajax({
                emulateJSON: true,
                url : booking.ajax_url,
                data: {
                        action: 'save_booking',
                        request: send,
                },
                beforeSend  : function(event){
                	form.attr('disabled', 'disabled');
                	form.find(".btn-submit").attr('disabled','disabled');
                	//$(".btn-submit").
                	form.find(".btn-submit").addClass("loading");
                },
                success : function(res){
                	form.find(".btn-submit").removeAttr('disabled');
                	form.find(".btn-submit").removeClass("loading");
                    if ( res.success ){

                    	$(".booking-form").html('<h3>'+res.msg+'</h3>');
                    	alert(res.msg);
                    } else {

                    }
                }

            });
           return false;
		});
	});
})(jQuery);