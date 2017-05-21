$(document).ready(function(){

//Check email address
$("#email").on('input', function(){
  var email = $(this).val();
  if (email.length > 3) {
    $.ajax({
      url: './Register',
      type: 'POST',
      data: {live: 1, email: email},
      success: function(res) {
        if (res.substr(0,1) === 'D' && email !== '') {
          $('.help-block').css('display','block').text('Email already exist, try another');
        } else {
          $('.help-block').css('display','none').text('');
        }
      },
      error: function() {
        console.log('oops, email error!');
      }
    });
  }
});


//User register
$('#register').on('click', function(event){
  $(this).prop('disabled', true).attr('value', 'wait...');
   
  event.preventDefault();
  
  setTimeout(function() {
    $('#register').prop('disabled', false).attr('value', 'Sign in');
  }, 500);

  var fname = $('#fname').val();
  var lname = $('#lname').val();
  var email = $('#email').val();
  var type = $('input[name=ticket]:checked').val();
  var storage = $('input[name=record]:checked').val();

  var regExp = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
  var error = false;

	// if (error) {
  if (checkData() || type === undefined || storage === undefined) {
    $('.error').fadeOut(100);
    $('.error').fadeIn(100).html(`<span>Error occurred:</span><br>
                  All fields must be filled and ticket type / data storage selected
                  <span class="closeMes" id="close">
                  <i class="fa fa-times" aria-hidden="true"></i>
                  </span>`)
               .css('display','block');
               

    $('#close').on('click', function() {
      $('.error').css('display', 'none');
    });
    
  } else if (!regExp.test(email)) {
		$('form input[type="email"]').removeClass('valid').addClass('invalid');
    $('.error').fadeOut(100);
    $('.error').fadeIn(100).html(`<span>Error occurred:</span><br>
                  Email is invalid
                  <span class="closeMes" id="close">
                  <i class="fa fa-times" aria-hidden="true"></i>
                  </span>`)
               .css('display','block');

    $('#close').on('click', function() {
      $('.error').css('display', 'none');
    });
  } else {
    var dataStr = JSON.stringify($('form').serialize());
    $.ajax({
      url: './Register',
      type: 'POST',
      data: dataStr,
      success: function(res) {
         if (res === 'success') {
            $('.error').fadeOut(100);
            $('form').trigger('reset');
            $(".imgcaptcha").removeAttr("src").attr("src", "captcha/captcha.php");
            $('.register').fadeIn(500)
                          .html(`Your are registered`)
                          .fadeOut(1500);
         } else {
            $('.error').fadeOut(100);
            $('.error').fadeIn(100).html(`<span>Error occurred:</span><br>
                        ${res}
                        <span class="closeMes" id="close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        </span>`)
                .css('display','block');

            $('#close').on('click', function() {
              $('.error').css('display', 'none');
            });
         }
      },
      error: function() {
        console.log('oops, something wrong');
      }
    });
  }
});

//On input validate
$('form input[type="email"]').on('input', function() {
  var regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;      
  var email = $(this).val();
  if (regExp.test(email)) {
    $(this).removeClass('invalid').addClass('valid');
  } else {
    $(this).removeClass('valid').addClass('invalid');
  }
});

$('form input[type="text"]').on('input', function() {
  // var userRegExp = "/^(?=.{2,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
if ($(this).attr('type') == 'text' && $(this).val() == '') {
    $(this).removeClass('valid').addClass('invalid');
  } else {
    $(this).removeClass('invalid').addClass('valid');
  }
});

$('form input[name=ticket]').on('change', function() {
if ($('input[name=ticket]:checked').val() === undefined) {
    $('.ticket').css('color','#b94a48');
  } else {
    $('.ticket').css('color','#333');
  }
});

$('form input[name=record]').on('change', function() {
if ($('input[name=record]:checked').val() === undefined) {
    $('.record').css('color','#b94a48');
  } else {
    $('.record').css('color','#333');
  }
});

function checkData(){
  var error = false;
  $('form input').each(function(i, el) {
    if ( ($(el).attr('type') === 'text' || $(el).attr('type') === 'email') && $(el).val() === '' ) {
     error = true;
      $(el).removeClass('valid').addClass('invalid');
    } else {
      $(el).addClass('valid').removeClass('invalid');
    }
    if ($('input[name=ticket]:checked').val() === undefined) {
      $('.ticket').css('color','#b94a48');
     error = true;
    } else {
      $('.ticket').css('color','#333');
    }
    if ($('input[name=record]:checked').val() === undefined) {
      $('.record').css('color','#b94a48');
     error = true;
    } else {
      $('.record').css('color','#333');
    }
  });
  return error;
}

$('i[class$="refresh"]').on('click', function() {
  $(".imgcaptcha").removeAttr("src").attr("src", "captcha/captcha.php");
});

});