<?php
  if(isset($_GET['id'])){
    $id =  escape($_GET['id']);
  }

  $query = "SELECT * FROM articles WHERE id = $id  ";
  $select_articles_by_id = mysqli_query($connection,$query);  

  while($row = mysqli_fetch_assoc($select_articles_by_id)) {
    $id            = $row['id'];
    $user          = $row['user'];
    $title         = $row['title'];
    $category   = $row['category'];
    $status        = $row['status'];
    $image         = $row['image'];
    $content       = $row['content'];
    $comments = $row['comments'];
    $date          = $row['date'];
  }

  if(isset($_POST['update_article'])) {
    $user           =  escape($_POST['user']);
    $title          =  escape($_POST['title']);
    $category    =  escape($_POST['category']);
    $status         =  escape($_POST['status']);
    $image          =  escape($_FILES['image']['name']);
    $image_temp     =  escape($_FILES['image']['tmp_name']);
    $content        =  escape($_POST['content']);
        
    move_uploaded_file($image_temp, "../images/$image"); 
        
    if(empty($image)) {
      $query = "SELECT * FROM articles WHERE id = $id ";
      $select_image = mysqli_query($connection, $query);  

      while($row = mysqli_fetch_array($select_image)) {    
          $image = $row['image'];
      }      
    }
        
    $title = mysqli_real_escape_string($connection, $title);
    $query = "UPDATE articles SET ";
    $query .="title  = '{$title}', ";
    $query .="category = '{$category}', ";
    $query .="date   =  now(), ";
    $query .="user = '{$user}', ";
    $query .="status = '{$status}', ";
    $query .="content= '{$content}', ";
    $query .="image  = '{$image}' ";
    $query .= "WHERE id = {$id} ";
    $update_article = mysqli_query($connection, $query);
    confirmQuery($update_article);
    echo "<p class='bg-success'>Article Updated. <a href='../article.php?id={$id}'>View Article</a> or <a href='articles.php'>Edit More Articles</a></p>";
  }
?>

<form action="" method="post" enctype="multipart/form-data">    
  <div class="form-group">
    <label for="title">Article Title</label>
    <input value="<?php echo htmlspecialchars(stripslashes($title)); ?>"  type="text" class="form-control" name="title">
  </div>

  <div class="form-group">
    <label for="categories">Categories</label>
    <select name="category" id="">  
      <?php
        $query = "SELECT * FROM categories ";
        $select_categories = mysqli_query($connection, $query);
        confirmQuery($select_categories);

        while($row = mysqli_fetch_assoc($select_categories )) {
          $id = $row['id'];
          $name = $row['name'];

          if($id == $category) {
            echo "<option selected value='{$id}'>{$name}</option>";
          } else {
            echo "<option value='{$id}'>{$name}</option>";
          }  
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="users">Users</label>
    <select name="post_user" id="">
      <?php echo "<option value='{$user}'>{$user}</option>"; ?>       
      <?php
        $users_query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $users_query);
        confirmQuery($select_users);

        while($row = mysqli_fetch_assoc($select_users)) {
          $id = $row['id'];
          $username = $row['username'];
          echo "<option value='{$username}'>{$username}</option>";   
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="title">Article Author</label>
    <input value="<?php// echo $user; ?>" type="text" class="form-control" name="user">
  </div>
      
  <div class="form-group">
    <select name="status" id="">      
      <option value='<?php echo $status ?>'><?php echo $status; ?></option>
        <?php
          if($status == 'published' ) { 
            echo "<option value='draft'>Draft</option>";
          } else {
            echo "<option value='published'>Publish</option>";
          }   
        ?>
    </select>
  </div>

  <div class="form-group">
    <img width="100" src="../images/<?php echo $image; ?>" alt="">
    <input  type="file" name="image">
  </div>
    
  <div class="form-group">
    <label for="content">Article Content</label>
    <textarea  class="form-control "name="content" id="body" cols="30" rows="10"><?php echo $content; ?></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_post" value="Update Article">
  </div>
</form>