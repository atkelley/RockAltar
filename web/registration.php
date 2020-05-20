<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation-special.php"; ?>

<?php
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname       = trim($_POST['firstname']);
    $lastname        = trim($_POST['lastname']);
    $username        = trim($_POST['username']);
    $email           = trim($_POST['email']);
    $password        = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    $error = [
      'firstname'       => '',
      'lastname'        => '',
      'username'        => '',
      'email'           => '',
      'password'        => '',
      'confirmPassword' => ''
    ];

    if($firstname == '') {
      $error['firstname'] = 'First name cannot be empty.';
    }

    if($lastname == '') {
      $error['lastname'] = 'Last name cannot be empty.';
    }

    if(strlen($username) < 4) {
      $error['username'] = 'Username must be 4 or more characters long.';
    }

    if($username == ''){
      $error['username'] = 'Username cannot be empty.';
    }

    if(username_exists($username)){
      $error['username'] = 'Username already exists. Please pick another one.';
    }

    if($email =='') {
      $error['email'] = 'Email cannot be empty.';
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error['email'] = 'Email not valid.';
    }

    if(email_exists($email)) {
      $error['email'] = 'Email already exists. Please login <a href="index.php">here</a>.';
    }

    if($password == '') {
      $error['password'] = 'Password cannot be empty.';
    }

    if(strlen($password) < 4) {
      $error['password'] = 'Password must be 4 or more characters long.';
    }

    if($confirmPassword == '') {
      $error['confirmPassword'] = 'Confirm password cannot be empty.';
    }

    if(strlen($confirmPassword) < 4) {
      $error['confirmPassword'] = 'Confirm password must be 4 or more characters long.';
    }

    if($password != $confirmPassword) {
      $error['password']        = 'Passwords do not match.';
      $error['confirmPassword'] = 'Passwords do not match.';
    }

    foreach ($error as $key => $value) {     
      if(empty($value)){
        unset($error[$key]);
      }
    } 

    if(empty($error)){
      $image = "https://www.gravatar.com/avatar/" . hash('md4', strtolower($email)) . "?s=350&d=identicon&r=PG";
      register_user($firstname, $lastname, $username, $email, $password, $image);
      $data['message'] = $username;
      redirect('login.php');
    }
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
              <p class="register-error"><strong><?php echo isset($error['username']) ? $error['username'] : ''; ?></strong></p>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="firstname" class="sr-only">First name</label>
                  <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter first name" autocomplete="on" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
                  <p class="register-error"><strong><?php echo isset($error['firstname']) ? $error['firstname'] : ''; ?></strong></p>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="lastname" class="sr-only">Last name</label>
                  <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter last name" autocomplete="on" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
                  <p class="register-error"><strong><?php echo isset($error['lastname']) ? $error['lastname'] : ''; ?></strong></p>
                </div>
              </div>
            </div>
  
            <div class="form-group">
              <label for="email" class="sr-only">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>" required>
              <p class="register-error"><strong><?php echo isset($error['email']) ? $error['email'] : ''; ?></strong></p>
            </div>

            <div class="form-group">
              <label for="password" class="sr-only">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
              <p class="register-error"><strong><?php echo isset($error['password']) ? $error['password'] : ''; ?></strong></p>
            </div>

            <div class="form-group">
              <label for="confirmPassword" class="sr-only">Confirm password</label>
              <input id="confirmPassword" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control" type="password" required>
              <p class="register-error"><strong><?php echo isset($error['confirmPassword']) ? $error['confirmPassword'] : ''; ?></strong></p>
            </div>
    
            <input type="submit" name="register" class="btn btn-primary btn-lg btn-block register-button" value="Register">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>