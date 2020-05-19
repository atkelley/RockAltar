<?php  
  if(isset($_GET['id'])){
    $id =  escape($_GET['id']);
    $query = "SELECT * FROM comments WHERE id = $id";
    $select_comment_query = mysqli_query($connection, $query);  

    while($row = mysqli_fetch_assoc($select_comment_query)) {
      $post_id = $row['post_id'];
      $author  = $row['author'];
      $email   = $row['email'];
      $content = $row['content'];
      $status  = $row['status'];
    }

    if(isset($_POST['edit'])) {
      $post_id = escape($_POST['post_id']);
      $author  = escape($_POST['author']);
      $email   = escape($_POST['email']);
      $content = escape($_POST['content']);
      $status  = escape($_POST['status']);
      $date    = escape(date('d-m-y'));

      $query = "UPDATE comments SET ";
      $query .= "post_id = '{$post_id}', ";
      $query .= "author = '{$author}', ";
      $query .= "email = '{$email}', ";
      $query .= "content = '{$content}', ";
      $query .= "status = '{$status}', ";
      $query .= "date = '{$date}' ";
      $query .= "WHERE id = {$id} ";
      $edit_comment_query = mysqli_query($connection, $query);
      confirmQuery($edit_comment_query);
      echo "Comment Updated" . " <a href='comments.php'>View Comments?</a>";
    } 
  } else {  
    header("Location: comments.php");
  }  
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header comment-header'>Edit Comment
    <?php if(is_admin($_SESSION['username'])): ?> 
      <span class="form-group pull-right comment-header-dropdown">
        <label for="status">Status:</label>
        <select name="status">   
          <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
            <?php
              $update_status = ($status == 'approved') ? "<option value='unapproved'>unapproved</option>" : "<option value='approved'>approved</option>";
              echo $update_status;
            ?>
        </select>
      </span>
    <?php endif; ?>
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
    <textarea  class="form-control "name="content" id="body" cols="30" rows="5"><?php echo $content; ?></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit" value="Update">
  </div>
</form>