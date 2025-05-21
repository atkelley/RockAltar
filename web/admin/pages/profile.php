<?php
   if(isset($_SESSION['id'])) {
    $user_profile = get_user_profile($_SESSION['id']);
  }

  if(isset($_POST['edit_user'])) {
    $result = edit_user_profile($_POST, $_SESSION['id']);
    if ($result) {
      redirect('index.php');
    }
  }
?>
  
<div id="page-wrapper" class="page-wrapper-admin">
  <div class="container-fluid">
    <div class="row row-admin">
      <div class="col-md-12 padding-right-zero">
        <h1 class="page-header profile-header">Profile</h1>
      </div>
    </div>

    <div class="row row-admin">
      <div class="col-md-3 padding-right-zero">
        <label for="image">Image:</label><br> 
        <img class="edit-profile-image" src="<?php echo $user_profile['image']; ?>">
      </div>
      
      <div class="col-md-9 padding-all-zero">
        <form method="post" enctype="multipart/form-data">  
          <div class="form-group">
            <label for="">Username:</label>
            <input type="text" value="<?php echo $user_profile['username']; ?>" class="form-control" name="username" required>
          </div>

          <div class="form-group">
            <label for="">First Name:</label>
            <input type="text" value="<?php echo $user_profile['firstname'];; ?>" class="form-control" name="firstname" required>
          </div>

          <div class="form-group">
            <label for="">Last Name:</label>
            <input type="text" value="<?php echo $user_profile['lastname']; ?>" class="form-control" name="lastname" required>
          </div>

          <div class="form-group">
            <label for="">Email:</label>
            <input type="email" value="<?php echo $user_profile['email']; ?>" class="form-control" name="email" required>
          </div>

          <div class="form-group">
            <label for="image">Image link:</label><br>    
            <input value="<?php echo $user_profile['image']; ?>" type="text" class="form-control" name="image">
          </div>
    
          <div class="form-group">
            <label for="">Password:</label>
            <input type="password" value="" class="form-control" name="password">
          </div>

          <div class="form-group">
            <input class="btn btn-primary btn-primary-profile" type="submit" name="edit_user" value="Update">
            <a class='btn btn-default' href='index.php'>Cancel</a>
          </div>
        </form>
      </div>


    </div>
  </div>