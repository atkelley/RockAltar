<?php include "includes/admin_header.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <?php
            $source = isset($_GET['source']) ? $_GET['source'] : "";
            $query = "SELECT * from articles";
            $select_articles = mysqli_query($connection, $query);  
            $count = mysqli_num_rows($select_articles);

            switch($source) {
              case "add_article";
                echo "<h1 class='page-header'>Add Article</h1>";  
                include "includes/add_article.php";
                break; 
              case "edit_article";
                echo "<h1 class='page-header'>Edit Article</h1>"; 
                include "includes/edit_article.php";
                break;
              default:
                echo "<h1 class='page-header'>View All Articles (" . $count . ")</h1>"; 
                include "includes/view_all_articles.php";
                break;
            }
          ?>
        </div>
      </div>
    </div>
  </div>
        
  <?php include "includes/admin_footer.php" ?>
