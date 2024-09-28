jQuery(document).ready(function(){

  $(document).on('submit','#sender_info_form', function(e) {
    e.preventDefault();
    $('.wqmessage').html('');
    $('.wqsubmit_message').html('');

    var sender_name = $('#sender_name').val();
    var sender_email = $('#sender_email').val();
    var current_user_id = $('#current_user_id').val();

    if(sender_name=='') {
      $('#sender_name_message').html('Name is Required');
    }
    if(sender_email=='') {
      $('#sender_email_message').html('Email is Required');
    }

    if(sender_name!='' && sender_email!='' && current_user_id!='') {
      var fd = new FormData(this);
      var action = 'wqnew_entry';
      fd.append("action", action);

      $.ajax({
        data: fd,
        type: 'POST',
        url: email_dps_ajax_object.ajaxurl,
        contentType: false,
			  cache: false,
			  processData:false,
        success: function(response) {
          var res = JSON.parse(response);
          $('.wqsubmit_message').html(res.message);
          if(res.rescode!='404') {
            $('#sender_info_form')[0].reset();
            $('.wqsubmit_message').css('color','green');
          } else {
            $('.wqsubmit_message').css('color','red');
          }
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('submit','#sender_edit_form', function(e) {
    e.preventDefault();
    $('.wqmessage').html('');
    $('.wqsubmit_message').html('');

    var sender_name = $('#sender_name').val();
    var sender_email = $('#sender_email').val();
    var current_user_id = $('#current_user_id').val();

    if(sender_name=='') {
      $('#sender_name_message').html('Name is Required');
    }
    if(sender_email=='') {
      $('#sender_email_message').html('Email is Required');
    }

    if(sender_name!='' && sender_email!='' && current_user_id!='') {
      var fd = new FormData(this);
      var action = 'wpedit_entry';
      fd.append("action", action);

      $.ajax({
        data: fd,
        type: 'POST',
        url: email_dps_ajax_object.ajaxurl,
        contentType: false,
			  cache: false,
			  processData:false,
        success: function(response) {
          var res = JSON.parse(response);
          $('.wqsubmit_message').html(res.message);
          if(res.rescode!='404') {
            $('.wqsubmit_message').css('color','green');
          } else {
            $('.wqsubmit_message').css('color','red');
          }
        }
      });
    } else {
      return false;
    }
  });

});
