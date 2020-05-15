<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation-special.php"; ?>
 
<?php 
  require '../vendor/autoload.php';

  if(isset($_POST['submit'])) {
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom("test@example.com", "Example User");
    $email->setSubject("Sending with SendGrid is Fun");
    $email->addTo("test@example.com", "Example User");
    $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $email->addContent(
        "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
    );
    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }

    // $from = new SendGrid\Email(null, $_POST['email']);
    // $subject = $_POST['subject'];
    // $to = new SendGrid\Email(null, "kelley.andrew.t@gmail.com");
    // $content = new SendGrid\Content("text/plain", $_POST['body']);
    // $mail = new SendGrid\Mail($from, $subject, $to, $content);

    // $apiKey = getenv('SENDGRID_API_KEY');
    // $sg = new \SendGrid($apiKey);

    // $response = $sg->client->mail()->send()->post($mail);
    // echo $response->statusCode();
    // echo $response->headers();
    // echo $response->body();
    // redirect('thank.php');
  }
?>
    
<div class="container contact-container">    
  <div class="row">
    <div class="col-xs-6 col-xs-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2 class="text-center contact-title"><strong>Contact</strong></h2>
          <form role="form" action="" method="post" id="login-form" autocomplete="off">
            <div class="form-group">
              <label for="email" class="sr-only">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
              <label for="subject" class="sr-only">Subject</label>
              <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject">
            </div>

            <div class="form-group">
              <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
            </div>
      
            <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block contact-button" value="Submit">
          </form>
      </div>
    </div>
  </div>
</div>
