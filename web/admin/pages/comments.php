<div id="page-wrapper" class="page-wrapper-admin">
  <div class="container-fluid">
    <div class="row row-admin">
      <div class="col-md-12">       
        <?php
          $source = isset($_GET['source']) ? escape($_GET['source']) : '';

          switch($source) {
            case "add";
              include "includes/components/add_comment.php";
              break; 
            case "edit":
              include "includes/components/edit_comment.php";
              break;
            default:
              include "includes/components/view_all_comments.php";
              break; 
          }
        ?>
      </div>
    </div>
  </div>
</div>
