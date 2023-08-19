<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php
  logged_in_redirect('admin');

  if(check_method('post')){
    if(isset($_POST['username']) && isset($_POST['password'])){
      login_user($_POST['username'], $_POST['password']);
    } else {
      redirect('login.php');
    }
  }
?>

<?php include "includes/navigation-special.php"; ?>

<div class="container login-container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="text-center">
            <h3><i class="fa fa-user fa-4x"></i></h3>
            <h2 class="text-center"><strong>Login</strong></h2>
            <div class="panel-body">
              <form id="login-form" role="form" autocomplete="off" class="form" method="post">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                    <input name="username" type="text" class="form-control" placeholder="Enter Username" required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                    <input name="password" type="password" class="form-control" placeholder="Enter Password" required>
                  </div>
                </div>

                <?php if (isset($_SESSION['error'])) { ?>
                  <p class="form-group-error"><?php echo $_SESSION['error'] ?></p>
                <?php } 
                  unset($_SESSION['error'])
                ?>

                <div class="form-group form-group-login">
                  <input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
                </div>

                <div class="form-group form-group-forgot">
                  <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
