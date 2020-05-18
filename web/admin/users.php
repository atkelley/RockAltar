<?php include "includes/admin_header.php" ?>
<?php if(!is_admin($_SESSION['username'])){ header("Location: index.php"); }?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">     
          <?php
            $source = isset($_GET['source']) ? $_GET['source'] : "";

            switch($source) {
              case 'add_user';
                echo "<h1 class='page-header'>Add User</h1>"; 
                include "includes/add_user.php";
                break; 
              case 'edit_user';
                echo "<h1 class='page-header'>Edit User</h1>"; 
                include "includes/edit_user.php";
                break;
              default:
                echo "<h1 class='page-header'>View All Users</h1>"; 
                include "includes/view_all_users.php";
                break;
            }
          ?>
        </div>
      </div>
    </div>
  </div>
      
  <?php include "includes/admin_footer.php" ?>
