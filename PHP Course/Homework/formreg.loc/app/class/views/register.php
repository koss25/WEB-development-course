<div class="register"></div>
  <form class="form-signin" method="post" action="" >
    <h2 class="form-signin-heading text-center">Please register</h2>
      <label for="fname" class="sr-only"></label>
        <input type="text" name="fname" id="fname" class="form-control" data-req="required"  placeholder="First name" >
      <label for="lname" class="sr-only"></label>
        <input type="text" name="lname" id="lname" class="form-control" data-req="required"  placeholder="Last name" >
      <label for="email" class="sr-only"></label>
        <input type="email" name="email" id="email" class="form-control" data-req="required"  placeholder="Email (example@gmail.com)" >
      <span  id="error block" class="help-block"></span>
      <br>
      <label class="ticket">Ticket type:</label>
      <div class="radio-inline">
        <label>
          <input type="radio" name="ticket" value="free">
          <i>free</i>
        </label>
      </div>
      <div class="radio-inline">
        <label>
          <input type="radio" name="ticket" value="standart">
          <i>standart</i>
        </label>
      </div>
      <div class="radio-inline">
        <label>
          <input type="radio" name="ticket" value="premium">
          <i>premium</i>
        </label>
      </div>
      <!---->
      <br>
      <label class="record">Data storage:</label>
      <div class="radio-inline">
        <label>
          <input type="radio" name="record" value="db">
          <!--<i>database</i>-->
          <i class="fa fa-database" aria-hidden="true" title="database"></i>
        </label>
      </div>
      <div class="radio-inline">
        <label>
          <input type="radio" name="record" value="file">
          <i class="fa fa-file" aria-hidden="true" title="txt file"></i>
          <!--<i>file</i>-->
        </label>
      </div>
      <div class="radio-inline">
        <label>
          <input type="radio" name="record" value="xml">
          <i class="fa fa-file-excel-o" aria-hidden="true" title="xml file"></i>
          <!--<i>xml</i>-->
        </label>
      </div>
      <!---->
      <br>
      <label for="lname" class="sr-only"></label>
      <input type="text" name="captcha" class="form-control captcha" data-req="required"  placeholder="Enter code">
      <img class="imgcaptcha" src="captcha/captcha.php"> <i class="fa fa-refresh" aria-hidden="true" title="reload image"></i>
      <?php //echo $_SESSION['string']; ?>
      <input type="submit" id="register" class="btn btn-lg btn-primary btn-block" value="Sign in">
  </form>
<div class="success"></div>
<div class="error"></div>
<?php
  ob_end_flush();
?>