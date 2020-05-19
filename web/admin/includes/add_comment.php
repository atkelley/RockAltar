<?php
  if(isset($_POST['create_comment'])) {
    $post_id = escape($_POST['post_id']);
    $author  = escape($_POST['author']);
    $email   = escape($_POST['email']);
    $content = escape($_POST['content']);
    $status  = escape($_POST['status']);

    $query = "INSERT INTO comments(post_id, author, email, content, status, date) ";        
    $query .= "VALUES({$post_id}, '{$author}', '{$email}', '{$content}', '{$status}', now()) ";    
    $create_comment_query = mysqli_query($connection, $query);  
    confirm_query($create_comment_query);
    $id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>Comment Created. <a href='../comment.php?id={$id}'>View Comment </a> or <a href='comments.php'>Edit More Comments</a></p>";
  } 
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header comment-header'>Add Comment
    <?php if(is_admin($_SESSION['username'])): ?> 
      <span class="form-group pull-right comment-header-dropdown">
        <label for="status">Status:</label>
        <select name="status">   
          <option value="approved">Approved</option>
          <option value="unapproved">Unapproved</option>
        </select>
      </span>
    <?php endif; ?>
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
    <label for="content">Content:</label>
    <textarea class="form-control "name="content" cols="30" rows="5"></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_comment" value="Submit">
  </div>
</form>