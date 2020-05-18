<?php include "includes/admin_header.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">       
          <?php
            $source = isset($_GET['source']) ? escape($_GET['source']) : '';

            switch($source) {
              case "add_post";
                echo "<h1 class='page-header'>Welcome to admin<small>Author</small></h1>";
                include "includes/add_post.php";
                break; 
              case "edit_post";
                echo "<h1 class='page-header'>Welcome to admin<small>Author</small></h1>";
                include "includes/edit_post.php";
                break;
              default:
                echo "<h1 class='page-header'>View All Comments</h1>";
                include "includes/view_all_comments.php";
                break; 
            }
          ?>
        </div>
      </div>
    </div>
  </div>
        
  <?php include "includes/admin_footer.php" ?>
