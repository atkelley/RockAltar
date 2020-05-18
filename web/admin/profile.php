<?php include "includes/admin_header.php" ?>

<?php
   if(isset($_SESSION['username'])) {
    $query = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' ";
    $select_user_profile_query = mysqli_query($connection, $query);
    
    while($row = mysqli_fetch_array($select_user_profile_query)) {
      $id        = $row['id'];
      $username  = $row['username'];
      $firstname = $row['firstname'];
      $lastname  = $row['lastname'];
      $password  = $row['password'];
      $email     = $row['email'];
      $image     = $row['image'];
      $role      = $row['role'];
    }
  }
?>
    
<?php 
  if(isset($_POST['edit_user'])) {
    $query = "SELECT randSalt FROM users";
    $select_randsalt_query = mysqli_query($connection, $query);
    if(!$select_randsalt_query) {
      die("Query Failed: " . mysqli_error($connection));
    }
       
    $row = mysqli_fetch_array($select_randsalt_query); 
    $hashed_password = crypt($_POST['password'], $row['randSalt']);
  
    $query = "UPDATE users SET 
              username       = '{$_POST['username']}',
              firstname      = '{$_POST['firstname']}', 
              lastname       = '{$_POST['lastname']}', 
              email          = '{$_POST['email']}', 
              role           = '{$_POST['role']}', 
              password       = '{$hashed_password}'
              WHERE username = '{$username}' ";

    $edit_user_query = mysqli_query($connection, $query);
  }
?> 

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>
  
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form action="" method="post" enctype="multipart/form-data">   
            <h1 class="page-header profile-title">Profile
              <span class="form-group pull-right profile-status-dropdown">
                <select name="role">
                  <option value="subscriber"><?php echo $role; ?></option>
                  <?php 
                    $status = ($user_role == 'admin') ? "<option value='subscriber'>subscriber</option>" : "<option value='admin'>admin</option>";
                    echo $status;
                  ?>
                </select>
              </span>
            </h1>
           
            <div class="form-group">
              <label for="">First Name:</label>
              <input type="text" value="<?php echo $firstname; ?>" class="form-control" name="firstname">
            </div>

            <div class="form-group">
              <label for="">Last Name:</label>
              <input type="text" value="<?php echo $lastname; ?>" class="form-control" name="lastname">
            </div>

            <div class="form-group">
              <label for="">Username:</label>
              <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
            </div>
        
            <div class="form-group">
              <label for="">Email:</label>
              <input type="email" value="<?php echo $email; ?>" class="form-control" name="email">
            </div>
      
            <div class="form-group">
              <label for="">Password:</label>
              <input type="password" value="<?php echo $password; ?>" class="form-control" name="password">
            </div>

            <div class="form-group">
              <input class="btn btn-primary" type="submit" name="edit_user" value="Update">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
        
  <?php include "includes/admin_footer.php" ?>
