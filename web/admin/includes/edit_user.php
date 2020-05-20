<?php  
  if(isset($_GET['user'])){
    $id =  escape($_GET['user']);
    $query = "SELECT * FROM users WHERE id = $id ";
    $select_user_query = mysqli_query($connection, $query);  

    while($row = mysqli_fetch_assoc($select_user_query)) {
      $username  = $row['username'];
      $firstname = $row['firstname'];
      $lastname  = $row['lastname'];
      $email     = $row['email'];
      $image     = (!empty($_POST['image'])) ? escape($_POST['image']) : "https://www.gravatar.com/avatar/" . hash('md4', strtolower($email)) . "?s=350&d=identicon&r=PG";
      $role      = $row['role'];
      $password  = $row['password'];
    }

    if(isset($_POST['edit_user'])) {
      $username  = escape($_POST['username']);
      $firstname = escape($_POST['firstname']);
      $lastname  = escape($_POST['lastname']);
      $email     = escape($_POST['email']);
      $image     = escape($_POST['image']);
      $role      = escape($_POST['role']);
      $password  = escape($_POST['password']);
      
      $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

      $query = "UPDATE users SET 
                firstname = '{$firstname}',
                lastname  = '{$lastname}',
                role      = '{$role}', 
                username  = '{$username}', 
                email     = '{$email}',
                image     = '{$image}',
                password  = '{$hashed_password}'
                WHERE id  = '{$id}' ";
      $edit_user_query = mysqli_query($connection, $query);
      confirm_query($edit_user_query);
      echo "<div class='bg-success'>User updated. <a href='../author.php?user={$id}' target='_blank'>View User</a> or go back to <a href='users.php'>View All Users</a></div>";
    } 
  } else {  
    header("Location: users.php");
  }  
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header edit-user-header'>Edit User
    <span class="form-group pull-right edit-user-header-dropdown">
      <label for="role" class="edit-user-header-label">Role:</label>
      <select name="role" class="form-control">
        <option selected value="<?php echo $role; ?>"><?php echo $role; ?></option>
        <?php 
          $option = ($role == 'admin') ? "<option value='subscriber'>subscriber</option>" : "<option value='admin'>admin</option>";
          echo $option;
        ?>
      </select>
    </span>
  </h1>

  <div class="row">
    <div class="col-md-8"> 
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" required>
      </div>

      <div class="form-group">
        <label for="firstname">First Name:</label>
        <input type="text" value="<?php echo $firstname; ?>" class="form-control" name="firstname" required>
      </div>

      <div class="form-group">
        <label for="lastname">Last Name:</label>
        <input type="text" value="<?php echo $lastname; ?>" class="form-control" name="lastname" required>
      </div>
          
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" value="<?php echo $email; ?>" class="form-control" name="email" required>
      </div>

      <div class="form-group">
        <label for="image-link">Image link:</label><br>    
        <input type="text" value="<?php echo $image; ?>" class="form-control" name="image">
      </div>
          
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" value="<?php echo $user_password; ?>" class="form-control" name="password" required>
      </div>

      <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update">
        <a class='btn btn-default' href='users.php'>Cancel</a>
      </div>
    </div>

    <div class="col-md-4 text-center">
      <label for="image">Image:</label><br>  
      <img class="edit-user-image" src="<?php echo $image; ?>">
    </div>
  </div>
</form>