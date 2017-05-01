
  <form class="form-signin" method="post" action="" >
    <h2 class="form-signin-heading text-center">Register</h2>
      <label for="fname" class="sr-only">First name</label>
        <input type="text" name="fname" id="fname" class="form-control" data-req="required"  placeholder="First name" >
      <label for="lname" class="sr-only">Last name</label>
        <input type="text" name="lname" id="lname" class="form-control" data-req="required"  placeholder="Last name" >
      <label for="email" class="sr-only">Email</label>
        <input type="email" name="email" id="email" class="form-control" data-req="required"  placeholder="Email (example@gmail.com)" >
      <span  id="error block" class="help-block"></span>
      <br>
      <label class="ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Ticket type:</label>
      <div class="radio-inline">
        <label>
          <input type="radio" name="ticket" value="free">free
        </label>
      </div>
      <div class="radio-inline">
        <label>
          <input type="radio" name="ticket" value="standart">standart
        </label>
      </div>
      <div class="radio-inline">
        <label>
          <input type="radio" name="ticket" value="premium">premium
        </label>
      </div>
      <input type="submit" id="register" class="btn btn-lg btn-primary btn-block" value="Sign in">
  </form>

<div class="register"></div>
<div class="success"></div>
<div class="error"></div>