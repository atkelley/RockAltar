<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation-special.php"; ?>

<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require 'classes/Config.php';
  require '../vendor/autoload.php';

  if(!isset($_GET['forgot'])){
    redirect('index');
  }

  if(check_method('post')){
    if(isset($_POST['email'])) {
      $email = $_POST['email'];
      $length = 50;
      $token = bin2hex(openssl_random_pseudo_bytes($length));

      if(email_exists($email)){
        if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE email= ?")){
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);

          $mail = new PHPMailer(true);
          $mail->isSMTP();
          $mail->Host = Config::SMTP_HOST;
          $mail->Username = Config::SMTP_USER;
          $mail->Password = Config::SMTP_PASSWORD;
          $mail->Port = Config::SMTP_PORT;
          $mail->SMTPSecure = 'tls';
          $mail->SMTPAuth = true;
          $mail->isHTML(true);
          $mail->CharSet = 'UTF-8';

          $mail->setFrom('info@rockaltar.com', 'Rock Altar Notification');
          $mail->addAddress($email);
          $mail->Subject = 'Reset Your Rock Altar Password';
          $mail->Body = '<br><p>Please click to reset your password:<br><br> 
          <a href="http://rock-altar-php-project.herokuapp.com/reset.php?email=' . $email . '&token=' . $token . ' ">http://rock-altar-php-project.herokuapp.com/reset.php?email=' . $email . '&token=' . $token . '</a></p>';

          if($mail->send()){
            $emailSent = true;
          } else{
            echo 'Mailer Error: ' . $mail->ErrorInfo;
          }
        }
      } 
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

