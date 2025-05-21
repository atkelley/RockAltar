<?php 
  include "./includes/components/edit_modal.php";
  include "./includes/components/delete_modal.php";
  
  if(isset($_POST['edit'])) {
    confirm_query("UPDATE genres SET name = '". escape($_POST['name']) . "' WHERE id = " . escape($_POST['id'])); 
    redirect("index.php?page=genres");
  }

  if(isset($_POST['submit'])){
    confirm_query("INSERT INTO genres (name) VALUES('" . $_POST['name'] . "')");
    redirect("index.php?page=genres");
  }

  if(isset($_GET['delete'])){
    confirm_query("DELETE FROM genres WHERE id = " . $_GET['delete']);
    redirect("index.php?page=genres");
  }
?>

<div id="page-wrapper" class="page-wrapper-admin">
  <div class="container-fluid">
    <div class="row row-admin">
      <div class="col-md-8"> 
        <form method='post'> 
          <h1 class='page-header'>View All Genres (<?php echo get_rows_count('genres'); ?>)</h1>   
          <div class="form-group">
            <input class="form-control genres-input" type="text" name="name" placeholder="Enter new genre..." required>
            <input class="btn btn-primary pull-right <?php echo (!is_admin($_SESSION['username']) ? "disabled" : "") ?>" type="submit" name="submit" value="Add New">
          </div>
          <?php 
            $all_genres = confirm_query("SELECT * FROM genres");

            if(!$all_genres) {
              echo "<h3 class='text-center'>No genres found.</h3>";
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
                <?php echo render_genre_or_category_table_rows($all_genres, 'genre'); ?>
              </tbody>
            </table>
          </div>
          <?php } ?>
        </form> 
      </div>
    </div>
  </div>
</div>