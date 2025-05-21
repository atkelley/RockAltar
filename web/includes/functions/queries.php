<?php
  include "includes/config/config.php";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  function get_published_articles() {
    $query = "SELECT articles.id, articles.title, articles.date, articles.image, 
              articles.description, articles.user, users.firstname, users.lastname,
              categories.name AS category, genres.name AS genre
              FROM articles 
              INNER JOIN users ON articles.user = users.id
              INNER JOIN genres ON articles.genre = genres.id
              INNER JOIN categories ON articles.category = categories.id
              WHERE articles.category = 1 
              AND articles.status = 'published'
              ORDER BY articles.date DESC";

    return confirm_query($query);
  }
  

  function get_selected_published_article($id) {
    $query = "SELECT articles.title, articles.date, articles.image, articles.content,
          articles.description, articles.user, users.firstname, users.lastname,
          articles.id 
          FROM articles 
          INNER JOIN users ON articles.user = users.id
          WHERE articles.id = " . $id;

    return confirm_query($query);
  }


  function get_published_articles_by_category($category) {
    $query = "SELECT articles.id, articles.title, articles.date, articles.image, articles.content,
              articles.description, articles.user, users.firstname, users.lastname,
              categories.name AS category, genres.name AS genre
              FROM articles 
              INNER JOIN users ON articles.user = users.id
              INNER JOIN genres ON articles.genre = genres.id
              INNER JOIN categories ON categories.name = '{$category}'
              WHERE articles.status = 'published'
              AND articles.category = categories.id";    
              
    return confirm_query($query);
  }


  function get_published_articles_by_genre($genre) {
    $query = "SELECT articles.id, articles.title, articles.date, articles.image, articles.content,
          articles.description, articles.user, users.firstname, users.lastname,
          categories.name AS category, genres.name AS genre
          FROM articles 
          INNER JOIN users ON articles.user = users.id
          INNER JOIN genres ON genres.name = '{$genre}'
          INNER JOIN categories ON articles.category = categories.id
          WHERE articles.status = 'published'
          AND articles.genre = genres.id";

    return confirm_query($query);
  }


  function get_published_articles_by_author($author) {
    $query = "SELECT articles.id, articles.title, articles.date, articles.image, articles.content,
          articles.description, articles.user, users.firstname, users.lastname,
          categories.name AS category, genres.name AS genre
          FROM articles 
          INNER JOIN users ON articles.user = users.id
          INNER JOIN genres ON articles.genre = genres.id
          INNER JOIN categories ON articles.category = categories.id
          WHERE articles.status = 'published'
          AND articles.user = " . $author;

    return confirm_query($query);
  }


  function username_exists($username){
    $username_query = confirm_query("SELECT username FROM users WHERE username = '$username'");
    return (mysqli_num_rows($username_query) > 0) ? true : false;
  }


  function email_exists($email){   
    $result = confirm_query("SELECT email FROM users WHERE email = '$email'");
    return (mysqli_num_rows($result) > 0) ? true : false;
  }

  
  function get_user_profile($id) {
    $query = "SELECT * FROM users WHERE id = $id";
    $get_user_profile_query = confirm_query($query);
    
    if (!$get_user_profile_query || mysqli_num_rows($get_user_profile_query) === 0) {
      return null; 
    }

    $row = mysqli_fetch_assoc($get_user_profile_query);

    return [
      'id'        => $row['id'],
      'username'  => $row['username'],
      'firstname' => $row['firstname'],
      'lastname'  => $row['lastname'],
      'password'  => $row['password'],
      'email'     => $row['email'],
      'image'     => $row['image'],
      'role'      => $row['role'],
    ];
  }


  function register_user($firstname, $lastname, $username, $email, $password, $image){
    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname  = mysqli_real_escape_string($connection, $lastname);
    $username  = mysqli_real_escape_string($connection, $username);
    $email     = mysqli_real_escape_string($connection, $email);
    $image     = mysqli_real_escape_string($connection, $image);
    $password  = mysqli_real_escape_string($connection, $password);
    $hashed_password  = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 12));
        
    $query = "INSERT INTO users (firstname, lastname, username, email, password, role, image) ";
    $query .= "VALUES('{$firstname}', '{$lastname}', '{$username}','{$email}', '{$hashed_password}', 'subscriber', '{$image}')";
    confirm_query($query);
  }


  function update_user_token($email) {
      global $connection;
      $token = bin2hex(openssl_random_pseudo_bytes(50));

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
          <a href="https://rock-altar-php.fly.dev/reset.php?email=' . $email . '&token=' . $token . ' ">https://rock-altar-php.fly.dev/reset.php?email=' . $email . '&token=' . $token . '</a></p>';

          if($mail->send()){
            return true;
          } else{
            echo 'Mailer Error: ' . $mail->ErrorInfo;
          }
        }
      } 
  }


  function get_approved_comments($id) {
    $query = "SELECT * FROM comments WHERE post_id = " . $id . " AND status = 'approved' ORDER BY date DESC";
    return confirm_query($query);
  }


  function increment_views($id) {
    confirm_query("UPDATE articles SET views = views + 1 WHERE id = '$id'");
  }
?>