<?php  
  if(isset($_GET['edit_user'])){
    $id =  escape($_GET['edit_user']);
    $query = "SELECT * FROM users WHERE id = $id ";
    $select_users_query = mysqli_query($connection, $query);  

    while($row = mysqli_fetch_assoc($select_users_query)) {
      $id        = $row['id'];
      $username       = $row['username'];
      $password  = $row['password'];
      $firstname = $row['firstname'];
      $lastname  = $row['lastname'];
      $email     = $row['email'];
      $image     = $row['image'];
      $role      = $row['role'];
    }

    if(isset($_POST['edit_user'])) {
      $firstname   = escape($_POST['firstname']);
      $lastname    = escape($_POST['lastname']);
      $role        = escape($_POST['role']);
      $username      = escape($_POST['username']);
      $email    = escape($_POST['email']);
      $password = escape($_POST['password']);
      $date     = escape(date('d-m-y'));

      if(!empty($password)) { 
        $query_password = "SELECT password FROM users WHERE id =  $id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);
        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['password'];

        if($db_user_password != $password) {
          $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        }

        $query = "UPDATE users SET ";
        $query .="firstname  = '{$firstname}', ";
        $query .="lastname = '{$lastname}', ";
        $query .="role   =  '{$role}', ";
        $query .="username = '{$username}', ";
        $query .="email = '{$email}', ";
        $query .="password   = '{$hashed_password}' ";
        $query .= "WHERE id = {$id} ";
        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);
        echo "User Updated" . " <a href='users.php'>View Users?</a>";
      } 
    } 
  } else {  
    header("Location: index.php");
  }  
?>

<form action="" method="post" enctype="multipart/form-data">    
  <div class="form-group">
    <label for="title">Firstname</label>
    <input type="text" value="<?php echo $firstname; ?>" class="form-control" name="firstname">
  </div>

  <div class="form-group">
    <label for="status">Lastname</label>
    <input type="text" value="<?php echo $lastname; ?>" class="form-control" name="lastname">
  </div>
     
  <div class="form-group">
    <select name="role" id="">   
      <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
        <?php 
        if($role == 'admin') { 
          echo "<option value='subscriber'>subscriber</option>";
        } else {
          echo "<option value='admin'>admin</option>";
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
  </div>
      
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" value="<?php echo $email; ?>" class="form-control" name="email">
  </div>
      
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" value="<?php //echo $user_password; ?>" class="form-control" name="password">
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
  </div>
</form>