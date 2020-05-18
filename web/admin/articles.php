<?php include "includes/admin_header.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Welcome to admin<small>Author</small></h1>      
            <?php
              if(isset($_GET['source'])){
                $source = $_GET['source'];
              } else {
                $source = '';
              }

              switch($source) {
                case 'add_article';
                  include "includes/add_article.php";
                  break; 
                case 'edit_post';
                  include "includes/edit_article.php";
                  break;
                case '200';
                  echo "NICE 200";
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
