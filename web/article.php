<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?> 
<?php  include "includes/navigation.php"; ?>
    
<div class="container">
  <div class="row">            
    <div class="col-md-8">
      <?php
        if(isset($_GET['id'])){
          $query = "SELECT articles.title, articles.date, articles.image, articles.content,
                    articles.description, articles.user, users.firstname, users.lastname,
                    articles.id 
                    FROM articles 
                    INNER JOIN users ON articles.user = users.id
                    WHERE articles.id = " . $_GET['id'];

          $select_article_query = mysqli_query($connection, $query);
          confirm_query($select_article_query);

          while($row = mysqli_fetch_assoc($select_article_query)) {
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
            <p class="lead"> by <a href="author.php?user=<?php echo $user ?>"><?php echo $author ?></a> on <span class="glyphicon glyphicon-time"></span> <?php echo $date ?></p>
            <img class="img-responsive" src="<?php echo $image;?>" alt="">
            <p><?php echo $content ?></p>
            <hr>         
    <?php } ?>

      <?php 
        if(isset($_POST['create_comment'])) {
          if (!empty($_POST['comment_author']) && !empty($_POST['comment_email']) && !empty($_POST['comment_content'])) {
            // $query = "INSERT INTO comments (
            //             post_id, 
            //             author, 
            //             email, 
            //             content, 
            //             status
            //           ) VALUES (
            //             '{$_GET['id']}' ,
            //             '{$_POST['comment_author']}', 
            //             '{$_POST['comment_email']}', 
            //             '{$_POST['comment_content']}', 
            //             'unapproved'
            //           )";
            // $create_comment_query = mysqli_query($connection, $query);

            $stmt = $connection->prepare("INSERT INTO comments(post_id, author, email, content, status) VALUES (?,?,?,?,?)");

            if ($stmt === FALSE) {
              echo "Error: " . mysqli_error($connection);
            } else {
              // $id = $_GET['id'];
              // $author = $_POST['comment_author'];
              // $email = $_POST['comment_email'];
              // $content = $_POST['comment_content'];
              // $status = 'unapproved';
              mysqli_stmt_bind_param($stmt, 'issss', $_GET['id'], $_POST['comment_author'], $_POST['comment_email'], $_POST['comment_comment'], 'unapproved');

              if (!$stmt->execute()) {
                die("Query failed: " . mysqli_error($connection));
              } else {
                header("Location: article.php?id={$_GET['id']}#comments");
              }
            }
          }
        }
      ?> 

      <div class="well">
        <h4>Leave a Comment:</h4>
        <?php 
          $author = "";
          $email = "";
          if (logged_in()) {
            $author = $_SESSION['username'];
            $email = $_SESSION['email'];
          } 
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
          <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <hr>

      <div id="comments">
        <?php 
          $query = "SELECT * FROM comments WHERE post_id = " . $_GET['id'] . " AND status = 'approved' ORDER BY date ASC";
          $select_approved_comments_query = mysqli_query($connection, $query);
          
          if(!$select_approved_comments_query) {
            die("Query Failed: " . mysqli_error($connection));
          }

          while ($row = mysqli_fetch_array($select_approved_comments_query)) {
            $comment_date = date("D, F dS, Y", strtotime($row['date']));
            $comment_time = date('h:i A', strtotime($row['date']));
            $comment_content= $row['content'];
            $comment_author = $row['author'];
        ?>
                
        <div class="media">
          <a class="pull-left" href="#">
            <img class="media-object" src="https://www.gravatar.com/avatar/<?php echo hash('md4', $row['email']); ?>?s=32&d=identicon&r=PG" alt="gravatar">
          </a>
          <div class="media-body">
            <h4 class="media-heading"><?php echo $comment_author; ?>
              <small><?php echo $comment_date; ?> at <?php echo $comment_time; ?></small>
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
    </div>    
    <?php include "includes/sidebar.php";?>
  </div>

  <?php include "includes/footer.php";?>