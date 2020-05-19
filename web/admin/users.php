<?php include "includes/admin_header.php" ?>
<?php if(!is_admin($_SESSION['username'])){ header("Location: index.php"); }?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">     
          <?php
            $source = isset($_GET['source']) ? $_GET['source'] : "";

            switch($source) {
              case 'add';
                include "includes/add_user.php";
                break; 
              case 'edit';
                include "includes/edit_user.php";
                break;
              default:
                include "includes/view_all_users.php";
                break;
            }
          ?>
        </div>
      </div>
    </div>
  </div>
      
  <?php include "includes/admin_footer.php" ?>
