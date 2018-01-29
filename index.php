<?php 
 /*
 *  Index page   
 */
  include 'inc/session.php';
  $auth = BookingSession::checkAuth();
  if ( $auth ){
    header('location:users/home.php');
    exit;
  }
  include('layout/header.php');
?>
  <div class="row" style="margin-top:100px;">
    <div class="col-md-4 offset-md-4 border bg-light pb-3 pt-2 rounded">
      <h2 class="text-center text-secondary">Bookings</h2>
      <div id="loginAlert" class="text-center mb-2"></div>
      <form id="loginFrom">
        <div class="form-group row ">
          <div class="col-sm-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
              </div>
              <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email">
            </div>              
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-key" aria-hidden="true"></i></span>
              </div>
              <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password">
            </div>              
          </div>
        </div>
        <button type="button" class="btn btn-info btn-block" id="loginBtn"><strong>Login</strong></button>
      </form>
    </div>
  </div>
<?php include('layout/footer.php'); ?>
    