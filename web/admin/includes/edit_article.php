<?php
  if(isset($_GET['id'])){
    $id =  escape($_GET['id']);
    $query = "SELECT articles.title, articles.date, articles.image, articles.content, articles.status,
              articles.description, articles.category, articles.user, users.firstname, users.lastname,
              articles.name 
              FROM articles 
              INNER JOIN users ON articles.user = users.id
              WHERE articles.id = " . $id;

    $select_article_by_id = mysqli_query($connection, $query);  

    while($row = mysqli_fetch_assoc($select_article_by_id)) {
      $title = $row['title'];
      $user = $row['user'];
      $name = isset($row['name']) ? $row['name'] : "";
      $date = date_create($row['date']);
      $date = date_format($date, "l, F jS, Y");
      $image = $row['image'];
      $status = $row['status'];
      $category = $row['category'];
      $description = $row['description'];
      $content = $row['content'];
    }

    if(isset($_POST['edit_article'])) {
      $name        = $_POST['name'];
      $title       = $_POST['title'];
      $user        = $_POST['user'];
      $image       = $_POST['image'];
      $status      = $_POST['status'];
      $category    = $_POST['category'];
      $description = $_POST['description'];
      $content     = $_POST['content'];
          
      $query = "UPDATE articles SET 
                name        = '{$name}',
                title       = '{$title}', 
                user        = '{$user}', 
                date        = CURDATE(),
                image       = '{$image}',
                status      = '{$status}', 
                category    = '{$category}', 
                description = '{$description}', 
                content     = '{$content}'
                WHERE id    = '{$id}' ";
      $edit_article_query = mysqli_query($connection, $query);
      confirm_query($edit_article_query);
      echo "<div class='bg-success'>Article updated. <a href='../article.php?id={$id}' target='_blank'>View Article</a> or go back to <a href='articles.php'>View All Articles</a></div>";
    }
  } else {
    header("Location: articles.php");
  }
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header edit-article-header'>Edit Article
    <?php if(is_admin($_SESSION['username'])): ?>
      <span class="form-group pull-right edit-article-header-dropdown">
        <label for="status" class="edit-article-header-label">Status:</label>
        <select name="status" class="form-control">
          <option selected value="<?php echo $status; ?>"><?php echo $status; ?></option>
          <?php 
            $option = ($status == 'published' ) ? "<option value='draft'>draft</option>" : "<option value='published'>published</option>";
            echo $option;
          ?>
        </select>
      </span>
    <?php endif; ?>
  </h1>

  <div class="col-md-8">
    <div class="row">
      <div class="form-group">
        <label for="name">Name:</label>
        <input value="<?php echo $name; ?>" type="text" class="form-control" name="name">
      </div>
    </div>

    <div class="row">
      <div class="form-group">
        <label for="image">Image link:</label><br>    
        <input value="<?php echo $image; ?>" type="text" class="form-control" name="image">
      </div>
    </div>

    <div class="row">
      <div class="form-group">
        <label for="user">Author:</label><br>
        <select name="user" class="form-control">  
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
    </div>

    <div class="row">
      <div class="form-group">
        <label for="category">Category:</label><br>
        <select name="category" class="form-control">  
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
    </div>

    <div class="row">
      <div class="form-group">
        <label for="genre">Genre:</label><br>
        <select name="genre" class="form-control">  
          <?php
            $query = "SELECT * FROM genres";
            $select_genres = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_genres)) {
              $id = $row['id'];
              $name = $row['name'];
              $option = ($id == $genre) ? "<option selected value='{$id}'>{$name}</option>" : "<option value='{$id}'>{$name}</option>";
              echo $option;
            }
          ?>
        </select>
      </div>
    </div>
  </div>

  <div class="col-md-4 text-center">
    <label for="image">Image:</label><br>  
    <img class="edit-article-image" src="<?php echo $image; ?>"><br>
  </div>

  <div class="form-group">
    <label for="title">Title:</label>
    <input value="<?php echo $title; ?>"  type="text" class="form-control" name="title">
  </div>

  <div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" name="description" id="body" cols="30" rows="10"><?php echo $description; ?></textarea>
  </div>
    
  <div class="form-group">
    <label for="content">Content:</label>
    <textarea class="form-control" name="content" id="body" cols="30" rows="10"><?php echo $content; ?></textarea>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit_article" value="Update">
    <a class='btn btn-default' href='articles.php'>Cancel</a>
  </div>
</form>