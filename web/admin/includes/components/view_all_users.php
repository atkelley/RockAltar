<?php 
  include("delete_modal.php");

  if(isset($_POST['checkbox_array'])) {
    foreach($_POST['checkbox_array'] as $post_id ){ 
      $bulk_options = $_POST['bulk_options'];
        
      switch($bulk_options) {
        case 'admin':   
        case 'subscriber':    
          echo $post_id;
          echo $bulk_options;
          confirm_query("UPDATE users SET role = '{$bulk_options}' WHERE id = {$post_id}");     
          break;
        case 'delete':
          confirm_query("DELETE FROM users WHERE id = {$post_id}");     
          break;
      }
    } 
  }

  if(isset($_GET['admin'])) {
    confirm_query("UPDATE users SET role = 'admin' WHERE id = " . escape($_GET['admin']));
    redirect("index.php?page=users");
  }

  if(isset($_GET['subscriber'])){
    confirm_query("UPDATE users SET role = 'subscriber' WHERE id = " . escape($_GET['subscriber']));
    redirect("index.php?page=users"); 
  }

  if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    confirm_query("DELETE FROM users WHERE id = {$id}");
    redirect("index.php?page=users"); 
  }
?>

<form method='post'>
  <h1 class='page-header'>View All Users (<?php echo get_rows_count('users'); ?>)</h1>
  <?php 
    $all_users = confirm_query("SELECT * FROM users");  

    if(!$all_users) {
      echo "<h3 class='text-center'>No users found.</h3>";
    } else {
  ?>
  <div class="dropdown-admin">
    <div id="bulkOptionContainer" class="col-xs-4">
      <select class="form-control" name="bulk_options">
        <option value="">Select Options</option>
        <option value="delete">Delete</option>
        <option value="subscriber">Subscriber</option>
        <option value="admin">Admin</option>
      </select>
    </div> 

    <div class="col-xs-4">
      <input type="submit" name="submit" class="btn btn-success" value="Apply">
      <a class="btn btn-primary" href="index.php?page=users&source=add">Add New</a>
    </div>
  </div>

  <div class="table-wrapper-admin">
    <table class="table">
      <thead>
        <tr class="tr-admin">
          <th><input id="select_all_boxes" type="checkbox"></th>
          <th>Username</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Image</th>
          <th>Role</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php echo render_user_table_rows($all_users); ?>
      </tbody>
    </table>
  </div>
  <?php } ?>
</form>