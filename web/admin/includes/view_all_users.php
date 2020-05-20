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

<form method='post'>
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
        <th>Image</th>
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
          $username       = $row['username'];
          $password       = $row['password'];
          $firstname      = $row['firstname'];
          $lastname       = $row['lastname'];
          $email          = $row['email'];
          $image          = (!empty($row['image'])) ? $row['image'] : "https://www.gravatar.com/avatar/" . hash('md4', strtolower($email)) . "?s=350&d=identicon&r=PG";
          $role           = $row['role'];

          echo "<tr>";
          ?><td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $id; ?>'></td><?php
          echo "<td><a href='../author.php?user={$id}'>$username</a></td>";
          echo "<td>$firstname</td>";     
          echo "<td>$lastname</td>";
          echo "<td>$email</td>";
          echo "<td><img width='100' src='$image' alt='image'></td>";
          echo "<td>$role</td>";
          echo "<td><a class='btn btn-warning' href='users.php?source=edit&user={$id}'>Edit</a></td>";
          echo "<td><a rel='$id' href='javascript:void(0)' class='btn btn-danger delete_link'>Delete</a></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</form>         

<?php
  if(isset($_GET['admin'])) {
    $id = escape($_GET['admin']);
    $query = "UPDATE users SET role = 'admin' WHERE id = $id   ";
    $update_role_query = mysqli_query($connection, $query);
    confirm_query($update_role_query);
    header("Location: users.php");
  }

  if(isset($_GET['subscriber'])){
    $id = escape($_GET['subscriber']);
    $query = "UPDATE users SET role = 'subscriber' WHERE id = $id   ";
    $update_role_query = mysqli_query($connection, $query);
    confirm_query($update_role_query);
    header("Location: users.php"); 
  }

  if(isset($_GET['delete'])){
    $id = escape($_GET['delete']);
    $query = "DELETE FROM users WHERE id = {$id} ";
    $delete_user_query = mysqli_query($connection, $query);
    confirm_query($delete_user_query);
    header("Location: users.php"); 
  }
?>     

<script>
  $(document).ready(function(){
    $(".delete_link").on('click', function(){
      $(".modal_delete_link").attr("href", "users.php?delete=" + $(this).attr("rel"));
      $("#deleteModal .modal-body h3").text("Are you sure you want to delete this user?");
      $("#deleteModal").modal('show');
    });
  });
</script>