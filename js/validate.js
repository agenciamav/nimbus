validateState = false;

/* Required message */
validateRequiredMsg = "campo de preechimento obrigat&oacute;rio";
validateMinMsg 		= "A quantidade m&iacute;nima de caracters &eacute;: ";
validateMaxMsg 		= "A quantidade m&aacute;xima de caracters &eacute;: ";
validateNumericMsg 	= "O valor deve ser n&uacute;merico";
validateMailMsg		= "E-mail informado &eacute; inv&aacute;lido";

function validateMessage(form_id)
{
    $('#'+form_id+' :input').each(function(){
        /* required */
        if ( $(this).hasClass('required') && $.trim( $(this).val() ) == ""){
            $(this).addClass('invalid');
            $(this).focus();
			$('#validateMessage').html($(this).attr('rel') + validateRequiredMsg);
            validateState = false; 
            return false;
        }
        else{
			 $('#validateMessage').html('');
            $(this).removeClass('invalid');
            validateState = true;
        }
		
         /* numeric value */
        if ( $(this).hasClass('required') && $(this).hasClass('numeric') ){
            var nan = new RegExp(/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/);
            if (!nan.test($.trim( $(this).val() ))){
                $(this).addClass('invalid');
                $(this).focus();
                $('#validateMessage').html(validateNumericMsg);
                validateState = false;
                return false;
            }
            else{
                $('#validateMessage').html('');
                $(this).removeClass('invalid');
                validateState = true;
            }
        }
		
        /* mail */
        if ( $(this).hasClass('email') ){
            var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
            if (!er.test($.trim( $(this).val() ))){
                 $(this).addClass('invalid');
                 $(this).focus();
				 $('#validateMessage').html(validateMailMsg);
                 validateState = false;
                 return false;
            }
            else{
                $(this).removeClass('invalid');
                validateState = true;
            }
        } 

        /* min value */
        if ( $(this).attr('min') && $(this).hasClass('required') ){
            if($.trim($(this).val()).length < $(this).attr('min') ){
                $(this).addClass('invalid');
                $(this).focus();
                $('#validateMessage').html(validateMinMsg + $(this).attr('min'));
                validateState = false;
                return false;
            }
            else{
                $('#validateMessage').html('');
                $(this).removeClass('invalid');
                validateState = true;
            }
        }
    });
}
