<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?> 
<?php  include "includes/navigation.php"; ?>
    
<div class="container">
  <div class="row">            
    <div class="col-md-8">
      <?php
        if(isset($_GET['id'])){

          $query = "SELECT * FROM articles WHERE id = " . $_GET['id'];
          $select_article_query = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($select_article_query)) {
            $title = $row['title'];
            $author = $row['author'] ? $row['author'] : "Staff Writer";
            $date = date_create($row['date']);
            $date = date_format($date, "l, F dS, Y");
            $image = $row['image'];
            $description = (strlen($row['description']) > 200) ? substr($row['description'], 0, strpos($row['description'], ' ', 200)) . "..." : $row['description'];
            $content = $row['content'];
            $status = $row['status'];


          // $id = $_GET['id'];
          // $update_statement = mysqli_prepare($connection, "UPDATE articles SET views = views + 1 WHERE id = ?");
          // mysqli_stmt_bind_param($update_statement, "i", $id);
          // mysqli_stmt_execute($update_statement);
          // // mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

          // if(!$update_statement) {
          //   die("Query failed." );
          // }

          // if(isset($_SESSION['username']) && is_admin($_SESSION['username']) ) {
          //   $stmt1 = mysqli_prepare($connection, "SELECT title, author, date, image, content FROM articles WHERE id = ?");
          // } else {
          //   $stmt2 = mysqli_prepare($connection , "SELECT title, author, date, image, content FROM articles WHERE id = ? AND status = ? ");
          //   $published = 'published';
          // }

          // if(isset($stmt1)){
          //   mysqli_stmt_bind_param($stmt1, "i", $id);
          //   mysqli_stmt_execute($stmt1);
          //   mysqli_stmt_bind_result($stmt1, $title, $author, $date, $image, $content);
          //   $stmt = $stmt1;
          // } else {
          //   mysqli_stmt_bind_param($stmt2, "is", $id, $published);
          //   mysqli_stmt_execute($stmt2);
          //   mysqli_stmt_bind_result($stmt2, $title, $author, $date, $image, $content);
          //   $stmt = $stmt2;
          // }
          // echo get_object_vars($stmt);
          // while(mysqli_stmt_fetch($stmt)) {
      ?>
            <h1 class="page-header">Posts</h1>
            <h2><?php echo $title ?></h2>
            <p class="lead"> by <a href="index.php"><?php echo $author ?></a> on <span class="glyphicon glyphicon-time"></span> <?php echo $date ?></p>
            <img class="img-responsive" src="<?php echo $image;?>" alt="">
            <p><?php echo $content ?></p>
            <hr>         
    <?php } ?>

      <?php 
        if(isset($_POST['create_comment'])) {
          $the_post_id = $_GET['p_id'];
          $comment_author = $_POST['comment_author'];
          $comment_email = $_POST['comment_email'];
          $comment_content = $_POST['comment_content'];

          if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status,comment_date)";
            $query .= "VALUES ($the_post_id ,'{$comment_author}', '{$comment_email}', '{$comment_content }', 'unapproved',now())";
            $create_comment_query = mysqli_query($connection, $query);

            if (!$create_comment_query) {
              die('QUERY FAILED' . mysqli_error($connection));
            }
          }
        }
      ?> 

      <div class="well">
        <h4>Leave a Comment:</h4>
        <form action="#" method="post" role="form">
          <div class="form-group">
            <label for="Author">Author</label>
            <input type="text" name="comment_author" class="form-control" name="comment_author">
          </div>

          <div class="form-group">
            <label for="Author">Email</label>
            <input type="email" name="comment_email" class="form-control" name="comment_email">
          </div>

          <div class="form-group">
            <label for="comment">Your Comment</label>
            <textarea name="comment_content" class="form-control" rows="3"></textarea>
          </div>
          <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <hr>
                
      <?php 
        $query = "SELECT * FROM comments WHERE comment_post_id = {$id} ";
        $query .= "AND comment_status = 'approved' ";
        $query .= "ORDER BY comment_id DESC ";
        $select_comment_query = mysqli_query($connection, $query);
        if(!$select_comment_query) {
          die('Query Failed' . mysqli_error($connection));
        }
        while ($row = mysqli_fetch_array($select_comment_query)) {
        $comment_date   = $row['comment_date']; 
        $comment_content= $row['comment_content'];
        $comment_author = $row['comment_author'];
      ?>
                
      <div class="media">
        <a class="pull-left" href="#">
          <img class="media-object" src="http://placehold.it/64x64" alt="">
        </a>
        <div class="media-body">
          <h4 class="media-heading"><?php echo $comment_author; ?>
            <small><?php echo $comment_date; ?></small>
          </h4>
          <?php echo $comment_content; ?>
        </div>
      </div>
  <?php } 
      } else {
        header("Location: index.php");
      }
  ?>
    </div>
    
    <?php include "includes/sidebar.php";?>
  </div>
  <hr>
<?php include "includes/footer.php";?>