$(document).ready(function(){

//Check email address
$("#email").on('input', function(){
  var email = $(this).val();  
  if (email.length > 3) {    
    $.ajax({
      url: 'send.php',
      type: 'POST',
      data: {email: email},
      success: function(res) {        
        if (res === 'error') {
          $('.help-block').css('display','block').text('Email already exist');          
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

//Register user
$('#register').on('click', function(event){  
  event.preventDefault();

  let fname = $('#fname').val();
  let lname = $('#lname').val();
  let email = $('#email').val();
  let type = $('input[name=ticket]:checked').val();
  
  let  regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
  if (checkData() || type === undefined || !regExp.test(email)) {    
    $('.success').fadeOut(100);
    $('.error').html(`<span> Error occurred </span><br /> 
                            All fields must be filled and email must be 
                            <span class="closeMes" id="close">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            </span>`)
               .css('display','block')
               .delay(2500).fadeOut(500);

    $('#close').on('click', function() {  
      $('.error').css('display', 'none');    
    });
    
  } else {    
    $.ajax({
      url: 'send.php',
      type: 'POST',
      data: {fname: fname, lname: lname, email: email, type: type},
      success: function(res) {        
         if (res === 'success')  {
            $('.error').fadeOut(100);
            $('.container').css('display','none');            
            $('.context_').html(`
            <div class="well">
            <h2 class="page-header text-center">Your are registered</h2>
              <a href="?do=logout" class="btn btn-large btn-block btn-success">Logout</a>            
            </div>`);
            
         } else {
            $('.success').fadeOut(100);
            $('.error').html(`<span> Error occurred </span><br /> 
                              ${res}
                              <span class="closeMes" id="close">
                              <i class="fa fa-times" aria-hidden="true"></i>
                              </span>`)
                .css('display','block')
                .delay(2500).fadeOut(500);

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


$('form input[name="email"]').on('input', function() {
  let regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;      
  let email = $(this).val();
  

  if (regExp.test(email)) {    
    $(this).removeClass('invalid').addClass('valid');    
  } else {
    $(this).removeClass('valid').addClass('invalid');
  }

});


function checkData(){
  let error = false;
  $('form input').each(function(i, el) {    
    if ( $(el).attr('type') === 'text' && $(el).val() === '') {
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

$('#logout').on('click', function() {
  
});

});


