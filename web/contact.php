<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation-special.php"; ?>
 
<?php 
  require '../vendor/autoload.php';

  if(isset($_POST['submit'])) {
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom($_POST['email'], $_POST['name']);
    $email->setSubject($_POST['subject']);
    $email->addTo("kelley.andrew.t@gmail.com", "webmaster");
    $email->addContent("text/plain", $_POST['body']);

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    try {
      $response = $sendgrid->send($email);
      redirect('thank.php');
      // print $response->statusCode() . "\n";
      // print_r($response->headers());
      // print $response->body() . "\n";
    } catch (Exception $e) {
      echo 'Caught exception: '. $e->getMessage() ."\n";
    }
  }
?>
    
<div class="container contact-container">    
  <div class="row">
    <div class="col-xs-6 col-xs-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2 class="text-center contact-title"><strong>Contact</strong></h2>
          <form role="form" action="contact.php" method="post" id="contact-form" autocomplete="off">
            <div class="form-group">
              <label for="name" class="sr-only">Name</label>
              <input type="name" name="name" id="name" class="form-control" placeholder="Enter name" required>
            </div>

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
