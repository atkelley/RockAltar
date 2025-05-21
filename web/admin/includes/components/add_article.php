<?php
  if(isset($_POST['create_article'])) {  
    $result = add_article($_POST);

    if ($result) {
      redirect("index.php?page=articles");
    }
   } 
?>

<form method="post" class="article-form">    
  <h1 class='page-header'>Add Article</h1>

  <div class="form-group">
    <label for="name">Band name: <span class="name-special">(for albums or videos)</span></label>
    <input type="text" class="form-control" name="name">
  </div>

  <div class="form-group">
    <label for="image">Image Link:</label>
    <input type="text" class="form-control" name="image">
  </div>

  <div class="form-group">
    <label for="user">Author:</label>
    <?php if(is_admin($_SESSION['username'])): ?>
    <select name="user" class="form-control"><br>     
      <?php
        $all_users = confirm_query("SELECT * FROM users");
        
        while($row = mysqli_fetch_assoc($all_users)) {
          $username = $row['username'];
          $selected = ($username == $_SESSION['username']) ? " selected" : "";
          echo "<option value='{$row['id']}'{$selected}>" . $row['firstname'] . " " . $row['lastname'] . " ({$username})</option>";
        }
      ?>
    </select>
    <?php else: ?>
      <select name="user" class="form-control"><br>   
        <option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] . " (" . $_SESSION['username'] . ") "; ?></option>
      </select>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label for="category">Category:</label>
    <select name="category" class="form-control"><br>      
      <?php
        $all_categories = confirm_query("SELECT * FROM categories");

        while($row = mysqli_fetch_assoc($all_categories)) {
          echo "<option value='{$row['id']}'>{$row['name']}</option>";  
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="genre">Genre:</label>
    <select name="genre" class="form-control"><br>      
      <?php
        $all_categories = confirm_query("SELECT * FROM genres");

        while($row = mysqli_fetch_assoc($all_categories)) {
          echo "<option value='{$row['id']}'>{$row['name']}</option>";  
        }
      ?>
    </select>
  </div>
      
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control" name="title" required>
  </div>

  <div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" name="description" id="body" cols="30" rows="4" required></textarea>
  </div>
    
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea class="form-control" name="content" id="body" cols="30" rows="4" required></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_article" value="Submit">
    <a class='btn btn-default' href='index.php?page=articles'>Cancel</a>
  </div>
</form>