<article class="article">
  <?php
    if(isset($_GET['id'])){
      $selected_article_query = get_selected_published_article($_GET['id']);
      
      while($row = mysqli_fetch_assoc($selected_article_query)) {
        $id = $row['id'];
        increment_views($id);
        $title = $row['title'];
        $author = $row['firstname'] . " " . $row['lastname'];;
        $date = date_create($row['date']);
        $date = date_format($date, "l, F jS, Y");
        $image = $row['image'];
        $description = (strlen($row['description']) > 200) ? substr($row['description'], 0, strpos($row['description'], ' ', 200)) . "..." : $row['description'];
        $content = $row['content'];
        $user = $row['user'];
  ?>
        <h2><?php echo $title ?></h2>
        <p class="lead"> by <a href="index.php?page=author&user=<?php echo $user ?>"><?php echo $author ?></a> on <span class="glyphicon glyphicon-time"></span> <?php echo $date ?></p>
        <img class="img-responsive" src="<?php echo $image;?>" alt="">
        <p><?php echo $content ?></p>
        <hr>         
  <?php } } ?>

  <?php 
    if(isset($_POST['create_comment'])) {
      if (!empty($_POST['comment_author']) && !empty($_POST['comment_email']) && !empty($_POST['comment_content'])) {
        $stmt = $connection->prepare("INSERT INTO comments(`post_id`, `author`, `email`, `content`, `status`, `date`) VALUES (?,?,?,?,?,?)");

        if ($stmt === FALSE) {
          echo "Error: " . mysqli_error($connection);
        } else {
          $id = $_GET['id'];
          $author = $_POST['comment_author'];
          $email = $_POST['comment_email'];
          $content = $_POST['comment_content'];
          $status = 'unapproved';
          date_default_timezone_set('America/New_York');
          $date = date("Y-m-d H:i:s");
          mysqli_stmt_bind_param($stmt, 'isssss', $id, $author, $email, $content, $status, $date);

          if (!$stmt->execute()) {
            die("Query failed: " . mysqli_error($connection));
          } else {
            setcookie("comment_submitted", time(), time() + 3600);
            redirect("index.php?page=article&id={$_GET['id']}#comments");
          }
        }
      }
    }
  ?> 

  <div class="well">
    <h4>Leave a Comment:</h4>
    <?php 
      $author = logged_in() ? $_SESSION['username'] : "";
      $email = logged_in() ? $_SESSION['email'] : "";
    ?>
    <form action="" method="post" role="form">
      <div class="form-group">
        <label for="Author">Author</label>
        <input type="text" name="comment_author" class="form-control" name="comment_author" value="<?php echo $author; ?>" required>
      </div>

      <div class="form-group">
        <label for="Author">Email</label>
        <input type="email" name="comment_email" class="form-control" name="comment_email" value="<?php echo $email; ?>" required>
      </div>

      <div class="form-group">
        <label for="comment">Your Comment</label>
        <textarea name="comment_content" class="form-control" rows="3" required></textarea>
      </div>

      <div class="comment-message-box">
        <?php if (isset($_COOKIE['comment_submitted'])) { ?>
          <p class="comment-message">Success! Your comment has been submitted and is currently awaiting approval.</p>
          <?php setcookie("comment_submitted", "", time() - 3600); ?>
        <?php } ?>
      </div>

      <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <?php 
    $approved_comments = get_approved_comments($_GET['id']);

    if(mysqli_num_rows($approved_comments) < 1) {
      echo "<hr /><h3 class='no-comments'>No comments...yet.</h3>";
    } else {
  ?>
  <hr />
  <div id="comments">
    <?php  
      include './includes/components/comment_card.php'; 
      while ($comment = mysqli_fetch_array($approved_comments)) {
        echo render_comment_card($comment);
      }
    ?>
  </div>
  <?php } ?>
</article>