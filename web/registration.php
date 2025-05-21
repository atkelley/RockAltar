<?php 
  include "includes/config/db.php"; 
  include "includes/layout/header.php";
  include "includes/layout/navigation-special.php";
  include "includes/functions/utilities.php";
  include "includes/functions/queries.php";
  include "includes/functions/auth.php";
  require '../vendor/autoload.php';

  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = validate_registration(
      trim($_POST['firstname']), 
      trim($_POST['lastname']), 
      trim($_POST['username']), 
      trim($_POST['email']), 
      trim($_POST['password']), 
      trim($_POST['confirm_password'])
    );
  } 
?>
    
<div class="container register-container">
  <div class="row">
    <div class="col-xs-6 col-xs-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2 class="text-center register-title"><strong>Register</strong></h2>
          <form role="form" action="registration.php" method="post" id="register-form" autocomplete="off">
            <div class="form-group">
              <label for="username" class="sr-only">Username</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>" required>
              <p class="register-error"><strong><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></strong></p>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="firstname" class="sr-only">First name</label>
                  <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter first name" autocomplete="on" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
                  <p class="register-error"><strong><?php echo isset($errors['firstname']) ? $errors['firstname'] : ''; ?></strong></p>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="lastname" class="sr-only">Last name</label>
                  <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter last name" autocomplete="on" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
                  <p class="register-error"><strong><?php echo isset($errors['lastname']) ? $errors['lastname'] : ''; ?></strong></p>
                </div>
              </div>
            </div>
  
            <div class="form-group">
              <label for="email" class="sr-only">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>" required>
              <p class="register-error"><strong><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></strong></p>
            </div>

            <div class="form-group">
              <label for="password" class="sr-only">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
              <p class="register-error"><strong><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></strong></p>
            </div>

            <div class="form-group">
              <label for="confirm_password" class="sr-only">Confirm password</label>
              <input id="confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm password" class="form-control" type="password" required>
              <p class="register-error"><strong><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></strong></p>
            </div>
    
            <input type="submit" name="register" class="btn btn-primary btn-lg btn-block register-button" value="Register">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>