jQuery(document).ready( function($){

  if( sms_params && sms_params.sms == true ) {
    window.location.replace( sms_params.smsurl );
  }

});
