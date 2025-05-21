<?php
  if(isset($_POST['create_comment'])) {
    $result = add_comment($_POST);

    if ($result) {
      if (isset($_GET['id'])){
        redirect("index.php?page=article_comments&id={$_GET['id']}");
      } else {
        redirect("index.php?page=comments");
      }
    }
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
        $select_published_articles = confirm_query("SELECT * FROM articles WHERE status = 'published'");
        while($row = mysqli_fetch_assoc($select_published_articles)) {
          $selected = ($_GET['id'] == $row['id']) ? 'selected' : '';
          echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['title'] . '</option>';
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
    <a class='btn btn-default' href='index.php?page=<?php echo (isset($_GET["type"]) ? "article_comments&id=" . $_GET['id'] : "comments"); ?>'>Cancel</a>
  </div>
</form>