<?php  
  include("delete_modal.php");

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

<form method='post'>
  <h1 class='page-header'>View All Comments (<?php get_rows_count('comments'); ?>)</h1>
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
      <a class="btn btn-primary" href="comments.php?source=add">Add New</a>
    </div>
    <br><br><br>

    <thead>
      <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Article</th>
        <th>Status</th>
        <th>Date</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $query = "SELECT 
                  comments.id,
                  articles.title,
                  comments.post_id,
                  comments.author,
                  comments.email,
                  comments.content,
                  comments.status,
                  comments.date
                  FROM comments 
                  INNER JOIN articles ON comments.post_id = articles.id";
        $select_comments = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_comments)) {
          $id      = $row['id'];
          $title   = $row['title'];
          $post_id = $row['post_id'];
          $author  = $row['author'];
          $email   = $row['email'];
          $content = $row['content'];
          $status  = $row['status'];
          $date    = date_create($row['date']);
          $date    = date_format($date, "F jS, Y");

          echo "<tr>";
          ?><td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $id; ?>'></td><?php
          echo "<td>$author</td>";
          echo "<td>$content</td>";
          echo "<td>$email</td>";
          echo "<td><a href='../article.php?id=$post_id#comments'>$title</a></td>";
          echo "<td>$status</td>";       
          echo "<td>$date</td>";
          // echo "<td><a href='comments.php?approve=$id'>Approve</a></td>";
          // echo "<td><a href='comments.php?unapprove=$id'>Unapprove</a></td>";
          echo "<td><a class='btn btn-warning' href='comments.php?source=edit&id={$id}'>Edit</a></td>";
          echo "<td><a rel='$id' href='javascript:void(0)' class='btn btn-danger delete_link'>Delete</a></td>";
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

<script>
  $(document).ready(function(){
    $(".delete_link").on('click', function(){
      $(".modal_delete_link").attr("href", "comments.php?delete=" + $(this).attr("rel"));
      $("#myModal .modal-body h3").text("Are you sure you want to delete this comment?");
      $("#myModal").modal('show');
    });
  });
</script>