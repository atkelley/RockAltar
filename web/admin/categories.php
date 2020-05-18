<?php include "includes/admin_header.php" ?>
<?php include "./includes/delete_modal.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h1 class="page-header">View All Categories</h1>
        </div>
      </div>

      <form action="" method="post">
        <div class="row">
          <div class="col-md-6">
            <?php insert_categories(); ?>
      
            <div class="form-group">
              <input type="text" class="form-control" name="name">
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <input class="btn btn-primary" type="submit" name="submit" value="Add New">
            </div>
          </div>
        </div>
      </form>

      <?php 
        if(isset($_GET['edit'])) {
          $id = $_GET['edit'];
          include "includes/update_categories.php";
        }         
      ?>

      <div class="row">
        <div class="col-md-6">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
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
                  echo "<td>{$id}</td>";
                  echo "<td>{$name}</td>";
                  echo "<td><a rel='$id' class='btn btn-danger delete_link'>Delete</a></td>";
                  echo "<td><a class='btn btn-warning' href='categories.php?edit={$id}'>Edit</a></td>";
                  echo "</tr>";
                }
              ?>
            </tbody>
          </table>
        </div> 
      </div>       
    </div>
  </div>

  <script>
    $(document).ready(function(){
      $(".delete_link").on('click', function(){
        var id = $(this).attr("rel");
        var delete_url = "categories.php?delete="+ id +" ";
        $(".modal_delete_link").attr("href", delete_url);
        $("#myModal").modal('show');
      });
    });
  </script>

  <?php delete_categories(); ?>   
  <?php include "includes/admin_footer.php" ?>
