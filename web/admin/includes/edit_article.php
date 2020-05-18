<?php
  if(isset($_GET['id'])){
    $id =  escape($_GET['id']);
  }

  $query = "SELECT articles.title, articles.date, articles.image, articles.content, articles.status,
            articles.description, articles.category, articles.user, users.firstname, users.lastname 
            FROM articles 
            INNER JOIN users ON articles.user = users.id
            WHERE articles.id = " . $id;

  $select_article_by_id = mysqli_query($connection, $query);  

  while($row = mysqli_fetch_assoc($select_article_by_id)) {
    $title = $row['title'];
    $user = $row['user'];
    $date = date_create($row['date']);
    $date = date_format($date, "l, F jS, Y");
    $image = $row['image'];
    $status = $row['status'];
    $category = $row['category'];
    $description = $row['description'];
    $content = $row['content'];
  }

  if(isset($_POST['update_article'])) {
    $title       = $_POST['title'];
    $user        = $_POST['user'];
    $image       = $_POST['image'];
    $status      = $_POST['status'];
    $category    = $_POST['category'];
    $description = $_POST['description'];
    $content     = $_POST['content'];
    $date        = new DateTime();
        
    $query = "UPDATE articles SET 
              title = '{$title}', 
              user = '{$user}', 
              date = $date,
              image  = '{$image}',
              status = '{$status}', 
              category = '{$category}', 
              description = '{$description}', 
              content= '{$content}'
              WHERE id = '{$id}' ";
    $update_article = mysqli_query($connection, $query);
    confirmQuery($update_article);
    echo "<p class='bg-success'>Article Updated. <a href='../article.php?id={$id}'>View Article</a> or <a href='articles.php'>Edit More Articles</a></p>";
  }
?>

<form action="" method="post" enctype="multipart/form-data">    
  <div class="form-group">
    <label for="title">Title:</label>
    <input value="<?php echo $title; ?>"  type="text" class="form-control" name="title">
  </div>

  <div class="form-group">
    <label for="category">Category:</label><br>
    <select name="category">  
      <?php
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_categories)) {
          $id = $row['id'];
          $name = $row['name'];
          $option = ($id == $category) ? "<option selected value='{$id}'>{$name}</option>" : "<option value='{$id}'>{$name}</option>";
          echo $option;
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="user">Author:</label><br>
    <select name="user">  
      <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_users)) {
          $id = $row['id'];
          $author = $row['firstname'] . " " . $row['lastname'];
          $option = ($id == $user) ? "<option selected value='{$id}'>{$author} (". $row['username'] . ")</option>" : "<option value='{$id}'>{$author} (". $row['username'] . ")</option>";
          echo $option;  
        }
      ?>
    </select>
  </div>
      
  <div class="form-group">
    <label for="status">Status:</label><br>
    <select name="status" id="">      
      <option value='<?php echo $status ?>'><?php echo $status; ?></option>
      <?php
        $other = ($status == 'published' ) ? "<option value='draft'>draft</option>" : "<option value='published'>published</option>";
        echo $other;
      ?>
    </select>
  </div>

  <div class="form-group">
    <img width="100" src="<?php echo $image; ?>" alt=""><br>
    <label for="image">Image:</label><br>    
    <input type="text" name="image">
  </div>

  <div class="form-group">
    <label for="description">Description:</label>
    <textarea  class="form-control "name="description" id="body" cols="30" rows="10"><?php echo $description; ?></textarea>
  </div>
    
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea  class="form-control "name="content" id="body" cols="30" rows="10"><?php echo $content; ?></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_article" value="Update">
  </div>
</form>