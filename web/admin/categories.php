<?php include "includes/admin_header.php" ?>
<?php include "./includes/delete_modal.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">  
          <h1 class='page-header'>View All Categories (<?php get_rows_count('categories'); ?>)</h1>    
        </div>
      </div>

      <div class="row">
        <div class="col-md-5">
          <div class="row">
            <form method="post">
              <div class="form-group">
                <?php insert_categories(); ?>
                <input class="form-control categories-input" type="text" name="name" required>
                <input class="btn btn-primary pull-right" type="submit" name="submit" value="Add New">
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
            </form>
          </div>
        </div> 

        <div class="col-md-5 col-md-offset-1">
          <div class="row">
            
          
          <form method="post">
            <div class="form-group">
              <?php insert_categories(); ?>
              <input class="form-control categories-input" type="text" name="name" required>
              <input class="btn btn-primary pull-right" type="submit" name="submit" value="Add New">
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
                    echo "<td><a rel='$id' class='btn btn-danger delete_link'>Delete</a></td>";
                    echo "<td><a class='btn btn-warning' href='categories.php?edit={$id}'>Edit</a></td>";
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



          
          <!-- <?php 
            if(isset($_GET['edit'])) {
              $id = $_GET['edit'];
              include "includes/update_categories.php";
            }         
          ?>

        </form>

        </div>
      </div> -->
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
