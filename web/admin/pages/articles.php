<div id="page-wrapper" class="page-wrapper-admin">
  <div class="container-fluid">
    <div class="row row-admin">
      <div class="col-lg-12">
        <?php
          $source = isset($_GET['source']) ? escape($_GET['source']) : "";

          switch($source) {
            case "add";
              include "includes/components/add_article.php";
              break; 
            case "edit";
              include "includes/components/edit_article.php";
              break;
            default:
              include "includes/components/view_all_articles.php";
              break;
          }
        ?>
      </div>
    </div>
  </div>
</div>