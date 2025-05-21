<?php
  if(isset($_POST['create_user'])) {  
    $result = add_user_profile($_POST);

    if ($result) {
      redirect("index.php?page=users");
    }
   }  
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header edit-user-header'>Create User
    <span class="form-group pull-right edit-user-header-dropdown">
      <label for="role" class="edit-user-header-label">Role:</label>
      <select name="role" class="form-control">
        <option selected value="subscriber">subscriber</option>
        <option value="admin">admin</option>
      </select>
    </span>
  </h1>

  <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" required>
  </div>

  <div class="form-group">
    <label for="firstname">First Name:</label>
    <input type="text" class="form-control" name="firstname" required>
  </div>

  <div class="form-group">
    <label for="lastname">Last Name:</label>
    <input type="text" class="form-control" name="lastname" required>
  </div>
      
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" name="email" required>
  </div>

  <div class="form-group">
    <label for="image">Image Link:</label><br>    
    <input type="text" class="form-control" name="image">
  </div>
      
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" name="password" required>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_user" value="Create">
    <a class='btn btn-default' href='index.php?page=users'>Cancel</a>
  </div>
</form>
    