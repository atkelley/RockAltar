<?php
  if(isset($_GET['id'])){
    $id =  escape($_GET['id']);
    $article = get_article($id);
  } else {  
    redirect("index.php?page=articles");
  }  

  if(isset($_POST['edit_article'])) {
    $result = update_article($_POST, $_GET['id']);

    if ($result) {
      redirect("index.php?page=articles");
    }
  } 
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header edit-article-header'>Edit Article
    <span class="form-group pull-right edit-article-header-dropdown">
      <label for="status" class="edit-article-header-label">Status:</label>
      <select name="status" class="form-control" <?php echo (is_admin($_SESSION['username']) || $_SESSION['id'] == $article['user']) ? "" : "disabled"; ?>> 
        <option selected value="<?php echo $article['status']; ?>"><?php echo $article['status']; ?></option>
        <?php 
          $option = ($article['status'] == 'published' ) ? "<option value='draft'>draft</option>" : "<option value='published'>published</option>";
          echo $option;
        ?>
      </select>
    </span>
  </h1>

  <div class="col-md-8">
    <div class="row">
      <div class="form-group">
        <label for="name">Band name: <span class="name-special">(for albums or videos)</span></label>
        <input value="<?php echo $article['name']; ?>" type="text" class="form-control" name="name">
      </div>
    </div>

    <div class="row">
      <div class="form-group">
        <label for="image">Image link:</label><br>    
        <input value="<?php echo $article['image']; ?>" type="text" class="form-control" name="image">
      </div>
    </div>

    <div class="row">
      <div class="form-group">
        <label for="user">Author:</label><br>
        <select name="user" class="form-control">  
          <?php
            $all_users = confirm_query("SELECT * FROM users");

            while($row = mysqli_fetch_assoc($all_users)) {
              $id = $row['id'];
              $selected = ($id == $article['user']) ? " selected" : "";
              echo "<option value='{$id}'{$selected}>" . $row['firstname'] . " " . $row['lastname'] . " ({$row['username']})</option>";
            }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="form-group">
        <label for="category">Category:</label><br>
        <select name="category" class="form-control">  
          <?php
            $all_categories = confirm_query("SELECT * FROM categories");

            while($row = mysqli_fetch_assoc($all_categories)) {
              $id = $row['id'];
              $selected = ($id == $article['category']) ? " selected" : "";
              echo "<option value='{$id}'{$selected}>{$row['name']}</option>";
            }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="form-group">
        <label for="genre">Genre:</label><br>
        <select name="genre" class="form-control">  
          <?php
            $all_genres = confirm_query("SELECT * FROM genres");

            while($row = mysqli_fetch_assoc($all_genres)) {
              $id = $row['id'];
              $selected = ($id == $article['genre']) ? " selected" : "";
              echo "<option value='{$id}'{$selected}>{$row['name']}</option>";
            }
          ?>
        </select>
      </div>
    </div>
  </div>

  <div class="col-md-4 text-center">
    <label for="image">Image:</label><br>  
    <img class="edit-article-image" src="<?php echo $article['image']; ?>"><br>
  </div>

  <div class="form-group">
    <label for="title">Title:</label>
    <input value="<?php echo $article['title']; ?>" type="text" class="form-control" name="title" required>
  </div>

  <div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" name="description" id="body" cols="30" rows="4" required><?php echo $article['description']; ?></textarea>
  </div>
    
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea class="form-control" name="content" id="body" cols="30" rows="4" required><?php echo $article['content']; ?></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit_article" value="Update">
    <a class='btn btn-default' href='/admin/index.php?page=articles'>Cancel</a>
  </div>
</form>