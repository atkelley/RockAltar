<?php
  include("delete_modal.php");
  include("reset_modal.php");

  if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $postValueId ){ 
      $bulk_options = $_POST['bulk_options'];
        
      switch($bulk_options) {
        case 'published':   
          $query = "UPDATE articles SET status = '{$bulk_options}' WHERE id = {$postValueId}  ";    
          $update_to_published_status = mysqli_query($connection, $query);  
          confirm_query($update_to_published_status);   
          break;
        case 'draft':
          $query = "UPDATE articles SET status = '{$bulk_options}' WHERE id = {$postValueId}  ";     
          $update_to_draft_status = mysqli_query($connection, $query);  
          confirm_query($update_to_draft_status);     
          break;
        case 'delete':
          $query = "DELETE FROM articles WHERE id = {$postValueId}  ";  
          $update_to_delete_status = mysqli_query($connection, $query);   
          confirm_query($update_to_delete_status);  
          break;
        case 'copy':
          $query = "SELECT * FROM articles WHERE id = '{$postValueId}' ";
          $copy_article_query = mysqli_query($connection, $query);

          while ($row = mysqli_fetch_array($copy_article_query)) {
            $title       = $row['title'];
            $category    = $row['category'];
            $genre       = $row['genre'];
            $description = $row['description'];
            $name        = $row['name'];
            $user        = $row['user'];
            $status      = $row['status'];
            $image       = $row['image'] ; 
            $content     = $row['content'];
          }
 
          $query = "INSERT INTO articles (category, title, user, date, image, content, status, genre, description) ";
          $query .= "VALUES({$category}, '{$title}', '{$user}', CURDATE(), '{$image}', '{$content}', '{$status}', '{$genre}', '{$description}') "; 
          $copy_query = mysqli_query($connection, $query);   
          confirm_query($copy_query); 
          break;
      }
    } 
  }
?>

<form method='post'>
  <h1 class='page-header'>View All Articles (<?php get_rows_count('articles'); ?>)</h1>
  <table class="table table-bordered table-hover">
    <div id="bulkOptionContainer" class="col-xs-4">
      <select class="form-control" name="bulk_options">
        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="copy">Copy</option>
      </select>
    </div> 
          
    <div class="col-xs-4">
      <input type="submit" name="submit" class="btn btn-success" value="Apply" <?php echo (!is_admin($_SESSION['username'])) ? "disabled" : "" ?>>
      <a class="btn btn-primary" href="articles.php?source=add">Add New</a>
    </div>
    <br><br>
                
    <thead>
      <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>User</th>
        <th>Title</th>
        <th>Genre</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Comments</th>
        <th>Views</th>
        <th>Date</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>          
    <tbody>
      <?php 
        $query = "SELECT articles.id, articles.title, articles.date, 
                  articles.image, articles.user, users.firstname, users.lastname, 
                  articles.status, articles.views, 
                  (SELECT COUNT(id) FROM comments WHERE articles.id = comments.post_id) AS comments,
                  categories.name AS category, genres.name AS genre
                  FROM articles 
                  INNER JOIN users ON articles.user = users.id
                  INNER JOIN genres ON articles.genre = genres.id
                  INNER JOIN categories ON articles.category = categories.id
                  ORDER BY articles.date DESC";

        $select_articles = mysqli_query($connection, $query);  
        confirm_query($select_articles);

        while($row = mysqli_fetch_assoc($select_articles)) {
          $id       = $row['id'];
          $user     = $row['user'];
          $author   = $row['firstname'] . " " . $row['lastname'];
          $title    = $row['title'];
          $category = $row['category'];
          $genre    = $row['genre'];
          $status   = $row['status'];
          $image    = $row['image'];
          $comments = $row['comments'];
          $date     = date_create($row['date']);
          $date     = date_format($date, "F jS, Y");
          $views    = $row['views'];

          echo "<tr>";
          ?><td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $id; ?>'></td><?php
          echo "<td><a href='../author.php?user={$user}'>$author</td>";
          echo "<td><a href='../article.php?id={$id}'>" . substr($title, 0, 50) . "...</a></td>";
          echo "<td><a href='../genre.php?genre=" . strtolower($genre) . "'>$genre</a></td>";
          echo "<td><a href='../category.php?category=" . strtolower($category) . "'>$category</a></td>";
          echo "<td>$status</td>";
          echo "<td><img width='100' src='$image' alt='image'></td>";
          echo ($comments > 0) ? "<td><a href='article_comments.php?id=$id'>$comments</a></td>" : "<td>$comments</td>";
          echo "<td><a rel='$id' href='javascript:void(0)' class='btn btn-default reset_link'" . ((!is_admin($_SESSION['username']) && $_SESSION['id'] != $user) ? "disabled" : "") . ">{$views}</a></td>";
          echo "<td>$date</td>";
          echo "<td><a class='btn btn-warning' href='articles.php?source=edit&id={$id}'" . ((!is_admin($_SESSION['username']) && $_SESSION['id'] != $user) ? "disabled" : "") . ">Edit</a></td>";
          echo "<td><a rel='$id' href='javascript:void(0)' class='btn btn-danger delete_link'"  . ((!is_admin($_SESSION['username']) && $_SESSION['id'] != $user) ? "disabled" : "") . ">Delete</a></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</form>
      
<?php 
  if(isset($_GET['delete'])){
    $id = escape($_GET['delete']);
    $query = "DELETE FROM articles WHERE id = {$id} ";
    $delete_query = mysqli_query($connection, $query);
    confirm_query($delete_query);
    header("Location: articles.php");
  }

  if(isset($_GET['reset'])){
    $id = escape($_GET['reset']);
    $query = "UPDATE articles SET views = 0 WHERE id = $id  ";
    $reset_query = mysqli_query($connection, $query);
    confirm_query($reset_query);
    header("Location: articles.php");
  }
?> 

<script>
  $(document).ready(function(){
    $(".delete_link").on('click', function(){
      $(".modal_delete_link").attr("href", "articles.php?delete=" + $(this).attr("rel"));
      $("#deleteModal .modal-body h3").text("Are you sure you want to delete this article?");
      $("#deleteModal").modal('show');
    });

    $(".reset_link").on('click', function(){
      $(".modal_reset_link").attr("href", "articles.php?reset=" + $(this).attr("rel"));
      $("#resetModal .modal-body h3").text("Are you sure you want to zero the views to this article?");
      $("#resetModal").modal('show');
    });
  });

  <?php 
    if(isset($_SESSION['message'])){
      unset($_SESSION['message']);
    }
  ?>
</script>
            
            
            
            
            
            
            
      