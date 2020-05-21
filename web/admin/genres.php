<?php include "includes/admin_header.php" ?>
<?php include "./includes/edit_modal.php" ?>
<?php include "./includes/delete_modal.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">  
          <h1 class='page-header'>View All Genres (<?php get_rows_count('genres'); ?>)</h1>    
        </div>
      </div>

      <div class="row">
        <div class="col-md-5">
          <div class="row">
            <form method="post">
              <div class="form-group">
                <?php insert_into_table('genres'); ?>
                <input class="form-control genres-input" type="text" name="name" required>
                <input class="btn btn-primary pull-right <?php echo (!is_admin($_SESSION['username']) ? "disabled" : "") ?>" type="submit" name="submit" value="Add New">
              </div>
            </form>
          </div>

          <div class="row">
            <form method="post">
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
                    $query = "SELECT * FROM genres";
                    $select_genres = mysqli_query($connection, $query);  

                    while($row = mysqli_fetch_assoc($select_genres)) {
                      $id = $row['id'];
                      $name = $row['name'];
                      echo "<tr>";
                      echo "<td>{$name}</td>";
                      echo "<td><a rel='$id' data-genre='$name' href='javascript:void(0)' class='btn btn-warning edit_link
                      " . (!is_admin($_SESSION['username']) ? "disabled" : "") . "
                      '>Edit</a></td>";
                      echo "<td><a rel='$id' href='javascript:void(0)' class='btn btn-danger delete_link
                      " . (!is_admin($_SESSION['username']) ? "disabled" : "") . "
                      '>Delete</a></td>";
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </form>
          </div>
        </div> 
      </div>
    </div>
  </div>

  <?php
    if(isset($_POST['edit'])) {
      $id = escape($_POST['id']);
      $name = escape($_POST['name']);
      $query = "UPDATE genres SET name = '{$name}' WHERE id = {$id}";
      $edit_query = mysqli_query($connection, $query);
      confirm_query($edit_query); 
      header("Location: genres.php");
    }
  ?>
        
  <script>
    $(document).ready(function(){
      $(".delete_link").on('click', function(){
        $(".modal_delete_link").attr("href", "genres.php?delete=" + $(this).attr("rel"));
        $("#deleteModal .modal-body h3").text("Are you sure you want to delete this genre?");
        $("#deleteModal").modal('show');
      });
    });

    $(document).ready(function(){
      $(".edit_link").on('click', function(){
        $("#editModal .modal-body #hidden").attr("value", $(this).attr("rel"));
        $("#editModal .modal-body #input").attr("value", $(this).attr("data-genre"));
        $("#editModal").modal('show');
      });
    });
  </script>

  <?php delete_from_table('genres'); ?>   
  <?php include "includes/admin_footer.php" ?>
