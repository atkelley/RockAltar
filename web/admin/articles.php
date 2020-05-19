<?php include "includes/admin_header.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <?php
            $source = isset($_GET['source']) ? $_GET['source'] : "";

            switch($source) {
              case "add";
                include "includes/add_article.php";
                break; 
              case "edit";
                include "includes/edit_article.php";
                break;
              default:
                include "includes/view_all_articles.php";
                break;
            }
          ?>
        </div>
      </div>
    </div>
  </div>
        
  <?php include "includes/admin_footer.php" ?>
