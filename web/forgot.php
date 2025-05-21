<?php 
  include "includes/config/db.php"; 
  include "includes/layout/header.php";
  include "includes/layout/navigation-special.php";
  include "includes/functions/utilities.php";
  include "includes/functions/queries.php";
  include "includes/functions/auth.php";
  require '../vendor/autoload.php';

  if(!isset($_GET['forgot'])){
    redirect('index');
  }

  if(check_method('post')){
    if(isset($_POST['email'])) {
      $email = $_POST['email'];
      $emailSent = update_user_token($email);
    }
  }
?>

<div class="container forgot-container">
  <div class="row">
    <div class="col-md-5 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="text-center">
            <?php if(isset($email) && !email_exists($email)): ?>
              <h2>Email not found.</h2>
              <h3>Please <a href="registration.php">register</a> to create an account.</h3>
            <?php elseif(!isset($emailSent)): ?>
              <h3><i class="fa fa-lock fa-4x"></i></h3>
              <h2 class="text-center">Forgot Password?</h2>
              <p>You can reset your password here.</p>
              <div class="panel-body">
                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                      <input id="email" name="email" placeholder="email address" class="form-control" type="email" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                  </div>

                  <input type="hidden" class="hide" name="token" id="token" value="">
                </form>
              </div>
            <?php else: ?>
              <h2>Please check your email.</h2>
            <?php endIf; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

