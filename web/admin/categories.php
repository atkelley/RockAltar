<?php include "includes/admin_header.php" ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Welcome to admin<small>Author</small></h1>

          <div class="col-xs-6">
            <?php insert_categories(); ?>
    
            <form action="" method="post">
              <div class="form-group">
                <label for="cat-title">Add Category</label>
                <input type="text" class="form-control" name="name">
              </div>
              <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
              </div>
            </form>
    
            <?php 
              if(isset($_GET['edit'])) {
                $id = $_GET['edit'];
                include "includes/update_categories.php";
              }         
            ?>
          </div>

          <div class="col-xs-6">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Category Title</th>
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
                    echo "<td><a href='categories.php?delete={$id}'>Delete</a></td>";
                    echo "<td><a href='categories.php?edit={$id}'>Edit</a></td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>        
        </div>
      </div>
    </div>
  </div>
  <?php 
    deleteCategories();
  ?>
       
  <?php include "includes/admin_footer.php" ?>
