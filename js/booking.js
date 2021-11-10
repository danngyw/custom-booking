(function($){
	 $(document).ready(function() {
        jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
            //return this.optional(element)  && phone_number.match(/^(\()?(\d{3})([\)-\. ])?(\d{3})([-\. ])?(\d{4})$/);
            return phone_number.match(/^\+(?:[0-9] ?){6,14}[0-9]$/) ||phone_number.match(/^(?:[0-9] ?){6,14}[0-9]$/);
        }, "Please specify a valid phone number");

        $(".booking-form").validate({
            rules: {
                "fullname": {
                    required: true,
                    maxlength: 20
                },
                "phone": {
                    required: true,
                    phoneUS: true,
                    maxlength:14,
                    minlength:5
                },
                "re-password": {
                    equalTo: "#password",
                    minlength: 8
                }
            },
            submitHandler: function(form) {
                $(".booking-form").submit(function(event){

                    event.preventDefault();
                    var form    = $(event.currentTarget);
                    if(! form.validate() ){
                        return false;
                    }

                    var form    = $(event.currentTarget);
                    var send    = {};
                    form.find( 'input' ).each( function() {
                        var key     = $(this).attr('name');
                        send[key]   = $(this).val();
                    });

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
            },
            onkeyup: function( element, event ) {

                if ( event.which === 9 && this.elementValue(element) === "" ) {
                    return;
                } else if ( element.name in this.submitted || element === this.lastElement ) {
                    this.element(element);
                }

                this.checkForm();

                if (this.valid()) { // checks form for validity
                    console.log('Isvalid');

                    $('.button-submit').removeClass('disabled');
                    $('.button-submit').removeAttr('disabled');
                } else {
                    console.log('unvalid');
                    //$('button.submit').attr('class', 'submit btn btn-danger disabled');   // disables button
                    $('.button-submit').addClass('disabled');
                    $('.button-submit').attr('disabled');
                }
            },
            onclick: function( element ) {
                // click on selects, radiobuttons and checkboxes
                if ( element.name in this.submitted ) {
                    this.element(element);

                // or option elements, check parent select in that case
                } else if ( element.parentNode.name in this.submitted ) {
                    this.element(element.parentNode);
                }

                this.checkForm();

                if (this.valid()) { // checks form for validity
                    console.log('Isvalid');

                    $('.button-submit').removeClass('disabled');
                    $('.button-submit').removeAttr('disabled');
                } else {
                    console.log('unvalid');

                    $('.button-submit').addClass('disabled');
                    $('.button-submit').attr('disabled', true);
                }
            }
        });
	});
})(jQuery);