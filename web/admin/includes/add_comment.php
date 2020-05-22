<?php
  if(isset($_POST['create_comment'])) {
    $post_id = escape($_POST['article']);
    $author  = escape($_POST['author']);
    $email   = escape($_POST['email']);
    $content = escape($_POST['content']);
    $status  = isset($_POST['status']) ? escape($_POST['status']) : "unapproved";

    $query = "INSERT INTO comments(post_id, author, email, content, status, date) ";        
    $query .= "VALUES({$post_id}, '{$author}', '{$email}', '{$content}', '{$status}', NOW()) ";    
    $create_comment_query = mysqli_query($connection, $query);  
    confirm_query($create_comment_query);
    header("Location: comments.php");
  } 
?>

<form method="post">    
  <h1 class='page-header edit-comment-header'>Add Comment
    <span class="form-group pull-right edit-comment-header-dropdown">
      <label for="status" class="edit-comment-header-label">Status:</label>
      <select name="status" class="form-control" <?php echo (is_admin($_SESSION['username'])) ? "" : "disabled"; ?>>   
        <option selected value="unapproved">unapproved</option>
        <option value="approved">approved</option>
      </select>
    </span>
  </h1>

  <div class="form-group">
    <label for="author">Author:</label>
    <input type="text" value="<?php echo ($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" class="form-control" name="author" required>
  </div>

  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" value="<?php echo ($_SESSION['email']) ? $_SESSION['email'] : ''; ?>"  class="form-control" name="email" required>
  </div>

  <div class="form-group">
    <label for="article">Article:</label>
    <select name="article" class="form-control"><br>     
      <?php
        $query = "SELECT * FROM articles WHERE status = 'published'";
        $select_user_articles = mysqli_query($connection, $query);
        confirm_query($select_user_articles); 

        while($row = mysqli_fetch_assoc($select_user_articles)) {
          $id = $row['id'];
          $title = substr($row['title'], 0, 50);
          echo "<option value='{$id}'>{$title}</option>"; 
        }
      ?>
    </select>
  </div>
        
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea class="form-control "name="content" cols="30" rows="5"></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_comment" value="Submit">
    <a class='btn btn-default' href='comments.php'>Cancel</a>
  </div>
</form>