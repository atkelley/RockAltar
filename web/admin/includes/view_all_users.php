<?php 
  include("delete_modal.php");

  if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $postValueId ){ 
      $bulk_options = $_POST['bulk_options'];
        
      switch($bulk_options) {
        case 'delete':
          $query = "DELETE FROM users WHERE id = {$postValueId}  ";  
          $delete_user_query = mysqli_query($connection, $query);     
          confirm_query($delete_user_query); 
          break;
        case 'subscriber':   
          $query = "UPDATE users SET role = '{$bulk_options}' WHERE id = {$postValueId}  ";    
          $update_to_subscriber_status = mysqli_query($connection, $query);   
          confirm_query($update_to_subscriber_status);     
          break;
        case 'admin':   
          $query = "UPDATE users SET role = '{$bulk_options}' WHERE id = {$postValueId}  ";    
          $update_to_admin_status = mysqli_query($connection, $query); 
          confirm_query($update_to_admin_status);       
          break;
      }
    } 
  }
?>

<table class="table table-bordered table-hover">
  <h1 class='page-header'>View All Users (<?php get_rows_count('users'); ?>)</h1>
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
    <a class="btn btn-primary" href="users.php?source=add">Add New</a>
  </div>
  <br><br><br>

  <thead>
    <tr>
      <th><input id="selectAllBoxes" type="checkbox"></th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $query = "SELECT * FROM users";
      $select_users = mysqli_query($connection, $query);  

      while($row = mysqli_fetch_assoc($select_users)) {
        $id             = $row['id'];
        $username            = $row['username'];
        $password       = $row['password'];
        $firstname      = $row['firstname'];
        $lastname       = $row['lastname'];
        $email          = $row['email'];
        $image          = $row['image'];
        $role           = $row['role'];
        echo "<tr>";
        ?><td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $id; ?>'></td><?php
        echo "<td>$username</td>";
        echo "<td>$firstname</td>";
        // $query = "SELECT * FROM categories WHERE id = {$category} ";
        // $select_categories_id = mysqli_query($connection,$query);  

        // while($row = mysqli_fetch_assoc($select_categories_id)) {
        //   $cat_id = $row['cat_id'];
        //   $cat_title = $row['cat_title']; 
        //   echo "<td>{$cat_title}</td>";
        // }
       
        echo "<td>$lastname</td>";
        echo "<td>$email</td>";
        echo "<td>$role</td>";

        $query = "SELECT * FROM articles WHERE category = $id ";
        $select_article_id_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_article_id_query)){
          // $id = $row['id'];
          $title = $row['title'];
          // echo "<td><a href='../article.php?id=$id'>$title</a></td>";
        }
        // echo "<td><a rel='$id' class='btn btn-danger delete_link'>Delete</a></td>";
        echo "<td><a class='btn btn-warning' href='users.php?source=edit&user={$id}'>Edit</a></td>";
        // echo "<td><a href='users.php?source=edit_user&user={$id}'>Edit</a></td>";
        // echo "<td><a href='users.php?delete={$id}'>Delete</a></td>";
        echo "<td><a rel='$id' class='btn btn-danger delete_link'>Delete</a></td>";
        echo "</tr>";
      }
    ?>
  </tbody>
</table>
                     
<?php
  // if(isset($_GET['change_to_admin'])) {
  //   $id = escape($_GET['change_to_admin']);
  //   $query = "UPDATE users SET role = 'admin' WHERE id = $id   ";
  //   $change_to_admin_query = mysqli_query($connection, $query);
  //   header("Location: users.php");
  // }

  // if(isset($_GET['change_to_sub'])){
  //   $id = escape($_GET['change_to_sub']);
  //   $query = "UPDATE users SET role = 'subscriber' WHERE id = $id   ";
  //   $change_to_sub_query = mysqli_query($connection, $query);
  //   header("Location: users.php"); 
  // }

  if(isset($_GET['delete'])){
    if(isset($_SESSION['role'])) {
      if($_SESSION['role'] == 'admin') {
        $id = escape($_GET['delete']);
        $query = "DELETE FROM users WHERE id = {$id} ";
        $delete_user_query = mysqli_query($connection, $query);
        header("Location: users.php");
      }   
    }
  }
?>     

<script>
  $(document).ready(function(){
    $(".delete_link").on('click', function(){
      var id = $(this).attr("rel");
      var delete_url = "users.php?delete="+ id +" ";
      $(".modal_delete_link").attr("href", delete_url);
      $("#myModal").modal('show');
    });
  });
</script>