<?php
  if(isset($_POST['create_article'])) {
    $title       = escape($_POST['title']);
    $user        = escape($_POST['user']);
    $name        = escape($_POST['name']);
    $category    = escape($_POST['category']);
    $genre       = escape($_POST['genre']);
    $image       = escape($_POST['image']);
    $content     = escape($_POST['content']);
    $description = escape($_POST['description']);

    $query = "INSERT INTO articles(category, genre, title, user, name, date, image, content, status, description, views, comments) ";        
    $query .= "VALUES({$category}, {$genre}, '{$title}', {$user}, '{$name}', CURDATE(), '{$image}', '{$content}', 'draft', '{$description}', 0, 0)";    
    $create_article_query = mysqli_query($connection, $query);  
    confirm_query($create_article_query);
    header("Location: articles.php");
  }
?>

<form method="post">    
  <h1 class='page-header'>Add Article</h1>

  <div class="form-group">
    <label for="name">Name:</label>
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
          $query = "SELECT * FROM users";
          $select_users = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($select_users)) {
            $id = $row['id'];
            $username = $row['username'];
            $author = $row['firstname'] . " " . $row['lastname'];
            $option = ($username == $_SESSION['username']) ? "<option selected value='{$id}'>{$author} (". $row['username'] . ")</option>" : "<option value='{$id}'>{$author} (". $row['username'] . ")</option>";
            echo $option;  
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
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);
        confirm_query($select_categories);

        while($row = mysqli_fetch_assoc($select_categories)) {
          $id = $row['id'];
          $name = $row['name'];
          echo "<option value='$id'>{$name}</option>";  
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="genre">Genre:</label>
    <select name="genre" class="form-control"><br>      
      <?php
        $query = "SELECT * FROM genres";
        $select_genres = mysqli_query($connection, $query);
        confirm_query($select_genres);

        while($row = mysqli_fetch_assoc($select_genres)) {
          $id = $row['id'];
          $name = $row['name'];
          echo "<option value='$id'>{$name}</option>";  
        }
      ?>
    </select>
  </div>
      
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control" name="title">
  </div>

  <div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" name="description" id="body" cols="30" rows="10"></textarea>
  </div>
    
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea class="form-control" name="content" id="body" cols="30" rows="10"></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_article" value="Submit">
    <a class='btn btn-default' href='articles.php'>Cancel</a>
  </div>
</form>