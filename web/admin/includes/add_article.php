<?php
  if(isset($_POST['create_article'])) {
    $title        = escape($_POST['title']);
    $user         = escape($_POST['user']);
    $category     = escape($_POST['category']);
    $status       = escape($_POST['status']);
    $image        = $_POST['image'];
    // $image        = escape($_FILES['image']['name']);
    // $image_temp   = escape($_FILES['image']['tmp_name']);
    $content      = escape($_POST['content']);
    $date         = escape(date('d-m-y'));

    move_uploaded_file($image_temp, "../images/$image");
    $query = "INSERT INTO articles(category, title, user, date, image, content, status) ";        
    $query .= "VALUES({$category}, '{$title}', '{$user}', now(), '{$image}', '{$content}', {$status}') ";    
    $create_article_query = mysqli_query($connection, $query);  
    confirmQuery($create_post_query);
    $id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>Post Created. <a href='../article.php?id={$id}'>View Post </a> or <a href='articles.php'>Edit More Articles</a></p>";
  }
?>

<form method="post">    
  <h1 class='page-header'>Add Article</h1>
  <div class="form-group">
    <label for="title">Article Title</label>
    <input type="text" class="form-control" name="title">
  </div>

  <div class="form-group">
    <label for="category">Category</label>
    <select name="category" id="">       
      <?php
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);
        // confirmQuery($select_categories);

        while($row = mysqli_fetch_assoc($select_categories)) {
          $cat_id = $row['id'];
          $cat_name = $row['name'];
          echo "<option value='$cat_id'>{$cat_name}</option>";  
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="users">Users</label>
    <select name="user" id="">        
      <?php
        $users_query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $users_query);
        // confirmQuery($select_users);

        while($row = mysqli_fetch_assoc($select_users)) {
          $user_id = $row['id'];
          $username = $row['username'];
          echo "<option value='{$user_id}'>{$username}</option>"; 
        }
      ?>
    </select>
  </div>
      
  <div class="form-group">
    <select name="status" id="">
      <option value="draft">Article Status</option>
      <option value="published">Published</option>
      <option value="draft">Draft</option>
    </select>
  </div>
      
  <div class="form-group">
    <label for="image">Post Image</label>
    <input type="file" class="form-control" name="image">
  </div>
      
  <div class="form-group">
    <label for="content">Article Content</label>
    <textarea class="form-control "name="content" id="body" cols="30" rows="10">
    </textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_article" value="Submit">
  </div>
</form>