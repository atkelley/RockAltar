<?php 
  include "./includes/components/edit_modal.php";
  include "./includes/components/delete_modal.php";
  
  if(isset($_POST['edit'])) {
    confirm_query("UPDATE categories SET name = '" . escape($_POST['name']) . "' WHERE id = " . escape($_POST['id'])); 
    redirect("index.php?page=categories");
  }

  if(isset($_POST['submit'])){
    confirm_query("INSERT INTO categories (name) VALUES('" . $_POST['name'] . "')");
    redirect("index.php?page=categories");
  }
 
  if(isset($_GET['delete'])){
    confirm_query("DELETE FROM categories WHERE id = " . $_GET['delete']);
    redirect("index.php?page=categories");
  }
?>

<div id="page-wrapper" class="page-wrapper-admin">
  <div class="container-fluid">
    <div class="row row-admin">
      <div class="col-md-8">  
        <form method='post'>
          <h1 class='page-header'>View All Categories (<?php echo get_rows_count('categories'); ?>)</h1> 
          <div class="form-group">
            <input class="form-control categories-input" type="text" name="name" placeholder="Enter new category..." required>
            <input class="btn btn-primary pull-right <?php echo (!is_admin($_SESSION['username']) ? "disabled" : "") ?>" type="submit" name="submit" value="Add New">
          </div>
          <?php 
            $all_categories = confirm_query("SELECT * FROM categories");

            if(!$all_categories) {
              echo "<h3 class='text-center'>No categories found.</h3>";
            } else {
          ?>  
          <div class="table-wrapper-admin">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Delete</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php echo render_genre_or_category_table_rows($all_categories, 'category'); ?>
              </tbody>
            </table>
          </div>
          <?php } ?>
        </form>
      </div>
    </div> 
  </div>
</div>