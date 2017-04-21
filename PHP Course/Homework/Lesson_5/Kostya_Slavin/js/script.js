$(document).ready(function(){

//Check email address
$("#email").on('input', function(){
  var email = $(this).val();
  if (email.length > 3) {
    $.ajax({
      url: 'send.php',
      type: 'POST',
      data: {live: 1, email: email},
      success: function(res) {
        if (res === 'error' && email !== '') {
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
        }, 1500);

  let fname = $('#fname').val();
  let lname = $('#lname').val();
  let email = $('#email').val();
  let type = $('input[name=ticket]:checked').val();

  let  regExp = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

  if (checkData() || type === undefined ) {
    $('.success').fadeOut(100);
    $('.error').html(`<span> Error occurred:</span><br>
                  All fields must be filled and radio button - selected
                  <span class="closeMes" id="close">
                  <i class="fa fa-times" aria-hidden="true"></i>
                  </span>`)
               .css('display','block')
               .delay(5000).fadeOut(500);

    $('#close').on('click', function() {
      $('.error').css('display', 'none');
    });
    
  } else {
    var dataStr = JSON.stringify($('form').serialize());
    $.ajax({
      url: 'send.php',
      type: 'POST',
      data: dataStr,
      success: function(res) {
         if (res === 'success') {
           console.log(res);
            $('.error').fadeOut(100);
            $("form").trigger('reset');
            $('.register').fadeIn(500)
                          .html(`
                            <h2 class="page-header text-center">
                              Your are registered
                            </h2>`)
                          .fadeOut(1500);
         } else {
            $('.success').fadeOut(100);
            $('.error').html(`<span>Error occurred:</span><br>
                        ${res}
                        <span class="closeMes" id="close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        </span>`)
                .css('display','block')
                .delay(5000).fadeOut(500);

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
  let regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;      
  let email = $(this).val();
  if (regExp.test(email)) {
    $(this).removeClass('invalid').addClass('valid');
  } else {
    $(this).removeClass('valid').addClass('invalid');
  }
});

$('form input[type="text"]').on('input', function() {
if ($(this).attr('type') == 'text' && $(this).val() == '') {
    $(this).removeClass('valid').addClass('invalid');
  } else {
    $(this).removeClass('invalid').addClass('valid');
  }
});

$('form input[type="radio"]').on('change', function() {
if ($('input[name=ticket]:checked').val() === undefined) {
    $('.ticket').css('color','#b94a48');
  } else {
    $('.ticket').css('color','#333');
  }
});

function checkData(){
  let error = false;
  $('form input').each(function(i, el) {
    if ( ($(el).attr('type') === 'text' || $(el).attr('type') === 'email') && $(el).val() === '') {
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
  });
  return error;
}

});
