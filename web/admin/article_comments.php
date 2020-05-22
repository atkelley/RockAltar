<?php include "includes/admin_header.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php  
            include("./includes/delete_modal.php");

            if(isset($_POST['checkBoxArray'])) {
              foreach($_POST['checkBoxArray'] as $commentValueId ){
                $bulk_options = $_POST['bulk_options'];
                  
                switch($bulk_options) {
                  case 'approved':     
                    $query = "UPDATE comments SET status = '{$bulk_options}' WHERE id = {$commentValueId}  "; 
                    $approve_comment_query = mysqli_query($connection, $query);         
                    confirm_query($approve_comment_query);   
                    break;
                  case 'unapproved':
                    $query = "UPDATE comments SET status = '{$bulk_options}' WHERE id = {$commentValueId}";    
                    $unapprove_comment_query = mysqli_query($connection, $query);       
                    confirm_query($unapprove_comment_query);  
                    break;
                  case 'delete':
                    $query = "DELETE FROM comments WHERE id = {$commentValueId}";
                    $delete_comment_query = mysqli_query($connection, $query);  
                    confirm_query($delete_comment_query); 
                    break;
                }
              } 
            }
          ?>

          <form method='post'>
            <h1 class='page-header'>View All Comments (<?php get_article_comments_count($_GET['id']); ?>)</h1>
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
                <input type="submit" name="submit" class="btn btn-success" value="Apply" <?php echo (!is_admin($_SESSION['username'])) ? "disabled" : "" ?>>
                <a class="btn btn-primary" href="comments.php?source=add">Add New</a>
              </div>
              <br><br>

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
                            INNER JOIN articles ON comments.post_id = articles.id
                            WHERE post_id = {$_GET['id']}";
                  $select_comments = mysqli_query($connection, $query);

                  while($row = mysqli_fetch_assoc($select_comments)) {
                    $id      = $row['id'];
                    $title   = $row['title'];
                    $post_id = $row['post_id'];
                    $author  = $row['author'];
                    $email   = $row['email'];
                    $content = $row['content'];
                    $status  = $row['status'];
                    $date = date("F dS, Y", strtotime($row['date']));
                    $time = date('h:i A', strtotime($row['date']));

                    echo "<tr>";
                    ?><td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $id; ?>'></td><?php
                    echo "<td>$author</td>";
                    echo "<td>$content</td>";
                    echo "<td>$email</td>";
                    echo "<td><a href='../article.php?id=$post_id#comments'>$title</a></td>";
                    echo "<td>$status</td>";       
                    echo "<td>$date, $time</td>";
                    echo "<td><a class='btn btn-warning' href='comments.php?source=edit&id={$id}'
                    " . ((!is_admin($_SESSION['username']) && $_SESSION['email'] != $email) ? "disabled" : "") . "
                    >Edit</a></td>";
                    echo "<td><a rel='$id' href='javascript:void(0)' class='btn btn-danger delete_link'
                    " . ((!is_admin($_SESSION['username']) && $_SESSION['email'] != $email) ? "disabled" : "") . "
                    >Delete</a></td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
        
  <?php include "includes/admin_footer.php" ?>                
  <?php
    if(isset($_GET['approve'])){
      $id = escape($_GET['approve']);
      $query = "UPDATE comments SET status = 'approved' WHERE id = $id";
      $approve_comment_query = mysqli_query($connection, $query);
      confirm_query($approve_comment_query); 
      header("Location: comments.php");
    }

    if(isset($_GET['unapprove'])){
      $id = escape($_GET['unapprove']);
      $query = "UPDATE comments SET status = 'unapproved' WHERE id = $id";
      $unapprove_comment_query = mysqli_query($connection, $query);
      confirm_query($unapprove_comment_query); 
      header("Location: comments.php"); 
    }

    if(isset($_GET['delete'])){
      $id = escape($_GET['delete']);
      $query = "DELETE FROM comments WHERE id = {$id}";
      $delete_query = mysqli_query($connection, $query);
      confirm_query($delete_comment_query); 
      header("Location: comments.php");
    }
  ?>     

  <script>
    $(document).ready(function(){
      $(".delete_link").on('click', function(){
        $(".modal_delete_link").attr("href", "comments.php?delete=" + $(this).attr("rel"));
        $("#deleteModal .modal-body h3").text("Delete this comment?");
        $("#deleteModal").modal('show');
      });
    });
  </script>