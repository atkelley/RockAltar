<?php  
  if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $commentValueId ){
      $bulk_options = $_POST['bulk_options'];
        
      switch($bulk_options) {
        case 'approved':     
          $query = "UPDATE comments SET status = '{$bulk_options}' WHERE id = {$commentValueId}  "; 
          $update_to_approved_status = mysqli_query($connection, $query);         
          confirmQuery( $update_to_approved_status);   
          break;
        case 'unapproved':
          $query = "UPDATE comments SET status = '{$bulk_options}' WHERE id = {$commentValueId}  ";    
          $update_to_unapproved_status = mysqli_query($connection, $query);       
          confirmQuery($update_to_unapproved_status);  
          break;
        case 'delete':
          $query = "DELETE FROM comments WHERE id = {$commentValueId}  ";
          $update_to_delete = mysqli_query($connection, $query);  
          confirmQuery($update_to_delete); 
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
        <option value="approved">Approve</option>
        <option value="unapproved">Unapprove</option>
        <option value="delete">Delete</option>
      </select>
    </div> 
 
    <div class="col-xs-4">
      <input type="submit" name="submit" class="btn btn-success" value="Apply">
    </div>

    <thead>
      <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Unapprove</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $query = "SELECT * FROM comments";
        $select_comments = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_comments)) {
          $id          = $row['id'];
          $post_id     = $row['post_id'];
          $author      = $row['author'];
          $content     = $row['content'];
          $email       = $row['email'];
          $status      = $row['status'];
          $date        = $row['date'];
          echo "<tr>";
          ?><td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $id; ?>'></td><?php
          echo "<td>$id </td>";
          echo "<td>$author</td>";
          echo "<td>$content</td>";
          echo "<td>$email</td>";
          echo "<td>$status</td>";
        
          $query = "SELECT * FROM articles WHERE id = $post_id ";
          $select_article_id_query = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($select_article_id_query)){
            $id = $row['id'];
            $name = $row['name'];
            echo "<td><a href='../article.php?id=$id'>$name</a></td>";
          }
        
          echo "<td>$date</td>";
          echo "<td><a href='comments.php?approve=$id'>Approve</a></td>";
          echo "<td><a href='comments.php?unapprove=$id'>Unapprove</a></td>";
          echo "<td><a href='comments.php?delete=$id'>Delete</a></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</form>
                     
<?php
  if(isset($_GET['approve'])){
    $the_comment_id = escape($_GET['approve']);
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id   ";
    $approve_comment_query = mysqli_query($connection, $query);
    header("Location: comments.php");
  }

  if(isset($_GET['unapprove'])){
    $the_comment_id = escape($_GET['unapprove']);
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
    $unapprove_comment_query = mysqli_query($connection, $query);
    header("Location: comments.php"); 
  }

  if(isset($_GET['delete'])){
    $the_comment_id = escape($_GET['delete']);
    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: comments.php");
  }
?>     