<?php
  include("reset_modal.php");
  include("delete_modal.php");

  if(isset($_POST['checkbox_array'])) {
    foreach($_POST['checkbox_array'] as $post_id ){ 
      $bulk_options = $_POST['bulk_options'];
        
      switch($bulk_options) {
        case 'draft':
        case 'published':
          confirm_query("UPDATE articles SET status = '{$bulk_options}' WHERE id = {$post_id}");
          break;
        case 'delete': 
          confirm_query("DELETE FROM articles WHERE id = {$post_id}");   
          break;
        case 'copy':
          copy_article($post_id);
          break;
      }
    } 
  }

  if(isset($_GET['delete'])){
    delete_article_and_comments(escape($_GET['delete']));
    redirect("index.php?page=articles");
  }

  if(isset($_GET['reset'])){
    confirm_query("UPDATE articles SET views = 0 WHERE id = " . escape($_GET['reset']));
    redirect("index.php?page=articles");
  }

  if(isset($_SESSION['message'])){
    unset($_SESSION['message']);
  }
?>

<form method='post'>
  <h1 class='page-header'>View All Articles (<?php echo get_rows_count('articles'); ?>)</h1>
  <?php 
    $all_articles = get_all_articles();

    if(!$all_articles) {
      echo "<h3 class='text-center'>No articles found.</h3>";
    } else {
  ?>
  <div class="dropdown-admin">
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
      <a class="btn btn-primary" href="index.php?page=articles&source=add">Add New</a>
    </div>
  </div>
  
  <div class="table-wrapper-admin">
    <table class="table">              
      <thead>
        <tr class="tr-admin">
          <th><input id="select_all_boxes" type="checkbox"></th>
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
        <?php echo render_article_table_rows($all_articles); ?>
      </tbody>
    </table>
  </div>
  <?php } ?>
</form>