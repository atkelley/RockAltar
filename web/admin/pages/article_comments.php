<div id="page-wrapper" class="page-wrapper-admin">
  <div class="container-fluid">
    <div class="row row-admin">
      <div class="col-md-12">
        <?php  
          include "./includes/components/delete_modal.php";

          if(isset($_POST['checkbox_array'])) {
            foreach($_POST['checkbox_array'] as $comment_id ){
              $bulk_options = $_POST['bulk_options'];
                
              switch($bulk_options) {
                case 'approved': 
                case 'unapproved':            
                  confirm_query("UPDATE comments SET status = '" . $bulk_options . "' WHERE id = " . $comment_id);   
                  break;
                case 'delete':
                  confirm_query("DELETE FROM comments WHERE id = " . $comment_id); 
                  break;
              }
            } 
          }

          if(isset($_GET['approve'])){
            confirm_query("UPDATE comments SET status = 'approved' WHERE id = " . escape($_GET['approve'])); 
            redirect("index.php?page=article_comments&id={$_GET['id']}");
          }

          if(isset($_GET['unapprove'])){
            confirm_query("UPDATE comments SET status = 'unapproved' WHERE id = " . escape($_GET['unapprove'])); 
            redirect("index.php?page=article_comments&id={$_GET['id']}"); 
          }

          if(isset($_GET['delete'])){
            $id = escape($_GET['delete']);
            confirm_query("DELETE FROM comments WHERE id = {$id}"); 
            redirect("index.php?page=article_comments&id={$_GET['id']}");
          }
        ?>

        <form method='post'>
          <h1 class='page-header'>View All Article Comments (<?php echo get_article_comments_count($_GET['id']); ?>)</h1>
          <?php 
            $all_article_comments = get_all_article_comments($_GET['id']);

            if(!$all_article_comments) {
              echo "<h3 class='text-center'>No article comments found.</h3>";
            } else {
          ?>
          <div class="dropdown-admin">
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
              <a class="btn btn-primary" href="index.php?page=comments&source=add&id=<?php echo $_GET['id']; ?>">Add New</a>
            </div>
          </div>

          <div class="table-wrapper-admin">
            <table class="table">
              <thead>
                <tr class="tr-admin">
                  <th><input id="select_all_boxes" type="checkbox"></th>
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
                <?php echo render_article_comment_table_rows($all_article_comments); ?>
              </tbody>
            </table>
          </div>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>