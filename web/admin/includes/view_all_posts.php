<?php
  include("delete_modal.php");

  if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $postValueId ){ 
      $bulk_options = $_POST['bulk_options'];
        
      switch($bulk_options) {
        case 'published':   
          $query = "UPDATE articles SET status = '{$bulk_options}' WHERE id = {$postValueId}  ";    
          $update_to_published_status = mysqli_query($connection, $query);       
          confirmQuery($update_to_published_status);
          break;
        case 'draft':
          $query = "UPDATE articles SET status = '{$bulk_options}' WHERE id = {$postValueId}  ";     
          $update_to_draft_status = mysqli_query($connection, $query);        
          confirmQuery($update_to_draft_status);
          break;
        case 'delete':
          $query = "DELETE FROM articles WHERE id = {$postValueId}  ";  
          $update_to_delete_status = mysqli_query($connection, $query);       
          confirmQuery($update_to_delete_status);
          break;
        case 'clone':
          $query = "SELECT * FROM articles WHERE id = '{$postValueId}' ";
          $select_article_query = mysqli_query($connection, $query);

          while ($row = mysqli_fetch_array($select_article_query)) {
            $title         = $row['title'];
            $category  = $row['category'];
            $date          = $row['date']; 
            $user        = $row['user'];
            $status        = $row['status'];
            $image         = $row['image'] ; 
            $content       = $row['content'];
          }
 
          $query = "INSERT INTO articles (category, title, user, date, image, content, status) ";
          $query .= "VALUES({$category}, '{$title}', '{$user}', now(), '{$image}', '{$content}', '{$status}') "; 
          $copy_query = mysqli_query($connection, $query);   

          if(!$copy_query ) {
            die("Query failed: " . mysqli_error($connection));
          }   
          break;
      }
    } 
  }
?>

<form action="" method='post'>
  <table class="table table-bordered table-hover">
    <div id="bulkOptionContainer" class="col-xs-4">
      <select class="form-control" name="bulk_options" id="">
        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
      </select>
    </div> 
          
    <div class="col-xs-4">
      <input type="submit" name="submit" class="btn btn-success" value="Apply">
      <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
    </div>
    <br><br><br>
                
    <thead>
      <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>User</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Comments</th>
        <th>Views</th>
        <th>Date</th>
        <th>View Post</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>          
    <tbody>
      <?php 
        $query = "SELECT * FROM articles ORDER BY id DESC ";
        $select_articles = mysqli_query($connection, $query);  

        while($row = mysqli_fetch_assoc($select_articles)) {
          $id            = $row['id'];
          $user          = $row['user'];
          $title         = $row['title'];
          $category      = $row['category'];
          $status        = $row['status'];
          $image         = $row['image'];
          $comments      = $row['comments'];
          $date          = $row['date'];
          $views         = $row['views'];
          echo "<tr>";
          ?><td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $id; ?>'></td><?php
          // echo "<td>$id</td>";
          echo "<td>$user</td>";
          echo "<td>$title</td>";

          $query = "SELECT * FROM categories WHERE id = {$category} ";
          $select_categories_id = mysqli_query($connection, $query);  

          while($row = mysqli_fetch_assoc($select_categories_id)) {
            $id = $row['id'];
            $name = $row['name'];
            echo "<td>$name</td>"; 
          }

          echo "<td>$status</td>";
          echo "<td><img width='100' src='$image' alt='image'></td>";
          $query = "SELECT * FROM comments WHERE post_id = $id";
          $send_comment_query = mysqli_query($connection, $query);
          $row = mysqli_fetch_array($send_comment_query);
          $comment_id = isset($row['id']) ? $row['id'] : 0;
          $count_comments = mysqli_num_rows($send_comment_query);
          echo "<td><a href='post_comments.php?id=$id'>$count_comments</a></td>";
          echo "<td><a href='posts.php?reset={$id}'>{$views}</a></td>";
          echo "<td>$date</td>";
          echo "<td><a class='btn btn-primary' href='../post.php?p_id={$id}'>View Post</a></td>";
          echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$id}'>Edit</a></td>";?>

          <!-- <form method="post">
            <input type="hidden" name="post_id" value="<?php echo $id ?>">
            <?php   
              echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';
            ?>
          </form> -->

          <?php
            echo "<td><a rel='$id' href='javascript:void(0)' class='btn btn-danger delete_link'>Delete</a></td>";
            // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete'); \" href='posts.php?delete={$id}'>Delete</a></td>";
            echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</form>
      
<?php 
  if(isset($_POST['delete'])){
    $id = escape($_POST['id']);
    $query = "DELETE FROM articles WHERE id = {$id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: /RockAltar/admin/posts.php");
  }

  if(isset($_GET['reset'])){
    $id = escape($_GET['reset']);
    $query = "UPDATE articles SET views = 0 WHERE id = $id  ";
    $reset_query = mysqli_query($connection, $query);
    header("Location: posts.php");
  }
?> 

<script>
  $(document).ready(function(){
    $(".delete_link").on('click', function(){
      var id = $(this).attr("rel");
      var delete_url = "posts.php?delete="+ id +" ";
      $(".modal_delete_link").attr("href", delete_url);
      $("#myModal").modal('show');
    });
  });

  <?php 
    if(isset($_SESSION['message'])){
      unset($_SESSION['message']);
    }
  ?>
</script>
            
            
            
            
            
            
            
      