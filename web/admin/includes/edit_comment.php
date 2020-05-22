<?php  
  if(isset($_GET['id'])){
    $id = escape($_GET['id']);
    $query = "SELECT 
              articles.user,
              comments.post_id,
              comments.author,
              comments.email,
              comments.status,
              comments.content
              FROM comments 
              INNER JOIN articles ON comments.post_id = articles.id
              WHERE comments.id = {$id}";
    $select_comment_query = mysqli_query($connection, $query); 
    confirm_query($select_comment_query);

    while($row = mysqli_fetch_assoc($select_comment_query)) {
      $user    = $row['user'];
      $post_id = $row['post_id'];
      $author  = $row['author'];
      $email   = $row['email'];
      $content = $row['content'];
      $status  = $row['status'];
    }

    if(isset($_POST['edit_comment'])) {
      $author  = escape($_POST['author']);
      $email   = escape($_POST['email']);
      $content = escape($_POST['content']);
      $status  = isset($_POST['status']) ? escape($_POST['status']) : $status;

      $query = "UPDATE comments SET 
                post_id  = '{$post_id}',
                author   = '{$author}', 
                email    = '{$email}', 
                content  = '{$content}',
                status = '{$status}',
                date = NOW() 
                WHERE id = '{$id}' ";

      $edit_comment_query = mysqli_query($connection, $query);
      confirm_query($edit_comment_query);
      echo "<div class='bg-success'>Comment updated. <a href='../article.php?id={$post_id}#comments' target='_blank'>View Comment</a> or go back to <a href='comments.php'>View All Comments</a></div>";
    } 
  } else {  
    header("Location: comments.php");
  }  
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header edit-comment-header'>Edit Comment
    <span class="form-group pull-right edit-comment-header-dropdown">
      <label for="status" class="edit-comment-header-label">Status:</label>
      <select name="status" class="form-control" <?php echo (is_admin($_SESSION['username']) || $_SESSION['id'] == $user) ? "" : "disabled"; ?>>   
        <option selected value="<?php echo $status; ?>"><?php echo $status; ?></option>
          <?php
            $option = ($status == 'approved') ? "<option value='unapproved'>unapproved</option>" : "<option value='approved'>approved</option>";
            echo $option;
          ?>
      </select>
    </span>
  </h1>

  <div class="form-group">
    <label for="author">Author:</label>
    <input type="text" value="<?php echo $author; ?>" class="form-control" name="author" required>
  </div>

  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" value="<?php echo $email; ?>" class="form-control" name="email" required>
  </div>
        
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea cols="30" rows="5" class="form-control" name="content" required><?php echo $content; ?></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit_comment" value="Update">
    <a class='btn btn-default' href='comments.php'>Cancel</a>
  </div>
</form>