<?php include "includes/admin_header.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">       
          <?php
            $source = isset($_GET['source']) ? escape($_GET['source']) : '';

            switch($source) {
              case "add";
                include "includes/add_comment.php";
                break; 
              case "edit":
                include "includes/edit_comment.php";
                break;
              default:
                include "includes/view_all_comments.php";
                break; 
            }
          ?>
        </div>
      </div>
    </div>
  </div>
        
  <?php include "includes/admin_footer.php" ?>
