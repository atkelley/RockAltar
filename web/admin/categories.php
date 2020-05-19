<?php include "includes/admin_header.php" ?>
<?php include "./includes/delete_modal.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row category-header">
        <div class="col-md-6">
          <h1 class='page-header'>View All Categories (<?php get_rows_count('categories'); ?>)</h1>
        </div>
        
        <form method="post">
          <div class="col-md-4 category-header-input">      
            <div class="form-group">
              <?php insert_categories(); ?>
              <input type="text" class="form-control" name="name" required>
            </div>
          </div>

          <div class="col-md-2 category-header-button">
            <div class="form-group">
              <input class="btn btn-primary" type="submit" name="submit" value="Add New">
            </div>
          </div>
        </div>
      </form>
      <hr class="category-hr">

      <div class="row category-body">
        <form method="post">
          <div class="col-md-6">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Delete</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $query = "SELECT * FROM categories";
                  $select_categories = mysqli_query($connection, $query);  

                  while($row = mysqli_fetch_assoc($select_categories)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    echo "<tr>";
                    echo "<td>{$name}</td>";
                    echo "<td><a rel='$id' class='btn btn-danger delete_link'>Delete</a></td>";
                    echo "<td><a class='btn btn-warning' href='categories.php?edit={$id}'>Edit</a></td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div> 
          
          <?php 
            if(isset($_GET['edit'])) {
              $id = $_GET['edit'];
              include "includes/update_categories.php";
            }         
          ?>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $(".delete_link").on('click', function(){
      $(".modal_delete_link").attr("href", "categories.php?delete=" + $(this).attr("rel"));
      $("#myModal .modal-body h3").text("Are you sure you want to delete this category?");
      $("#myModal").modal('show');
    });
  });
</script>

<?php delete_categories(); ?>   
<?php include "includes/admin_footer.php" ?>
