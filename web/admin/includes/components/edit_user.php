<?php  
  if(isset($_GET['user'])){
    $user_profile = get_user_profile($_GET['user']);
  } else {  
    redirect("index.php?page=users");
  }  

  if(isset($_POST['edit_user'])) {
    $result = edit_user_profile($_POST, $_GET['user']);

    if ($result) {
      redirect('index.php?page=users');
    }
  } 
?>

<form method="post">    
  <h1 class='page-header edit-user-header'>Edit User
    <span class="form-group pull-right edit-user-header-dropdown">
      <label for="role" class="edit-user-header-label">Role:</label>
      <select name="role" class="form-control">
        <option selected value="<?php echo $user_profile['role']; ?>"><?php echo $user_profile['role']; ?></option>
        <?php 
          $option = ($user_profile['role'] == 'admin') ? "<option value='subscriber'>subscriber</option>" : "<option value='admin'>admin</option>";
          echo $option;
        ?>
      </select>
    </span>
  </h1>

  <div class="row">
    <div class="col-md-8"> 
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" value="<?php echo $user_profile['username']; ?>" class="form-control" name="username" required>
      </div>

      <div class="form-group">
        <label for="firstname">First Name:</label>
        <input type="text" value="<?php echo $user_profile['firstname']; ?>" class="form-control" name="firstname" required>
      </div>

      <div class="form-group">
        <label for="lastname">Last Name:</label>
        <input type="text" value="<?php echo $user_profile['lastname']; ?>" class="form-control" name="lastname" required>
      </div>
          
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" value="<?php echo $user_profile['email']; ?>" class="form-control" name="email" required>
      </div>

      <div class="form-group">
        <label for="image-link">Image link:</label><br>    
        <input type="text" value="<?php echo $user_profile['image']; ?>" class="form-control" name="image">
      </div>
          
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" value="" class="form-control" name="password">
      </div>

      <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update">
        <a class='btn btn-default' href='index.php?page=users'>Cancel</a>
      </div>
    </div>

    <div class="col-md-4 text-center">
      <label for="image">Image:</label><br>  
      <img class="edit-user-image" src="<?php echo $user_profile['image']; ?>">
    </div>
  </div>
</form>