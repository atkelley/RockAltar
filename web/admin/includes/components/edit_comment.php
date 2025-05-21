<?php    
  if(isset($_GET['id'])){
    $comment = get_comment($_GET['id']);
  } else {  
    if (isset($_GET['type'])) {
      redirect('index.php?page=article_comments&id=' . $comment['post_id']);
    } else {
      redirect('index.php?page=comments');
    }
  }  

  if(isset($_POST['edit_comment'])) {
    $result = update_comment($_POST, $comment['post_id'], $_GET['id']);

    if ($result) {
      if (isset($_GET['type'])) {
        redirect('index.php?page=article_comments&id=' . $comment['post_id']);
      } else {
        redirect('index.php?page=comments');
      }
    }
  } 
?>

<form method="post">    
  <h1 class='page-header edit-comment-header'>Edit Comment
    <span class="form-group pull-right edit-comment-header-dropdown">
      <label for="status" class="edit-comment-header-label">Status:</label>
      <select name="status" class="form-control" <?php echo (is_admin($_SESSION['username']) || $_SESSION['id'] == $comment['user']) ? "" : "disabled"; ?>>   
        <option selected value="<?php echo $comment['status']; ?>"><?php echo $comment['status']; ?></option>
          <?php
            $option = ($comment['status'] == 'approved') ? "<option value='unapproved'>unapproved</option>" : "<option value='approved'>approved</option>";
            echo $option;
          ?>
      </select>
    </span>
  </h1>

  <div class="form-group">
    <label for="author">Author:</label>
    <input type="text" value="<?php echo $comment['author']; ?>" class="form-control" name="author" required>
  </div>

  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" value="<?php echo $comment['email']; ?>" class="form-control" name="email" required>
  </div>
        
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea cols="30" rows="5" class="form-control" name="content" required><?php echo $comment['content']; ?></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit_comment" value="Update">
    <a class='btn btn-default' href='index.php?page=<?php echo (isset($_GET["type"]) ? "article_comments&id=" . $comment['post_id'] : "comments"); ?>'>Cancel</a>
  </div>
</form>